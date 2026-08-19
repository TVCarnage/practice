<?php
session_start();
require_once "config.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
   $email = trim($_POST['email']);
   $password = trim($_POST['password']);
   // Prepare SQL query
   $sql = "SELECT * FROM users WHERE email = ?";
   if ($stmt = mysqli_prepare($conn, $sql)) {
       mysqli_stmt_bind_param($stmt, "s", $email);
       mysqli_stmt_execute($stmt);
       $result = mysqli_stmt_get_result($stmt);
       if ($row = mysqli_fetch_assoc($result)) {
           // Verify password
           if (password_verify($password, $row['password'])) {
               $_SESSION["user_id"] = $row['id'];
               header("Location: welcome.php");
               exit;
           } else {
               echo "Invalid password.";
           }
       } else {
           echo "No account found with that email.";
       }
       mysqli_stmt_close($stmt);
   }
}
mysqli_close($conn);
?>