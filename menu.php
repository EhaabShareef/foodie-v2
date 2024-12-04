<?php
// menu.php
require_once 'includes/template.php';
require_once 'models/Category.php';
require_once 'models/FoodItem.php';

session_start();

$template->setLayout(__DIR__ . '/layouts/main_layout.php');

$categories = Category::getAll();
$foodItems = FoodItem::getAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $itemId = $_POST['item_id'];
    $item = FoodItem::getById($itemId);
    
    if ($item) {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        
        if (isset($_SESSION['cart'][$itemId])) {
            $_SESSION['cart'][$itemId]['quantity']++;
        } else {
            $_SESSION['cart'][$itemId] = [
                'id' => $item['id'],
                'name' => $item['name'],
                'price' => $item['price'],
                'quantity' => 1
            ];
        }
    }
    
    // Redirect to prevent form resubmission
    header('Location: menu.php');
    exit;
}

defineSection('title', function() {
    echo 'Our Menu - Foodie MV';
});

defineSection('content', function() use ($categories, $foodItems) {
?>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-4xl font-bold mb-4 font-dyna text-orange-400 text-center">Our Menu</h1>

        <!-- Category Selection -->
        <div class="mb-8">
            <h2 class="text-2xl font-semibold mb-6 font-dyna text-neutral-700">Categories</h2>
            <div class="flex flex-wrap gap-4" id="category-buttons">
                <button class="category-btn bg-orange-500 hover:bg-orange-400 text-white font-bold py-2 px-4 rounded" data-category="all">
                    All
                </button>
                <?php foreach ($categories as $category): ?>
                    <button class="font-inter category-btn bg-neutral-200 hover:bg-orange-300 text-gray-800 font-bold py-2 px-4 rounded" data-category="<?php echo htmlspecialchars($category['id']); ?>">
                        <?php echo htmlspecialchars($category['name']); ?>
                    </button>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Food Items Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" id="food-items-grid">
            <?php foreach ($foodItems as $item): ?>
                <div class="food-item bg-white rounded-lg shadow-md overflow-hidden" data-category="<?php echo htmlspecialchars($item['category_id']); ?>">
                    <img src="<?php echo htmlspecialchars($item['image_path']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h3 class="text-xl font-semibold mb-2"><?php echo htmlspecialchars($item['name']); ?></h3>
                        <p class="text-neutral-500 text-sm mb-4"><?php echo htmlspecialchars($item['description']); ?></p>
                        <div class="flex justify-between items-center">
                            <span class="text-xl font-bold">ރ <?php echo number_format($item['price'], 2); ?></span>
                            <form method="POST" action="menu.php">
                                <input type="hidden" name="item_id" value="<?php echo $item['id']; ?>">
                                <button type="submit" name="add_to_cart" class="bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-bold py-2 px-4 rounded">
                                    Add to Cart
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php
});

defineSection('scripts', function() {
?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const categoryButtons = document.querySelectorAll('.category-btn');
            const foodItems = document.querySelectorAll('.food-item');

            categoryButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const category = this.getAttribute('data-category');

                    // Update active button
                    categoryButtons.forEach(btn => btn.classList.remove('bg-orange-500', 'text-white'));
                    categoryButtons.forEach(btn => btn.classList.add('bg-orange-200', 'text-gray-800'));
                    this.classList.remove('bg-orange-200', 'text-gray-800');
                    this.classList.add('bg-orange-600', 'text-white');

                    // Filter food items
                    foodItems.forEach(item => {
                        if (category === 'all' || item.getAttribute('data-category') === category) {
                            item.style.display = 'block';
                        } else {
                            item.style.display = 'none';
                        }
                    });
                });
            });
        });
    </script>
<?php
});

$template->render();