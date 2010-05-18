<?php
// Application: tag cloud 
error_reporting(E_ALL);
header('content-type: text/html; charset: utf-8'); 
?>
<head>
<link rel='stylesheet' href='includes/style.css' media='screen' type='text/css'>
<script src="http://code.jquery.com/jquery-latest.js"></script>
<script src="includes/tooltip.js" media="screen"></script>
<script type='text/javaScript' src='includes/corners/curvycorners.src.js'></script>
<script type="text/JavaScript">

  addEvent(window, 'load', initCorners);

  function initCorners() {
    var settings = {
      tl: { radius: 10 },
      tr: { radius: 10 },
      bl: { radius: 10 },
      br: { radius: 10 },
      antiAlias: true
    }

    /*
    Usage:

    curvyCorners(settingsObj, selectorStr);
    curvyCorners(settingsObj, Obj1[, Obj2[, Obj3[, . . . [, ObjN]]]]);

    selectorStr ::= complexSelector [, complexSelector]...
    complexSelector ::= singleSelector[ singleSelector]
    singleSelector ::= idType | classType
    idType ::= #id
    classType ::= [tagName].className
    tagName ::= div|p|form|blockquote|frameset // others may work
    className : .name
    selector examples:
      #mydiv p.rounded
      #mypara
      .rounded
    */
    curvyCorners(settings, ".cloud");
  }

</script>

</head>
<body>
<?php
//include the binTree cloud generator and faceboko API
require_once 'includes/binTree.php';
require_once 'facebookAPI/facebook-platform/php/facebook.php';
$appapikey = '59f818f601c19ba21c6124f6631b23cf';
$appsecret = 'ac08c579883901c53ac76d3296f4daaa';
$facebook = new Facebook($appapikey, $appsecret);
//require the user to be logged in
$user_id = $facebook->require_login();

//retrieve interest to compare with
$interest = $_GET['tag'];
//$interest = str_replace("_"," ",$interest);
$interest = trim($interest);
$interest = urldecode($interest);
$interest = str_replace("\\", "", $interest);

//use FQL to do to compare interests
$query = "SELECT uid, name, pic, hometown_location, activities, interests, music, tv, movies, books, profile_url FROM user WHERE uid IN (SELECT uid2 FROM friend WHERE uid1 = '$user_id')";

//perform query
$result=$facebook->api_client->fql_query($query);

//arrays hold users that share a tag - their name, uid, and pic url
$hasInCommonNm = array();
$hasInCommonID = array();
$pics = array();

//add push user data to each array if they share a given tag
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
     array_push($pics, $result[$i]['pic']);
   }
}

//set post variables in order to use user data in binTree.php
$_POST['users'] = $hasInCommonID;
$_POST['pics'] = $pics;

//build cloud displaying usernames
$friendTree = buildTree($hasInCommonNm, "user");

if(count($hasInCommonNm) > 0) {
?>
	Your friends who like <i><?php echo utf8_decode($interest); ?></i>
        &nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:history.go(-1);">back</a>
	<div style="width:500px;">
	<?php $friendTree->prin(1,0); ?>
	</div>
<?php
}
else {
   echo "No one else likes <i>$interest</i><br><br>";
   echo "<a href='javascript:history.go(-1);'>back</a>";
}
?>

</body>
</html>
