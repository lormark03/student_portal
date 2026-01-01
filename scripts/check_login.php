<?php
require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

$user = User::where('username', 'admin')->first();
if (! $user) {
    echo "NO_USER\n";
    exit(0);
}

echo 'FOUND USER id=' . $user->id . " username={$user->username} role={$user->role}\n";

echo 'Hash check for "password": ' . (Hash::check('password', $user->password) ? "OK\n" : "FAIL\n");

// Try Auth attempt (note: Auth::attempt needs session driver, but will return boolean)
$credentials = ['username' => 'admin', 'password' => 'password'];
$attempt = Auth::attempt($credentials);
echo 'Auth::attempt returned: ' . ($attempt ? "TRUE\n" : "FALSE\n");

// Print last log entries
$log = @file_get_contents(__DIR__ . '/../storage/logs/laravel.log');
if ($log === false) {
    echo "No log file found.\n";
} else {
    $lines = explode("\n", $log);
    $last = array_slice($lines, -20);
    echo "\n--- last 20 log lines ---\n";
    echo implode("\n", $last) . "\n";
}
