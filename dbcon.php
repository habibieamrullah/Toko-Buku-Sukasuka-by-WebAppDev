<?php

$adminusername = "admin";
$adminpassword = "admin";
$tableoptions = "weboptions";

$dbname = "dbbaru";
$dbuser = "root";
$dbpass = "";

$connection = mysqli_connect("localhost", $dbuser, $dbpass, $dbname);
$connection->set_charset("utf8");