/**
 * Process Payment
 * Netlify Function for Malaysia Solar Platform
 *
 * This is a stub - integrate with Stripe in production
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

    try {
        const data = JSON.parse(event.body);

        // Validate required fields
        if (!data.name || !data.email || !data.amount) {
            return {
                statusCode: 400,
                headers,
                body: JSON.stringify({ error: 'Missing required fields' })
            };
        }

        // In production, integrate with Stripe here
        // const stripe = require('stripe')(process.env.STRIPE_SECRET_KEY);

        // Example Stripe integration:
        /*
        const paymentIntent = await stripe.paymentIntents.create({
            amount: data.amount * 100, // Convert to cents
            currency: 'myr',
            metadata: {
                customer_name: data.name,
                customer_email: data.email,
                system_size: data.systemSize,
                type: 'site_visit_deposit'
            }
        });

        return {
            statusCode: 200,
            headers,
            body: JSON.stringify({
                clientSecret: paymentIntent.client_secret
            })
        };
        */

        // For now, log the payment attempt and return success
        console.log('Payment request received:', {
            name: data.name,
            email: data.email,
            amount: data.amount,
            systemSize: data.systemSize,
            timestamp: new Date().toISOString()
        });

        // Notify via GoHighLevel webhook if configured
        const ghlWebhook = process.env.GHL_PAYMENT_WEBHOOK_URL;
        if (ghlWebhook) {
            try {
                await fetch(ghlWebhook, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        type: 'payment_intent',
                        customer: data.name,
                        email: data.email,
                        amount: data.amount,
                        system_size: data.systemSize,
                        status: 'pending_integration',
                        timestamp: new Date().toISOString()
                    })
                });
            } catch (webhookError) {
                console.error('Webhook notification failed:', webhookError);
            }
        }

        // Return success (stub response)
        return {
            statusCode: 200,
            headers,
            body: JSON.stringify({
                success: true,
                message: 'Payment request received. Our team will contact you to complete the booking.',
                reference: `MS-${Date.now()}`
            })
        };

    } catch (error) {
        console.error('Error processing payment:', error);

        return {
            statusCode: 500,
            headers,
            body: JSON.stringify({
                error: 'Internal server error',
                message: 'Payment processing failed. Please try again or contact support.'
            })
        };
    }
};
