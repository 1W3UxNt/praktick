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
$password = $_POST['psw'];

// Использование подготовленных выражений
$stmt = mysqli_prepare($conn, "SELECT * FROM form WHERE email=?");
mysqli_stmt_bind_param($stmt, 's', $mail);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_assoc($result);
    if (password_verify($password, $row['password'])) {
        // Если пароль верен, выполняется авторизация
        session_start();
        $_SESSION['mail'] = $mail;
        header('Location: welcome.php');
        exit;
    } else {
        // Если пароль неверен, выводится сообщение об ошибке
        echo "Неверный пароль";
    }
} else {
    // Если пользователь с таким email не найден, выводится сообщение об ошибке
    echo "Пользователь с таким email не найден";
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
