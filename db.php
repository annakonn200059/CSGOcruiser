<?php 
require "rb-mysql.php";

R::setup( 'mysql:host=127.0.0.1;dbname=cruiser',
   'taran', '' );
session_start();
ob_start();
?>