<?php
require_once 'config.php';

// Get all articles ordered by newest first
function get_articles($conn) {
    $sql = "SELECT id, title, author, content, image, created_at FROM articles ORDER BY created_at DESC";
    $result = $conn->query($sql);
    $articles = [];
    if ($result) {
        while($row = $result->fetch_assoc()) {
            $articles[] = $row;
        }
    }
    return $articles;
}

// Get article by id
function get_article_by_id($conn, $id) {
    $stmt = $conn->prepare("SELECT * FROM articles WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $article = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    return $article;
}

// Create new article
function create_article($conn, $title, $author, $content, $image = null) {
    $stmt = $conn->prepare("INSERT INTO articles (title, author, content, image, created_at) VALUES (?, ?, ?, ?, NOW())");
    $stmt->bind_param("ssss", $title, $author, $content, $image);
    $stmt->execute();
    $success = $stmt->affected_rows > 0;
    $stmt->close();
    return $success;
}

// Update article
function update_article($conn, $id, $title, $author, $content, $image = null) {
    if ($image) {
        $stmt = $conn->prepare("UPDATE articles SET title = ?, author = ?, content = ?, image = ? WHERE id = ?");
        $stmt->bind_param("ssssi", $title, $author, $content, $image, $id);
    } else {
        $stmt = $conn->prepare("UPDATE articles SET title = ?, author = ?, content = ? WHERE id = ?");
        $stmt->bind_param("sssi", $title, $author, $content, $id);
    }
    $stmt->execute();
    $success = $stmt->affected_rows >= 0;
    $stmt->close();
    return $success;
}
// Delete article by id
function delete_article($conn, $id) {
    $stmt = $conn->prepare("DELETE FROM articles WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $success = $stmt->affected_rows > 0;
    $stmt->close();
    return $success;
}


// Check if admin username exists
function admin_exists($conn, $username) {
    $stmt = $conn->prepare("SELECT id FROM admins WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    $exists = $stmt->num_rows > 0;
    $stmt->close();
    return $exists;
}

// Create new admin user with password hashing
function create_admin($conn, $username, $password) {
    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO admins (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $password_hash);
    $stmt->execute();
    $success = $stmt->affected_rows > 0;
    $stmt->close();
    return $success;
}

// Fungsi untuk memverifikasi login admin
function verify_admin($conn, $username, $password) {
    $stmt = $conn->prepare("SELECT id, password FROM admins WHERE username = ?");
    if (!$stmt) {
        return false;
    }
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result && $row = $result->fetch_assoc()) {
        if (password_verify($password, $row['password'])) {
            return $row['id'];
        }
    }
    return false;
}

// Fungsi untuk memeriksa apakah user sudah ada
function user_exists($conn, $username) {
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    $exists = $stmt->num_rows > 0;
    $stmt->close();
    return $exists;
}

// Fungsi untuk membuat user baru
function create_user($conn, $username, $password) {
    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $password_hash);
    $stmt->execute();
    $success = $stmt->affected_rows > 0;
    $stmt->close();
    return $success;
}

// Fungsi untuk memverifikasi login user
function verify_user($conn, $username, $password) {
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
    if (!$stmt) {
        return false;
    }
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result && $row = $result->fetch_assoc()) {
        if (password_verify($password, $row['password'])) {
            return $row['id'];
        }
    }
    return false;
}
?>