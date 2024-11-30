<?php
require_once '../../includes/template.php';
require_once '../../models/Order.php';

$template->setLayout(__DIR__ . '/../../layouts/admin_layout.php');

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: index.php');
    exit;
}

$order = Order::getById($id);
if (!$order) {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newStatus = $_POST['status'] ?? '';
    if ($newStatus && Order::updateStatus($id, $newStatus)) {
        header('Location: show.php?id=' . $id);
        exit;
    } else {
        $error = "Failed to update order status.";
    }
}

defineSection('title', function() use ($order) {
    echo 'Change Status for Order #' . $order['id'];
});

defineSection('header', function() use ($order) {
    echo 'Change Status for Order #' . $order['id'];
});

defineSection('content', function() use ($order) {
?>
    <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <form action="" method="POST" class="space-y-4">
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700">New Status</label>
                <select id="status" name="status" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                    <option value="pending" <?php echo $order['status'] === 'pending' ? 'selected' : ''; ?>>Pending</option>
                    <option value="processing" <?php echo $order['status'] === 'processing' ? 'selected' : ''; ?>>Processing</option>
                    <option value="completed" <?php echo $order['status'] === 'completed' ? 'selected' : ''; ?>>Completed</option>
                    <option value="cancelled" <?php echo $order['status'] === 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                </select>
            </div>
            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Update Status
                </button>
                <a href="show.php?id=<?php echo $order['id']; ?>" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                    Cancel
                </a>
            </div>
        </form>
    </div>
<?php
});

$template->render();