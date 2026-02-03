/**
 * Solar Analysis API - Malaysia Solar Platform
 * Uses Google Solar API to analyze roof solar potential
 * Netlify Serverless Function
 */

exports.handler = async (event, context) => {
    // Handle CORS preflight
    if (event.httpMethod === 'OPTIONS') {
        return {
            statusCode: 200,
            headers: {
                'Access-Control-Allow-Origin': '*',
                'Access-Control-Allow-Headers': 'Content-Type',
                'Access-Control-Allow-Methods': 'POST, OPTIONS'
            },
            body: ''
        };
    }

    // Only allow POST requests
    if (event.httpMethod !== 'POST') {
        return {
            statusCode: 405,
            body: JSON.stringify({ error: 'Method not allowed' })
        };
    }

    const headers = {
        'Access-Control-Allow-Origin': '*',
        'Access-Control-Allow-Headers': 'Content-Type',
        'Content-Type': 'application/json'
    };

    // Google API Key from environment variable only
    const GOOGLE_API_KEY = process.env.GOOGLE_SOLAR_API_KEY;

    // If no API key configured, return estimated data
    if (!GOOGLE_API_KEY) {
        console.log('Google Solar API key not configured');
        return {
            statusCode: 200,
            headers,
            body: JSON.stringify({
                success: true,
                dataSource: 'estimated',
                message: 'Using estimated values. Configure GOOGLE_SOLAR_API_KEY for precise roof analysis.',
                location: {
                    lat: 3.1390,
                    lng: 101.6869,
                    formattedAddress: JSON.parse(event.body).address
                },
                roofAnalysis: {
                    roofAreaSqm: null,
                    usableRoofAreaSqm: null,
                    maxPanelCount: null,
                    maxSolarArrayAreaM2: null,
                    pitchDegrees: 15,
                    azimuthDegrees: 180
                },
                solarPotential: {
                    maxSunshineHoursPerYear: 1800,
                    carbonOffsetFactorKgPerMwh: 400,
                    annualSunshineHours: 1800,
                    estimatedKwhPerKwpPerYear: 1400
                },
                recommendation: calculateRecommendation(null, null)
            })
        };
    }

    try {
        const data = JSON.parse(event.body);
        const { address, lat, lng } = data;

        if (!address) {
            return {
                statusCode: 400,
                headers,
                body: JSON.stringify({ error: 'Address is required' })
            };
        }

        console.log('Analyzing solar potential for:', address);

        let location;
        let formattedAddress = address;

        // If coordinates are provided (from Places Autocomplete), use them directly
        if (lat && lng) {
            console.log('Using provided coordinates:', lat, lng);
            location = { lat, lng };
        } else {
            // Step 1: Geocode the address to get lat/lng
            const geocodeUrl = `https://maps.googleapis.com/maps/api/geocode/json?address=${encodeURIComponent(address)}&components=country:MY&key=${GOOGLE_API_KEY}`;

            const geocodeResponse = await fetch(geocodeUrl);
            const geocodeData = await geocodeResponse.json();

            if (geocodeData.status !== 'OK' || !geocodeData.results || geocodeData.results.length === 0) {
                console.log('Geocoding failed:', geocodeData.status, geocodeData.error_message);

                // Return estimated data for Malaysia when geocoding fails
                return {
                    statusCode: 200,
                    headers,
                    body: JSON.stringify({
                        success: true,
                        dataSource: 'estimated',
                        message: 'Using estimated values for Malaysian conditions. Enable Google Maps Geocoding API for precise roof analysis.',
                        location: {
                            lat: 3.1390,
                            lng: 101.6869,
                            formattedAddress: address
                        },
                        roofAnalysis: {
                            roofAreaSqm: null,
                            usableRoofAreaSqm: null,
                            maxPanelCount: null,
                            maxSolarArrayAreaM2: null,
                            pitchDegrees: 15,
                            azimuthDegrees: 180
                        },
                        solarPotential: {
                            maxSunshineHoursPerYear: 1800,
                            carbonOffsetFactorKgPerMwh: 400,
                            annualSunshineHours: 1800,
                            estimatedKwhPerKwpPerYear: 1400
                        },
                        recommendation: calculateRecommendation(null, null)
                    })
                };
            }

            location = geocodeData.results[0].geometry.location;
            formattedAddress = geocodeData.results[0].formatted_address;
        }

        console.log('Using location:', location, formattedAddress);

        // Step 2: Call Google Solar API - Building Insights
        const solarUrl = `https://solar.googleapis.com/v1/buildingInsights:findClosest?location.latitude=${location.lat}&location.longitude=${location.lng}&requiredQuality=HIGH&key=${GOOGLE_API_KEY}`;

        const solarResponse = await fetch(solarUrl);

        // Check if Solar API returned an error
        if (!solarResponse.ok) {
            const errorText = await solarResponse.text();
            console.log('Solar API error:', solarResponse.status, errorText);

            // Solar API might not have data for this location
            // Return estimated values based on average Malaysian conditions
            return {
                statusCode: 200,
                headers,
                body: JSON.stringify({
                    success: true,
                    dataSource: 'estimated',
                    message: 'Solar API data not available for this location. Using estimated values.',
                    location: {
                        lat: location.lat,
                        lng: location.lng,
                        formattedAddress
                    },
                    roofAnalysis: {
                        roofAreaSqm: null,
                        usableRoofAreaSqm: null,
                        maxPanelCount: null,
                        maxSolarArrayAreaM2: null,
                        pitchDegrees: 15, // Common pitch in Malaysia
                        azimuthDegrees: 180 // South-facing assumed
                    },
                    solarPotential: {
                        maxSunshineHoursPerYear: 1800, // Malaysia average
                        carbonOffsetFactorKgPerMwh: 400,
                        annualSunshineHours: 1800,
                        estimatedKwhPerKwpPerYear: 1400 // Malaysia average
                    },
                    recommendation: calculateRecommendation(null, null)
                })
            };
        }

        const solarData = await solarResponse.json();
        console.log('Solar API response received');

        // Extract relevant data from Solar API response
        const solarPotential = solarData.solarPotential || {};
        const roofSegmentStats = solarPotential.roofSegmentStats || [];

        // Calculate total roof metrics
        let totalRoofArea = 0;
        let totalUsableArea = 0;
        let weightedPitch = 0;
        let weightedAzimuth = 0;

        roofSegmentStats.forEach(segment => {
            const segmentArea = segment.stats?.areaMeters2 || 0;
            totalRoofArea += segmentArea;

            // Usable area considering shading and orientation
            const sunshineQuantile = segment.stats?.sunshineQuantiles?.[5] || 0;
            if (sunshineQuantile > 800) { // Good sunshine threshold
                totalUsableArea += segmentArea;
            }

            if (segment.pitchDegrees && segmentArea > 0) {
                weightedPitch += segment.pitchDegrees * segmentArea;
            }
            if (segment.azimuthDegrees && segmentArea > 0) {
                weightedAzimuth += segment.azimuthDegrees * segmentArea;
            }
        });

        const avgPitch = totalRoofArea > 0 ? weightedPitch / totalRoofArea : 15;
        const avgAzimuth = totalRoofArea > 0 ? weightedAzimuth / totalRoofArea : 180;

        // Get the best configuration
        const solarPanelConfigs = solarPotential.solarPanelConfigs || [];
        const bestConfig = solarPanelConfigs.length > 0
            ? solarPanelConfigs[solarPanelConfigs.length - 1]
            : null;

        const maxPanelCount = solarPotential.maxArrayPanelsCount || (bestConfig ? bestConfig.panelsCount : null);
        const maxSolarArrayArea = solarPotential.maxArrayAreaMeters2 || null;

        // Financial analysis if available
        const financialAnalyses = solarPotential.financialAnalyses || [];
        const bestFinancial = financialAnalyses.length > 0 ? financialAnalyses[0] : null;

        // Build the response
        const analysisResult = {
            success: true,
            dataSource: 'google_solar_api',
            location: {
                lat: location.lat,
                lng: location.lng,
                formattedAddress
            },
            roofAnalysis: {
                roofAreaSqm: Math.round(totalRoofArea * 10) / 10,
                usableRoofAreaSqm: Math.round(totalUsableArea * 10) / 10,
                maxPanelCount: maxPanelCount,
                maxSolarArrayAreaM2: maxSolarArrayArea ? Math.round(maxSolarArrayArea * 10) / 10 : null,
                pitchDegrees: Math.round(avgPitch),
                azimuthDegrees: Math.round(avgAzimuth),
                roofSegmentCount: roofSegmentStats.length
            },
            solarPotential: {
                maxSunshineHoursPerYear: solarPotential.maxSunshineHoursPerYear || 1800,
                carbonOffsetFactorKgPerMwh: solarPotential.carbonOffsetFactorKgPerMwh || 400,
                panelCapacityWatts: solarPotential.panelCapacityWatts || 400,
                panelHeightMeters: solarPotential.panelHeightMeters || 1.65,
                panelWidthMeters: solarPotential.panelWidthMeters || 0.99,
                panelLifetimeYears: solarPotential.panelLifetimeYears || 25,
                yearlyEnergyDcKwh: bestConfig ? bestConfig.yearlyEnergyDcKwh : null,
                estimatedKwhPerKwpPerYear: 1400 // Malaysia average
            },
            financialSummary: bestFinancial ? {
                initialAcKwhPerYear: bestFinancial.initialAcKwhPerYear,
                savingsYear1: bestFinancial.cashPurchaseSavings?.savings?.savingsYear1?.units || null,
                savingsYear20: bestFinancial.cashPurchaseSavings?.savings?.savingsYear20?.units || null,
                paybackYears: bestFinancial.cashPurchaseSavings?.paybackYears || null
            } : null,
            recommendation: calculateRecommendation(totalUsableArea || totalRoofArea, maxPanelCount)
        };

        console.log('Analysis complete:', {
            roofArea: analysisResult.roofAnalysis.roofAreaSqm,
            usableArea: analysisResult.roofAnalysis.usableRoofAreaSqm,
            maxPanels: analysisResult.roofAnalysis.maxPanelCount,
            recommendedSystem: analysisResult.recommendation.systemSizeKw
        });

        return {
            statusCode: 200,
            headers,
            body: JSON.stringify(analysisResult)
        };

    } catch (error) {
        console.error('Error in solar analysis:', error);

        return {
            statusCode: 500,
            headers,
            body: JSON.stringify({
                error: 'Failed to analyze solar potential',
                message: error.message
            })
        };
    }
};

