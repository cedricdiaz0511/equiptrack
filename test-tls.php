<?php

$host = 'ac-pi9nt1b-shard-00-00.obzuswd.mongodb.net';
$port = 27017;

$context = stream_context_create([
    'ssl' => [
        'verify_peer' => true,
        'verify_peer_name' => true,
        'SNI_enabled' => true,
    ],
]);

$socket = stream_socket_client(
    "tls://{$host}:{$port}",
    $errno,
    $errstr,
    15,
    STREAM_CLIENT_CONNECT,
    $context
);

if ($socket) {
    echo "TLS SUCCESS\n";
    fclose($socket);
} else {
    echo "TLS FAILED\n";
    echo "Error: {$errstr}\n";
    echo "Error code: {$errno}\n";
    echo "OpenSSL errors:\n";

    while ($error = openssl_error_string()) {
        echo $error . "\n";
    }
}
