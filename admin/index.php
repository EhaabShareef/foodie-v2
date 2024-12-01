<?php
// admin/dashboard.php
require_once '../includes/template.php';
require_once '../models/Order.php';

$template->setLayout(__DIR__ . '/../layouts/admin_layout.php');

$orderCounts = Order::getOrderCountsByStatus();
$projectedRevenue = Order::getProjectedRevenue();
$earnedRevenue = Order::getEarnedRevenue();
$lostRevenue = Order::getLostRevenue();

defineSection('title', function() {
    echo 'Admin Dashboard';
});

defineSection('header', function() {
    echo 'Dashboard';
});

defineSection('content', function() use ($orderCounts, $projectedRevenue, $earnedRevenue, $lostRevenue) {
?>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="bg-white overflow-hidden shadow rounded-lg col-span-3">
            <div class="p-5 ">
                <div class="flex items-start">
                    <div class="flex-shrink-0 bg-indigo-500 rounded-md p-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-file-chart-column-increasing">
                        <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"/><path d="M14 2v4a2 2 0 0 0 2 2h4"/><path d="M8 18v-2"/><path d="M12 18v-4"/><path d="M16 18v-6"/>
                    </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-neutral-500 truncate">
                                Order Status Counts
                            </dt>
                            <dd class="mt-1 text-sm text-neutral-900">
                                <ul>
                                    <li class="text-xs mb-2 mt-4">Pending: <?php echo $orderCounts['Pending']; ?></li>
                                    <li class="text-xs mb-2">Processing: <?php echo $orderCounts['Processing']; ?></li>
                                    <li class="text-xs mb-2">Delivered: <?php echo $orderCounts['Delivered']; ?></li>
                                    <li class="text-xs mb-2">Cancelled: <?php echo $orderCounts['Cancelled']; ?></li>
                                </ul>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="flex flex-row justify-end text-sm items-center">
                <a href="/admin/orders/index.php" class="font-medium text-indigo-600 hover:text-indigo-500 flex items-center px-5 py-4">
                    <span class="mr-2">View all orders</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-move-right"><path d="M18 8L22 12L18 16"/><path d="M2 12H22"/></svg>
                </a>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-start">
                    <div class="flex-shrink-0 bg-cyan-500 rounded-md p-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chart-line">
                        <path d="M3 3v16a2 2 0 0 0 2 2h16"/><path d="m19 9-5 5-4-4-3 3"/></svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">
                                Projected Revenue
                            </dt>
                            <dd class="text-3xl font-semibold text-gray-900">
                            ރ <?php echo number_format($projectedRevenue, 2); ?>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-start">
                    <div class="flex-shrink-0 bg-emerald-500 rounded-md p-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-dollar-sign">
                        <circle cx="12" cy="12" r="10"/><path d="M16 8h-6a2 2 0 1 0 0 4h4a2 2 0 1 1 0 4H8"/><path d="M12 18V6"/></svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">
                                Revenue Earned
                            </dt>
                            <dd class="text-3xl font-semibold text-gray-900">
                            ރ <?php echo number_format($earnedRevenue, 2); ?>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-start">
                    <div class="flex-shrink-0 bg-red-500 rounded-md p-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-dollar-sign">
                        <circle cx="12" cy="12" r="10"/><path d="M16 8h-6a2 2 0 1 0 0 4h4a2 2 0 1 1 0 4H8"/><path d="M12 18V6"/></svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">
                                Lost Revenue
                            </dt>
                            <dd class="text-3xl font-semibold text-gray-900">
                            ރ <?php echo number_format($lostRevenue, 2); ?>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
});

$template->render();