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

    function add(&$arr)
    {
	if ($this->left == null) {
	    $this->data = array_pop($arr);
	} else {
	    $this->left->add($arr);
	    $this->right->add($arr);
	}
    }

    function prin($horizontal)
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
}


function buildtree($darr)
{
	$tree = new binTree();
	for($i=0; $i< (count($darr)-1); $i++) {
		$tree->split();
	}
        $tree->add($darr);
	return $tree;
}


