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

$mail = mysqli_real_escape_string($conn,$_POST['email']);
$password = mysqli_real_escape_string($conn,$_POST['password']);

$sql = "INSERT INTO form (email, password)
VALUES ('$email', '$password' )";

if(mysqli_query($conn, $sql)){
  echo "<h3>Информация добавлена.</h3>";  
} else{
  echo "Ошибка $sql. "
      . mysqli_error($conn);
}

mysqli_close($conn);
?>
