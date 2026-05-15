<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Ai\Agents\ChatAgent;

try {
    echo "Starting prompt...\n";
    $response = (new ChatAgent())->prompt('Hello');
    echo "Response: " . $response . "\n";
} catch (\Throwable $e) {
    echo "Error: " . $e->getMessage() . "\n";
    if (isset($e->response)) {
        echo "Response Body: " . $e->response->body() . "\n";
    }
}
