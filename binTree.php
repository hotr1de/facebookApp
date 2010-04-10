<html><body>
<?php
class binTree
{
    public $data = "HELLO";
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

    function prin($horizontal)
    {
	if ($this->left == null && $this->right == null) {
		echo $this->data;
	} elseif ($horizontal) {
		echo "<table border=1><tr><td>";
		$this->left->prin(!$horizontal);
		echo "</td><td>";
		$this->right->prin(!$horizontal);
		echo "</td></tr></table>";
	} else {
		echo "<table border=1><tr><td>";
		$this->left->prin(!$horizontal);
		echo "</td></tr> <tr><td>";
		$this->right->prin(!$horizontal);
		echo "</td></tr></table>";
	}
    }
}
    

function buildtree($darr)
{
	$tree = new binTree();
	foreach ($darr as $d) {
		$tree->split();
	}

	return $tree;
}

$a = array(1,2,3,4);
$b = buildtree($a);
$b->prin(1);
