<?php
ob_start();
session_start();
if($_SESSION['name']!='snchousebd')
{
header('location: login.php');
}

?>

<?php
if(!isset($_REQUEST['ID']))
{
	header("location:manage_category.php");
}
else
{
		$id=$_REQUEST['ID'];
}

?>
<?php include_once("config.php"); ?>
<?php

$statement1=$db->prepare('delete from tbl_category where cat_id=?');
$statement1->execute(array($id));

header("location:manage_category.php");
?>