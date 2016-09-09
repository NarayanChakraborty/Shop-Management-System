<?php
ob_start();
session_start();
if($_SESSION['name']!='snchousebd')
{
header('location: login.php');
}

?>


<?php 
include_once("config.php");
?>
<?php
if(!isset($_REQUEST['id']))
{
	header('location:dealer_customers_with_due.php');
}
else
{
	
	
	 $id=$_REQUEST['id'];
	 
	
	 $statement=$db->prepare("delete from tbl_dealer_two where d_id=?");
	 $statement->execute(array($id));
	 //$success_msg2="Category has been successfully Deleted";
	 //echo ""
	 header('location:dealer_customers_with_due.php');
 }
?>