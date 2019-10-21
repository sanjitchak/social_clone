<?php
require 'config/config.php';
include("includes/classes/User.php");
include("includes/classes/Post.php");
include("includes/classes/Message.php");
include("includes/classes/Notification.php");

if (isset($_SESSION['username'])) {
    $userLoggedIn = $_SESSION['username'];
    $user_details_query = mysqli_query($conn, "SELECT * FROM users WHERE username = '$userLoggedIn'");
    $user = mysqli_fetch_array($user_details_query);
} else {
    header(
        "Location: register.php"
    );
}

$iphone = strpos($_SERVER['HTTP_USER_AGENT'], "iPhone");
$android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");
$palmpre = strpos($_SERVER['HTTP_USER_AGENT'], "webOS");
$berry = strpos($_SERVER['HTTP_USER_AGENT'], "BlackBerry");
$ipod = strpos($_SERVER['HTTP_USER_AGENT'], "iPod");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Social Network</title>
    <script src="http://code.jquery.com/jquery-latest.min.js"></script>
    <script src="assets/js/bootstrap.bundle.js"> </script>
    <script src="assets/js/bootstrap.js"> </script>
    <script src="assets/js/bootbox.min.js"> </script>
    <script src="assets/js/demo.js"> </script>
    <script src="assets/js/jquery.Jcrop.js"></script>
    <script src="assets/js/jcrop_bits.js"></script>
    
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/jquery.Jcrop.css" type="text/css" />


</head>

<body>
    <div class="top_bar">
        <div class="logo">
            <a href="index.php">Swirlfeed</a>
        </div>
<div class="search">

<form action="search.php" method="GET" name="search_form">
<input type="text" onkeyup="getLiveSearchUsers(this.value, '<?php echo $userLoggedIn; ?>')" name="q" placeholder="Search..." autocomplete="off" id="search_text_input">
<div  class="button_holder">
<img src="assets/images/icons/glass.png">
</div>
</form>
<div class="search_results">
</div>
<div class="search_results_footer_empty">
</div>

</div>


        <nav>
<?php
$messages = new Message($conn, $userLoggedIn);
$num_messages = $messages->getUnreadNumber();

$notifications = new Notification($conn, $userLoggedIn);
$num_notifications = $notifications->getUnreadNumber();

$user_obj = new User($conn, $userLoggedIn);
$num_requests = $user_obj->getNumberOfFriendRequests();
?>

            <a href="<?php echo $userLoggedIn; ?>">
                <?php
                echo $user['first_name'];
                ?>
            </a>
            <a href="#"><i style="color:#fff;" class="fas fa-home"></i></a>
            <a href="javascript:void(0);" onclick="getDropdownData('<?php echo $userLoggedIn; ?>', 'message' )"><i  style="color:#fff;"class="far fa-envelope"></i>
        <?php
        if($num_messages > 0)
        echo '<span class="notification_badge" id="unread_message">' . $num_messages . '</span>';
        ?>
        </a>
            <a href="javascript:void(0);" onclick="getDropdownData('<?php echo $userLoggedIn; ?>', 'notification' )"><i  style="color:#fff;"class="far fa-bell"></i>
            <?php
        if($num_notifications > 0)
        echo '<span class="notification_badge" id="unread_notification">' . $num_notifications . '</span>';
        ?>
            </a>
            <a href="requests.php"><i  style="color:#fff;"class="far fa-user"></i>
            <?php
        if($num_requests > 0)
        echo '<span class="notification_badge" id="unread_requests">' . $num_requests . '</span>';
        ?>
            </a>
            <a href="settings.php"><i  style="color:#fff;"class="fas fa-cog"></i></a>
            <a href="includes/handlers/logout.php"><i  style="color:#fff;"class="fas fa-sign-out-alt"></i>

            </a>

        </nav>
<div class="dropdown_data_window" style="height:0px; border:none;"></div>
<input type="hidden" id="dropdown_data_type" value="">



    </div>

    <script>
var userLoggedIn = '<?php echo $userLoggedIn; ?>';
$(document).ready(function() {
    var ajaxReq;

$('.dropdown_data_window').on("scroll" ,  function() {
    var inner_height = $('.dropdown_data_window').innerHeight();
var scroll_top = $('.dropdown_data_window').scrollTop();

var page = $('.dropdown_data_window').find('.nextPageDropdownData').val();
var noMoreData= $('.dropdown_data_window').find('.noMoreDropdownData').val();


 if( (scroll_top + inner_height >= $('.dropdown_data_window')[0].scrollHeight) && noMoreData == 'false') {

var pageName;
var type = $('#dropdown_data_type').val();

if(type == 'notification')
    pageName = "ajax_load_notifications.php";
else if(type = 'message')
     pageName = "ajax_load_messages.php";


 if(ajaxReq) {
    ajaxReq.abort();
        }

  ajaxReq =    $.ajax({
url: "includes/handlers/" + pageName,
type: "POST",
data:  "page="+page +"&userLoggedIn=" + userLoggedIn,
cache: false,
success: function(response) {
 
    $('.dropdown_data_window').find('.nextPageDropdownData').remove();
    $('.dropdown_data_window').find('.noMoreDropdownData').remove();
 $('.dropdown_data_window').append(response);


}
}); 

}
return false;
}); //window scroll end
});
</script>

    <div class="wrapper">