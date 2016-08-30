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

if(isset($_POST['form1']))
{
	try{  
		if(empty($_POST['p_model']))
		{
			throw new Exception("Product Model can not be empty");
		}
		if(empty($_POST['p_sell_price']))
		{
			throw new Exception("Price can not be empty");
		}	
		if(empty($_POST['p_base_price']))
		{
			throw new Exception("Purchase Price can not be empty");
		}
	    if(empty($_POST['p_amount']))
		{
			throw new Exception("Amount can not be empty");
		}
		if(empty($_POST['p_category']))
		{
			throw new Exception("Category Name can not be empty");
		}
		if(empty($_POST['p_details']))
		{
			throw new Exception("Product Details can not be empty");
		}
		if(empty($_POST['p_date']))
		{
			throw new Exception("Date can not be empty");
		}
		if(empty($_POST['p_shop']))
		{
			throw new Exception("Shop Name can not be empty");
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
		   	       $statement1=$db->prepare("insert into tbl_products(p_model,p_category,p_base_price,p_price,p_amount,p_details,p_shop,p_date) values(?,?,?,?,?,?,?,?)");
		   $statement1->execute(array($_POST['p_model'],$_POST['p_category'],$_POST['p_base_price'],$_POST['p_sell_price'],$_POST['p_amount'],$_POST['p_details'],$_POST['p_shop'],$_POST['p_date']));
		   
		   $success_message1="Product is inserted succesfully";
	
	
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
                                             <center> <h2>Add Product</h2></center>
											 							  
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
                                                      <label class="col-lg-2 control-label">Product Model</label>
                                                      <div class="col-lg-8">
                                                          <input type="text" class="form-control" name="p_model" id="f-name" placeholder=" " required>
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
                                                      <label class="col-lg-2 control-label">Product Category</label>
                                                      <div class="col-lg-8">
													          
                <select class="form-control select2" name="p_category" style="width: 100%;" required>
               									     
                      <?php
                      $statement = $db->prepare("SELECT * FROM tbl_category");
                      $statement->execute();
                      $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                      foreach ($result as $row) {
                        ?>
                      
                      <option value="<?php echo $row['cat_id'];?>"><?php echo $row['cat_name'];?></option>
                      <?php
                      }
                      ?>
                </select>
                                                         
                                                      </div>
                                                  </div><hr> 
												    <div class="form-group">
                                                      <label class="col-lg-2 control-label">Product purchase Price</label>
                                                      <div class="col-lg-8">
                                                          <input type="number" min=0 name="p_base_price" class="form-control" id="l-name" placeholder=" " required>
                                                      </div>
                                                  </div><hr>
												  <div class="form-group">
                                                      <label class="col-lg-2 control-label">Product selling Price</label>
                                                      <div class="col-lg-8">
                                                          <input type="number" min=0 name="p_sell_price" class="form-control" id="l-name" placeholder=" " required>
                                                      </div>
                                                  </div><hr>
                                                  <div class="form-group">
                                                      <label class="col-lg-2 control-label">Product Amount</label>
                                                      <div class="col-lg-8">
                                                          <input type="number" min=0 name="p_amount" class="form-control" id="l-name" placeholder=" " required>
                                                      </div>
                                                  </div>
												  <hr>                                                 
                                                  <div class="form-group">
                                                      <label class="col-lg-2 control-label">Details of Product</label>
                                                      <div class="col-lg-8">
                                                         <textarea name="p_details" cols="60 rows="10"></textarea>
				<script type="text/javascript">
				if ( typeof CKEDITOR == 'undefined' )
				{
					document.write(
						'<strong><span style="color: #ff0000">Error</span>: CKEditor not found</strong>.' +
						'This sample assumes that CKEditor (not included with CKFinder) is installed in' +
						'the "/ckeditor/" path. If you have it installed in a different place, just edit' +
						'this file, changing the wrong paths in the &lt;head&gt; (line 5) and the "BasePath"' +
						'value (line 32).' ) ;
				}
				else
				{
					var editor = CKEDITOR.replace( 'p_details' );
					//editor.setData( '<p>Just click the <b>Image</b> or <b>Link</b> button, and then <b>&quot;Browse Server&quot;</b>.</p>' );
				}

			</script>
                                                      </div>
                                                  </div><hr>
                                                  <div class="form-group">
                                                      <label class="col-lg-2 control-label">Select Shop</label>
                                                      <div class="col-lg-8">
                                                      
													  <select class="form-control" name="p_shop" reuired>
													  
				<?php
                      $statement2 = $db->prepare("SELECT * FROM tbl_shop");
                      $statement2->execute();
                      $result2 = $statement2->fetchAll(PDO::FETCH_ASSOC);
                      foreach ($result2 as $row2) {
                     ?>
                      
                      <option value="<?php echo $row2['shop_id'];?>"><?php echo $row2['shop_name'];?></option>
                      <?php
                      }
                      ?>
													  </select>

                                                      </div>
                                                  </div><hr>
												  <div class="form-group">
                                                      <label class="col-lg-2 control-label">Arival Date</label>
                                                      <div class="col-lg-8">
                                                                         <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="date" name="p_date" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask>
                </div>
                                                      </div>
                                                  </div><hr>
                                                 <br>

                                                  <div class="form-group">
                                                      <div class="col-lg-offset-10 col-lg-2">
                                                          <button type="submit" name="form1" class="btn btn-primary">Save</button>
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