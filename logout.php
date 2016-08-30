<?php
ob_start();
session_start();
if($_SESSION['name']!='snchousebd')
{
header('location: index.php');
}
?>	

<?php
session_start();
session_destroy();
header('location: login.php');
?>