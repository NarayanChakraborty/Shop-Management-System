<?php
ob_start();
session_start();
if($_SESSION['name']!='snchousebd')
{
header('location: login.php');
}

?>

<?php include_once('header.php'); ?>
<?php include_once('sidebar.php'); ?>
<?php require_once('config.php'); ?>
<?php 
if(isset($_POST['submit'])){
   
    try{
   
	
	  $old_password=$_POST['current_password'];
	  $old_password=md5($old_password);
	  $num=0;
	  $name=$_POST['name'];
	  
	  //$result=mysql_query("select * from admin where password='$old_password'");
       $statement=$db->prepare("select * from tbl_login where password=? and username=?");
	   $statement->execute(array($old_password,$name));
	  $num=$statement->rowCount();
	  if($num==0)
	  {
	    throw new Exception(' Wrong Information');
	  }

	  $new_password=$_POST['new_password'];
	  $new_password=md5($new_password);
	  //$check=mysql_query("update admin set password='$new_password' where id=1");
	  /*$result=mysql_query("insert into student (std_name,std_roll,std_age,std_email) values('$_POST[name]',
	  '$_POST[roll]','$_POST[age]','$_POST[email]')");
	  */
	  $statement=$db->prepare("update tbl_login set password=? where id=1 and username=?");
	  $statement->execute(array($new_password,$name));
	$success_message="Data inserted succesfully";
		
	}
	catch (Exception $e) {
    $error_message = $e->getMessage();
  }
}    	
?>

 <div class="row">


		<div class="col-xs-12 col-sm-8 col-md-9">
		
		
 <div class="col-md-offset-4 col-md-6 validation-grids widget-shadow" data-example-id="basic-forms" style="margin-top:20px;"> 
							<div class="form-title">
								<h4 align="center" ><u>Change Your Password</u></h4><br>
																								
								<?php
                      if(isset($error_message)){
                        ?>
                        <div class="alert alert-block alert-danger fade in">
                          <button data-dismiss="alert" class="close close-sm" type="button">
                          <i class="icon-remove">x</i>
                          </button>
                          <strong>Opps!&nbsp; </strong><?php echo $error_message;?>
                       </div>
                        <?php
                      }
                      if (isset($success_message)) {
                       ?>
                        <div class="alert alert-block alert-success fade in">
                          <button data-dismiss="alert" class="close close-sm" type="button">
                          <i class="icon-remove">x</i>
                          </button>
                          <strong>Well done!&nbsp; </strong><?php echo $success_message;?>
                       </div>
                       <?php
                        }
                      ?>
					  
					  <div class="form-body" >
								<form data-toggle="validator"  action="change_password.php" method="POST">
									<div class="form-group">
									<label>Your Name:</label>
										<input type="text" class="form-control" name="name" id="inputName" placeholder="name" required>
									</div>
									<div class="form-group">
									<label>Current Password:</label>
									  <input type="password" data-toggle="validator" data-minlength="6" class="form-control"  name="current_password"placeholder="Password" required>
									</div>
									<div class="form-group">
									<label>New Password:</label>
									  <input type="password" data-toggle="validator" data-minlength="6" class="form-control" id="inputPassword" name="new_password"placeholder="Password" required>
									  <span class="help-block">Minimum of 6 characters</span>
									</div>
									<div class="form-group">
									<label>Confirm Password:</label>
									  <input type="password" class="form-control" id="inputPasswordConfirm" data-match="#inputPassword" name="confirm_password" data-match-error="Whoops, these don't match" placeholder="Confirm password" required>
									  <div class="help-block with-errors"></div>
									</div>

									<div class="form-group">
										<div class="checkbox">
											<label>
												<input type="checkbox" id="terms" data-error="Before you wreck yourself" required>
												I have read and accept terms of use.
											</label>
											<div class="help-block with-errors"></div>
										</div>
									</div>
									<div class="form-group">
										<button type="submit" name="submit" class="btn btn-primary disabled">Submit</button>
									</div>
								</form>
							</div>
							</div>
					  
					  
					  
					  </div>
					  
					</div>
              <!-- page end-->
 
      <!--main content end-->
  </div>
  <?php include_once('footer.php'); ?>