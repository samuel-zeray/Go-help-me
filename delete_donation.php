<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}
require 'database.php';

if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
    $id = trim($_GET["id"]);
    $sql = "DELETE FROM donations WHERE id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $param_id);
        $param_id = $id;
        if ($stmt->execute()) {
            header("location: dashboard.php");
        } else {
            echo "Something went wrong. Please try again later.";
        }
        $stmt->close();
    }
    $conn->close();
} else {
    echo "Invalid request.";
}
 include 'footer.php';
?>