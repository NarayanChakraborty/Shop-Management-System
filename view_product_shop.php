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
	header('location:index.php');
}
else
{
	$id1=$_REQUEST['id'];
}
?>

<?php include_once('header.php'); ?>
<?php include_once('sidebar.php'); ?>




    <!-- Main content -->
   <section class="content">
        <?php include_once('header_shop.php'); ?>
      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-12 connectedSortable">
          <!-- Custom tabs (Charts with tabs)-->
                     <section class="panel">                                          
                                          <div class="panel-body bio-graph-info">
		             
		  
		                      
				                   <form method="POST" >
                                        <div class="form-group">
                                            <h3>Select Products For :</h3>
                                            <select class="form-control" name="product">
											   <option  value="All">From The Begining</option>
                                                <option value="7">Last Week</option>
                                                <option value="30">Last Month</option>
                                                <option value="180">Last 6 Months</option>
                                                <option value="365">Last 1 Year</option>
												
                                            </select><br>
											<input class="btn btn-info" style="float:right;" type="submit" value="Select"/>
                                        </div>
                                  </form>
								
								  </div>
								  </section>

			  <!--------- page start-->
			  <?php include_once("config.php");?>
			  <?php 
			  if(isset($_POST['product']))
			  {
				  $value=$_POST['product'];
			  }
			  else
			  {
				  $value="All";
			  }
			  
			  ?>
			  
			<div class="panel panel-default">
                        <div class="panel-heading">List of Products   <?php 

                 if($value==7)
				 {
					 echo " For Last Week";
				 }else if($value==30)
				 {
					 echo " For Last Month";
				 }else  if($value==180)
				 {
					 echo " For Last 6 Months";
				 } else if($value==365)
				 {
					 echo " For Last Last Year";
				 }
				 else
				 {
					 echo "From The Begining";
				 }

			  ?>
            </div>
            <!-- /.box-header -->
            <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example" >
                <thead>
                <tr>
                  <th>Product Model</th>
				  <th>Product Serial</th>
                  <th>Product Category</th>
                  <th>Product Sell Price</th>
                  <th>Product Amount</th>
                  <th>Shop Name</th>
				  <th>Sell</th>
				  <th>Action</th>
				  
                </tr>
                </thead>
                <tbody style="text-align:center">
                 <?php
										 if($value!="All")
										 {
										  $statement =$db->prepare("SELECT * FROM tbl_products where p_date>DATE_SUB(CURDATE(), INTERVAL ? DAY) and p_shop=?");
										  $statement->execute(array($value,$id1));
										 }
										 else
										 {
											 $statement =$db->prepare("SELECT * FROM tbl_products where p_shop=?");
										    $statement->execute(array($id1));
										 }
										  $result = $statement->fetchAll(PDO::FETCH_ASSOC);
										 foreach ($result as $row) {
                                          ?> 
                
               
                <tr>
                   <td><?php echo $row['p_model']; ?></td>
				   <td><?php echo $row['p_serial']; ?></td>
                  <td><?php 
                                                    
										  $statement1 = $db->prepare("SELECT cat_name FROM tbl_category where cat_id=?");
										  $statement1->execute(array($row['p_category']));
										  $result1 = $statement1->fetch();
												echo $result1['cat_name'];	
											?></td>
				   <td><?php echo $row['p_price']; ?></td>
				    <td><?php echo $row['p_amount']; ?></td>
					 <td>								
					 <?php
                      $statement2 = $db->prepare("SELECT * FROM tbl_shop where shop_id=?");
                      $statement2->execute(array($row['p_shop']));
                      $result2 = $statement2->fetchAll(PDO::FETCH_ASSOC);
                      foreach ($result2 as $row2) {
                        echo $row2['shop_name']; 
						
					  }
						?>
						</td>
						<td><a class="btn btn-primary" href="sell_product1.php?id=<?php echo $row['p_id']; ?>" title="Sell Product"><i class="glyphicon glyphicon-usd"></i></a></td>
					                    <td><center>
                    <div class="btn-group">
                      <a class="btn btn-primary fancybox" href="#inline<?php echo $row['p_id'];?>"title="View image"><i class="glyphicon glyphicon-eye-open"></i></a>

					 
					 <div id="inline<?php echo $row['p_id'];?>"style="display:none;width:800px;margin:10px 30px">
														<h3 style= "border-bottom: 2px solid #295498; color:#0C86AC;margin-bottom:10px;" >Product Details</h3>
														<div class="shopper-info">
														  <h4> <label>Product MOdel :&nbsp;&nbsp;</label>
														  <?php echo $row['p_model']; ?></h4>
														  <h4> <label>Product Category :&nbsp;&nbsp;</label>
														  <?php 
                                                    
										  $statement1 = $db->prepare("SELECT cat_name FROM tbl_category where cat_id=?");
										  $statement1->execute(array($row['p_category']));
										  $result1 = $statement1->fetch();
												echo $result1['cat_name'];	
											?></h4>
													<h4> 
													<label>Product Base Price :&nbsp;&nbsp;</label>
													<?php echo $row['p_base_price']; ?>
													</h4>
													<h4> 
													<label>Product sell Price :&nbsp;&nbsp;</label>
													<?php echo $row['p_price']; ?>
													</h4>
													<h4> 
													<label>Product Amount :&nbsp;&nbsp;</label>
													<?php echo $row['p_amount']; ?>
													</h4>
													<h4> 
													<label>Product Shop :&nbsp;&nbsp;</label>
													
													 <?php
                      $statement2 = $db->prepare("SELECT * FROM tbl_shop where shop_id=?");
                      $statement2->execute(array($row['p_shop']));
                      $result2 = $statement2->fetchAll(PDO::FETCH_ASSOC);
                      foreach ($result2 as $row2) {
                        echo $row2['shop_name']; 
						
					  }
						?>
													</h4>
													<h4> 
													<label>Product Details :&nbsp;&nbsp;</label>
													<?php echo $row['p_details']; ?>
													</h4>	
													
													<h4> 
													<label>Product Arival Date :&nbsp;&nbsp;</label>
													<?php echo $row['p_date']; ?>
													</h4>	  
														  
														</div>
						 </div>
                      <a class="btn btn-success" title="Edit this Product" href="edit_product.php?ID=<?php echo $row['p_id']; ?>"><i class="glyphicon glyphicon-pencil"></i>
													  
													  </a>
                       <a class="btn btn-danger"  title="Delete This product" data-toggle="modal" data-target="#productModal<?php echo $row['p_id'];?>"><i class="glyphicon glyphicon-remove"></i>
													   </a>
													  
																		  
											<!-- Modal -->
													<div id="productModal<?php echo $row['p_id'];?>" class="modal fade " role="dialog">
													  <div class="modal-dialog">

														<!-- Modal content-->
														<div class="modal-content">
														  <div class="modal-header">
															<button type="button" class="close" data-dismiss="modal">&times;</button>
															<h4 class="modal-title">DELETE Confirmation</h4>
														  </div>
														  <div class="modal-body">
															<h4>Are You Confirm To Delete This Element?</h4>
														  </div>
														  <div class="modal-footer">
															<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
															<a class="btn btn-danger btn-ok" href="delete_product.php?id=<?php echo $row['p_id']; ?>" >Confirm</a>
														  </div>
														</div>

													  </div>
													</div>
												
					
					
					
					</div></center>
                  </td>
                </tr>
				
					<?php  
										}
										?>
                </tbody>
               
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
		  
</div>
		  

        </section>
        
     
      </div>
      <!-- /.row (main row) -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  

  <!-- /.control-sidebar -->
 <?php include_once('footer.php'); ?>