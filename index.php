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
$sql = "INSERT INTO form (email, password)
VALUES ('$mail', '$password' )";

if(mysqli_query($conn, $sql)){
  mysqli_close($conn);
  header("Location: index.html");
  exit;
} 
else{
  echo "Ошибка $sql. "
      . mysqli_error($conn);
  mysqli_close($conn);
}
if(mysqli_query($conn, $sql)){
  mysqli_close($conn);
  echo "<script>alert('Информация добавлена.');</script>";
  header("Location: index.html");
  exit;
} 
else{
  echo "Ошибка $sql. "
      . mysqli_error($conn);
  mysqli_close($conn);
}

?>
