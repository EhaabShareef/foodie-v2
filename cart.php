<?php
// cart.php
require_once 'includes/template.php';

session_start();

// Handle cart updates
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_cart'])) {
        foreach ($_POST['quantity'] as $id => $quantity) {
            if ($quantity > 0) {
                $_SESSION['cart'][$id]['quantity'] = $quantity;
            } else {
                unset($_SESSION['cart'][$id]);
            }
        }
    } elseif (isset($_POST['remove_item'])) {
        $id = $_POST['remove_item'];
        unset($_SESSION['cart'][$id]);
    }
    
    // Redirect to prevent form resubmission
    header('Location: cart.php');
    exit;
}

$template->setLayout(__DIR__ . '/layouts/main_layout.php');

defineSection('title', function() {
    echo 'Your Cart - Foodie MV';
});

defineSection('content', function() {
    $cart = $_SESSION['cart'] ?? [];
    $total = 0;
?>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-4xl font-bold mb-8 text-center">Your Cart</h1>

        <?php if (empty($cart)): ?>
            <p class="text-center text-xl">Your cart is empty.</p>
            <div class="text-center mt-8">
                <a href="menu.php" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                    Back to Menu
                </a>
            </div>
        <?php else: ?>
            <form method="POST" action="cart.php">
                <div class="bg-white shadow-md rounded-lg overflow-hidden mb-8">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Item</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subtotal</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php foreach ($cart as $id => $item): ?>
                                <?php $subtotal = $item['price'] * $item['quantity']; $total += $subtotal; ?>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($item['name']); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap">$<?php echo number_format($item['price'], 2); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="number" name="quantity[<?php echo $id; ?>]" value="<?php echo $item['quantity']; ?>" min="0" class="w-16 px-2 py-1 border rounded">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">$<?php echo number_format($subtotal, 2); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <button type="submit" name="remove_item" value="<?php echo $id; ?>" class="text-red-600 hover:text-red-900">Remove</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr class="bg-gray-50">
                                <td colspan="3" class="px-6 py-4 text-right font-bold">Total:</td>
                                <td class="px-6 py-4 font-bold">$<?php echo number_format($total, 2); ?></td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="flex justify-between items-center mb-8">
                    <a href="menu.php" class="text-blue-500 hover:text-blue-600">
                        &larr; Back to Menu
                    </a>
                    <button type="submit" name="update_cart" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                        Update Cart
                    </button>
                </div>
            </form>

            <form action="checkout.php" method="POST" class="bg-white shadow-md rounded-lg p-8">
                <h2 class="text-2xl font-bold mb-6">Customer Information</h2>
                <div class="mb-4">
                    <label for="customer_name" class="block text-gray-700 text-sm font-bold mb-2">Name</label>
                    <input type="text" id="customer_name" name="customer_name" required
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mb-4">
                    <label for="customer_email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                    <input type="email" id="customer_email" name="customer_email" required
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mb-6">
                    <label for="customer_phone" class="block text-gray-700 text-sm font-bold mb-2">Phone</label>
                    <input type="tel" id="customer_phone" name="customer_phone" required
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="flex items-center justify-end">
                    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Proceed to Checkout
                    </button>
                </div>
            </form>
        <?php endif; ?>
    </div>
<?php
});

$template->render();