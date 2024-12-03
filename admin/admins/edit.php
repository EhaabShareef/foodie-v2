<?php
require_once '../../includes/template.php';
require_once '../../models/Admin.php';

$template->setLayout(__DIR__ . '/../../layouts/admin_layout.php');

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: index.php');
    exit;
}

$admin = Admin::getById($id);
if (!$admin) {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = $_POST['full_name'] ?? '';
    $user_name = $_POST['user_name'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $verified_yn = isset($_POST['verified_yn']) ? 'Y' : 'N';

    $errors = [];

    // Validate inputs
    if (empty($full_name)) {
        $errors[] = "Full name is required.";
    }
    if (empty($user_name)) {
        $errors[] = "Username is required.";
    }
    if (!empty($password)) {
        if (strlen($password) < 8) {
            $errors[] = "Password must be at least 8 characters long.";
        }
        if ($password !== $confirm_password) {
            $errors[] = "Passwords do not match.";
        }
    }

    if (empty($errors)) {
        try {
            if (Admin::update($id, $full_name, $user_name, $password)) {
                if ($verified_yn === 'Y' && $admin['verified_yn'] === 'N') {
                    Admin::approveUser($id);
                }
                header('Location: index.php');
                exit;
            } else {
                $errors[] = "Failed to update admin.";
            }
        } catch (Exception $e) {
            $errors[] = $e->getMessage();
        }
    }
}

defineSection('title', function() {
    echo 'Edit Admin';
});

defineSection('header', function() {
    echo 'Edit Admin';
});

defineSection('content', function() use ($admin) {
?>
    <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">

        <form action="" method="POST">
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="full_name">
                    Full Name
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="full_name" type="text" name="full_name" value="<?php echo htmlspecialchars($admin['full_name']); ?>" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="user_name">
                    Username
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="user_name" type="text" name="user_name" value="<?php echo htmlspecialchars($admin['user_name']); ?>" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                    New Password (leave blank to keep current password)
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="password" type="password" name="password">
            </div>
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="confirm_password">
                    Confirm New Password
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="confirm_password" type="password" name="confirm_password">
            </div>
            <div class="mb-4">
                <label class="inline-flex items-center">
                    <input type="checkbox" class="form-checkbox" name="verified_yn" <?php echo $admin['verified_yn'] === 'Y' ? 'checked' : ''; ?>>
                    <span class="ml-2">Verified</span>
                </label>
            </div>
            <div class="flex items-center justify-between">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                    Update Admin
                </button>
                <a class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800" href="index.php">
                    Cancel
                </a>
            </div>
        </form>
    </div>
<?php
});

$template->render();