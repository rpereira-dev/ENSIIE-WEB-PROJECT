<?php

session_start();


class Joueur {
	public $val;

	public function __construct($v) {
		$this->val = $v;
	}
}

if (isset($_SESSION['pass'])) {
	echo unserialize($_SESSION['pass'])->val;
}

$_SESSION['pass'] = serialize(new Joueur("hello world 2"));

?>