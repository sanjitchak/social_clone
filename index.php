<?php
$conn = mysqli_connect("localhost","root","","social");
if(mysqli_connect_errno())
{
    echo "Cannot connect :". mysqli_connect_errno();
}
$query = mysqli_query($conn, "INSERT into test values(' ','Rash')");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    Hello
    <br>
    <a href = "register.php">Register</a>
</body>
</html>