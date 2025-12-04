<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Http\Kernel')->handle(
    $request = Illuminate\Http\Request::capture()
);

$controller = new \App\Http\Controllers\Admin\SubscriptionPlanController();
try {
    $response = $controller->subscriptionsIndex();
    echo "✅ Controller method executed successfully\n";
    echo "Response type: " . get_class($response) . "\n";
    
    // Check the view data
    if (method_exists($response, 'getData')) {
        $data = $response->getData();
        echo "\nView data passed:\n";
        foreach ($data as $key => $value) {
            if (is_object($value) || is_array($value)) {
                echo "  - $key: " . (is_array($value) ? 'Array' : get_class($value)) . "\n";
            } else {
                echo "  - $key: $value\n";
            }
        }
    }
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString();
}
