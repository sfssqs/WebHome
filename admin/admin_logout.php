<?php
require('../include/common.inc.php');
session_start();
if (isset($_SESSION['pyadmin'])){
	unset($_SESSION['pyadmin']);
	
}
msg('','location="default.php"');
?>
