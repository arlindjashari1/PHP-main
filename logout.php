<?php // logout.php
require __DIR__ . '/auth.php';
logout();
header('Location: /php_mysql_media_starter/login.php');
exit;
