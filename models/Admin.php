<?php
require_once __DIR__ . '/../includes/db_connection.php';

class Admin {
    // Login function
    public static function login($username, $password) {
        $conn = getDbConnection();
        $stmt = $conn->prepare("SELECT * FROM admin WHERE user_name = ? AND verified_yn = 'Y' LIMIT 1");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $admin = $result->fetch_assoc();
        $stmt->close();
        $conn->close();

        if ($admin && password_verify($password, $admin['password'])) {
            // Start session and store admin data
            session_start();
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_username'] = $admin['user_name'];
            return true;
        }
        return false;
    }

    // Check for authentication
    public static function checkAdminSession() {
        session_start();
        if (!isset($_SESSION['admin_id'])) {
            header('Location: /login.php');
            exit;
        }
    }

    //get session user info
    public static function getCurrentAdmin() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        return isset($_SESSION['admin_id']) ? self::getById($_SESSION['admin_id']) : null;
    }

    //check if any user is logged in
    public static function isLoggedIn() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        return isset($_SESSION['admin_id']);
    }
    

    // Logout function
    public static function logout() {
        session_start();
        session_unset();
        session_destroy();
    }

    // Create new admin
    public static function create($full_name, $username, $password) {
        $conn = getDbConnection();
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $verified = 'N';
        $created_at = date('Y-m-d H:i:s');
        
        $stmt = $conn->prepare("INSERT INTO admin (full_name, user_name, password, verified_yn, created_at) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $full_name, $username, $hashed_password, $verified, $created_at);
        $result = $stmt->execute();
        $stmt->close();
        $conn->close();
        return $result;
    }

    // Update admin
    public static function update($id, $full_name, $username, $password = null) {
        $conn = getDbConnection();
        $updated_at = date('Y-m-d H:i:s');
        
        if ($password) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("UPDATE admin SET full_name = ?, user_name = ?, password = ?, updated_at = ? WHERE id = ?");
            $stmt->bind_param("ssssi", $full_name, $username, $hashed_password, $updated_at, $id);
        } else {
            $stmt = $conn->prepare("UPDATE admin SET full_name = ?, user_name = ?, updated_at = ? WHERE id = ?");
            $stmt->bind_param("sssi", $full_name, $username, $updated_at, $id);
        }
        
        $result = $stmt->execute();
        $stmt->close();
        $conn->close();
        return $result;
    }

    // Delete admin
    public static function delete($id) {
        $conn = getDbConnection();
        $stmt = $conn->prepare("DELETE FROM admin WHERE id = ?");
        $stmt->bind_param("i", $id);
        $result = $stmt->execute();
        $stmt->close();
        $conn->close();
        return $result;
    }

    // Approve user (set verified_yn to 'Y')
    public static function approveUser($id) {
        $conn = getDbConnection();
        $verified = 'Y';
        $updated_at = date('Y-m-d H:i:s');
        
        $stmt = $conn->prepare("UPDATE admin SET verified_yn = ?, updated_at = ? WHERE id = ?");
        $stmt->bind_param("ssi", $verified, $updated_at, $id);
        $result = $stmt->execute();
        $stmt->close();
        $conn->close();
        return $result;
    }

    // Get all admins
    public static function getAll() {
        $conn = getDbConnection();
        $result = $conn->query("SELECT id, full_name, user_name, verified_yn, created_at, updated_at FROM admin ORDER BY full_name");
        $admins = [];
        while ($row = $result->fetch_assoc()) {
            $admins[] = $row;
        }
        $conn->close();
        return $admins;
    }

    // Get admin by ID
    public static function getById($id) {
        $conn = getDbConnection();
        $stmt = $conn->prepare("SELECT id, full_name, user_name, verified_yn, created_at, updated_at FROM admin WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $admin = $result->fetch_assoc();
        $stmt->close();
        $conn->close();
        return $admin;
    }
}