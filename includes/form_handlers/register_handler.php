<?php
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
          $username = strtolower($fname."_". $lname)."_". $i;
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