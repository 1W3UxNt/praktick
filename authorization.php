<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'form';

// создаем соединение с базой данных
$conn = mysqli_connect($host, $user, $pass, $db);

// проверяем, удалось ли подключиться
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
}

// проверяем, что запрос был выполнен с методом POST и защищаем форму от CSRF-атак
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['csrf_token']) && $_POST['csrf_token'] === $_SESSION['csrf_token']) {
    // проверяем, что email не пустой и является корректным email-адресом
    if (!empty($_POST['mail']) && filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {
        $mail = mysqli_real_escape_string($conn, $_POST['mail']);
        $password = mysqli_real_escape_string($conn, $_POST['psw']);
    } else {
        echo "Некорректный email";
        exit();
    }
}

// подготавливаем и выполняем запрос к базе данных и защищаем пароль от инъекций SQL
$stmt = mysqli_prepare($conn, "SELECT password FROM form WHERE email = ?");
mysqli_stmt_bind_param($stmt, 's', $mail);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $db_password);
mysqli_stmt_fetch($stmt);
print_r(mysqli_stmt_affected_rows($stmt));exit();

// проверяем, были ли получены данные из таблицы
if (mysqli_stmt_affected_rows($stmt) > 0) {
    // сравниваем введенный пароль с хэшем пароля в базе данных
    if (password_verify($password, $db_password)) {
        // если пароли совпали, то создаем сессию для пользователя и переходим на страницу welcome.php
        session_start();
        $_SESSION['email'] = $mail;
        header("Location: welcome.php");
        exit();
    } else {
        echo "Неверный пароль";
    }
} else {
    echo "Пользователь с таким email не найден";
}

?>
