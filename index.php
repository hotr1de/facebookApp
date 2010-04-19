<?php
// Application: tag cloud 

error_reporting(E_ALL);

require_once 'includes/binTree.php';
require_once 'facebookAPI/facebook-platform/php/facebook.php';
$appapikey = '59f818f601c19ba21c6124f6631b23cf';
$appsecret = 'ac08c579883901c53ac76d3296f4daaa';
$facebook = new Facebook($appapikey, $appsecret);
$user_id = $facebook->require_login();
$currentUser = $facebook->api_client->users_getLoggedInUser();
$userFullName = $facebook->api_client->users_getInfo($currentUser,'name');
$userFullName = $userFullName[0]['name'];
echo "<link rel='stylesheet' href='includes/style.css' media='screen' type='text/css'>";

if(isset($_GET['uid'])) $currentUser = $_GET['uid'];
if(isset($_GET['name'])) $userFullName = $_GET['name'];

if(isset($_POST['users'])) unset($_POST['users']);
if(isset($_POST['pics'])) unset($_POST['pics']);

// state whose info it is
echo "<p>$userFullName likes :</p>";

$info = $facebook->api_client->users_getInfo($currentUser,'music,interests,movies, activities, tv, books');

$music = $info[0]['music'];
$interests = $info[0]['interests'];
$movies = $info[0]['movies'];
$activities = $info[0]['activities'];
$tv = $info[0]['tv'];
$books = $info[0]['books'];
$info = $music.",".$interests.",".$movies.",".$activities.",".$tv.",".$books;

//splits the info string delimited by commas and periods
//and puts each element in the new info array
$info = preg_split("/[,.\/\;]+/",$info);

$infoTree = buildtree($info, "info");
?>
<div style="width:400px;">
<?php $infoTree->prin(1,0); ?>
</div>
<?php

?>


