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
				  <th>Transfer</th>
				 
                </tr>
                </thead>
                <tbody style="text-align:center">
                 <?php
										 if($value!="All")
										 {
										  $statement =$db->prepare("SELECT * FROM tbl_products where p_date>DATE_SUB(CURDATE(), INTERVAL ? DAY)");
										  $statement->execute(array($value));
										 }
										 else
										 {
											 $statement =$db->prepare("SELECT * FROM tbl_products");
										    $statement->execute(array());
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
						<td><a class="btn " data-toggle="modal" href="#myModal1<?php echo $row['p_id']; ?>" title="Sell Product"><i class="glyphicon glyphicon-text-width"></i></a>
						<!-- Modal -->
							  <div class="modal fade" id="myModal1<?php echo $row['p_id'];?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
								<div class="modal-dialog">
								  <div class="modal-content col-lg-12" style="text-align:justify;max-width:400px">
									<div class="modal-header">
									  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
									  <h4 class="modal-title">Product Transformation</h4>
									</div>
									<div class="modal-body">
									 <h4>Product Model  : <?php echo $row['p_model']; ?> </h4>
									 <h4>Product Category   :
									 <?php 
                                                    
										  $statement1 = $db->prepare("SELECT cat_name FROM tbl_category where cat_id=?");
										  $statement1->execute(array($row['p_category']));
										  $result1 = $statement1->fetch();
												echo $result1['cat_name'];	
											?> </h4>
									 <h4>Shop Name: 	
									 <?php
                      $statement2 = $db->prepare("SELECT * FROM tbl_shop where shop_id=?");
                      $statement2->execute(array($row['p_shop']));
                      $result2 = $statement2->fetchAll(PDO::FETCH_ASSOC);
                      foreach ($result2 as $row2) {
                        echo $row2['shop_name']; 
						
					  }
						?> </h4>
									 <h4>Product Amount   :<?php echo $row['p_amount']; ?> </h4>
									  <hr> 
									  <form method="post" action="dealer_customers_with_due1.php" enctype="multipart/form-data">
										<div class="form-group col-lg-12">
                                                      <label class="col-lg-4 control-label">Select Shop</label>
                                                      <div class="col-lg-8">
                                                      
													  <select class="form-control" name="p_shop" reuired>
																						  
													<?php
														  $statement2 = $db->prepare("SELECT * FROM tbl_shop");
														  $statement2->execute();
														  $result2 = $statement2->fetchAll(PDO::FETCH_ASSOC);
														  foreach ($result2 as $row2) {
															  if($row2['shop_id']!=$row['p_shop']){
														 ?>
														  
														  <option value="<?php echo $row2['shop_id'];?>"><?php echo $row2['shop_name'];?></option>
														  <?php
															  }
														  }
														  ?>
																		</select>
																		

                                                      </div>
                                        </div><hr>
										   <div class="form-group col-lg-12">
                                                      <label class="col-lg-4 control-label">Product Amount</label>
                                                      <div class="col-lg-8">
                                                          <input type="number" min=1 max=<?php echo $row['p_amount']; ?>  name="p_amount" value="<?php echo $row['p_amount']; ?>" class="form-control"  placeholder=" " required>
                                                      </div>
                                          </div><br><br><br><br>
												  
												  
												  
												  
										<button data-dismiss="modal" class="btn btn-default" style="float:right" type="button">Close</button>
										<input type="hidden" name="hidden_id_for_edit_payment" value="<?php echo $row['d_id'];?>">
										<input type="hidden" name="hidden_id_for_due" value="<?php echo $row['d_due'];?>">
										<input type="hidden" name="hidden_id_for_total" value="<?php echo $row['d_amount'];?>">
										 <input type="submit" value="Update" style="float:right;margin-right:2px" class="btn btn-success" name="form_payment1">
									  </form><br><br>
									</div>         
								  </div>
								</div>
							  </div>
							  <!-- modal -->
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
		  
		  
		  
		  
		  
		  
		  
		  
		  

        </section>
        
     
      </div>
      <!-- /.row (main row) -->

    </section>
    <!-- /.content -->

  

  <!-- /.control-sidebar -->
  
  
 <?php include_once('footer.php'); ?>
