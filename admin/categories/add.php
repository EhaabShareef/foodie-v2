<?php
require_once '../../includes/template.php';
require_once '../../models/Category.php';

$template->setLayout(__DIR__ . '/../../layouts/admin_layout.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $description = $_POST['description'] ?? '';
    $image = $_FILES['image'] ?? null;

    try {
        if (Category::add($name, $description, $image)) {
            header('Location: index.php');
            exit;
        } else {
            $error = "Failed to add category.";
        }
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}

defineSection('title', function() {
    echo 'Add Category';
});

defineSection('header', function() {
    echo 'Add New Category';
});

defineSection('content', function() {
?>
    <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">

        <form action="" method="POST" enctype="multipart/form-data">
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                    Name
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="name" type="text" name="name" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="description">
                    Description
                </label>
                <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="description" name="description" rows="3"></textarea>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="image">
                    Image
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="image" type="file" name="image" accept="image/*">
            </div>
            <div class="flex items-center justify-between">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                    Add Category
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