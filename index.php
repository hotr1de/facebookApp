<?php
// Application: tag cloud 

error_reporting(E_ALL);

//require_once 'includes/binTree.php';
require_once 'facebookAPI/facebook-platform/php/facebook.php';
$appapikey = '59f818f601c19ba21c6124f6631b23cf';
$appsecret = 'ac08c579883901c53ac76d3296f4daaa';
$facebook = new Facebook($appapikey, $appsecret);
$user_id = $facebook->require_login();
$currentUser = $facebook->api_client->users_getLoggedInUser();
$userFullName = $facebook->api_client->users_getInfo($currentUser,'first_name, last_name');
$userFullName = $userFullName[0]['first_name']." ".$userFullName[0]['last_name'];

// Greet the currently logged-in user!
echo "<p>Hello, $userFullName</p>";

//use 32104238 as user 
$info = $facebook->api_client->users_getInfo($currentUser,'music,interests,movies');

$music = $info[0]['music'];
$interests = $info[0]['interests'];
$movies = $info[0]['movies'];
$info = $music.",".$interests.",".$movies;;
$info = preg_split("/,/",$info);

$friends = $facebook->api_client->friends_get();
echo count($friends);

?><div style="width:600px;"><?php
foreach($info as $tag) {
   trim($tag);
   echo "<a href='friends.php?interest=$tag' style='text-decoration:none'>\n";
   echo "<font style='font-size:".rand(8,20)."px; color:rgb(".rand(0,255).",".rand(0,255).",".rand(0,255).");'>$tag</font>\n";
   echo "</a>\n";
}

?></div><?php
?>
