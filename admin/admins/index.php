<?php
require_once '../../includes/template.php';
require_once '../../models/Admin.php';

$template->setLayout(__DIR__ . '/../../layouts/admin_layout.php');

$message = $_SESSION['message'] ?? '';
$messageType = $_SESSION['messageType'] ?? '';

// Clear the session message after retrieving it
//unset($_SESSION['message']);
//unset($_SESSION['messageType']);

defineSection('title', function() {
    echo 'Manage Admins';
});

defineSection('header', function() {
    echo 'Admins';
});

defineSection('content', function() use ($message, $messageType) {
    $admins = Admin::getAll();
?>
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">

        <?php if ($message): ?>
            <div class="p-4 <?php echo $messageType === 'success' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'; ?> mb-4">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
            <h3 class="text-lg leading-6 font-medium text-neutral-900">
                Admin User List
            </h3>
            <a href="add.php" class="bg-cyan-500 hover:bg-cyan-600 text-white font-bold py-2 px-4 rounded text-sm">
                Add New Admin
            </a>
        </div>
        <div class="border-t border-gray-200">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            ID
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Full Name
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Username
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Verified
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Created At
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach ($admins as $admin): ?>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <?php echo htmlspecialchars($admin['id']); ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            <?php echo htmlspecialchars($admin['full_name']); ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <?php echo htmlspecialchars($admin['user_name']); ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <?php echo $admin['verified_yn'] === 'Y' ? 'Yes' : 'No'; ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <?php echo htmlspecialchars($admin['created_at']); ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-xs font-medium">
                            <a href="edit.php?id=<?php echo $admin['id']; ?>" class="text-indigo-600 hover:text-indigo-900 mr-2">Edit</a>
                            <a href="delete.php?id=<?php echo $admin['id']; ?>" class="text-red-600 hover:text-red-900 mr-2">Delete</a>
                            <?php if ($admin['verified_yn'] === 'N'): ?>
                                <a href="approve.php?id=<?php echo $admin['id']; ?>" class="text-green-600 hover:text-green-900">Approve</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php
});

$template->render();