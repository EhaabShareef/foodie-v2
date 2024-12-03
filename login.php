<?php
require_once 'includes/template.php';
require_once 'models/Admin.php';

$template->setLayout(__DIR__ . '/layouts/main_layout.php');

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $loginResult = Admin::login($username, $password);
    if ($loginResult['success']) {
        // Redirect to admin dashboard
        header('Location: admin/index.php');
        exit;
    } else {
        $error = $loginResult['message'];
    }
}

defineSection('title', function() {
    echo 'Admin Login';
});

defineSection('content', function() use($error) {
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
                <?php if($error): ?>
                    <div class="rounded-md bg-red-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">
                                    <?php echo htmlspecialchars($error); ?>
                                </h3>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
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