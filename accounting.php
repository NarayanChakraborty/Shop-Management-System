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
<?php require_once('config.php'); 
 $c_date=date('Y-m-d');
?>

   

		  <?php
		  try
		  {
		  
		         if(isset($_POST['form2']))
				 {
					 	$statement1=$db->prepare('select * from tbl_accounting where a_date=?');
					$statement1->execute(array($c_date));
					$result1=$statement1->fetchColumn();
					if($result1>0)
					{
						 $statement3 = $db->prepare("SELECT cost_today FROM tbl_accounting where a_date=?");
										  $statement3->execute(array($c_date));
										  $result3 = $statement3->fetch();
											
						
						
						
						$_POST['todays_cost']=$_POST['todays_cost']+$result3['cost_today'];
						$balance= $_POST['hidden_id_for_income']-$_POST['todays_cost'];
					 $statement2=$db->prepare("update tbl_accounting set income_today=? ,due_today=?,cost_today=?,balance_today=? where a_date=? ");
		             $statement2->execute(array($_POST['hidden_id_for_income'],$_POST['hidden_id_for_due'],$_POST['todays_cost'],$balance,$c_date));
						
						
					}
					else
					{
						
						$balance=$_POST['hidden_id_for_income']-$_POST['todays_cost'];
					 $statement2=$db->prepare("insert into tbl_accounting(income_today,due_today,cost_today,balance_today,a_date) values(?,?,?,?,?) ");
		             $statement2->execute(array($_POST['hidden_id_for_income'],$_POST['hidden_id_for_due'],$_POST['todays_cost'],$balance,$c_date));
					 $success_message1="Inserted successfully";
					}
					 
				 }
		  }
		  catch(Exception $e) {
    $error_message1 = $e->getMessage();
  
			  
		  }
		   
		  ?>


   <!-- Main content -->
    <section class="content">
        <?php include_once('header_shop.php'); ?>
      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <section class=" col-lg-12 connectedSortable">
          <!-- Custom tabs (Charts with tabs)-->
		   <section class="panel">                                          
                                          <div class="panel-body bio-graph-info">
	
											
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
												
										<?php 
										 //--------------------TO Find The daily balance ,due-------------------------
										  $statement1=$db->prepare("select sum(c_last_payment) as payment, sum(c_due) as due from tbl_customers where c_date=?");
										  $statement1->execute(array(date('Y-m-d')));
										 $result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
										foreach($result1 as $row1){	
									    //--------------------------------------------------------------------------
											
											?>
											
											<center><h4><?php echo "Date :".date('d-m-Y'); ?> </h4></center>
											<h4>Todays Income :
											
											<!--------------------Wheather account row is created or not , if not then insert default value------->
											<?php 	
											$statement1=$db->prepare('select * from tbl_accounting where a_date=?');
					$statement1->execute(array($c_date));
					$result1=$statement1->fetchColumn();
					if($result1<=0)
					{
											
											$statement3 = $db->prepare("insert into tbl_accounting(income_today,cost_today,balance_today,a_date) values(?,?,?,?)");
										  $statement3->execute(array($row1['payment'],0,$row1['payment'],date('Y-m-d')));
					}
					                   //----------------------------------------------------------------------------------------------------------
											?>
						
											<?php
											
										//-------------------------select  income_today,balance_today,cost_today---from tbl_accounting----------------	
											 $statement3 = $db->prepare("SELECT income_today,balance_today,cost_today  FROM tbl_accounting where a_date=?");
										  $statement3->execute(array(date('Y-m-d')));
										  $result3 = $statement3->fetch();
										  echo $result3['income_today']; 
											
											?>
											</h4>
											
											<h4>Todays Cost  :
											<?php echo $result3['cost_today']; ?></h4>
										
											
											<h4>Todays Balance  :
											<?php echo $result3['balance_today']; ?></h4>
											<!---------------------------------------------------------------->
											
											
											<form class="form-horizontal" role="form" data-toggle="validator" method="post">                                                  
                                                 <div class="form-group">
                                                      <label class="col-lg-2 control-label">Count Todays Cost</label>
                                                      <div class="col-lg-8">
                                                          <input type="number" min=0 name="todays_cost" value="" class="form-control"  placeholder="Total Cost of today " required>
                                                      </div>
                                                  </div>
                                                 
                                                  <div class="form-group">
                                                      <div class="col-lg-offset-8 col-lg-2">
													  <input type="hidden" name="hidden_id_for_income" value="<?php echo $row1['payment'];?>">
													  <input type="hidden" name="hidden_id_for_due" value="<?php echo $row1['due'];?>">
                                                          <button type="submit" name="form2" class="btn btn-primary">Update Banlance</button>
                                                        
                                                      </div>
                                                  </div>
                                              </form>
											
											
											<?php
											}
											?>
								
								  </div>
								  </section>
								  
								  
								  
							  <section class="panel">                                          
                                          <div class="panel-body bio-graph-info">
		             
		  
		                      
				                   <form method="POST" >
                                        <div class="form-group">
                                            <h3>Select Accounting For :</h3>
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
											
	
		  
		  
				            <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example" >
                <thead>
                <tr>
                  <th>Income Today</th>
				  <th>Due Today</th>
                  <th>Cost Today</th>
                  <th>Total Balance</th>
				  <th>Date</th>
				  
                </tr>
                </thead>
                <tbody style="text-align:center">
                 <?php
										 if($value!="All")
										 {
										  $statement =$db->prepare("SELECT * FROM tbl_accounting where a_date>DATE_SUB(CURDATE(), INTERVAL ? DAY)");
										  $statement->execute(array($value));
										 }
										 else if($value=="All")
										 {
											 $statement =$db->prepare("SELECT * FROM tbl_accounting");
										    $statement->execute();
										 }
										  $result = $statement->fetchAll(PDO::FETCH_ASSOC);
										  foreach ($result as $row) {
                                          ?> 
                
               
                <tr>
                   <td><?php echo $row['income_today']; ?></td>
				   
					 <td> <?php echo $row['due_today'];?></td> 
					 <td> <?php echo $row['cost_today'];?></td>				
					 <td> <?php echo $row['balance_today'];?></td>
					 <td> <?php echo $row['a_date'];?></td>
					 
						
					                    
												
					
					
					
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


        </section>

        <!-- right col -->
      </div>
      <!-- /.row (main row) -->

    </section>
    <!-- /.content -->

  

  <!-- /.control-sidebar -->
 <?php include_once('footer.php'); ?>