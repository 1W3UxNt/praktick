<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'form';

$conn = mysqli_connect($host, $user, $pass, $db);
if ($conn === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

$mail = $_POST['mail'];
$password = md5($_POST['psw']);

// Использование подготовленных выражений
$stmt = mysqli_prepare($conn, "SELECT * FROM form WHERE email=? AND password=?");
mysqli_stmt_bind_param($stmt, 'ss', $mail, $password);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_assoc($result);
    session_start();
    $_SESSION['login'] = true;
    header("Location: welcome.php");
} else {
    // Если пользователь с таким email не найден, выводится сообщение об ошибке
    echo '<script>alert("Неверный логин."); window.location.href="authorization.html";</script>';
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
