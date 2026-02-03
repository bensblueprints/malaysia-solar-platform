/**
 * Address Autocomplete API - Malaysia Solar Platform
 * Uses Google Places Autocomplete API (server-side)
 * Keeps API key secure on the server
 */

exports.handler = async (event, context) => {
    // Handle CORS preflight
    if (event.httpMethod === 'OPTIONS') {
        return {
            statusCode: 200,
            headers: {
                'Access-Control-Allow-Origin': '*',
                'Access-Control-Allow-Headers': 'Content-Type',
                'Access-Control-Allow-Methods': 'GET, OPTIONS'
            },
            body: ''
        };
    }

    // Only allow GET requests
    if (event.httpMethod !== 'GET') {
        return {
            statusCode: 405,
            body: JSON.stringify({ error: 'Method not allowed' })
        };
    }

    const headers = {
        'Access-Control-Allow-Origin': '*',
        'Access-Control-Allow-Headers': 'Content-Type',
        'Content-Type': 'application/json',
        'Cache-Control': 'public, max-age=300' // Cache for 5 minutes
    };

    const GOOGLE_API_KEY = process.env.GOOGLE_SOLAR_API_KEY;

    if (!GOOGLE_API_KEY) {
        return {
            statusCode: 200,
            headers,
            body: JSON.stringify({
                predictions: [],
                message: 'API key not configured'
            })
        };
    }

    try {
        const { input } = event.queryStringParameters || {};

        if (!input || input.length < 3) {
            return {
                statusCode: 200,
                headers,
                body: JSON.stringify({ predictions: [] })
            };
        }

        // Call Google Places Autocomplete API
        const autocompleteUrl = `https://maps.googleapis.com/maps/api/place/autocomplete/json?input=${encodeURIComponent(input)}&components=country:my&types=address&key=${GOOGLE_API_KEY}`;

        const response = await fetch(autocompleteUrl);
        const data = await response.json();

        if (data.status === 'OK' || data.status === 'ZERO_RESULTS') {
            const predictions = (data.predictions || []).map(p => ({
                description: p.description,
                placeId: p.place_id,
                mainText: p.structured_formatting?.main_text || '',
                secondaryText: p.structured_formatting?.secondary_text || ''
            }));

            return {
                statusCode: 200,
                headers,
                body: JSON.stringify({ predictions })
            };
        }

        // If Places API fails, try Geocoding API as fallback
        if (data.status === 'REQUEST_DENIED') {
            console.log('Places API denied, trying Geocoding API fallback');

            const geocodeUrl = `https://maps.googleapis.com/maps/api/geocode/json?address=${encodeURIComponent(input)}&components=country:MY&key=${GOOGLE_API_KEY}`;
            const geocodeResponse = await fetch(geocodeUrl);
            const geocodeData = await geocodeResponse.json();

            if (geocodeData.status === 'OK') {
                const predictions = geocodeData.results.slice(0, 5).map(r => ({
                    description: r.formatted_address,
                    placeId: r.place_id,
                    mainText: r.formatted_address.split(',')[0],
                    secondaryText: r.formatted_address.split(',').slice(1).join(',').trim(),
                    location: r.geometry?.location
                }));

                return {
                    statusCode: 200,
                    headers,
                    body: JSON.stringify({ predictions, source: 'geocoding' })
                };
            }
        }

        console.log('Address autocomplete error:', data.status, data.error_message);

        return {
            statusCode: 200,
            headers,
            body: JSON.stringify({
                predictions: [],
                status: data.status,
                message: data.error_message || 'Could not fetch suggestions'
            })
        };

    } catch (error) {
        console.error('Error in address autocomplete:', error);

        return {
            statusCode: 200,
            headers,
            body: JSON.stringify({
                predictions: [],
                error: error.message
            })
        };
    }
};
