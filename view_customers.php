<?php include_once('header.php'); ?>
<?php include_once('sidebar.php'); ?>
  <?php include_once("config.php");?>





<?php 

if(isset($_POST['form_payment']))
	{
		try{
			if(empty($_POST['payment_amount']))
			{
				throw new Exception('Payment Amount Can not be Empty');
			}
			if(empty($_POST['hidden_id_for_due']))
			{
				throw new Exception('This Customer Has No Due'); 
			}
			$due=$_POST['hidden_id_for_due']-$_POST['payment_amount'];
			$statement1=$db->prepare('update tbl_customers set c_due=? where c_id=?');
			$statement1->execute(array($due,$_POST['hidden_id_for_edit_payment']));
						
			
			$success_message2='Payment Amount Successfully Updated';
		}
		catch(Exception $e)
		{
		    $error_message2=$e->getMessage();	
		}
	}


?>








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
                                            <h3>Select Customers For :</h3>
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
                        <div class="panel-heading">Customer List   <?php 

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
			  
			  <?php
                      if(isset($error_message2)){
                        ?>
                        <div class="alert alert-block alert-danger fade in">
                          <button data-dismiss="alert" class="close close-sm" type="button">
                          <i class="icon-remove"> X</i>
                          </button>
                          <strong>Opps!&nbsp; </strong><?php echo $error_message2;?>
                       </div>
                        <?php
                      }
                      if (isset($success_message2)) {
                       ?>
                       <div class="alert alert-success fade in">
                          <button data-dismiss="alert" class="close close-sm" type="button">
                            <i class="icon-remove">X</i>
                          </button>
                          <strong>Well done!&nbsp; </strong><?php echo $success_message2;?>
                       </div>
                       <?php
                        }
                      ?> 
			  
			  
			  
			  
			  
			  
            </div>
            <!-- /.box-header -->
            <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example" >
                <thead>
                <tr>
                  <th>Customer Name</th>
				  <th>Product Model</th>
                  <th>Sold Amount</th>
                  <th>Total Cost </th>
				  <th>Due Amount</th>
				  <th>Mobile No</th>
				  <th>Address</th>
				  <th>Action</th>
                </tr>
                </thead>
                <tbody style="text-align:center">
                 <?php
										 if($value!="All")
										 {
										  $statement =$db->prepare("SELECT * FROM tbl_customers where c_date>DATE_SUB(CURDATE(), INTERVAL ? DAY)");
										  $statement->execute(array($value));
										 }
										 else
										 {
											 $statement =$db->prepare("SELECT * FROM tbl_customers");
										    $statement->execute(array());
										 }
										  $result = $statement->fetchAll(PDO::FETCH_ASSOC);
										  foreach ($result as $row) {
                                          ?> 
                
               
                <tr>
                   <td><?php echo $row['c_name']; ?></td>
				   <?php 
                                                    
										  $statement1 = $db->prepare("SELECT * from tbl_products where p_id=?");
										  $statement1->execute(array($row['p_id']));
										  $result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
											foreach($result1 as $row1){	?>
                  	 <td>
				  
                            <?php echo $row1['p_model']; ?>		
				  </td>	  

				
				  
											<?php 
											}
											?>
				   
					  <td><?php echo $row['p_amount']; ?> </td>
					 <td> <?php echo $row['c_total'];?></td>	
					
					 <td> <?php echo $row['c_due'];?>
					 <a class="btn " data-toggle="modal" href="#myModal<?php echo $row['c_id'];?>" title="Payment"><i class="glyphicon glyphicon-minus-sign"></i></a>
					 <!-- Modal -->
							  <div class="modal fade" id="myModal<?php echo $row['c_id'];?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
								<div class="modal-dialog">
								  <div class="modal-content">
									<div class="modal-header">
									  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
									  <h4 class="modal-title">Payment Section</h4>
									</div>
									<div class="modal-body">
									 <h4>Total Cost  : <?php echo $row['c_total']; ?> </h4>
									 <h4>Due Amount   :<?php echo $row['c_due']; ?> </h4>
									  <h4>Payment Amount :</h4>
									  <form method="post" action="view_customers.php" enctype="multipart/form-data">
										<input type="number" value="<?php echo $row['c_due'];?>"class="form-control" name="payment_amount" required><br>
										<button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
										<input type="hidden" name="hidden_id_for_edit_payment" value="<?php echo $row['c_id'];?>">
										<input type="hidden" name="hidden_id_for_due" value="<?php echo $row['c_due'];?>">
										<input type="submit" value="Update" class="btn btn-success" name="form_payment">
									  </form>
									</div>         
								  </div>
								</div>
							  </div>
							  <!-- modal -->
					 
					 
					 
					 </td>	 
					 <td> <?php echo $row['c_mobile'];?></td> 
					 <td> <?php echo $row['c_address'];?></td>
					 
						
					                    <td><center>
                     <div class="btn-group">
                      <a class="btn btn-primary fancybox" href="#inline<?php echo $row['c_id'];?>"title="View image"><i class="glyphicon glyphicon-eye-open"></i></a>

					 
					 <div id="inline<?php echo $row['c_id'];?>"style="display:none;width:700px;margin:10px 30px">
														<h3 style= "border-bottom: 2px solid #295498; color:#0C86AC;margin-bottom:10px;" >Product Details</h3>
														<div class="shopper-info">
														  <h4> <label>Customer Name :&nbsp;&nbsp;</label>
														  <?php echo $row['c_name']; ?></h4>
														  <h4> <label>Total Cost :&nbsp;&nbsp;</label>
														  <?php echo $row['c_total']; ?></h4>
														  <h4> <label>Amount Due :&nbsp;&nbsp;</label>
														  <?php echo $row['c_due']; ?></h4>
														  <h4> <label>Customer Mobile No :&nbsp;&nbsp;</label>
														  <?php echo $row['c_mobile']; ?></h4>
														  <h4> <label>Customer NID:&nbsp;&nbsp;</label>
														  <?php echo $row['c_nid']; ?></h4>
														  <h4> <label>Customer Address :&nbsp;&nbsp;</label>
														  <?php echo $row['c_address']; ?></h4>
														  <?php 
                                                    
										  $statement1 = $db->prepare("SELECT * from tbl_products where p_id=?");
										  $statement1->execute(array($row['p_id']));
										  $result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
											foreach($result1 as $row1){	?>
											
												
											<h4> 
													<label>Product Model :&nbsp;&nbsp;</label>
													<?php echo $row1['p_model']; ?>
													</h4>
														  
														  
														  <h4> <label>Product Category :&nbsp;&nbsp;</label>
														 

														 <?php 
                                                    
										  $statement2 = $db->prepare("SELECT cat_name FROM tbl_category where cat_id=?");
										  $statement2->execute(array($row1['p_category']));
										  $result2 = $statement2->fetch();
												echo $result2['cat_name'];	
											?></h4>
											
										
											
													<h4> 
													<label>Price Per Product:&nbsp;&nbsp;</label>
													<?php echo $row1['p_price']; ?>
													</h4>
													<h4> 
													<label>Sold Amount:&nbsp;&nbsp;</label>
													<?php echo $row['p_amount']; ?>
													</h4>
													
													
													<h4> 
													<label>Product Shop :&nbsp;&nbsp;</label>
													
													
													 <?php
                      $statement2 = $db->prepare("SELECT * FROM tbl_shop where shop_id=?");
                      $statement2->execute(array($row1['p_shop']));
                      $result2 = $statement2->fetchAll(PDO::FETCH_ASSOC);
                      foreach ($result2 as $row2) {
                        echo $row2['shop_name']; 
						
					  }
						?>
													</h4>
												<h4> 
													<label>Date Of Sale:&nbsp;&nbsp;</label>
													<?php echo $row['c_date']; ?>
													</h4>
													
													 
													  <?php 
													  } 
													  ?>	
													  
																  
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
