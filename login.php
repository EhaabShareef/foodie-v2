<?php
require_once 'includes/template.php';
require_once 'models/Admin.php';

$template->setLayout(__DIR__ . '/layouts/main_layout.php');

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (Admin::login($username, $password)) {
        // Redirect to admin dashboard
        header('Location: admin/index.php');
        exit;
    } else {
        $error = "Invalid username or password.";
    }
}

defineSection('title', function() {
    echo 'Admin Login';
});

defineSection('content', function() {
?>
    <div class="flex items-center justify-center bg-neutral-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <div>
                <h2 class="mt-6 text-center text-3xl font-dyna font-bold text-neutral-800">
                    FOODIE MV - Admin
                </h2>
                <h2 class="mt-2 mb-12 text-center text-sm font-extrabold text-neutral-600">
                    Sign in to your account
                </h2>
            </div>

            <form class="mt-12 space-y-6" action="" method="POST">
                <input type="hidden" name="remember" value="true">
                <div class="rounded-md shadow-sm -space-y-px">
                    <div>
                        <label for="username" class="sr-only">Username</label>
                        <input id="username" name="username" type="text" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-neutral-300 placeholder-neutral-500 text-neutral-900 rounded-t-md focus:outline-none focus:ring-orange-500 focus:border-orange-500 focus:z-10 sm:text-sm" placeholder="Username">
                    </div>
                    <div>
                        <label for="password" class="sr-only">Password</label>
                        <input id="password" name="password" type="password" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-neutral-300 placeholder-neutral-500 text-neutral-900 rounded-b-md focus:outline-none focus:ring-orange-500 focus:border-orange-500 focus:z-10 sm:text-sm" placeholder="Password">
                    </div>
                </div>

                <div>
                    <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                        Login
                    </button>
                </div>
            </form>
        </div>
    </div>
<?php
});

$template->render();