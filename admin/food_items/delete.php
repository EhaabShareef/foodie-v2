<?php
require_once '../../includes/template.php';
require_once '../../models/FoodItem.php';

$template->setLayout(__DIR__ . '/../../layouts/admin_layout.php');

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: index.php');
    exit;
}

$item = FoodItem::getById($id);
if (!$item) {
    header('Location: index.php');
    exit;
}

$confirmed = $_POST['confirm'] ?? false;

if ($confirmed) {
    if (FoodItem::delete($id)) {
        header('Location: index.php');
        exit;
    } else {
        $error = "Failed to delete food item.";
    }
}

defineSection('title', function() {
    echo 'Delete Food Item';
});

defineSection('header', function() {
    echo 'Delete Food Item';
});

defineSection('content', function() use ($item) {
?>
    <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <h2 class="text-2xl font-bold mb-4">Are you sure you want to delete this food item?</h2>
        <div class="mb-4">
            <p><strong>Name:</strong> <?php echo htmlspecialchars($item['name']); ?></p>
            <p><strong>Category:</strong> <?php echo htmlspecialchars($item['category_name']); ?></p>
            <p><strong>Price:</strong> $<?php echo number_format($item['price'], 2); ?></p>
            <?php if ($item['image_path']): ?>
                <img src="<?php echo htmlspecialchars($item['image_path']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>" class="mt-2 max-w-xs">
            <?php endif; ?>
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