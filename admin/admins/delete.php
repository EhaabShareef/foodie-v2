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

$confirmed = $_POST['confirm'] ?? false;

if ($confirmed) {
    if (Admin::delete($id)) {
        header('Location: index.php');
        exit;
    } else {
        $error = "Failed to delete admin user.";
    }
}

defineSection('title', function() {
    echo 'Delete Admin User';
});

defineSection('header', function() {
    echo 'Delete Admin User';
});

defineSection('content', function() use ($admin, $error) {
?>
    <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <?php if (isset($error)): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Error!</strong>
                <span class="block sm:inline"><?php echo htmlspecialchars($error); ?></span>
            </div>
        <?php endif; ?>

        <h2 class="text-2xl font-bold mb-4">Are you sure you want to delete this admin user?</h2>
        <div class="mb-4">
            <p><strong>Full Name:</strong> <?php echo htmlspecialchars($admin['full_name']); ?></p>
            <p><strong>Username:</strong> <?php echo htmlspecialchars($admin['user_name']); ?></p>
            <p><strong>Verified:</strong> <?php echo $admin['verified_yn'] === 'Y' ? 'Yes' : 'No'; ?></p>
            <p><strong>Created At:</strong> <?php echo htmlspecialchars($admin['created_at']); ?></p>
        </div>
        <form action="" method="POST" class="flex items-center space-x-4">
            <input type="hidden" name="confirm" value="1">
            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Confirm Delete
            </button>
            <a href="index.php" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Cancel
            </a>
        </form>
    </div>
<?php
});

$template->render();