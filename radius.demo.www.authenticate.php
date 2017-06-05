<?php

$custom_auth_realm       = "Pure PHP radius class";
$custom_auth_timeout     = 15*60; // Custom authentification timeout without activity (default is 900 seconds)
$custom_ip_radius_server = '127.0.0.1';
$custom_shared_secret    = 'secret';

require_once("radius.www.authenticate.php");

echo "User <strong>".$_SERVER['PHP_AUTH_USER']."</strong> authenticated.";

?>
