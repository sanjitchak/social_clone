<?php
include("includes/header.php");
?>

<div class="user_details column">
    <a href="<?php echo $userLoggedIn; ?>"><img src="<?php echo $user['profile_pic'] ?>"></a>
    <div class="user_details_left_right">
        <a href="<?php echo $userLoggedIn; ?>">
            <?php
            echo $user['first_name'] . " " . $user['last_name'];
            ?>
        </a>
        <br>
        <?php
        echo "Posts: " . $user['num_posts'] . "<br>";
        echo "Likes: " . $user['num_likes'];
        ?>
 
    </div>
</div>
<div class="main_column column">
    <form class="post_form" action="index.php" method="POST">
        <textarea name="post_text" id="post_text" placeholder="Got something to say?"></textarea>
        <input type="submit" name="post" id="post_button" value="Post">
        <hr>
    </form>

    <div class="posts_area"></div>
    <img id="loading" src="assets/images/icons/loading.gif">

</div>
<div class="user_details column">
<div class="trends">
    <h4> Popular Words </h4>
    <?php $query = mysqli_query($conn, "SELECT * FROM trends ORDER BY hits DESC LIMIT 9");
    foreach ($query as $row) {
    $word = $row['title'];
    $word_dot = strlen($word) >= 14 ? "..." : "";
    $trimmed_word = str_split($word, 14);
    $trimmed_word = $trimmed_word[0];
    echo "<div style='padding: 1px'>";
    echo $trimmed_word . $word_dot;
    echo "<br> </div>";
    }
    ?>
</div>

<script>
var userLoggedIn = '<?php echo $userLoggedIn; ?>';
$(document).ready(function() {
$('#loading').show();
$.ajax({
url: "includes/handlers/ajax_load_posts.php",
type: "POST",
data:  "page=1&userLoggedIn=" + userLoggedIn,
cache: false,

success: function(data) {
$('#loading').hide();
$('.posts_area').html(data);
 
}
}); 
$(window).on("scroll" ,  function() {
    var scrollHeight = $(document).height();
var scrollPosition = $(window).height() + $(window).scrollTop();

var page = $('.posts_area').find('.nextPage').val();
var noMorePosts = $('.posts_area').find('.noMorePosts').val();


 if( ((scrollHeight - scrollPosition) / scrollHeight === 0) && noMorePosts == 'false') {
    $('#loading').show();

 var ajaxReq =    $.ajax({
url: "includes/handlers/ajax_load_posts.php",
type: "POST",
data:  "page="+page +"&userLoggedIn=" + userLoggedIn,
cache: false,

success: function(response) {

    $('.post_area').find('.nextPage').remove();
    $('.posts_area').find('.noMorePosts').remove();
$('#loading').hide();
$('.posts_area').append(response);
}
}); 

}
return false;
}); //window scroll end
});
</script>
</div>
</body>

</html>