<?php
$host= 'localhost';
$user = 'root';
$pass = '';
$db = 'form';
  
$conn = mysqli_connect($host , $user , $pass , $db);
if($conn === false){
  die("ERROR: Could not connect. "
      . mysqli_connect_error());
}

$mail = mysqli_real_escape_string($conn,$_POST['mail']);
$password = mysqli_real_escape_string($conn,$_POST['psw']);
$password = md5($_POST['password']); 
$sql = "SELECT * FROM form";
$result = mysqli_query($conn, $sql);

// Выводим результаты запроса
if (mysqli_num_rows($result) > 0) {
  // Выводим данные каждой строки
  while($row = mysqli_fetch_assoc($result)) {
      echo "id: " . $row["id"]. " - Name: " . $row["name"]. " - Email: " . $row["email"]. "<br>";
  }
} else {
  echo "0 results";
}



mysqli_close($conn);
?>
