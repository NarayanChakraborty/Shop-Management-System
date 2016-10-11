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
    if(isset($_POST['form_transformation']))
	{
		try{
			
			
			if(empty($_POST['t_shop']))
			{
				throw new Exception('Shop Name Can not be empty');
			}
			
			if(empty($_POST['t_amount']))
			{
				throw new Exception('Transformation Amount Can not be empty');
			}
			
			$amount=$_POST['t_amount'];
			$shop=$_POST['t_shop'];
			
                      $statement = $db->prepare("SELECT shop_name FROM tbl_shop where shop_id=?");
                      $statement->execute(array($_POST['hidden_id_for_shop']));
                      $result= $statement->fetch();
                     
                        $shop_name=$result['shop_name']; 
						
			
			
			$statement=$db->prepare("select * from tbl_products where p_id=?");
			$statement->execute(array($_POST['hidden_id_for_transformation']));
			$result=$statement->fetch();
			
				
			$statement1=$db->prepare("select * from tbl_products where p_model=? and p_category=? and p_shop=?");
			$statement1->execute(array($result['p_model'],$result['p_category'],$shop));
			$result1=$statement1->fetch();
			
			
			
			    $total=$statement1->rowCount();
				if($total>0)
				{
					
					$exit_amount_increase=$result1['p_amount']+$amount;
					
					$shop_name=$shop_name."(".$amount.")";
					
				  $statement2=$db->prepare("update tbl_products set p_amount=?,p_shop=?,p_from=? where p_id=?");
		   $statement2->execute(array($exit_amount_increase,$shop,$shop_name,$result1['p_id']));
		   
		   
						$update_amount=$_POST['hidden_id_for_amount']-$amount;
						
						 $statement2=$db->prepare("update tbl_products set p_amount=? where p_id=?");
		   $statement2->execute(array($update_amount,$_POST['hidden_id_for_transformation']));
		   	
			
			 $success_message1="Product Transformation is updated succesfully";
				}
				else{
					$abc=$shop_name."(".$amount.")";
					 $statement2=$db->prepare("insert into tbl_products(p_model,p_serial,p_category,p_base_price,p_price,p_amount,p_details,p_shop,p_date,p_from) values(?,?,?,?,?,?,?,?,?,?)");
		   $statement2->execute(array($result['p_model'],$result['p_serial'],$result['p_category'],$result['p_base_price'],$result['p_price'],$amount,$result['p_details'],$shop,date('Y-m-d'),$abc));
					 	
						
						$update_amount=$_POST['hidden_id_for_amount']-$amount;
						
						 $statement2=$db->prepare("update tbl_products set p_amount=? where p_id=?");
		   $statement2->execute(array($update_amount,$_POST['hidden_id_for_transformation']));
			
			 $success_message1="Product Transformation is updated succesfully";
				}
				
			
			
			
			
			
			
		
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
				  <th>Come From</th>
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
						 <td><?php echo $row['p_from']; ?></td>
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
									  <form method="post" action="product_transformation.php" enctype="multipart/form-data">
										<div class="form-group col-lg-12">
                                                      <label class="col-lg-4 control-label">Select Shop</label>
                                                      <div class="col-lg-8">
                                                      
													  <select class="form-control" name="t_shop" reuired>
																						  
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
                                                          <input type="number" min=1 max=<?php echo $row['p_amount']; ?>  name="t_amount" value="<?php echo $row['p_amount']; ?>" class="form-control"  placeholder=" " required>
                                                      </div>
                                          </div><br><br><br><br>
												  
												  
												  
												  
										<button data-dismiss="modal" class="btn btn-default" style="float:right" type="button">Close</button>
										<input type="hidden" name="hidden_id_for_transformation" value="<?php echo $row['p_id'];?>">
										<input type="hidden" name="hidden_id_for_amount" value="<?php echo $row['p_amount'];?>">
										<input type="hidden" name="hidden_id_for_shop" value="<?php echo $row['p_shop'];?>">
										
										 <input type="submit" value="Update" style="float:right;margin-right:2px" class="btn btn-success" name="form_transformation">
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
