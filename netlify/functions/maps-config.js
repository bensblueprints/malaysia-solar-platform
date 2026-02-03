/**
 * Maps Config API - Malaysia Solar Platform
 * Securely provides Google Maps API key for client-side Places Autocomplete
 */

exports.handler = async (event, context) => {
    const headers = {
        'Access-Control-Allow-Origin': '*',
        'Access-Control-Allow-Headers': 'Content-Type',
        'Content-Type': 'application/json',
        'Cache-Control': 'public, max-age=3600' // Cache for 1 hour
    };

    // Only allow GET requests
    if (event.httpMethod !== 'GET') {
        return {
            statusCode: 405,
            headers,
            body: JSON.stringify({ error: 'Method not allowed' })
        };
    }

    const GOOGLE_API_KEY = process.env.GOOGLE_SOLAR_API_KEY;

    if (!GOOGLE_API_KEY) {
        return {
            statusCode: 200,
            headers,
            body: JSON.stringify({
                enabled: false,
                message: 'Google Maps API key not configured'
            })
        };
    }

    return {
        statusCode: 200,
        headers,
        body: JSON.stringify({
            enabled: true,
            apiKey: GOOGLE_API_KEY,
            libraries: 'places'
        })
    };
};
