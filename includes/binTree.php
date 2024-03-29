<?php
class binTree
{
    public $data;
    public $right = null;
    public $left = null;

    function __construct()
    {
      
    }

    function split()
    {
	if ($this->left == null) {
		$this->left = new binTree();
		$this->right = new binTree();
	} else if (rand(0,1) == 1) {
		$this->right->split();
	} else {
		$this->left->split();
	}
    }

    function addInfo(&$arr)
    {
	if ($this->left == null) {
	    $this->data = array_pop($arr);
            $cleanTag = trim($this->data);
            $cleanTag = urlencode($cleanTag);
            $link = "'friends.php?tag=$cleanTag'";
            $this->data = "<div class='cloud' onClick=\"window.location=$link\"><font style='color:rgb(".rand(0,128).",".rand(0,128).",".rand(0,128)."); font-size:".rand(8,16)."pt'>".$this->data."</font></div>";
	} else {
	    $this->left->addInfo($arr);
	    $this->right->addInfo($arr);
	}
    }

    function addUser(&$arr)
    {
	if ($this->left == null) {
	    $this->data = array_pop($arr);
            $id = array_pop($_POST['users']);
            $pic = array_pop($_POST['pics']);
            $cleanUsr = str_replace(" ","_",trim($this->data));
            $htmlUsr = utf8_decode(html_entity_decode($this->data));
            $link = "'index.php?uid=$id&name=$this->data'";
            $this->data = "<div class='cloud' onMouseOver=\"doTooltip(event, 0, '$pic');\" onMouseOut='hideTip()' onClick=\"window.location=$link\"><font style='color:rgb(".rand(0,128).",".rand(0,128).",".rand(0,128)."); font-size:".rand(8,16)."pt'>".$htmlUsr."</font></div>";
	} else {
	    $this->left->addUser($arr);
	    $this->right->addUser($arr);
	}
    }

    function prin($horizontal, $hCount)
    {
	if ($this->left == null && $this->right == null) {
		echo $this->data;
	} elseif ($horizontal && ($hCount < 3)) {
                $hCount++;
		echo "<table><tr><td valign='middle'>\n";
		$this->left->prin(!$horizontal, $hCount);
		echo "</td><td valign='middle'>\n";
		$this->right->prin(!$horizontal, $hCount);
		echo "</td></tr>\n</table>\n";
	} else {
		echo "<table><tr><td valign='middle'>\n";
		$this->left->prin(!$horizontal, $hCount);
		echo "</td></tr> <tr><td valign='middle'>\n";
		$this->right->prin(!$horizontal, $hCount);
		echo "</td></tr></table>\n";
	}
    }

    function prinIE($horizontal, $hCount)
    {
	if ($this->left == null && $this->right == null) {
		echo $this->data;
	} elseif ($horizontal && ($hCount < 3)) {
                $hCount++;
		echo "<table><tr><td valign='middle'>\n";
		$this->left->prin(!$horizontal, $hCount);
		echo "</td><td valign='middle'>\n";
		$this->right->prin(!$horizontal, $hCount);
		echo "</td></tr>\n</table>\n";
	} else {
		echo "<table><tr><td valign='middle'>\n";
		$this->left->prin(!$horizontal, $hCount);
		echo "</td></tr> <tr><td valign='middle'>\n";
		$this->right->prin(!$horizontal, $hCount);
		echo "</td></tr></table>\n";
	}
    }


/* 
    function printHTML($horizontal)
    {
	if ($this->left == null && $this->right == null) {
		echo $this->data;
	} elseif ($horizontal) {
		echo "<table><tr><td>";
		$this->left->prin(!$horizontal);
		echo "</td><td>";
		$this->right->prin(!$horizontal);
		echo "</td></tr></table>";
	} else {
		echo "<table><tr><td>";
		$this->left->prin(!$horizontal);
		echo "</td></tr> <tr><td>";
		$this->right->prin(!$horizontal);
		echo "</td></tr></table>";
	}
    }
*/
}


function buildtree($darr, $type)
{       
	$tree = new binTree();
        $tree->type = $type;
	for($i=0; $i< (count($darr)-1); $i++) {
		$tree->split();
	}
        if($type == "info") $tree->addInfo($darr);
        else $tree->addUser($darr);
	return $tree;
}


