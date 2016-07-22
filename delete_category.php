
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