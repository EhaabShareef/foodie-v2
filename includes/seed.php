<?php
require_once __DIR__ . '/db_connection.php';
require_once __DIR__ . '../../models/Admin.php';

// Set the admin user details
$fullName = 'Admin User';
$username = 'admin';
$password = 'password@123'; // You should change this to a strong password

try {
    // Attempt to create the admin user (approved by default)
    if (Admin::create($fullName, $username, $password, true)) {
        echo "Admin user created successfully!\n";
        echo "Username: $username\n";
        echo "Password: $password\n";
        echo "This admin user is already approved.\n";
        echo "Please change the password after first login.\n";
    } else {
        echo "Failed to create admin user. It may already exist.\n";
    }
} catch (Exception $e) {
    echo "An error occurred: " . $e->getMessage() . "\n";
}