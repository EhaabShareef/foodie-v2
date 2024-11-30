<?php
require_once __DIR__ . '/../includes/db_connection.php';

class FoodItem {
    public static function getAll() {
        $conn = getDbConnection();
        $result = $conn->query("SELECT f.*, c.name as category_name FROM food f JOIN food_category c ON f.category_id = c.id WHERE f.is_active = 1 ORDER BY f.name");
        $items = [];
        while ($row = $result->fetch_assoc()) {
            $items[] = $row;
        }
        $conn->close();
        return $items;
    }

    public static function getById($id) {
        $conn = getDbConnection();
        $stmt = $conn->prepare("SELECT f.*, c.name as category_name FROM food f JOIN food_category c ON f.category_id = c.id WHERE f.id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $item = $result->fetch_assoc();
        $stmt->close();
        $conn->close();
        return $item;
    }

    public static function add($category_id, $name, $description, $price, $image) {
        $conn = getDbConnection();
        $image_path = self::uploadImage($image);
        
        $stmt = $conn->prepare("INSERT INTO food (category_id, name, description, price, image_path) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("issds", $category_id, $name, $description, $price, $image_path);
        $result = $stmt->execute();
        $stmt->close();
        $conn->close();
        return $result;
    }

    public static function update($id, $category_id, $name, $description, $price, $image, $is_active) {
        $conn = getDbConnection();
        
        if ($image['size'] > 0) {
            $image_path = self::uploadImage($image);
            $stmt = $conn->prepare("UPDATE food SET category_id = ?, name = ?, description = ?, price = ?, image_path = ?, is_active = ? WHERE id = ?");
            $stmt->bind_param("issdsis", $category_id, $name, $description, $price, $image_path, $is_active, $id);
        } else {
            $stmt = $conn->prepare("UPDATE food SET category_id = ?, name = ?, description = ?, price = ?, is_active = ? WHERE id = ?");
            $stmt->bind_param("issdsi", $category_id, $name, $description, $price, $is_active, $id);
        }
        
        $result = $stmt->execute();
        $stmt->close();
        $conn->close();
        return $result;
    }

    public static function delete($id) {
        $conn = getDbConnection();
        $stmt = $conn->prepare("DELETE FROM food WHERE id = ?");
        $stmt->bind_param("i", $id);
        $result = $stmt->execute();
        $stmt->close();
        $conn->close();
        return $result;
    }

    private static function uploadImage($image) {
        $target_dir = $_SERVER['DOCUMENT_ROOT'] . "/public/uploads/food_items/";
        $file_extension = pathinfo($image["name"], PATHINFO_EXTENSION);
        $file_name = uniqid() . "." . $file_extension;
        $target_file = $target_dir . $file_name;
        
        if (move_uploaded_file($image["tmp_name"], $target_file)) {
            return "/public/uploads/food_items/" . $file_name;
        } else {
            throw new Exception("Sorry, there was an error uploading your file.");
        }
    }
}