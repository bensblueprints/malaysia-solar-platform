/**
 * Submit Lead to GoHighLevel CRM
 * Netlify Function for Malaysia Solar Platform
 */

exports.handler = async (event, context) => {
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

        // GoHighLevel webhook URL (set in Netlify environment variables)
        const webhookUrl = process.env.GHL_WEBHOOK_URL;

        if (!webhookUrl) {
            console.error('GHL_WEBHOOK_URL not configured');
            // Still return success to not block user experience
            return {
                statusCode: 200,
                headers,
                body: JSON.stringify({
                    success: true,
                    message: 'Lead received (webhook not configured)'
                })
            };
        }

        // Format data for GoHighLevel
        const ghlPayload = {
            // Contact fields
            firstName: data.name.split(' ')[0],
            lastName: data.name.split(' ').slice(1).join(' ') || '',
            email: data.email,
            phone: data.phone,
            address1: data.address || '',

            // Custom fields (configure in GHL)
            customField: {
                tnb_bill: data.tnb_bill,
                property_type: data.property_type,
                is_homeowner: data.is_homeowner,
                roof_size: data.roof_size,
                system_size: data.system_size,
                monthly_savings: data.monthly_savings,
                yearly_savings: data.yearly_savings,
                roi_years: data.roi_years,
                system_price: data.system_price
            },

            // Source tracking
            source: data.source || 'Website Calculator',
            tags: ['Solar Lead', 'Website', data.system_size || 'Unknown System'],

            // Timestamp
            dateAdded: data.timestamp || new Date().toISOString()
        };

        // Send to GoHighLevel
        const response = await fetch(webhookUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(ghlPayload)
        });

        if (!response.ok) {
            console.error('GHL webhook error:', response.status, await response.text());
            // Still return success to not block user
        }

        // Log for debugging (visible in Netlify function logs)
        console.log('Lead submitted:', {
            name: data.name,
            email: data.email,
            system_size: data.system_size,
            timestamp: new Date().toISOString()
        });

        return {
            statusCode: 200,
            headers,
            body: JSON.stringify({
                success: true,
                message: 'Lead submitted successfully'
            })
        };

    } catch (error) {
        console.error('Error processing lead:', error);

        return {
            statusCode: 500,
            headers,
            body: JSON.stringify({
                error: 'Internal server error',
                message: error.message
            })
        };
    }
};
