<?php
// layouts/main_layout.php
require_once __DIR__ . '/../includes/template.php';
require_once __DIR__ . '../../models/Admin.php';

//check if user is logged in
$isLoggedIn = Admin::isLoggedIn();

?>
<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=DynaPuff:wght@400..700&display=swap" rel="stylesheet">
    <title>Foodie MV - <?php echo renderSection('title') ?: 'Welcome'; ?></title>
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
<body class="flex flex-col min-h-screen bg-gray-100 transition-colors">
    <header class="bg-neutral-800 text-white">
        <nav class="container mx-auto px-4 py-4 flex justify-between items-center">
            <div class="text-2xl font-bold font-dyna">Foodie MV</div>
            <ul class="flex space-x-12 font-inter">
                <li><a href="index.php" class="hover:text-orange-600">Home</a></li>
                <li><a href="/menu.php" class="hover:text-orange-600">Menu</a></li>
                <li>
                    <a href="cart.php" class="hover:text-orange-600 relative">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shopping-cart">
                        <circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/>
                    </svg>
                        <?php if (!empty($_SESSION['cart'])): ?>
                            <span class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs">
                                <?php echo array_sum(array_column($_SESSION['cart'], 'quantity')); ?>
                            </span>
                        <?php endif; ?>
                    </a>
                </li>
                <li>
                <?php if ($isLoggedIn): ?>
                        <a href="/admin/index.php" class="border border-white hover:text-orange-600 hover:border-orange-600 rounded-lg py-1 px-2">Admin</a>
                    <?php else: ?>
                        <a href="/login.php" class="border border-white hover:text-orange-600 hover:border-orange-600 rounded-lg py-1 px-2">Login</a>
                <?php endif; ?>
                </li>
            </ul>
        </nav>
    </header>

    <main class="w-full flex-grow container mx-auto px-4 py-8 bg-neutral-100">
        <?php echo renderSection('content'); ?>
    </main>

    <footer class="bg-neutral-900 text-neutral-300 text-xs py-4 mt-auto">
        <div class="container mx-auto px-4 text-center font-inter">
            <p>&copy; <?php echo date('Y'); ?> Foodie MV. All rights reserved.</p>
        </div>
    </footer>

    <?php echo renderSection('scripts'); ?>
</body>
</html>