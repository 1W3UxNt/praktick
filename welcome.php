<?php
session_start();

if (!isset($_SESSION['mail'])) {
	header("Location: index.html");
	exit();
}

$mail = $_SESSION['mail'];
?>

<!DOCTYPE html>
<html>
<head>
	<title>Добро пожаловать</title>
</head>
<body>
	<h2>Добро пожаловать, <?php echo $mail; ?></h2>
	<p>Вы успешно аутентифицировались.</p>
	<p><a href="logout.php">Выйти</a></p>
</body>
</html>
