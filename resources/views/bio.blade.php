<!DOCTYPE html>
<html>
<head>
    <title>WebAuthn Example</title>
</head>
<body>
    <h1>WebAuthn Example</h1>
    <button id="registerBtn">Register</button>
    <button id="loginBtn">Login</button>

    <script>
        let credentialId;

document.getElementById('registerBtn').addEventListener('click', async () => {

    try {
        const credential = await navigator.credentials.create({
            publicKey: {
                challenge: Uint8Array.from(window.crypto.getRandomValues(new Uint8Array(32))),
                rp: { name: "Example Corp" },
                user: {
                    id: Uint8Array.from('user-id', c => c.charCodeAt(0)),
                    name: 'user@example.com',
                    displayName: 'User'
                },
                pubKeyCredParams: [{ type: 'public-key', alg: -7 }],
                timeout: 60000,
                attestation: 'direct'
            }
        });
 console.log(credentialId)
        credentialId = credential.id;
        console.log('Credential created:', credential);
    } catch (error) {
        console.error('Error creating credential:', error);
    }
});

document.getElementById('loginBtn').addEventListener('click', async () => {
    console.log(credentialId)
    try {
        if (!credentialId) {
            console.error('No credential ID set.');
            return;
        }

        const credential = await navigator.credentials.get({
            publicKey: {
                challenge: Uint8Array.from(window.crypto.getRandomValues(new Uint8Array(32))),
                allowCredentials: [{ type: 'public-key', id: credentialId }],
                timeout: 60000
            }
        });

        console.log('Credential retrieved:', credential);
    } catch (error) {
        console.error('Error retrieving credential:', error);
    }
});

    </script>
</body>
</html>
