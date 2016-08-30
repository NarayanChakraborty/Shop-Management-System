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
	header('location:view_labourer.php');
}
else
{
	$id=$_REQUEST['ID'];
}
?>


<?php include_once('header.php'); ?>
<?php include_once('sidebar.php'); ?>
<?php require_once('config.php'); ?>

         <?php

if(isset($_POST['l_form'])){
  try {
   
			  if (
        !isset($_FILES['l_image']['error']) ||
        is_array($_FILES['l_image']['error'])
    ) {
        throw new RuntimeException('Invalid parameters.');
    }
		
		
	 //IMAGE MANAGE
        //if no new image is selected  
		if(empty($_FILES['l_image']['name']))
        {
			 //pdo to insert all above informations.. to tbl_post
		   $statement=$db->prepare("update  tbl_labourer set l_name=?,l_contact_no=?,l_type=?,l_nid=?,l_address=?,l_sex=?,l_joining_date=? where l_id=?");
		   $statement->execute(array($_POST['l_name'],$_POST['l_contact_no'],$_POST['l_type'],$_POST['l_nid'],$_POST['l_address'],$_POST['l_sex'],$_POST['l_joining_date'],$id));
		}	
         else
         {
		  if($_FILES['l_image']['size']>1000000)
			      {	   
				throw new Exception("<div class='error'>Sorry,your file is too large</div>"); //image file must be<1MB
												 
			     }
			   
				//access image process one;   
				$up_filename=$_FILES['l_image']['name'];   //file_name
				$file_basename=substr($up_filename,0,strripos($up_filename,'.'));//orginal image name
				$file_ext=substr($up_filename,strripos($up_filename,'.')); //extension
				$f1=$id.$file_ext;  //Rename filename;

				
				//only allow png ,jpg,jpeg,gif
				if(($file_ext!='.png')&&($file_ext!='.jpg')&&($file_ext!='.jpeg')&&($file_ext!='.gif')&&($file_ext!='.PNG')&&($file_ext!='.JPG')&&($file_ext!='.JPEG')&&($file_ext!='.GIF'))
				{
					throw new Exception("only jpg,jpeg,png and gif format are allowed");
				}
				 
				
						$target_folder = 'images/labourer/'; 
    $upload_image = $target_folder.$f1;
				
				
				//To unlink previous image
				
				
                        $statement1=$db->prepare("select * from tbl_labourer where l_id=?");
						$statement1->execute(array($id));
						$result1=$statement1->fetchAll(PDO::FETCH_ASSOC);
						foreach($result1 as $row1)
						{
							$real_path= $target_folder.$row1['l_image'];
						    unlink($real_path);
						}
				      //upload image to a folder
		 if(!move_uploaded_file($_FILES['l_image']['tmp_name'],$upload_image)) 
    {
      throw new Exception('image is not uploaded');
    }
			
		
		 $statement=$db->prepare("update  tbl_labourer set l_name=?,l_contact_no=?,l_image=?,l_type=?,l_nid=?,l_address=?,l_sex=?,l_joining_date=? where l_id=?");
		   $statement->execute(array($_POST['l_name'],$_POST['l_contact_no'],$f1,$_POST['l_type'],$_POST['l_nid'],$_POST['l_address'],$_POST['l_sex'],$_POST['l_joining_date'],$id));
				
						 
		 }			 


		   $success_message1="Labourer Information is updated succesfully";
	
	
	
	}
	catch(Exception $e)
	{
		$error_message1=$e->getMessage();
	}
}
?>
		
