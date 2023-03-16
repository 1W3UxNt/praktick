<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'form';

$conn = mysqli_connect($host, $user, $pass, $db);
if ($conn === false) {
    error_log("ERROR: Could not connect. " . mysqli_connect_error());
    trigger_error("Could not connect to database");
}

$email = mysqli_real_escape_string($conn, $_POST['email']);
$password = mysqli_real_escape_string($conn, $_POST['password']);

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "Invalid email format";
    exit;
}

$stmt = mysqli_prepare($conn, "SELECT email, password FROM form WHERE email = ?");
mysqli_stmt_bind_param($stmt, 's', $email);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $db_email, $hashed_password);
mysqli_stmt_fetch($stmt);

if (password_verify($password, $hashed_password)) {
    session_start();
    $_SESSION['email'] = $email;
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    header("Location: welcome.php");
    exit;
} else {
    echo "Invalid email or password";
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>
