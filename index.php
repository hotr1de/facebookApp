<?php
// Application: tag cloud 
//header('P3P: CP="CAO PSA OUR"');
header('P3P:CP="IDC DSP COR ADM DEVi TAIi PSA PSD IVAi IVDi CONi HIS OUR IND CNT"');
error_reporting(E_ALL);

require_once 'includes/binTree.php';
require_once 'facebookAPI/facebook-platform/php/facebook.php';
$appapikey = '59f818f601c19ba21c6124f6631b23cf';
$appsecret = 'ac08c579883901c53ac76d3296f4daaa';
$facebook = new Facebook($appapikey, $appsecret);
$user_id = $facebook->require_login($required_permissions = 'publish_stream');
//$currentUser = $facebook->api_client->users_getLoggedInUser();
$userFullName = $facebook->api_client->users_getInfo($user_id,'name');
$userFullName = $userFullName[0]['name'];

//$message = 'in ur tubez'; 
//$facebook->api_client->stream_publish($message);

?>
<html>
<head>
<link rel='stylesheet' href='includes/style.css' media='screen' type='text/css'></head>
<body>

<?php
if(isset($_GET['uid'])) $user_id = $_GET['uid'];
if(isset($_GET['name'])) $userFullName = $_GET['name'];

$userSmallPic = $facebook->api_client->users_getInfo($user_id,'pic_square');
$userSmallPic = $userSmallPic[0]['pic_square'];

//unset 'shared' users data if it exists
if(isset($_POST['users'])) unset($_POST['users']);
if(isset($_POST['pics'])) unset($_POST['pics']);

$likesStr = utf8_decode($userFullName)." likes:";
// state whose info it is
echo "<div style='height:50px; width:".(strlen($likesStr) * 15)."px; border:3px solid #3B5998; background: #ffffff'><img src='$userSmallPic' align='left' style='border-right:3px solid #3B5998'/><div style='float:left; margin-top:14px; margin-left:10px;'>$likesStr</div></div>";

$info = $facebook->api_client->users_getInfo($user_id,'music,interests,movies, activities, tv, books');

$music = $info[0]['music'];
$interests = $info[0]['interests'];
$movies = $info[0]['movies'];
$activities = $info[0]['activities'];
$tv = $info[0]['tv'];
$books = $info[0]['books'];

$tags = "";
if($music) $tags .= $music.",";
if($interests) $tags .= $interests.",";
if($movies) $tags .= $movies.",";
if($activities) $tags .= $activities.",";
if($tv) $tags .= $tv.",";
if($books) $tags .= $books;

//splits the info string delimited by , ; / .
//and puts each element in the new info array
$tags = preg_split("/[,.\/\;]+/",$tags);
array_pop($tags);
$infoTree = buildtree($tags, "info");
?>


<div style="width:400px;">
<?php $infoTree->prin(1,0); ?>
</div>
<?php
?>

</body>
</html>
