<?php
include("../../config/config.php");
include("../classes/User.php");
include("../classes/Message.php");
$limit = 5;
$message = new Message($conn, $_REQUEST['userLoggedIn']);
echo $message->getConvosDropdown($_REQUEST, $limit);

?>