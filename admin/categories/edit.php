<?php
require_once '../../includes/template.php';
require_once '../../models/Category.php';

$template->setLayout(__DIR__ . '/../../layouts/admin_layout.php');

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: index.php');
    exit;
}

$category = Category::getById($id);
if (!$category) {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $description = $_POST['description'] ?? '';
    $image = $_FILES['image'] ?? null;
    $is_active = isset($_POST['is_active']) ? 1 : 0;

    try {
        if (Category::update($id, $name, $description, $image, $is_active)) {
            header('Location: index.php');
            exit;
        } else {
            $error = "Failed to update category.";
        }
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}

defineSection('title', function() {
    echo 'Edit Category';
});

defineSection('header', function() {
    echo 'Edit Category';
});

defineSection('content', function() use ($category) {
?>
    <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">

        <form action="" method="POST" enctype="multipart/form-data">
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                    Name
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="name" type="text" name="name" value="<?php echo htmlspecialchars($category['name']); ?>" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="description">
                    Description
                </label>
                <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="description" name="description" rows="3"><?php echo htmlspecialchars($category['description']); ?></textarea>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="image">
                    Image
                </label>
                <?php if ($category['image_path']): ?>
                    <img src="<?php echo htmlspecialchars($category['image_path']); ?>" alt="<?php echo htmlspecialchars($category['name']); ?>" class="mb-2 max-w-xs">
                <?php endif; ?>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="image" type="file" name="image" accept="image/*">
            </div>
            <div class="mb-4">
                <label class="inline-flex items-center">
                    <input type="checkbox" class="form-checkbox" name="is_active" <?php echo $category['is_active'] ? 'checked' : ''; ?>>
                    <span class="ml-2">Active</span>
                </label>
            </div>
            <div class="flex items-center justify-between">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                    Update Category
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