<?php
// Application: tag cloud 

error_reporting(E_ALL);

//require_once 'includes/binTree.php';
require_once 'includes/binTree.php';
require_once 'facebookAPI/facebook-platform/php/facebook.php';
$appapikey = '59f818f601c19ba21c6124f6631b23cf';
$appsecret = 'ac08c579883901c53ac76d3296f4daaa';
$facebook = new Facebook($appapikey, $appsecret);
$user_id = $facebook->require_login();
$currentUser = $facebook->api_client->users_getLoggedInUser();
$userFullName = $facebook->api_client->users_getInfo($currentUser,'first_name, last_name');
$userFullName = $userFullName[0]['first_name']." ".$userFullName[0]['last_name'];

echo "<link rel='stylesheet' href='includes/style.css' media='screen' type='text/css'>";

//retrieve interest to compare with
$interest = $_GET['tag'];
$interest = str_replace("_"," ",$interest);
$interest = trim($interest);

//use FQL to do to compare interests
$query = "SELECT uid, name, pic_big, hometown_location, activities, interests, music, tv, movies, books, profile_url FROM user WHERE uid IN (SELECT uid2 FROM friend WHERE uid1 = 32104247)";

$result=$facebook->api_client->fql_query($query);
$hasInCommonNm = array();
$hasInCommonID = array();
$name = "";
for($i = 0; $i < count($result); $i++) {
   if(stristr($result[$i]['music'], $interest) || 
      stristr($result[$i]['activities'], $interest) || 
      stristr($result[$i]['interests'], $interest) || 
      stristr($result[$i]['tv'], $interest) || 
      stristr($result[$i]['movies'], $interest) ||  
      stristr($result[$i]['books'], $interest)  
     ) { 
     array_push($hasInCommonNm, $result[$i]['name']);
     array_push($hasInCommonID, $result[$i]['uid']);
   }
}
$_POST['users'] = $hasInCommonID;
$friendTree = buildTree($hasInCommonNm, "user");
?>
Friends who like <?php echo $interest; ?>
<div style="width:500px;">
<?php $friendTree->prin(1,0); ?>
</div>
<?php

?>


