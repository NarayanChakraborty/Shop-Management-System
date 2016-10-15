<?php
ob_start();
session_start();
if($_SESSION['name']!='snchousebd')
{
header('location: login.php');
}

?>




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

 	    

      
		   $c_date=date('Y-m-d');
		   $c_due=$_POST['c_total']-$_POST['p_payment'];
		   
		   
		   
		   $amount=$_POST['p_amount'];
		    $statement1 = $db->prepare("SELECT p_amount FROM tbl_products where p_id=?");
			 $statement1->execute(array($_POST['hidden_id']));
			 $result1=$statement1->fetch();
			 if($result1['p_amount']<=0){
				 
			 throw  new Exception('This  product is out of stock  Now ');
	 
			 }
				 
				 
				 
				 
				 $base_total=$_POST['hidden_id_base_price']*$_POST['p_amount'];
		   //pdo to insert all above informations.. to tbl_post
		   
		    if($base_total>$_POST['c_total'])
			{
				throw new Exception('You are going to make loss');
			}
			
			
			
		   	       $statement2=$db->prepare("insert into tbl_sell(p_id,p_shop,p_amount,p_base_price,c_total,c_cash,c_date) values(?,?,?,?,?,?,?)");
		   $statement2->execute(array($_POST['hidden_id'],$_POST['hidden_id_shop'],$_POST['p_amount'],$base_total,$_POST['c_total'],$_POST['p_payment'],$c_date));
		   
		   $last_id=$db->lastInsertId();
		   
		    $statement2=$db->prepare("insert into tbl_customer(customer_id,s_id,c_name,c_due,c_mobile,c_nid,c_address,c_date) values(?,?,?,?,?,?,?,?)");
		   $statement2->execute(array($_POST['c_id'],$last_id,$_POST['c_name'],$c_due,$_POST['c_mobile'],$_POST['c_nid'],$_POST['c_address'],$c_date));
				 
		
		
		        $amount1=$result1['p_amount']-$_POST['p_amount'];
				
			  $statement2=$db->prepare("update tbl_products set p_amount=? where p_id=?");
			  
		   $statement2->execute(array($amount1,$_POST['hidden_id']));
		   
		   header('location: entry_slip.php');
		   $success_message1="Customer Information is inserted succesfully";
	
	
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
											 
											 
											 
											 
											 
											 
											 
                                              <form class="form-horizontal" role="form" data-toggle="validator" method="post"enctype="multipart/form-data" name="form2">                                                  
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
                                                      <label class="col-lg-2 control-label">Product base Price</label>
                                                      <div class="col-lg-8">
                                                          <?php echo $row['p_base_price']; ?>
                                                      </div>
                                                  </div>
												  <div class="form-group">
                                                      <label class="col-lg-2 control-label">Product Selling Price</label>
                                                      <div class="col-lg-8">
                                                          <?php echo $row['p_price']; ?>
                                                      </div>
                                                  </div><hr>
												
                                                  <div class="form-group">
                                                      <label class="col-lg-2 control-label">Product Amount</label>
                                                      <div class="col-lg-8">
                                                          <input type="number" min=1 max=<?php echo $row['p_amount']; ?> onkeyup="findTotal()" name="p_amount" value="<?php echo $row['p_amount']; ?>" class="form-control" id="one" placeholder=" " required>
                                                      </div>
                                                  </div>
												  <hr>    
											
												  <div class="form-group">
                                                      <label class="col-lg-2 control-label">Discount(%)</label>
                                                      <div class="col-lg-8">
                                                          <input type="number" min=0 name="p_discount" value="" onkeyup="findTotal()" class="form-control" id="two" placeholder=" Give Only Percentage Value of per product" required>
                                                      </div>
                                                  </div>
											
												 
								
                                              <hr>
											  <div class="form-group">
                                                      <label class="col-lg-2 control-label">Less($)</label>
                                                      <div class="col-lg-8">
                                                          <input type="number" min=0 name="p_less" value="" onkeyup="findTotal()" class="form-control" id="three" placeholder="Special Offer (Just Amount)" >
                                                      </div>
                                                  </div>
											
												 
								
                                              <hr>
											    <div class="form-group">
                                                      <label class="col-lg-2 control-label">Installment Amount(+)</label>
                                                      <div class="col-lg-8">
                                                          <input type="number" min=0 name="p_installment" value="" onkeyup="findTotal()" class="form-control" id="four" placeholder="Add Amount For Installment ">
                                                      </div>
                                                  </div>
											
												 
								
                                              <hr>
											    
												  <div class="form-group">
                                                      <label class="col-lg-2 control-label">Total</label>
                                                      <div class="col-lg-8">
                                                          <input type="number"  min=0 name="c_total" value="" class="form-control" id="total" placeholder=" " >
														 
                                                      </div>
                                                  </div>
												  <hr> 
												    <div class="form-group">
                                                      <label class="col-lg-2 control-label">Payment(-)</label>
                                                      <div class="col-lg-8">
                                                          <input type="number" min=0 name="p_payment" value=""  class="form-control"  placeholder="Payment Amount " required>
                                                      </div>
                                                  </div>
											
												 
								
                                              <hr>
												  
                                                	 <script type="text/javascript">
												function findTotal(){
													var arr = document.form2.p_amount.value;
													var arr1 =  document.form2.p_discount.value;	
													var arr2 =  document.form2.p_less.value;
													var arr3 =  document.form2.p_installment.value;
													if(arr2==" ")
													{
														arr2=0;
													}
													if(arr3==" ")
													{
														arr3=0;
													}
													var tot=0;
													tot=parseInt(arr)*(<?php echo $row['p_price']; ?> -<?php echo $row['p_price']; ?>*((parseInt(arr1)/100)));
													tot=tot-arr2;
													tot=+tot + +arr3; 
													
													document.getElementById('total').value = parseInt(tot);
											
													
												}

													</script>
												
                                                 
												  
                                                 <br>
												
												 <center> <h2>Customer Details</h2></center>
												  <div class="form-group">
                                                      <label class="col-lg-2 control-label">Customer ID</label>
                                                      <div class="col-lg-8">
                                                          <input type="text" min=0 name="c_id" class="form-control" id="" placeholder=" " required>
                                                      </div>
                                                  </div><hr>
												 <div class="form-group">
                                                      <label class="col-lg-2 control-label">Customer Name</label>
                                                      <div class="col-lg-8">
                                                          <input type="text" min=0 name="c_name" class="form-control" id="" placeholder=" " required>
                                                      </div>
                                                  </div><hr>
												  <div class="form-group">
                                                      <label class="col-lg-2 control-label">Mobile No</label>
                                                      <div class="col-lg-8">
                                                           <input type="number" data-toggle="validator" data-length="11" min=0  name="c_mobile" class="form-control" id="" placeholder=" " required>
                                                      </div>
                                                  </div><hr>
												  <div class="form-group">
                                                      <label class="col-lg-2 control-label">National Id No</label>
                                                      <div class="col-lg-8">
                                                          <input type="number" min=0 name="c_nid" class="form-control" id="" placeholder=" " >
                                                      </div>
                                                  </div><hr>
												  <div class="form-group">
                                                      <label class="col-lg-2 control-label">Address</label>
                                                      <div class="col-lg-8 col-md-4">
                                                         <textarea name="c_address"  cols="92" rows=""></textarea>
														 </div>
														 </div>
												 <br>
												

                                                  <div class="form-group">
                                                      <div class="col-lg-offset-10 col-lg-2">
													  <input type="hidden" name="hidden_id" value="<?php echo $row['p_id'];?>">
													  <input type="hidden" name="hidden_id_base_price" value="<?php echo $row['p_base_price'];?>">
													   <input type="hidden" name="hidden_id_shop" value="<?php echo $row['p_shop'];?>">
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