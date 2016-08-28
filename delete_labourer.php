<?php 
include_once("config.php");
?>
<?php
if(!isset($_REQUEST['id']))
{
	header('location:view_labourer.php');
}
else
{
	
	
	 $id=$_REQUEST['id'];
	 
	
	 $statement=$db->prepare("delete from tbl_labourer where l_id=?");
	 $statement->execute(array($id));
	 //$success_msg2="Category has been successfully Deleted";
	 //echo ""
	 header('location:view_labourer.php');
 }
?>