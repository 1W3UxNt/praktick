<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'form';

$conn = mysqli_connect($host, $user, $pass, $db);
if ($conn === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

// Использование подготовленных выражений
$stmt = mysqli_prepare($conn, "INSERT INTO form (email, password) VALUES (?, ?)");
if ($stmt === false) {
    die("ERROR: Could not prepare statement. " . mysqli_error($conn));
}

$mail = $_POST['mail'];
$password = $_POST['psw'];

// Использование md5 для хеширования пароля
$hashed_password = md5($password);

mysqli_stmt_bind_param($stmt, 'ss', $mail, $hashed_password);

if (mysqli_stmt_execute($stmt)) {
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    echo '<script>alert("Информация добавлена успешно."); window.location.href="reg.html";</script>';
    exit;
} else {
    echo "Ошибка: " . mysqli_error($conn);
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>
