<?php

// if (!isset($_SESSION['login']) && !$_SESSION['login']) {
// 	header("Location: authorization.html");
// 	exit();
// }

$mail = $_SESSION['email'];
?>

<!DOCTYPE html>
<html>
<head>
	<title>Добро пожаловать</title>
</head>
<body>
	<h2>Добро пожаловать, <?php echo $mail; ?></h2>
	<p>Вы успешно авторезировались.</p>
	<p><a href="logout.php">Выйти</a></p>
</body>
</html>
