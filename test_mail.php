<?php
// Quick standalone SMTP test - DELETE THIS FILE after testing
// Access via: http://localhost/AI-Wholesale/test_mail.php

$smtpHost = 'smtp.office365.com';
$smtpPort = 587;
$smtpUser = 'info@mmswholesale.co.uk';
$smtpPass = 'Harford193';
$toEmail  = 'info@mmswholesale.co.uk'; // change to your test email if needed

// 1. Test TCP connection
echo "<h3>Step 1: TCP Connection Test</h3>";
$conn = @fsockopen($smtpHost, $smtpPort, $errno, $errstr, 10);
if ($conn) {
    echo "<p style='color:green'>✔ Connected to {$smtpHost}:{$smtpPort}</p>";
    fclose($conn);
} else {
    echo "<p style='color:red'>✘ Cannot connect: {$errstr} ({$errno})</p>";
    echo "<p>Your server may be blocking outbound SMTP. Try port 25 or use a relay.</p>";
    exit;
}

// 2. Test PHPMailer-style via PHP's mail() as fallback check
echo "<h3>Step 2: SMTP Auth Send Test (PHPMailer via socket)</h3>";

// Use PHPMailer if available, otherwise raw socket
$smtpSend = false;
$error    = '';

// Raw SMTP STARTTLS test
$fp = @fsockopen($smtpHost, $smtpPort, $errno, $errstr, 15);
if (!$fp) {
    echo "<p style='color:red'>✘ Socket open failed: {$errstr}</p>";
    exit;
}

stream_set_timeout($fp, 15);

function smtp_read($fp) {
    $data = '';
    while ($line = fgets($fp, 515)) {
        $data .= $line;
        if (substr($line, 3, 1) == ' ') break;
    }
    return $data;
}

function smtp_cmd($fp, $cmd) {
    fwrite($fp, $cmd . "\r\n");
    return smtp_read($fp);
}

$res = smtp_read($fp); // 220 greeting
echo "<pre>S: " . htmlspecialchars($res) . "</pre>";

$res = smtp_cmd($fp, "EHLO localhost");
echo "<pre>EHLO: " . htmlspecialchars($res) . "</pre>";

$res = smtp_cmd($fp, "STARTTLS");
echo "<pre>STARTTLS: " . htmlspecialchars($res) . "</pre>";

if (strpos($res, '220') !== false) {
    // Upgrade to TLS
    stream_socket_enable_crypto($fp, true, STREAM_CRYPTO_METHOD_TLS_CLIENT);
    $res = smtp_cmd($fp, "EHLO localhost");
    echo "<pre>EHLO after TLS: " . htmlspecialchars($res) . "</pre>";

    $res = smtp_cmd($fp, "AUTH LOGIN");
    echo "<pre>AUTH: " . htmlspecialchars($res) . "</pre>";

    $res = smtp_cmd($fp, base64_encode($smtpUser));
    echo "<pre>USER: " . htmlspecialchars($res) . "</pre>";

    $res = smtp_cmd($fp, base64_encode($smtpPass));
    echo "<pre>PASS: " . htmlspecialchars($res) . "</pre>";

    if (strpos($res, '235') !== false) {
        echo "<p style='color:green'>✔ Authentication successful!</p>";

        smtp_cmd($fp, "MAIL FROM:<{$smtpUser}>");
        smtp_cmd($fp, "RCPT TO:<{$toEmail}>");
        smtp_cmd($fp, "DATA");
        $msg  = "From: AI Wholesale <{$smtpUser}>\r\n";
        $msg .= "To: {$toEmail}\r\n";
        $msg .= "Subject: SMTP Test from AI-Wholesale\r\n";
        $msg .= "Content-Type: text/html\r\n\r\n";
        $msg .= "<p>This is a test email from your local AI-Wholesale application.</p>";
        $res  = smtp_cmd($fp, $msg . "\r\n.");
        echo "<pre>SEND: " . htmlspecialchars($res) . "</pre>";

        if (strpos($res, '250') !== false) {
            echo "<p style='color:green'>✔ Email sent successfully to {$toEmail}!</p>";
        } else {
            echo "<p style='color:red'>✘ Send failed. Response above.</p>";
        }
    } else {
        echo "<p style='color:red'>✘ Authentication failed. Check username/password.</p>";
    }
} else {
    echo "<p style='color:red'>✘ STARTTLS not supported or failed.</p>";
}

smtp_cmd($fp, "QUIT");
fclose($fp);

echo "<hr><p><strong>Note:</strong> Delete <code>test_mail.php</code> after testing.</p>";
