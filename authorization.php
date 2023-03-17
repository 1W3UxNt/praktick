<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'form';

// создаем соединение с базой данных
$conn = mysqli_connect($host, $user, $pass, $dbname);

// проверяем, удалось ли подключиться
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
}

// проверяем, что запрос был выполнен с методом POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $mail = mysqli_real_escape_string($conn, $_POST['mail']);
    $password = mysqli_real_escape_string($conn, $_POST['psw']);

    // проверяем валидность email-адреса
    if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
        echo "не правильный пароль";
        exit;
    }

    // подготавливаем и выполняем запрос к базе данных
    $stmt = mysqli_prepare($conn, "SELECT mail, password FROM users WHERE mail = ?");
    mysqli_stmt_bind_param($stmt, 's', $mail);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $db_mail, $db_password, $db_id);
    mysqli_stmt_fetch($stmt);

    // сравниваем введенный пароль с хэшем пароля в базе данных
    if (password_verify($password, $db_password)) {
        // если пароли совпали, то создаем сессию для пользователя
        session_start();
        $_SESSION['mail'] = $mail;
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        header("Location: welcome.php");
        exit;
    } else {
        // если пароли не совпали, то выводим сообщение об ошибке
        echo '<script>alert("Ошибка."); window.location.href="autorization.html";</script>';
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    }
}
?>
