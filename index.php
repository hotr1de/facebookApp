<?php
// Copyright 2007 Facebook Corp.  All Rights Reserved. 
// 
// Application: Test Guessing Game
// File: 'index.php' 
//require_once 'facebook.php';
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
//use 32104238 for a mock user
$info = $facebook->api_client->users_getInfo($currentUser,'music,interests');
$music = $info[0]['music'];
$interests = $info[0]['interests'];
$info = $music.",".$interests;
$info = preg_split("/,/",$info);
foreach($info as $tag) {
  ?>
  <div style="position:absolute; top:<?php echo rand(30,475); ?>px; left:<?php echo rand(0,500); ?>px">
    <a href="http://www.google.com/#hl=en&source=hp&q=<?php echo $tag;?>&aq=f&aqi=g10&aql=&oq=&gs_rfai=&fp=bcdf8cbbf06dc4f" target="_blank">
    <font style="font-size:<?php echo rand(6,17); ?>pt">
    <?php echo $tag; ?>
    </font>
    </a>
  </div>
  <?php
  }
?>