<!--------------------------------------------->
 <!-- Main content -->
    <section class="content">
      <?php include_once('header_shop.php'); ?>
      <!-- /.row -->
      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-12 ">
          <div id="edit-profile" class="tab-pane">
                                    <section class="panel">                                          
                                          <div class="panel-body bio-graph-info">
                                             <center> <h2>Update Labourer</h2></center>
											 							  
										<?php	
					 if(isset($error_message1)){
                        ?>
                        <div class="alert alert-block alert-danger fade in">
                          <button data-dismiss="alert" class="close close-sm" type="button">
                          <i class="icon-remove"> X</i>
                          </button>
                          <strong>Opps!&nbsp; </strong><?php echo $error_message1;?>
                       </div>
                        <?php
                      }
                      if (isset($success_message1)) {
                       ?>
                       <div class="alert alert-success fade in">
                          <button data-dismiss="alert" class="close close-sm" type="button">
                            <i class="icon-remove"> X</i>
                          </button>
                          <strong>Well done!&nbsp; </strong><?php echo $success_message1;?>
                       </div>
                       <?php
                        }
                      ?>	  
									 						 
										<?php	
						$statement=$db->prepare("select * from tbl_labourer where l_id=?");
						$statement->execute(array($id));
						$result=$statement->fetchAll(PDO::FETCH_ASSOC);
						foreach($result as $row)
						{?>	 
									
											 <hr>
                                              <form class="form-horizontal" role="form" data-toggle="validator" method="post"enctype="multipart/form-data">                                                  
                                                  <div class="form-group">
                                                      <label class="col-lg-2 control-label">Labourer Name</label>
                                                      <div class="col-lg-8">
                                                          <input type="text" class="form-control" value="<?php echo $row['l_name']; ?>" name="l_name" id="f-name" placeholder=" " required>
                                                      </div>
                                                  </div><hr>
												  <!--
												    <div class="form-group">
                                                      <label class="col-lg-2 control-label">Product Image</label>
                                                      <div class="col-lg-8">
                                                           <input type="file"class="form-control" name="p_image" required>
                                                      </div>
                                                  </div><hr> 
												  --->
												    <div class="form-group">
                                                      <label class="col-lg-2 control-label">Contact No</label>
													  <div class="col-lg-8" >
													  <input type="number" value="<?php echo $row['l_contact_no']; ?>" data-toggle="validator" data-minlength="11" class="form-control" name="l_contact_no" placeholder="Contact Number" required>
									<span class="help-block with-errors">Please Enter Your 11 Digit Mobile Number</span>
                                                    </div>
                                                  </div><hr> 
												  
									
												  <div class="form-group">
												  <label class="col-lg-2 control-label">Previous Image</label>
												  <div class="col-lg-8">
												 <img src="images/labourer/<?php echo $row['l_image'];?>" alt="" width="320px" height="250px">
												 </div>
												 <br>
												  </div>
												  
												  <div class="form-group">
                                                      <label class="col-lg-2 control-label">New Image if You want</label>
                                                      <div class="col-lg-8">
                                                          <input type="file" id="exampleInputFile" name="l_image"> 
								   <p class="help-block">Input Labourer Image.</p>
                                                      </div>
                                                  </div><hr>
												  
												  
												  
												  
                                                  <div class="form-group">
                                                      <label class="col-lg-2 control-label">Labourer Type</label>
                                                      <div class="col-lg-8">
                                                          <select class="form-control m-bot15"  name="l_type" required>
														  <?php  
														  if($row['l_type']=="Permanent"){
															  ?>
															    <option value="Permanent" selected>Permanent</option>
									  <option value="Temporary">Temporary</option>
									  
									  
									  <?php
														  }
									  else{
										  ?>
										   <option value="Permanent" >Permanent</option>
									  <option value="Temporary" selected>Temporary</option>
									<?php	  
									  }
														  
														  ?>
									
									</select>
                                                      </div>
                                                  </div>
												  <hr> 


												  
                                                   <div class="form-group">
                                                      <label class="col-lg-2 control-label">Enter National ID</label>
                                                      <div class="col-lg-8">
                                                         <input type="" min="0" data-toggle="validator" value="<?php echo $row['l_nid']; ?>" data-minlength="17" class="form-control " 
									  name="l_nid" id="inputPassword" placeholder="NID Number" required>
									  <span class="help-block with-errors">Please Enter Your 17 Digit NID Number</span>
                                                      </div>
                                                  </div><hr>
												  
												  
												  
												  
                                                <div class="form-group">
                                                      <label class="col-lg-2 control-label">Address</label>
                                                      <div class="col-lg-8 col-md-4">
                                                         <textarea name="l_address"  cols="92" rows=""><?php echo $row['l_address']; ?></textarea>
														 </div>
														 </div><hr>
												  
												  
												  	<div class="form-group">
									<label class="col-lg-2 control-label">Sex:</label>
									  <div class="col-lg-8">
									  
									  <?php 
									  if($row['l_sex']=="female")
									  {
										  ?>
										  <div class="radio">
											<label>
											  <input type="radio" name="l_sex" value="female" checked required>
											  Female
											</label>
										</div>
										<div class="radio">
											<label>
											<input type="radio" name="l_sex" value="male" required>
											Male
											</label>
										</div>
										 <?php 
									  }
									  else{
										  
										    ?>
										  <div class="radio">
											<label>
											  <input type="radio" name="l_sex" value="female"  required>
											  Female
											</label>
										</div>
										<div class="radio">
											<label>
											<input type="radio" name="l_sex" value="male" checked required>
											Male
											</label>
										</div>
										 <?php
										  
										  
									  }
									  
									  ?>
									  
									  
									  
										
										</div>
									</div><hr>
												  
												  
												  <div class="form-group">
                                                      <label class="col-lg-2 control-label">Joining Date</label>
                                                      <div class="col-lg-8">
                                                                         <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="date" name="l_joining_date" value="<?php echo $row['l_joining_date']; ?>" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask required>
                </div>
                                                      </div>
                                                  </div><hr>
                                                 <br>

                                                  <div class="form-group">
                                                      <div class="col-lg-offset-10 col-lg-2">
                                                          <button type="submit" name="l_form" class="btn btn-primary">Save</button>
                                                      </div>
                                                  </div>
                                              </form>
											  
											  
											  <?php
											  
						}
						?>
                                          </div>
                                      </section>
                                  </div>


        </section>
        <!-- /.Left col -->
     
      </div>
      <!-- /.row (main row) -->

    </section>
    <!-- /.content -->
  
 <?php include_once('footer.php'); ?>