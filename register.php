<?php
session_start();
$conn = mysqli_connect("localhost","root","","social");
if(mysqli_connect_errno())
{
    echo "Cannot connect :". mysqli_connect_errno();
}
 $fname = "";
$lname = "";
$em = "";
$em2 = "";
$pass = "";
$pass2 = "";
$date = "";
$error_array = array();

if(isset($_POST['register_button']))
{
    $fname = strip_tags($_POST['reg_fname']) ;
    $fname = str_replace(' ','',$fname);
    $fname = ucfirst(strtolower($fname));
    $_SESSION['reg_fname'] = $fname;

    $lname = strip_tags($_POST['reg_lname']) ;
    $lname = str_replace(' ','',$lname);
    $lname = ucfirst(strtolower($lname));
    $_SESSION['reg_lname'] = $lname;

    $em = strip_tags($_POST['reg_email']) ;
    $em = str_replace(' ','',$em);
    $_SESSION['reg_email'] = $em;

    $em2 = strip_tags($_POST['reg_email2']) ;
    $em2 = str_replace(' ','',$em2);
    $_SESSION['reg_email2'] = $em2;

    $pass = strip_tags($_POST['reg_password']) ;
    $_SESSION['reg_password'] = $pass;

    $pass2 = strip_tags($_POST['reg_password2']) ;
    $_SESSION['reg_password2'] = $pass2;
  $date = date("Y-m-d");
  if ($em == $em2)
  {
      if(filter_var($em, FILTER_VALIDATE_EMAIL))
      {
  $em = filter_var($em, FILTER_VALIDATE_EMAIL);
  $e_check = mysqli_query($conn, "Select email from users where  email='$em'  ");
  $num_of_rows = mysqli_num_rows($e_check);
  if($num_of_rows > 0)
  {
      array_push($error_array,"Email is used   <br>");
  }

      }
      else {
        array_push($error_array,"Invalid Email  <br>");
      }
      
  }
  else {
    array_push($error_array,"Email not match <br>");
  }

  if(strlen($fname) > 25|| strlen($fname) < 2)
  {
    array_push($error_array,"Your first name should be between 2 and 25 <br>");
  }
  if(strlen($lname) > 25 || strlen($lname) < 2)
  {
    array_push($error_array,"Your last name should be between 2 and 25 <br>");
  }
   if($pass != $pass2){
    array_push($error_array,"Password not matching <br>");
   }
   else {
       if(preg_match('/[^A-Za-z0-9]/',$pass)){
        array_push($error_array,"Type only letters or numbers in password<br>");
       }
   }
   if(strlen($pass)>25 || strlen($pass)<5)
   {
    array_push($error_array,"type password between 25 and 5 words <br>");
   }
   if(empty($error_array))
   {
       $pass = md5($pass);
       $username = strtolower($fname."_". $lname) ;
       $i = 0;
       $check_username_query  = mysqli_query($conn,"Select username from users where username = '$username' ");
       while(mysqli_num_rows($check_username_query) != 0)
       {
          $i ++;
          $username = $username."_". $i;
          $check_username_query  = mysqli_query($conn,"Select username from users where username = '$username' ");
        }
 $rand =  rand(1,2);
 if ($rand == 1)
 {
     $profile_pics = "assets/images/profile_pics/defaults/ic_launcher-web.png";
 }
 else if($rand == 2)
 {
     $profile_pics="assets/images/profile_pics/defaults/images.png";
 }
$query = mysqli_query($conn, "Insert into users values ( '' ,'$fname', '$lname', '$username' , '$em' , '$pass','$date','$profile_pics' , '0','0','no', ',')");
array_push($error_array, "<span style= 'color:#14C000;'>   You are done</span>");   

$_SESSION['reg_fname'] ="";
$_SESSION['reg_lname'] ="";
$_SESSION['reg_email'] ="";
$_SESSION['reg_email2'] ="";
}
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Social Network</title>
</head>
<body>
<form action="register.php" method="POST">
    <input type="text" name="reg_fname" placeholder="First Name" value= "<?php if(isset($_SESSION['reg_fname'])) {
        echo $_SESSION['reg_fname'];
    } ?>" required>
    <br>
    <?php 
    if(in_array("Your first name should be between 2 and 25 <br>",$error_array))
    {
echo "Your first name should be between 2 and 25 <br>";
    }
    ?>
    <input type="text" name="reg_lname" placeholder="Last Name" value= "<?php if(isset($_SESSION['reg_lname'])) {
        echo $_SESSION['reg_lname'];
    } ?>"  required>
    <br> 
    <?php 
    if(in_array("Your last name should be between 2 and 25 <br>",$error_array))
    {
echo "Your last name should be between 2 and 25 <br>";
    }
    ?>
    <input type="email" name="reg_email" placeholder="Email" value= "<?php if(isset($_SESSION['reg_email'])) {
        echo $_SESSION['reg_email'];
    } ?>"  required>
    <br>
    <?php 
    if(in_array("Email is used   <br>",$error_array))
    { echo "Email is used   <br>"; }
    if(in_array("Invalid Email  <br>",$error_array))
    { echo "Invalid Email  <br>"; }
    ?>
    <input type="email" name="reg_email2" placeholder="Confirm Email" value= "<?php if(isset($_SESSION['reg_email2'])) {
        echo $_SESSION['reg_email2'];
    } ?>" required>
    <br>
    <?php
    if(in_array("Email not match <br>",$error_array))
    { echo "Email not match <br>"; }
    ?>

    <input type="password" name="reg_password" placeholder="Password" required>
    <br>
    <input type="password" name="reg_password2" placeholder="Confirm Password" required>
    <br>
    <?php
     if(in_array("Type only letters or numbers in password<br>",$error_array))
     { echo "Type only letters or numbers in password<br>"; }
     if(in_array("Password not matching <br>",$error_array))
     { echo "Password not matching <br>"; }
     if(in_array("type password between 25 and 5 words <br>",$error_array))
     { echo "type password between 25 and 5 words <br>"; }
    ?>
    <input type="submit" name="register_button" value="Register">
    <br>
    <?php
    if(in_array("<span style= 'color:#14C000;'>   You are done</span>",$error_array))
     { echo "<span style= 'color:#14C000;'>   You are done</span>"; }
     ?>
    </form>
</body>
</html>