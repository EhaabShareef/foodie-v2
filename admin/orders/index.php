<?php
require_once '../../includes/template.php';
require_once '../../models/Order.php';

$template->setLayout(__DIR__ . '/../../layouts/admin_layout.php');

defineSection('title', function() {
    echo 'Manage Orders';
});

defineSection('header', function() {
    echo 'Orders';
});

defineSection('content', function() {
    $orders = Order::getAll();
?>
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">
                Order List
            </h3>
        </div>
        <div class="border-t border-gray-200">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Order ID
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Customer Name
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Total Amount
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
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
                    <?php foreach ($orders as $order): ?>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            <?php echo htmlspecialchars($order['id']); ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <?php echo htmlspecialchars($order['customer_name']); ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        ރ <?php echo number_format($order['total_amount'], 2); ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-2 inline-flex text-xs leading-5 font-semibold rounded-lg bg-<?php echo $order['status'] === 'Delivered' ? 'green' : 'yellow'; ?>-100 text-<?php echo $order['status'] === 'Delivered' ? 'green' : 'yellow'; ?>-800">
                                <?php echo ucfirst(htmlspecialchars($order['status'])); ?>
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <?php echo date('Y-m-d H:i:s', strtotime($order['created_at'])); ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-xs font-medium">
                            <a href="show.php?id=<?php echo $order['id']; ?>" class="text-emerald-600 hover:text-emerald-900 mr-2">View</a>
                            <a href="status.php?id=<?php echo $order['id']; ?>" class="text-cyan-600 hover:text-cyan-900">Change Status</a>
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