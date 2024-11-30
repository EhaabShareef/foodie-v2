<?php
// layouts/admin_layout.php
require_once __DIR__ . '/../includes/template.php';
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
            <h2 class="text-sm text-neutral-500">Admin Pannel</h2>
        </div>
        <nav class="flex mt-4 space-y-4">
            <ul>
                <li><a href="/admin/index.php" class="block py-2 px-4 hover:bg-neutral-700">Dashboard</a></li>
                <li><a href="/admin/categories/index.php" class="block py-2 px-4 hover:bg-neutral-700">Categories</a></li>
                <li><a href="/admin/food_items/index.php" class="block py-2 px-4 hover:bg-neutral-700">Food Items</a></li>
                <li><a href="/admin/orders/index.php" class="block py-2 px-4 hover:bg-neutral-700">Orders</a></li>
            </ul>
        </nav>
    </aside>

    <div class="flex-1 flex flex-col overflow-hidden">
        <header class="bg-neutral-100 shadow mt-6">
            <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
                <h2 class="text-2xl font-bold leading-tight text-neutral-900">
                    <?php echo renderSection('header') ?>
                </h2>
                <a href="/index.php" class="text-cyan-500 hover:text-blue-600">Back to Site</a>
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