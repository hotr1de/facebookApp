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
$interest = $_GET['interest'];

$friends = $facebook->api_client->friends_get();
$info = $facebook->api_client->users_getInfo($currentUser,'music'); 
$music = $info[0]['music'];
$music = preg_split("/,/",$music);

/* compare music of two users
//use 32104238 as user 
$samInfo = $facebook->api_client->users_getInfo('32104238','music');
$samMusic = $samInfo[0]['music'];
$samMusic = preg_split("/,/",$samMusic);

foreach($music as $band) {
  if( in_array($band, $samMusic) ) echo $band;
}
*/
for($i = 0; $i < 100; $i++) {
   $friendInfo = $facebook->api_client->users_getInfo($friends[$i],'music,name');
   $friendMusic = $friendInfo[0]['music'];
   $friendName = $friendInfo[0]['name'];
   $friendMusic = preg_split("/,/",$friendMusic);
   foreach($friendMusic as $friendBand) {
      if(in_array($friendBand, $music)) {
         echo "$friendBand - ".$friends[$i]." $friendName<br>";
      }
   }
}
/*
foreach($friends as $friend) {
   $friendInfo = $facebook->api_client->users_getInfo($friend,'music');
   $friendMusic = $friendInfo[0]['music'];
   $friendMusic = preg_split("/,/",$friendMusic);
   foreach($friendMusic as $friendBand) {
      if(in_array($friendBand, $music)) {
         echo "$friendBand - $friend";
      }
   }
}
*/
?>


