<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\OnlineClass;

$user = User::where('email', 'admin@paathshaala.com')->first();
echo 'Admin can create: ' . ($user->can('create', OnlineClass::class) ? 'YES' : 'NO') . PHP_EOL;

$user = User::where('email', 'teacher@paathshaala.com')->first();
echo 'Teacher can create: ' . ($user->can('create', OnlineClass::class) ? 'YES' : 'NO') . PHP_EOL;

$user = User::where('email', 'student@paathshaala.com')->first();
echo 'Student can create: ' . ($user->can('create', OnlineClass::class) ? 'YES' : 'NO') . PHP_EOL;