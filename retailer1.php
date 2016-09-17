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
	header('location:dealer_customers_with_due1.php');
}
else
{
	$id=$_REQUEST['ID'];
}
?>

<?php include_once('header.php'); ?>
<?php include_once('sidebar.php'); ?>
<?php require_once('config.php'); ?>




    <!-- Main content -->
    <section class="content">
        <?php include_once('header_shop.php'); ?>
		
		
		
      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-12 connectedSortable">
          <!-- Custom tabs (Charts with tabs)-->
                    

			  <!--------- page start-->
			  
			  
			<div class="panel panel-default">
                        <div class="panel-heading">List of Retailer Accounts  <?php	
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
							
							
						<form class="form-horizontal" role="form" data-toggle="validator" method="POST" enctype="multipart/form-data" >	
							  
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example" >

                <thead>
                <tr>
				  <th>----</th>
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
				
                 <tr class="txtMult"><td><input type="hidden" name="products[]" value="<?php echo $row["p_id"]; ?>" checked ></td>
				 
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
						
				
			   
			   $statement=$db->prepare("select * from tbl_dealer_two where d_id=?");
						$statement->execute(array($id));
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
		   $j=0;
		  
		  $statement2 = $db->prepare("SELECT * FROM tbl_products where p_id=?");
                      $statement2->execute(array($_POST['products'][$i] ));
                      $result2 = $statement2->fetchAll(PDO::FETCH_ASSOC);
					  foreach($result2 as $row2)
					  {
						  
						  if($_POST['amount'][$i]!=0){
							  
						  
						  
						 ?>
						 
						 <tr>
						 <td>
						 <center>
						 <?php echo 
						 $j=$j+1; ?></center>
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
					  
		  
		  
	  }
	  ?>
	  
	  	  <tr> <td></td><td></td><td><center> Amount:</center></td><td><center><?php echo $total; 
		  
		  $statement3 = $db->prepare("select d_due,d_cash,d_amount from tbl_dealer_two where d_id=?");
                      $statement3->execute(array($id));
					  $row3=$statement3->fetch();
					  
					  
					  
		  
		  $due=$total-$less-$cash+$row3['d_due'];
					  $total1=$total-$less+$row3['d_amount'];
					  $cash_total=$cash+$row3['d_cash'];
						$statement3 = $db->prepare("update tbl_dealer_two set d_amount=?,d_cash=?,d_last_payment=?,d_due=? where d_id=?");
                      $statement3->execute(array($total1,$cash_total,$cash_total,$due,$id));
	                  $success_message1="Retailer Information is inserted succesfully";
		  
		  
		  ?></tr> 
	 
	   <tr> <td></td><td><center> Less Amount:</center></td><td>---</td><td><center><?php echo $less; ?></center></td></tr>
	   <tr> <td></td><td><center> Final Amount:</center></td><td>---</td><td><center><?php echo $total-$less; ?></center></td></tr>
	   <tr> <td></td><td><center> Cash Amount:</center></td><td>---</td><td><center><?php echo $cash; ?></center></td></tr>
	    <tr> <td></td><td><center> Due Amount(Today):</center></td><td>---</td><td><center><?php echo $total-$less-$cash; ?></center></td></tr>
		 <tr> <td></td><td><center>Your Total Due Amount(From The Begining):</center></td><td>---</td><td><center>		<?php
						
				
			   
			   $statement4=$db->prepare("select * from tbl_dealer_two where d_id=?");
						$statement4->execute(array($id));
						$result4=$statement4->fetchAll(PDO::FETCH_ASSOC);
						foreach($result4 as $row4)
						{
							 echo $row4['d_due'];
							
					
						}
						?></center></td></tr>
	
	
	
<?php	
}
	catch(Exception $e)
	{
		$error_message1=$e->getMessage();
	}



}





?>				
<tr>

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
						
</tr>

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
