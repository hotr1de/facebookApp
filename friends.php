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

//retrieve interest to compare with
$interest = $_GET['interest'];

//retrieve list of friends
$friends = $facebook->api_client->friends_get();

/* compare interest with 100 friends
for($i = 0; $i < 100; $i++) {
   $friendInfo=$facebook->api_client->users_getInfo($friends[$i],'music,name');
   $friendMusic = $friendInfo[0]['music'];
   $friendName = $friendInfo[0]['name'];
   $friendMusic = preg_split("/,/",$friendMusic);
   if(in_array($interest, $friendMusic)) {
         echo "$interest - ".$friends[$i]." $friendName<br>";
   }
}
*/

//use FQL to do the task

$query = "SELECT name FROM group WHERE gid IN (SELECT gid FROM group_member WHERE uid = '$currentUser')";
$result=$facebook->api_client->fql_query($query);
print_r($result);

?>


