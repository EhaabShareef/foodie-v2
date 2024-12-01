<?php
require_once __DIR__ . '/../includes/db_connection.php';

class Order {

    // get all orders function
    public static function getAll() {
        $conn = getDbConnection();
        $result = $conn->query("SELECT * FROM orders ORDER BY created_at DESC");
        $orders = [];
        while ($row = $result->fetch_assoc()) {
            $orders[] = $row;
        }
        $conn->close();
        return $orders;
    }

    // get order based on Id
    public static function getById($id) {
        $conn = getDbConnection();
        $stmt = $conn->prepare("SELECT * FROM orders WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $order = $result->fetch_assoc();
        $stmt->close();
        $conn->close();
        return $order;
    }

    // get order items based on order id
    public static function getOrderItems($orderId) {
        $conn = getDbConnection();
        $stmt = $conn->prepare("SELECT oi.*, f.name as food_name FROM order_items oi JOIN food f ON oi.food_id = f.id WHERE oi.order_id = ?");
        $stmt->bind_param("i", $orderId);
        $stmt->execute();
        $result = $stmt->get_result();
        $items = [];
        while ($row = $result->fetch_assoc()) {
            $items[] = $row;
        }
        $stmt->close();
        $conn->close();
        return $items;
    }

    // update order status
    public static function updateStatus($id, $status) {
        $conn = getDbConnection();
        $stmt = $conn->prepare("UPDATE orders SET status = ?, updated_at = NOW() WHERE id = ?");
        $stmt->bind_param("si", $status, $id);
        $result = $stmt->execute();
        $stmt->close();
        $conn->close();
        return $result;
    }

    // create order from cart page
    /*
        1. insert order first
        2. loop and insert order items
    */
    public static function create($customer_name, $customer_email, $customer_phone, $total_amount, $cart_items) {
        $conn = getDbConnection();
        
        // Start transaction
        $conn->begin_transaction();
    
        try {
            // Insert order
            $stmt = $conn->prepare("INSERT INTO orders (customer_name, customer_email, customer_phone, total_amount, status) VALUES (?, ?, ?, ?, 'pending')");
            if (!$stmt) {
                throw new Exception("Prepare failed: " . $conn->error);
            }
            $stmt->bind_param("sssd", $customer_name, $customer_email, $customer_phone, $total_amount);
            if (!$stmt->execute()) {
                throw new Exception("Execute failed: " . $stmt->error);
            }
            $order_id = $stmt->insert_id;
            $stmt->close();
    
            // Insert order items
            $stmt = $conn->prepare("INSERT INTO order_items (order_id, food_id, quantity, item_price) VALUES (?, ?, ?, ?)");
            if (!$stmt) {
                throw new Exception("Prepare failed: " . $conn->error);
            }
            foreach ($cart_items as $item) {
                $stmt->bind_param("iiid", $order_id, $item['id'], $item['quantity'], $item['price']);
                if (!$stmt->execute()) {
                    throw new Exception("Execute failed: " . $stmt->error);
                }
            }
            $stmt->close();
    
            // Commit transaction
            $conn->commit();
            $conn->close();
    
            return $order_id;
        } catch (Exception $e) {
            // Rollback transaction on error
            $conn->rollback();
            $conn->close();
            error_log("Error creating order: " . $e->getMessage());
            return false;
        }
    }

    // for admin dashboard statistic cards
    public static function getOrderCountsByStatus() {
        $conn = getDbConnection();
        $result = $conn->query("SELECT status, COUNT(*) as count FROM orders GROUP BY status");
        $counts = [
            'Pending' => 0,
            'Processing' => 0,
            'Delivered' => 0,
            'Cancelled' => 0
        ];
        while ($row = $result->fetch_assoc()) {
            $counts[$row['status']] = $row['count'];
        }
        $conn->close();
        return $counts;
    }

    public static function getProjectedRevenue() {
        $conn = getDbConnection();
        $result = $conn->query("SELECT SUM(total_amount) as projected_revenue FROM orders WHERE status != 'Cancelled'");
        $row = $result->fetch_assoc();
        $conn->close();
        return $row['projected_revenue'] ?? 0;
    }

    public static function getEarnedRevenue() {
        $conn = getDbConnection();
        $result = $conn->query("SELECT SUM(total_amount) as earned_revenue FROM orders WHERE status = 'Delivered'");
        $row = $result->fetch_assoc();
        $conn->close();
        return $row['earned_revenue'] ?? 0;
    }

    public static function getLostRevenue() {
        $conn = getDbConnection();
        $result = $conn->query("SELECT SUM(total_amount) as earned_revenue FROM orders WHERE status = 'Cancelled'");
        $row = $result->fetch_assoc();
        $conn->close();
        return $row['lost_revenue'] ?? 0;
    }
}