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
        <h1 class="text-4xl font-bold mb-4 font-dyna text-orange-400 mt-24">Welcome to Foodie MV</h1>
        <p class="text-sm text-neutral-500 mb-8 font-inter">Discover the best food in the Maldives!</p>
        <a href="menu.php" class="bg-neutral-800 hover:bg-neutral-950 text-white text-sm font-bold py-2 px-4 rounded transition-colors">
            View Menu
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