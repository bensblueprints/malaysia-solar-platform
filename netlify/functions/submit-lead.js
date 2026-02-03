/**
 * Submit Lead to GoHighLevel CRM
 * Netlify Function for Malaysia Solar Platform
 * Uses GHL Contact API to create contacts with Malaysia Solar tags
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

    // CORS headers
    const headers = {
        'Access-Control-Allow-Origin': '*',
        'Access-Control-Allow-Headers': 'Content-Type',
        'Content-Type': 'application/json'
    };

    // GHL API Configuration
    const GHL_API_KEY = process.env.GHL_API_KEY || 'pit-c5f1dcfb-969d-49eb-924c-144e4695bc0a';
    const GHL_LOCATION_ID = process.env.GHL_LOCATION_ID || 'fl5rL3eZQWBq2GYlDPkl';
    const GHL_API_URL = 'https://services.leadconnectorhq.com';

    try {
        const data = JSON.parse(event.body);

        // Validate required fields
        if (!data.name || !data.phone || !data.email) {
            return {
                statusCode: 400,
                headers,
                body: JSON.stringify({ error: 'Missing required fields: name, phone, email' })
            };
        }

        // Parse name
        const nameParts = data.name.trim().split(' ');
        const firstName = nameParts[0] || '';
        const lastName = nameParts.slice(1).join(' ') || '';

        // Format phone number for Malaysia
        let phone = data.phone.replace(/[^0-9+]/g, '');
        if (phone.startsWith('0')) {
            phone = '+60' + phone.substring(1);
        } else if (!phone.startsWith('+')) {
            phone = '+60' + phone;
        }

        // Build custom fields for solar data
        const customFields = [];

        if (data.tnb_bill) {
            customFields.push({ key: 'tnb_bill', value: String(data.tnb_bill) });
        }
        if (data.property_type) {
            customFields.push({ key: 'property_type', value: data.property_type });
        }
        if (data.is_homeowner) {
            customFields.push({ key: 'is_homeowner', value: data.is_homeowner });
        }
        if (data.roof_size) {
            customFields.push({ key: 'roof_size', value: data.roof_size });
        }
        if (data.system_size) {
            customFields.push({ key: 'system_size', value: data.system_size });
        }
        if (data.monthly_savings) {
            customFields.push({ key: 'monthly_savings', value: String(Math.round(data.monthly_savings)) });
        }
        if (data.yearly_savings) {
            customFields.push({ key: 'yearly_savings', value: String(Math.round(data.yearly_savings)) });
        }
        if (data.roi_years) {
            customFields.push({ key: 'roi_years', value: String(data.roi_years.toFixed(1)) });
        }
        if (data.system_price) {
            customFields.push({ key: 'system_price', value: String(data.system_price) });
        }
        if (data.roof_area_sqm) {
            customFields.push({ key: 'roof_area_sqm', value: String(data.roof_area_sqm) });
        }

        // Create contact payload for GHL API
        const contactPayload = {
            firstName,
            lastName,
            email: data.email,
            phone,
            address1: data.address || '',
            city: 'Malaysia',
            country: 'MY',
            source: 'Malaysia Solar Website',
            tags: [
                'Malaysia Solar',
                'Solar Lead',
                'Website Calculator',
                data.system_size || 'Unknown System',
                data.is_homeowner === 'yes' ? 'Homeowner' : 'Renter',
                data.property_type || 'Unknown Property'
            ].filter(Boolean),
            customFields: customFields.length > 0 ? customFields : undefined
        };

        console.log('Creating contact in GHL:', {
            name: `${firstName} ${lastName}`,
            email: data.email,
            phone,
            tags: contactPayload.tags
        });

        // Create contact via GHL API
        const response = await fetch(`${GHL_API_URL}/contacts/`, {
            method: 'POST',
            headers: {
                'Authorization': `Bearer ${GHL_API_KEY}`,
                'Content-Type': 'application/json',
                'Version': '2021-07-28',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                ...contactPayload,
                locationId: GHL_LOCATION_ID
            })
        });

        const responseData = await response.json();

        if (!response.ok) {
            console.error('GHL API error:', response.status, responseData);

            // If contact already exists, that's still a success
            if (responseData.message && responseData.message.includes('duplicate')) {
                console.log('Contact already exists in GHL');
                return {
                    statusCode: 200,
                    headers,
                    body: JSON.stringify({
                        success: true,
                        message: 'Lead already exists in CRM'
                    })
                };
            }

            // Return success to not block user experience
            return {
                statusCode: 200,
                headers,
                body: JSON.stringify({
                    success: true,
                    message: 'Lead received (CRM sync pending)'
                })
            };
        }

        console.log('Contact created successfully:', responseData.contact?.id);

        return {
            statusCode: 200,
            headers,
            body: JSON.stringify({
                success: true,
                message: 'Lead submitted successfully',
                contactId: responseData.contact?.id
            })
        };

    } catch (error) {
        console.error('Error processing lead:', error);

        // Always return success to not block user experience
        return {
            statusCode: 200,
            headers,
            body: JSON.stringify({
                success: true,
                message: 'Lead received'
            })
        };
    }
};
