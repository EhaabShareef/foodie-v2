<?php
// layouts/admin_layout.php
require_once __DIR__ . '/../includes/template.php';
require_once __DIR__ . '../../models/Admin.php';

// protect admin pages with auth
Admin::checkAdminSession();

// Handle logout
if (isset($_GET['logout'])) {
    Admin::logout();
    header('Location: /index.php');
    exit;
}

// Get current admin user
$currentAdmin = Admin::getCurrentAdmin();
?>

<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=DynaPuff:wght@400..700&display=swap" rel="stylesheet">
    <title>Foodie MV Admin - <?php echo renderSection('title') ?: 'Dashboard'; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'inter': ['Inter', 'sans-serif'],
                        'roboto': ['Roboto', 'sans-serif'],
                        'dyna':['DynaPuff', 'system-ui']
                    },
                },
            },
        }
    </script>

    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="flex h-screen bg-neutral-100">
    <aside class="w-64 bg-neutral-800 text-white">
        <div class="p-4 mt-6">
            <h1 class="text-2xl font-dyna font-bold">Foodie MV</h1>
            <h2 class="text-sm text-neutral-500">Admin Panel</h2>
        </div>
        <nav class="flex p-2 mt-12 mr-2">
            <ul class="flex  flex-col w-full font-inter">
                <li class="py-4 px-6 hover:bg-neutral-700 rounded-md"><a href="/admin/index.php">Dashboard</a></li>
                <li class="py-4 px-6 hover:bg-neutral-700 rounded-md" ><a href="/admin/categories/index.php">Categories</a></li >
                <li class="py-4 px-6 hover:bg-neutral-700 rounded-md"><a href="/admin/food_items/index.php">Food Items</a></li >
                <li class="py-4 px-6 hover:bg-neutral-700 rounded-md"><a href="/admin/orders/index.php">Orders</a></li>
                <li class="py-4 px-6 hover:bg-neutral-700 rounded-md"><a href="/admin/admins/index.php">Users</a></li>
            </ul>
        </nav>
    </aside>

    <div class="flex-1 flex flex-col overflow-hidden">
        <header class="bg-neutral-100 shadow mt-6">
            <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
                <h2 class="text-2xl font-bold leading-tight text-neutral-900">
                    <?php echo renderSection('header') ?>
                </h2>
                <div class="flex items-center">
                    <?php if ($currentAdmin): ?>
                        <span class="mr-4 text-sm text-neutral-600">
                            Logged in as: <strong><?php echo htmlspecialchars($currentAdmin['full_name']); ?></strong>
                        </span>
                    <?php endif; ?>
                    <a href="/admin/index.php?logout=1" class="font-bold text-sm text-red-500 hover:text-red-600 mr-4">Logout</a>
                    <a href="/index.php" class="font-bold text-sm text-orange-500 hover:text-orange-600">Back to Site</a>
                </div>
            </div>
        </header>

        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-neutral-100">
            <div class="max-w-7xl mx-auto mt-2 py-6 sm:px-6 lg:px-8">
                <?php echo renderSection('content'); ?>
            </div>
        </main>
    </div>

    <?php echo renderSection('scripts'); ?>
</body>
</html>