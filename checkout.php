<?php
// checkout.php
require_once 'includes/template.php';
require_once 'models/Order.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_SESSION['cart'])) {
    header('Location: cart.php');
    exit;
}

$customer_name = $_POST['customer_name'] ?? '';
$customer_email = $_POST['customer_email'] ?? '';
$customer_phone = $_POST['customer_phone'] ?? '';

$cart = $_SESSION['cart'];
$total_amount = array_sum(array_map(function($item) {
    return $item['price'] * $item['quantity'];
}, $cart));

$order_id = Order::create($customer_name, $customer_email, $customer_phone, $total_amount, $cart);

if ($order_id) {
    // Clear the cart after successful order creation
    unset($_SESSION['cart']);
}

$template->setLayout(__DIR__ . '/layouts/main_layout.php');

defineSection('title', function() {
    echo 'Order Confirmation - Foodie MV';
});

defineSection('content', function() use ($order_id) {
?>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-4xl font-bold mb-8 text-center">Order Confirmation</h1>

        <?php if ($order_id): ?>
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-8" role="alert">
                <p class="font-bold">Order Placed Successfully!</p>
                <p>Your order number is: <?php echo $order_id; ?></p>
            </div>
            <p class="text-center mb-8">Thank you for your order. We'll start preparing it right away!</p>
        <?php else: ?>
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-8" role="alert">
                <p class="font-bold">Oops!</p>
                <p>There was an error processing your order. Please try again.</p>
            </div>
        <?php endif; ?>

        <div class="text-center">
            <a href="menu.php" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                Back to Menu
            </a>
        </div>
    </div>
<?php
});

$template->render();