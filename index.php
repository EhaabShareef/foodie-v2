<?php
// index.php
require_once 'includes/template.php';

$template->setLayout(__DIR__ . '/layouts/main_layout.php');

defineSection('title', function() {
    echo 'Welcome to Foodie MV';
});

defineSection('content', function() {
?>
    <div class="text-center">
        <h1 class="text-4xl font-bold mb-4">Welcome to Foodie MV</h1>
        <p class="text-xl mb-8">Discover the best food in the Maldives!</p>
        <a href="menu.php" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
            View Our Menu
        </a>
    </div>
<?php
});

defineSection('scripts', function() {
?>
    <script>
        console.log('Welcome to Foodie MV!');
    </script>
<?php
});

$template->render();