/**
 * Calculate recommended system based on roof area and panel count
 * Tailored for Malaysian market
 */
function calculateRecommendation(usableRoofAreaSqm, maxPanelCount) {
    // Standard panel specs (typical 400W panels)
    const PANEL_WATTAGE = 400; // watts
    const PANEL_AREA = 1.65 * 0.99; // ~1.63 sqm per panel

    // System configurations available in Malaysia
    const SYSTEMS = [
        { kw: 3, panels: 7, minArea: 12, price: 15000 },
        { kw: 5, panels: 12, minArea: 20, price: 22000 },
        { kw: 7, panels: 16, minArea: 26, price: 30000 },
        { kw: 10, panels: 24, minArea: 40, price: 40000 },
        { kw: 12, panels: 28, minArea: 46, price: 48000 },
        { kw: 15, panels: 36, minArea: 60, price: 58000 }
    ];

    let recommendedSystem = SYSTEMS[0]; // Default to smallest
    let roofSuitable = true;
    let roofSizeCategory = 'unknown';
    let notes = [];

    if (usableRoofAreaSqm !== null && usableRoofAreaSqm > 0) {
        // Calculate based on usable roof area
        const possiblePanels = Math.floor(usableRoofAreaSqm / PANEL_AREA);

        // Find the largest system that fits
        for (const system of SYSTEMS) {
            if (possiblePanels >= system.panels) {
                recommendedSystem = system;
            }
        }

        // Categorize roof size
        if (usableRoofAreaSqm < 15) {
            roofSizeCategory = 'small';
            notes.push('Your roof has limited space for solar panels');
        } else if (usableRoofAreaSqm < 30) {
            roofSizeCategory = 'medium';
        } else if (usableRoofAreaSqm < 50) {
            roofSizeCategory = 'large';
        } else {
            roofSizeCategory = 'extra_large';
            notes.push('Your roof has excellent potential for a large solar system');
        }

        // Check if roof is suitable
        if (usableRoofAreaSqm < 10) {
            roofSuitable = false;
            notes.push('Roof area may be too small for cost-effective solar installation');
        }
    } else if (maxPanelCount !== null && maxPanelCount > 0) {
        // Calculate based on max panel count
        for (const system of SYSTEMS) {
            if (maxPanelCount >= system.panels) {
                recommendedSystem = system;
            }
        }

        if (maxPanelCount < 7) {
            roofSizeCategory = 'small';
            roofSuitable = maxPanelCount >= 5;
        } else if (maxPanelCount < 16) {
            roofSizeCategory = 'medium';
        } else if (maxPanelCount < 24) {
            roofSizeCategory = 'large';
        } else {
            roofSizeCategory = 'extra_large';
        }
    }

    // Calculate expected production (Malaysia average: 1400 kWh per kWp per year)
    const annualProductionKwh = recommendedSystem.kw * 1400;
    const monthlyProductionKwh = Math.round(annualProductionKwh / 12);

    // Calculate savings (TNB average rate: RM 0.57/kWh)
    const TNB_RATE = 0.57;
    const monthlySavings = Math.round(monthlyProductionKwh * TNB_RATE);
    const yearlySavings = monthlySavings * 12;

    // Calculate ROI
    const roiYears = recommendedSystem.price / yearlySavings;

    return {
        systemSizeKw: recommendedSystem.kw,
        panelCount: recommendedSystem.panels,
        estimatedPrice: recommendedSystem.price,
        roofSizeCategory,
        roofSuitable,
        maxPossiblePanels: maxPanelCount,
        usableRoofAreaSqm: usableRoofAreaSqm ? Math.round(usableRoofAreaSqm) : null,
        expectedProduction: {
            annualKwh: annualProductionKwh,
            monthlyKwh: monthlyProductionKwh
        },
        estimatedSavings: {
            monthlyRm: monthlySavings,
            yearlyRm: yearlySavings,
            over25YearsRm: yearlySavings * 25
        },
        paybackPeriodYears: Math.round(roiYears * 10) / 10,
        notes
    };
}
