<?php
if(!isset($_REQUEST['id']))
{
	header('location:view_product.php');
}
else
{
	$id=$_REQUEST['id'];
}
?>


<?php include_once('header.php'); ?>
<?php include_once('sidebar.php'); ?>
<?php require_once('config.php'); ?>


<?php

if(isset($_POST['form1']))
{
	try{  
		if(empty($_POST['p_model']))
		{
			throw new Exception("Product Model can not be empty");
		}
		if(empty($_POST['p_price']))
		{
			throw new Exception("Title can not be empty");
		}
	    if(empty($_POST['p_amount']))
		{
			throw new Exception("Category can not be empty");
		}
		if(empty($_POST['p_category']))
		{
			throw new Exception("Tag Name can not be empty");
		}
		if(empty($_POST['p_details']))
		{
			throw new Exception("Tag Name can not be empty");
		}
		if(empty($_POST['p_date']))
		{
			throw new Exception("Tag Name can not be empty");
		}
		if(empty($_POST['p_shop']))
		{
			throw new Exception("Tag Name can not be empty");
		}
 	    
		//IMAGE MANAGE
		/*
		if(getimagesize($_FILES['p_image']['tmp_name'])==FALSE)
		 {
		   throw new Exception("<div class='error'>Please select an image</div>"); //access only image
		 }
		 if($_FILES['post_image']['size']>1000000){
		 throw new Exception("<div class='error'>Sorry,your file is too large</div>"); //image file must be<1MB
		 }
		
		
	    //To generate id(next auto increment value from tbl_post)
		$statement=$db->prepare("show table status like 'tbl_post' ");
		$statement->execute();
		$result=$statement->fetchAll();
		foreach($result as $row)
		$new_id=$row[10];
		   
		//access image process one;   
	    $up_filename=$_FILES['post_image']['name'];   //file_name
		$file_basename=substr($up_filename,0,strripos($up_filename,'.'));//orginal image name
		$file_ext=substr($up_filename,strripos($up_filename,'.')); //extension
		$f1=$new_id.$file_ext;  //Rename filename;

	    
		//only allow png ,jpg,jpeg,gif
		if(($file_ext!='.png')&&($file_ext!='.jpg')&&($file_ext!='.jpeg')&&($file_ext!='.gif')&&($file_ext!='.PNG')&&($file_ext!='.JPG')&&($file_ext!='.JPEG')&&($file_ext!='.GIF'))
		{
			throw new Exception("only jpg,jpeg,png and gif format are allowed");
		}
	     
	     
        //upload image to a folder
        move_uploaded_file($_FILES['post_image']['tmp_name'],"uploads/".$f1);		
		
		
		*/
	
      
		   
		   
		   //pdo to insert all above informations.. to tbl_post
		   	       $statement1=$db->prepare("update tbl_products set p_model=?,p_category=?,p_price=?,p_amount=?,p_details=?,p_shop=?,p_date=?   where p_id=?");
		   $statement1->execute(array($_POST['p_model'],$_POST['p_category'],$_POST['p_price'],$_POST['p_amount'],$_POST['p_details'],$_POST['p_shop'],$_POST['p_date'],$id));
		   
		   $success_message1="Post is inserted succesfully";
	
	
	}
	
	catch(Exception $e)
	{
		$error_message1=$e->getMessage();
	}
}
?>

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
                                             <center> <h2>Sell Product</h2></center>
											 							  
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
											 
											 
											 
										<?php	
						$statement=$db->prepare("select * from tbl_products where p_id=?");
						$statement->execute(array($id));
						$result=$statement->fetchAll(PDO::FETCH_ASSOC);
						foreach($result as $row)
						{?>	 
											 
											 
											 
											 
											 
											 
											 
                                              <form class="form-horizontal" role="form" data-toggle="validator" method="post"enctype="multipart/form-data">                                                  
                                                  <div class="form-group">
                                                      <label class="col-lg-2 control-label">Product Model</label>
                                                      <div class="col-lg-8">
                                                          <?php echo $row['p_model']; ?>
                                                      </div>
                                                  </div>
												  <!--
												    <div class="form-group">
                                                      <label class="col-lg-2 control-label">Product Image</label>
                                                      <div class="col-lg-8">
                                                           <input type="file"class="form-control" name="p_image" required>
                                                      </div>
                                                  </div><hr> 
												  --->
												    <div class="form-group">
                                                      <label class="col-lg-2 control-label">Product Category</label>
                                                      <div class="col-lg-8">
							     
                      <?php
                      $statement1 = $db->prepare("SELECT * FROM tbl_category");
                      $statement1->execute();
                      $result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
                      foreach ($result1 as $row1) {
                           if($row1['cat_id']==$row['p_category']){
						
						echo $row1['cat_name'];
                     
						   }
					  }
                     ?>
                
                                                         
                                                      </div>
                                                  </div>
												   <div class="form-group">
                                                      <label class="col-lg-2 control-label">Details of Product</label>
                                                      <div class="col-lg-8">
                                                         <?php echo $row['p_details']; ?>
				
                                                      </div>
                                                  </div>
												  <div class="form-group">
                                                      <label class="col-lg-2 control-label">Product Price</label>
                                                      <div class="col-lg-8">
                                                          <?php echo $row['p_price']; ?>
                                                      </div>
                                                  </div><hr>
                                                  <div class="form-group">
                                                      <label class="col-lg-2 control-label">Product Amount</label>
                                                      <div class="col-lg-8">
                                                          <input type="number" min=1 max=<?php echo $row['p_amount']; ?>  name="p_amount" value="<?php echo $row['p_amount']; ?>" class="form-control" id="one" placeholder=" " required>
                                                      </div>
                                                  </div>
												  <hr>    
											
												  <div class="form-group">
                                                      <label class="col-lg-2 control-label">Discount(%)</label>
                                                      <div class="col-lg-8">
                                                          <input type="number" min=0 name="p_discount" value="" class="form-control" id="two" placeholder=" Give Only Percentage Value" required>
                                                      </div>
                                                  </div>
												  <script>
												 $('#two').keyup(function(){
													 
													 
													 var valueone;
													 var valuetwo;
												
													 valueone=parseFloat($('#one').val());
													 valuetwo=parseFloat($('#two').val());
													
													 var result=valueone+valuetwo;
													 $('#total').val(result.toFiexed(2));
													 
												 });
												 
												 
												 
												 </script>
                                              <hr>
												  <div class="form-group">
                                                      <label class="col-lg-2 control-label">Total</label>
                                                      <div class="col-lg-8">
                                                          <input type="number" min=0 name="p_total" value="" class="form-control" id="total" placeholder=" " required>
                                                      </div>
                                                  </div>
												  <hr> 
												  
                                                
                                                 
												  
                                                 <br>

                                                  <div class="form-group">
                                                      <div class="col-lg-offset-10 col-lg-2">
                                                          <button type="submit" name="form1" class="btn btn-primary">Calculate</button>
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