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
 <?php include_once("config.php");?>

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

			
	
			$statement3=$db->prepare("insert into tbl_dealer_two(d_name,d_mobile,d_nid,d_address,d_amount,d_cash,d_last_payment,d_due,d_date,d_last_date) values(?,?,?,?,?,?,?,?,?,?)");
			$statement3->execute(array($_POST['c_name'],$_POST['c_mobile'],$_POST['c_nid'],$_POST['c_address'],0,0,0,0,date('Y-m-d'),date('Y-m-d')));
						
			$success_message1="Retailer Id is created";
			
		}
		catch(Exception $e)
		{
		    $error_message1=$e->getMessage();	
		}
	}


?>

<?php 

if(isset($_POST['form_payment1']))
	{
		try{
			if(empty($_POST['payment_amount']))
			{
				throw new Exception('Payment Amount Can not be Empty');
			}
			if(empty($_POST['hidden_id_for_due']))
			{
				throw new Exception('This Retailer Has No Due'); 
			}
			
		      $statement4=$db->prepare("select * from tbl_dealer_two where d_id=?");
						$statement4->execute(array($_POST['hidden_id_for_edit_payment']));
						$result4=$statement4->fetchAll(PDO::FETCH_ASSOC);
						foreach($result4 as $row4)
						{
							 
							 $statement5=$db->prepare("select d_last_payment  from tbl_dealer_two where d_id=? and d_last_date=?");
						$statement5->execute(array($_POST['hidden_id_for_edit_payment'],date('Y-m-d'))); 
							$result5=$statement5->fetch(); 
							 
							 $last_payment=$_POST['payment_amount']+$result5['d_last_payment'];
							$due=$row4['d_due']-$_POST['payment_amount'];
			$total_cash=$row4['d_cash']+$_POST['payment_amount'];
			$statement6=$db->prepare('update tbl_dealer_two set d_due=?,d_cash=?,d_last_payment=?,d_last_date=? where d_id=?');
			$statement6->execute(array($due,$total_cash,$last_payment,date('Y-m-d'),$_POST['hidden_id_for_edit_payment']));
					
						}
			
			
			
			
			
			
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
		
		
		
		
				<div class="row">
        <!-- Left col -->
        <section class="col-lg-12 connectedSortable">
          <!-- Custom tabs (Charts with tabs)-->
			 <section class="panel">                                          
                                          <div class="panel-body bio-graph-info">
										  
										   <center> <h2>Retailer Details</h2></center>
												
												<form class="form-horizontal" role="form" data-toggle="validator" method="post"enctype="multipart/form-data" name="form2">                                       
									
												<div class="form-group">
                                                      <label class="col-lg-2 control-label">Retailer Name</label>
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
                     <section class="panel">                                          
                                          <div class="panel-body bio-graph-info">
		             
		  
		                      
				                   <form method="POST" >
                                        <div class="form-group">
                                            <h3>Select Retailer Accounts For :</h3>
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
                        <div class="panel-heading">Retailer Accounts List   <?php 

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
                      ?> <?php
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
                            <i class="icon-remove">X</i>
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
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example" >
                <thead>
                <tr>
                  <th>Retailer Name</th>
				  
                  <th>Total Cost </th> 
				  <th>Total payment </th>
				  <th>Todays payment </th>
				  <th>Due Amount</th>
				  <th>Mobile No</th>
				  <th>Sell</th>
				  <th>Action</th>
                </tr>
                </thead>
                <tbody style="text-align:center">
                 <?php
										 if($value!="All")
										 {
										  $statement =$db->prepare("SELECT * from tbl_dealer_two where d_date>DATE_SUB(CURDATE(), INTERVAL ? DAY)");
										  $statement->execute(array($value));
										 }
										 else
										 {
											 $statement =$db->prepare("SELECT * from tbl_dealer_two");
										    $statement->execute(array());
										 }
										  $result = $statement->fetchAll(PDO::FETCH_ASSOC);
										  foreach ($result as $row) {
                                          ?> 
                
               
                <tr>
                   <td><?php echo $row['d_name']; ?></td>
				   


					<td>
				  
                            <?php echo $row['d_amount']; ?>		
				  </td>	  

				
					  <td><?php echo $row['d_cash']; ?> </td>
					   <td><?php echo $row['d_last_payment']; ?> </td>
					 <td> <?php echo $row['d_due'];?>	
					
					 
					 
					  <!----------------Edit Payment Information------------------------->
					 <a class="btn " data-toggle="modal" href="#myModal1<?php echo $row['d_id'];?>" title="Payment"><i class="glyphicon glyphicon-minus-sign"></i></a>
					 <!-- Modal -->
							  <div class="modal fade" id="myModal1<?php echo $row['d_id'];?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
								<div class="modal-dialog">
								  <div class="modal-content">
									<div class="modal-header">
									  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
									  <h4 class="modal-title">Payment Section</h4>
									</div>
									<div class="modal-body">
									 <h4>Total Cost  : <?php echo $row['d_amount']; ?> </h4>
									 <h4>Due Amount   :<?php echo $row['d_due']; ?> </h4>
									  <h4>Payment Amount :</h4>
									  <form method="post" action="dealer_customers_with_due1.php" enctype="multipart/form-data">
										<input type="number" value="<?php echo $row['d_due'];?>"class="form-control" name="payment_amount" required><br>
										<button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
										<input type="hidden" name="hidden_id_for_edit_payment" value="<?php echo $row['d_id'];?>">
										<input type="hidden" name="hidden_id_for_due" value="<?php echo $row['d_due'];?>">
										<input type="hidden" name="hidden_id_for_total" value="<?php echo $row['d_amount'];?>">
										<input type="submit" value="Update" class="btn btn-success" name="form_payment1">
									  </form>
									</div>         
								  </div>
								</div>
							  </div>
							  <!-- modal -->
					 
					  <!----------------Edit Payment Information------------------------->
					 
					 </td>	 
					 <td> <?php echo $row['d_mobile'];?></td>
					 <td><a class="btn " data-toggle="modal" href="retailer1.php?ID=<?php echo $row['d_id']; ?>" title="Payment"><i class="glyphicon glyphicon-minus-sign"></i></a></td>
					
					 
						
					                    <td><center>
                     <div class="btn-group">
                      <a class="btn btn-primary fancybox" href="#inline<?php echo $row['d_id'];?>"title="View image"><i class="glyphicon glyphicon-eye-open"></i></a>

					 
					 <div id="inline<?php echo $row['d_id'];?>"style="display:none;width:700px;margin:10px 30px">
														<h3 style= "border-bottom: 2px solid #295498; color:#0C86AC;margin-bottom:10px;" >Product Details</h3>
														<div class="shopper-info">
														  <h4> <label>Retailer Name :&nbsp;&nbsp;</label>
														  <?php echo $row['d_name']; ?></h4>
														  <h4> <label>Total Cost :&nbsp;&nbsp;</label>
														  <?php echo $row['d_amount']; ?></h4>
														  <h4> <label>Amount Due :&nbsp;&nbsp;</label>
														  <?php echo $row['d_due']; ?></h4> 
														  <h4> <label>Total Payment :&nbsp;&nbsp;</label>
														  <?php echo $row['d_cash']; ?></h4>
														  <h4> <label>Last Payment :&nbsp;&nbsp;</label>
														  <?php echo $row['d_last_payment']; ?></h4>	
														  <h4> <label>Last Payment Date:&nbsp;&nbsp;</label>
														  <?php echo $row['d_last_date']; ?></h4>
														  <h4> <label>Customer Mobile No :&nbsp;&nbsp;</label>
														  <?php echo $row['d_mobile']; ?></h4>
														  <h4> <label>Customer NID:&nbsp;&nbsp;</label>
														  <?php echo $row['d_nid']; ?></h4>
														  <h4> <label>Customer Address :&nbsp;&nbsp;</label>
														  <?php echo $row['d_address']; ?></h4>
														  <h4> <label>Customer Id Creation Date :&nbsp;&nbsp;</label>
														  <?php echo $row['d_date']; ?></h4>
														 
														</div>
						 </div>
						 
						 <!----------------Edit Customer Information------------------------->
                    <a class="btn btn-success" data-toggle="modal" href="#myModal2<?php echo $row['d_id'];?>" title="Edit Customer Information"><i class="glyphicon glyphicon-pencil"></i></a>
												  
												   <div class="modal fade" id="myModal2<?php echo $row['d_id'];?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
								<div class="modal-dialog">
								  <div class="modal-content">
									<div class="modal-header">
									  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
									  <h4 class="modal-title">Edit Customer Information</h4>
									</div>
									<div class="modal-body">
									
									  <form method="post" action="view_customers.php" enctype="multipart/form-data">
									    <label>Customer Name</label>
										<input type="text" value="<?php echo $row['d_name'];?>"class="form-control" name="d_name" required><br>
										 <label>Mobile No</label>
										 <input type="text" value="<?php echo $row['d_mobile'];?>"class="form-control" name="d_mobile" required><br>
										 <label>Customer NID</label>
										 <input type="text" value="<?php echo $row['d_nid'];?>"class="form-control" name="d_nid" required><br>
										 <label>Customer Address</label>
										 <input type="text" value="<?php echo $row['d_address'];?>"class="form-control" name="d_address" required><br><br>
										<button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
										<input type="hidden" name="hidden_id_for_edit_customer" value="<?php echo $row['d_id'];?>">
										<input type="submit" value="Update" class="btn btn-success" name="form_customer">
									  </form>
									</div>         
								  </div>
								</div>
							  </div>
							  <!------------------------------------------------------------------>
							  
							  
                       <a class="btn btn-danger"  title="Delete This product" data-toggle="modal" data-target="#productModal<?php echo $row['d_id'];?>"><i class="glyphicon glyphicon-remove"></i>
													   </a>
													  
																		  
											<!-- Modal -->
													<div id="productModal<?php echo $row['d_id'];?>" class="modal fade " role="dialog">
													  <div class="modal-dialog">

														<!-- Modal content-->
														<div class="modal-content">
														  <div class="modal-header">
															<button type="button" class="close" data-dismiss="modal">&times;</button>
															<h4 class="modal-title">DELETE Confirmation</h4>
														  </div>
														  <div class="modal-body">
															<h4>Are You Confirm To Delete This Customer?</h4>
														  </div>
														  <div class="modal-footer">
															<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
															<a class="btn btn-danger btn-ok" href="delete_retailer.php?id=<?php echo $row['d_id']; ?>" >Confirm</a>
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
