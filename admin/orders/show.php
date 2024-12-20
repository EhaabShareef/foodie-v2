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

$orderItems = Order::getOrderItems($id);

defineSection('title', function() use ($order) {
    echo 'View Order #' . $order['id'];
});

defineSection('header', function() use ($order) {
    echo 'Order #' . $order['id'] . ' Details';
});

defineSection('content', function() use ($order, $orderItems) {
?>
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-neutral-900">
                Order Information
            </h3>
        </div>
        <div class="border-t border-neutral-200 px-4 py-5 sm:p-0">
            <dl class="sm:divide-y sm:divide-neutral-200">
                <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-neutral-500">
                        Order ID
                    </dt>
                    <dd class="mt-1 text-sm text-neutral-900 sm:mt-0 sm:col-span-2">
                        <?php echo htmlspecialchars($order['id']); ?>
                    </dd>
                </div>
                <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-neutral-500">
                        Customer Details
                    </dt>
                    <dd class="mt-1 text-sm font-semibold text-neutral-900 sm:mt-0 sm:col-span-2">
                        <?php echo htmlspecialchars($order['customer_name'] ?? 'Guest'); ?> <br>
                        <span class="text-xs font-medium"> Contact : <?php echo htmlspecialchars($order['customer_phone']); ?></span>
                    </dd>
                </div>
                <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-neutral-500">
                        Total Amount
                    </dt>
                    <dd class="mt-1 text-sm text-neutral-900 sm:mt-0 sm:col-span-2">
                    ރ <?php echo number_format($order['total_amount'], 2); ?>
                    </dd>
                </div>
                <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-neutral-500">
                        Status
                    </dt>
                    <dd class="mt-1 text-sm text-neutral-900 sm:mt-0 sm:col-span-2">
                        <span class="px-4 py-2 inline-flex text-xs leading-5 font-semibold rounded-lg bg-<?php echo $order['status'] === 'Delivered' ? 'green' : 'yellow'; ?>-100 text-<?php echo $order['status'] === 'Delivered' ? 'green' : 'yellow'; ?>-800">
                            <?php echo ucfirst(htmlspecialchars($order['status'])); ?>
                        </span>
                    </dd>
                </div>
                <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-neutral-500">
                        Ordered At
                    </dt>
                    <dd class="mt-1 text-sm text-neutral-900 sm:mt-0 sm:col-span-2">
                        <?php echo date('d-m-Y H:i', strtotime($order['created_at'])); ?>
                    </dd>
                </div>
            </dl>
        </div>
    </div>

    <div class="mt-8 bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-neutral-900">
                Order Items
            </h3>
        </div>
        <div class="border-t border-neutral-200">
            <table class="min-w-full divide-y divide-neutral-200">
                <thead class="bg-neutral-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">
                            Item
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">
                            Quantity
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">
                            Price
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">
                            Subtotal
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-neutral-200">
                    <?php foreach ($orderItems as $item): ?>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-neutral-900">
                            <?php echo htmlspecialchars($item['food_name']); ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-500">
                            <?php echo htmlspecialchars($item['quantity']); ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-500">
                        ރ <?php echo number_format($item['item_price'], 2); ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-500">
                        ރ <?php echo number_format($item['quantity'] * $item['item_price'], 2); ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6 ms-3">
        <a href="index.php" class="font-semibold text-orange-500 hover:text-orange-700">Back to Orders</a>
    </div>
<?php
});

$template->render();