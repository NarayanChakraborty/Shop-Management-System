<?php include_once('header.php'); ?>
<?php include_once('sidebar.php'); ?>
<?php require_once('config.php'); ?>

         <?php

if(isset($_POST['submit'])){
  try {
   
			
					/*---------------------------------Image Upload for doctor's Image ------------------------------*/
	
	if(getimagesize($_FILES['n_image']['tmp_name'])==FALSE)
		 {
		   throw new Exception("Please select an image"); //access only image
		 }
		 if($_FILES['n_image']['size']>2000000){
		 throw new Exception("Sorry,your file is too large"); //image file must be<2MB
		 }
		
		
	    //To generate id(next auto increment value from tbl_post)
		$statement=$db->prepare("show table status like 'nurse_details' ");
		$statement->execute();
		$result=$statement->fetchAll();
		foreach($result as $row)
		$new_id=$row[10];
		   
		//access image process one;   
	    $up_filename=$_FILES['n_image']['name'];   //file_name
		$file_basename=substr($up_filename,0,strripos($up_filename,'.'));//orginal image name
		$file_ext=substr($up_filename,strripos($up_filename,'.')); //extension
		$f1=$new_id.$file_ext;  //Rename filename;

	    
		//only allow png ,jpg,jpeg,gif
		if(($file_ext!='.png')&&($file_ext!='.jpg')&&($file_ext!='.jpeg')&&($file_ext!='.gif'))
		{
			throw new Exception("only jpg,jpeg,png and gif format are allowed");
		}
	     
        //upload image to a folder
        move_uploaded_file($_FILES['n_image']['tmp_name'],"images/nurses_image/".$f1);		
	
	
//=========================Image upload=============================//	
			
			
			
			
			
			/*---------------------------------Image Upload for doctor's nid ------------------------------*/
	
	if(getimagesize($_FILES['n_nid_image']['tmp_name'])==FALSE)
		 {
		   throw new Exception("Please select an image"); //access only image
		 }
		 if($_FILES['n_nid_image']['size']>2000000){
		 throw new Exception("Sorry,your file is too large"); //image file must be<2MB
		 }
		
		
	    //To generate id(next auto increment value from tbl_post)
		$statement=$db->prepare("show table status like 'nurse_details' ");
		$statement->execute();
		$result=$statement->fetchAll();
		foreach($result as $row)
		$new_id=$row[10];
		   
		//access image process one;   
	    $up_filename=$_FILES['n_nid_image']['name'];   //file_name
		$file_basename=substr($up_filename,0,strripos($up_filename,'.'));//orginal image name
		$file_ext=substr($up_filename,strripos($up_filename,'.')); //extension
		$f2=$new_id.$file_ext;  //Rename filename;

	    
		//only allow png ,jpg,jpeg,gif
		if(($file_ext!='.png')&&($file_ext!='.jpg')&&($file_ext!='.jpeg')&&($file_ext!='.gif'))
		{
			throw new Exception("only jpg,jpeg,png and gif format are allowed");
		}
	     
        //upload image to a folder
        move_uploaded_file($_FILES['n_nid_image']['tmp_name'],"images/nurses_nid/".$f2);		
	
	
//=========================Image upload=============================//

		
		
		$statement1=$db->prepare("insert into employee_details(e_name,e_contact_no,e_email_id,e_image,e_nid,e_nid_image,e_sex) values(?,?,?,?,?,?,?)");
		   $statement1->execute(array($_POST['n_name'],$_POST['n_contact_no'],$_POST['n_email'],$f1,$_POST['n_nid'],$f2,$_POST['n_sex']));
		   
           $last_id = $db->lastInsertId();
		   
		   $statement2=$db->prepare("insert into nurse_details(employee_id,nurse_type) values(?,?)");
		   $statement2->execute(array($last_id,$_POST['n_type']));
		   
		   
		   
		   $success_message="Nurse details is inserted succesfully";
		
  }catch (Exception $e) {
    $error_message = $e->getMessage();
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
                                             <center> <h2>Add Labourer</h2></center>
											 							  
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
									 
											 <hr>
                                              <form class="form-horizontal" role="form" data-toggle="validator" method="post"enctype="multipart/form-data">                                                  
                                                  <div class="form-group">
                                                      <label class="col-lg-2 control-label">Labourer Name</label>
                                                      <div class="col-lg-8">
                                                          <input type="text" class="form-control" name="l_name" id="f-name" placeholder=" " required>
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
													  <input type="number" data-toggle="validator" data-minlength="11" class="form-control" name="l_contact_no" placeholder="Contact Number" required>
									<span class="help-block with-errors">Please Enter Your 11 Digit Mobile Number</span>
                                                    </div>
                                                  </div><hr> 
												  
									
												  
												  <div class="form-group">
                                                      <label class="col-lg-2 control-label">Labourer Image</label>
                                                      <div class="col-lg-8">
                                                          <input type="file" id="exampleInputFile" name="l_image"> 
								   <p class="help-block">Input Labourer Image.</p>
                                                      </div>
                                                  </div><hr>
												  
												  
												  
												  
                                                  <div class="form-group">
                                                      <label class="col-lg-2 control-label">Labourer Type</label>
                                                      <div class="col-lg-8">
                                                          <select class="form-control m-bot15" name="l_type" required>
									  <option value="Permanent">Permanent</option>
									  <option value="Trainee">Temporary</option>
									</select>
                                                      </div>
                                                  </div>
												  <hr> 


												  
                                                   <div class="form-group">
                                                      <label class="col-lg-2 control-label">Enter National ID</label>
                                                      <div class="col-lg-8">
                                                         <input type="" min="0" data-toggle="validator" data-minlength="17" class="form-control " 
									  name="l_nid" id="inputPassword" placeholder="NID Number" required>
									  <span class="help-block with-errors">Please Enter Your 17 Digit NID Number</span>
                                                      </div>
                                                  </div><hr>
												  
												  
												  
												  
                                                <div class="form-group">
                                                      <label class="col-lg-2 control-label">Address</label>
                                                      <div class="col-lg-8 col-md-4">
                                                         <textarea name="l_address"  cols="92" rows=""></textarea>
														 </div>
														 </div><hr>
												  
												  
												  	<div class="form-group">
									<label class="col-lg-2 control-label">Sex:</label>
									  <div class="col-lg-8">
										<div class="radio">
											<label>
											  <input type="radio" name="l_sex" value="female" required>
											  Female
											</label>
										</div>
										<div class="radio">
											<label>
											<input type="radio" name="l_sex" value="male" required>
											Male
											</label>
										</div>
										</div>
									</div><hr>
												  
												  
												  <div class="form-group">
                                                      <label class="col-lg-2 control-label">Joining Date</label>
                                                      <div class="col-lg-8">
                                                                         <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="date" name="l_date" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask>
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