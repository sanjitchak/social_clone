<?php
include("../../config/config.php");
include("../classes/User.php");
 
include("../classes/Notification.php");
$limit = 7;
$notification = new Notification($conn, $_REQUEST['userLoggedIn']);
echo $notification->getNotifications($_REQUEST, $limit);

?>