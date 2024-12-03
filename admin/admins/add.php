<?php
require_once '../../includes/template.php';
require_once '../../models/Admin.php';

$template->setLayout(__DIR__ . '/../../layouts/admin_layout.php');

$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = $_POST['full_name'] ?? '';
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $is_approved = isset($_POST['is_approved']) ? true : false;

    if ($password !== $confirm_password) {
        $message = "Passwords do not match.";
        $messageType = "error";
    } else {
        $result = Admin::create($full_name, $username, $password, $is_approved);
        if ($result['success']) {
            $_SESSION['message'] = $result['message'];
            $_SESSION['messageType'] = "success";
            header('Location: index.php');
            exit;
        } else {
            $message = $result['message'];
            $messageType = "error";
        }
    }
}

defineSection('title', function() {
    echo 'Add New Admin';
});

defineSection('header', function() {
    echo 'Add New Admin';
});

defineSection('content', function() use ($message, $messageType) {
?>
    <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <?php if ($message): ?>
            <div class="mb-4 p-4 rounded <?php echo $messageType === 'error' ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700'; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <form action="" method="POST" class="space-y-6">
            <div>
                <label for="full_name" class="block text-sm font-medium text-gray-700">Full Name</label>
                <input type="text" name="full_name" id="full_name" required class="py-2 px-3 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
            </div>

            <div>
                <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                <input type="text" name="username" id="username" required class="py-2 px-3 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password" id="password" required class="py-2 px-3 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
            </div>

            <div>
                <label for="confirm_password" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                <input type="password" name="confirm_password" id="confirm_password" required class="py-2 px-3 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
            </div>

            <div>
                <label class="inline-flex items-center">
                    <input type="checkbox" name="is_approved" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <span class="ml-2 font-heading text-xs">Approve immediately</span>
                </label>
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" class="text-sm bg-cyan-500 hover:bg-cyan-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Add Admin
                </button>
                <a href="index.php" class="inline-block align-baseline font-bold text-sm text-cyan-500 hover:text-cyan-800">
                    Cancel
                </a>
            </div>
        </form>
    </div>
<?php
});

$template->render();