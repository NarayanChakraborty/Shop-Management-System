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

if(isset($_POST['form3']))
	{
		try{
			
			
			if(empty($_POST['c_name']))
			{
				throw new Exception('Customer Name Can not be Empty');
			}
			if(empty($_POST['c_mobile']))
			{
				throw new Exception('Customer Mobile No Can not be Empty');
			}
			if(empty($_POST['c_nid']))
			{
				throw new Exception('Customer National Id Can not be Empty');
			}
			
			if(empty($_POST['c_address']))
			{
				throw new Exception('Customer Address Can not be Empty');
			}

			
	
			$statement3=$db->prepare("insert into tbl_dealer_two(d_name,d_mobile,d_nid,d_address,d_date) values(?,?,?,?,?)");
			$statement3->execute(array($_POST['c_name'],$_POST['c_mobile'],$_POST['c_nid'],$_POST['c_address'],date('Y-m-d')));
						
			$success_message1="Retailer Id is created";
			
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
		
		
		
		
		<div class="row">
        <!-- Left col -->
        <section class="col-lg-12 connectedSortable">
          <!-- Custom tabs (Charts with tabs)-->
			 <section class="panel">                                          
                                          <div class="panel-body bio-graph-info">
										  
										   <center> <h2>Customer Details</h2></center>
												
												<form class="form-horizontal" role="form" data-toggle="validator" method="post"enctype="multipart/form-data" name="form2">                                       
												<!---- 
												 <div class="form-group">
                                                      <label class="col-lg-2 control-label">Less($)</label>
                                                      <div class="col-lg-8">
                                                          <input type="number" min=0 name="c_less" value=""  class="form-control" id="" placeholder="Special Offer (Just Amount)" >
                                                      </div>
                                                 </div><hr>
												
												 
												 <div class="form-group">
                                                      <label class="col-lg-2 control-label">Payment(-)</label>
                                                      <div class="col-lg-8">
                                                          <input type="number" min=0 name="c_payment" value=""  class="form-control"  placeholder="Payment Amount " required>
                                                      </div>
                                                  </div>
												
												---->
												
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
											
                                                          <button type="submit" name="form3" class="btn btn-primary">Save</button>
                                                      </div>
                                                  </div>
                                              </form>
										  
										  
										  </div>
										  
										  </section>

        </section>
 
      </div>
		
		
		
		
		
		
		
		
		
		
		
      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-12 connectedSortable">
          <!-- Custom tabs (Charts with tabs)-->
                    

			  <!--------- page start-->
			  
			  
			<div class="panel panel-default">
                        <div class="panel-heading">List of Products  <?php	
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
								
            </div>
            <!-- /.box-header -->
            <div class="panel-body">
                            <div class="table-responsive">
							
							
						<form class="form-horizontal" role="form" data-toggle="validator" method="post" enctype="multipart/form-data" >	
							  
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example" >

                <thead>
                <tr>
				  <th>Click</th>
				  <th>Category</th>
                  <th>Product Model</th>
				  <th>Product Base Price</th>
				  <th>Product Sell Price</th>
				  <th>Quantity</th>
				
                  <th>Final Amount</th>
                
				
				
				
				  
                </tr>
                </thead>
				
				
				
				
                <tbody style="text-align:center">
				
				
				<?php
				 $statement =$db->prepare("SELECT * FROM tbl_products where p_amount!=0");
										    $statement->execute(array());
											$result = $statement->fetchAll(PDO::FETCH_ASSOC);
										  foreach ($result as $row) {
                                          ?> 
				
                 <tr class="txtMult"><td><input type="checkbox" name="products[]" value="<?php echo $row["p_id"]; ?>"></td>
				 
				 <td><?php 
                                                    
										  $statement1 = $db->prepare("SELECT cat_name FROM tbl_category where cat_id=?");
										  $statement1->execute(array($row['p_category']));
										  $result1 = $statement1->fetch();
												echo $result1['cat_name'];	
											?></td>
                     <td><?php echo $row['p_model']; ?></td>
					 <td><?php echo $row['p_base_price']; ?>
					 </td><td><input type="number" class="val1" value="<?php echo $row['p_price']; ?>" disabled ></td>
                      
                     <td>
					  <div class="form-group">
					 <input type="number" min=0 max=<?php echo $row['p_amount']; ?>  name="amount[]" value="0" class="val2"  placeholder=" "  ><?php echo "(".$row['p_amount'].")"; ?>
					 
					 </td>
                     <td>  
					<div class="form-group">
					 <input type="number"  min=0  value="" class="multTotal" name="totals[]"  id="total" placeholder=" " >
					 </div>
					 </td>
                  
				  <script type="text/javascript">
												$(document).ready(function () {
       $(".txtMult input").keyup(multInputs);

       function multInputs() {
           var mult = 0;
           // for each row:
           $("tr.txtMult").each(function () {
               // get the values from this row:
               var $val1 = $('.val1', this).val();
               var $val2 = $('.val2', this).val();
               var $total = ($val1 * 1) * ($val2 * 1)
               $('.multTotal',this).val($total);
               mult += $total;
           });
           $(".grandTotal").val(mult);
       }
  });
</script>
												
				  
				  </tr>
				  
				  
				  <?php
										  }
				  ?>
				  
				  
                                             
                </tbody>
               
              </table>
			  
			  <br><br>
			<div class="form-group col-lg-12">
               <label class="col-lg-2 control-label">Total Amount</label>
			  <div class=" col-lg-2" >
			   <input type="number"  min=0  value="" class="grandTotal" name="total" id="" placeholder=" " disabled>
			  </div>
			  
            </div>
			<br>
			<div class="col-lg-12">
			<div class="form-group ">
               <label class="col-lg-2 control-label">Less Amount</label>
			  <div class=" col-lg-2" >
			   <input type="number"  min=0  value="0"  name="less_amount" id="" placeholder=" " required>
			  </div>
			  
            </div>
			<div class="form-group">
               <label class="col-lg-2 control-label">Cash Amount</label>
			  <div class=" col-lg-2" >
			   <input type="number"  min=0  value="0"  name="cash" id="" placeholder=" " required>
			  </div>
			  
            </div>
			</div>
			  
			  
			  
	
			  
			  
			  <br><br>
			                          <div class="form-group">
                                                      <div class="col-lg-offset-10 col-lg-2">
													 
                                                          <button type="submit" name="form1" class="btn btn-primary">Save</button>
                                                      </div>
                                                  </div>
                 </form>
											  

            <!-- /.box-body -->
			
			
			
			
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
		  
		  
	</div>	  
		  
		  
		  
		  
		  
		  
		  
		  
		  

      <!-- /.row (main row) -->

    </section>
    <!-- /.content -->
	</div>
	
	
	
	
	
	
	<div class="row">
	
   <div id="printableArea">
        <!-- Left col -->
        <section class="col-lg-offset-2 col-lg-10 connectedSortable">
		
					<div class="panel panel-default">
                        <div class="panel-heading">
						
						<center><h4>KHALEK ELECTRONICS</h4></center>
						<?php
						
						$statement3 = $db->prepare("SELECT d_id FROM tbl_dealer_two order by d_id desc limit 1");
			  $statement3->execute();
              $result3=$statement3->fetch();
			   $last_id=$result3['d_id'];
			   
			   $statement=$db->prepare("select * from tbl_dealer_two where d_id=?");
						$statement->execute(array($last_id));
						$result=$statement->fetchAll(PDO::FETCH_ASSOC);
						foreach($result as $row)
						{
							?>	 
						      
						    <h5>Retailer Name: <?php echo $row['d_name']; ?></h5>
							<h5>Date          :<?php echo date('Y-m-d'); ?></h5>
							
						
						
						<?php
						
						}
						?>
			   
			   
			 		
						</div>
						  <div class="panel-body">
						 <table class="table table-striped table-bordered table-hover" id="dataTables-example" >
						<thead>
						<tr>
						
				  <th>SL</th>
				  <th>Product Model</th>
				 
                  <th>Sold Amount</th>
				  <th>Amount</th>
				  
                 
						</tr>
						
						</thead>
						<tbody>
						
						
						         <?php
if(isset($_POST['form1']))
{
	
 
		
		
	
	try{  
	
	if(empty($_POST['products']))
			{
				throw new Exception('You have selected no product');
			}
	
	
	$less=$_POST['less_amount'];
	$cash=$_POST['cash'];
	$total=0;

      $rowCount = count($_POST["products"]);
	 
      for($i=0;$i<$rowCount;$i++) {
		  
		  $statement2 = $db->prepare("SELECT * FROM tbl_products where p_id=?");
                      $statement2->execute(array($_POST['products'][$i] ));
                      $result2 = $statement2->fetchAll(PDO::FETCH_ASSOC);
					  foreach($result2 as $row2)
					  {
						 ?>
						 
						 <tr>
						 <td>
						 <center>
						 <?php echo 
						 $i+1; ?></center>
						 </td>
						 
						 
						 <td><center>
						 <?php echo 
						 $row2['p_model']; ?></center></td>
						 
						
						 <td>
						 <center>
						 <?php echo
						 $_POST['amount'][$i];

						
					  
						 $product_amount=$row2['p_amount']-$_POST['amount'][$i];
						 $statement3 = $db->prepare("update tbl_products set p_amount=? where p_id=?");
                      $statement3->execute(array($product_amount,$_POST['products'][$i]));
                      
						 ?></center></td>
						<td>
						  <center>
						 <?php 
						
						 echo
						 $_POST['totals'][$i] ; 
						 $total+=$_POST['totals'][$i];
						
						
						 ?>
						 </center>
							</td>
						 
					
						 
						 
						 </tr>
						 <?php
						 
					  }
					  
		  
		  
	  }
	  	
						 
	  ?>
	  
	  <tr> <td></td><td></td><td><center> Amount:</center></td><td><center><?php echo $total; 
	   $statement2 = $db->prepare("SELECT d_id FROM tbl_dealer_two order by d_id desc limit 1");
			  $statement2->execute();
              $result2=$statement2->fetch();
			   $last_id=$result2['d_id'];
					  
					  $due=$total-$cash;
					  $total=$total-$less;
						$statement3 = $db->prepare("update tbl_dealer_two set d_amount=?,d_cash=?,d_due=? where d_id=? and d_date=?");
                      $statement3->execute(array($total,$cash,$due,$last_id,date('Y-m-d')));
	                  $success_message1="Product is inserted succesfully";
					  
					  
					      }
		catch(Exception $e)
	{
		$error_message1=$e->getMessage();
	}
}
	  ?>
	  
	  
	  </center> </td></tr>
	  <tr><td></td><td></td><td><center>After Giving Comission Final Amount:</center></td><td><center><?php 
	  $statement2 = $db->prepare("SELECT d_id FROM tbl_dealer_two order by d_id desc limit 1");
			  $statement2->execute();
              $result2=$statement2->fetch();
			   $last_id=$result2['d_id'];
	           
			   			   $statement=$db->prepare("select * from tbl_dealer_two where d_id=?");
						$statement->execute(array($last_id));
						$result=$statement->fetchAll(PDO::FETCH_ASSOC);
						foreach($result as $row)
						{
							echo $row['d_amount']; ?>
							<br>
							<?php
						}
	   ?></td></tr>
	   
	  	 <?php
				
				


?>
</tbody>
</table>
</div>
						
						</div>
		
		
		



        </section>
    
				
        <!-- right col -->
      </div>
	  <div class="col-lg-offset-11 col-lg-1" style="margin-bottom:20px">
	   <a  href="javascript:void(0);" name="release" class="btn btn-default"  onclick="printPageArea('printableArea')"> <i class="fa fa-print"></i> Print</a>
      </div>	   
  </section>
  <!-- /.content-wrapper -->
  

  <!-- /.control-sidebar -->
  
  
 <?php include_once('footer.php'); ?>
