<?php
require_once __DIR__ . '/../includes/db_connection.php';

class Category {

    // view all function
    public static function getAll() {
        $conn = getDbConnection();
        $result = $conn->query("SELECT * FROM food_category WHERE is_active = 1 ORDER BY name");
        $categories = [];
        while ($row = $result->fetch_assoc()) {
            $categories[] = $row;
        }
        $conn->close();
        return $categories;
    }

    // create new function
    public static function add($name, $description, $image) {
        $conn = getDbConnection();
        $image_path = self::uploadImage($image);
        
        $stmt = $conn->prepare("INSERT INTO food_category (name, description, image_path) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $description, $image_path);
        $result = $stmt->execute();
        $stmt->close();
        $conn->close();
        return $result;
    }

    // update/edit functions
    public static function update($id, $name, $description, $image, $is_active) {
        $conn = getDbConnection();
        
        if ($image['size'] > 0) {
            $image_path = self::uploadImage($image);
            $stmt = $conn->prepare("UPDATE food_category SET name = ?, description = ?, image_path = ?, is_active = ? WHERE id = ?");
            $stmt->bind_param("sssii", $name, $description, $image_path, $is_active, $id);
        } else {
            $stmt = $conn->prepare("UPDATE food_category SET name = ?, description = ?, is_active = ? WHERE id = ?");
            $stmt->bind_param("ssii", $name, $description, $is_active, $id);
        }
        
        $result = $stmt->execute();
        $stmt->close();
        $conn->close();
        return $result;
    }


    private static function uploadImage($image) {
        $target_dir = $_SERVER['DOCUMENT_ROOT'] . "/public/uploads/categories/";
        $file_extension = pathinfo($image["name"], PATHINFO_EXTENSION);
        $file_name = uniqid() . "." . $file_extension;
        $target_file = $target_dir . $file_name;
        
        if (move_uploaded_file($image["tmp_name"], $target_file)) {
            return "/public/uploads/categories/" . $file_name;
        } else {
            throw new Exception("Sorry, there was an error uploading your file.");
        }
    }

    public static function delete($id) {
        $conn = getDbConnection();
        $stmt = $conn->prepare("DELETE FROM food_category WHERE id = ?");
        $stmt->bind_param("i", $id);
        $result = $stmt->execute();
        $stmt->close();
        $conn->close();
        return $result;
    }

    public static function getById($id) {
        $conn = getDbConnection();
        $stmt = $conn->prepare("SELECT * FROM food_category WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $category = $result->fetch_assoc();
        $stmt->close();
        $conn->close();
        return $category;
    }
}