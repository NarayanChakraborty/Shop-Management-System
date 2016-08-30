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
						 $statement3 = $db->prepare("SELECT *  FROM tbl_accounting where a_date=?");
										  $statement3->execute(array($c_date));
										  $result3 = $statement3->fetchAll(PDO::FETCH_ASSOC);
										  foreach($result3 as $row3)
										  {
											  $_POST['todays_cost']=$_POST['todays_cost']+$row3['cost_today'];
						$balance= $row3['income_today']-$_POST['todays_cost'];
					 $statement2=$db->prepare("update tbl_accounting set cost_today=?,balance_today=? where a_date=? ");
		             $statement2->execute(array($_POST['todays_cost'],$balance,$c_date));
						
										  }
											
						
						
						
						
						
					}
					else
					{
						
						throw new Exception('Fill Up This Insert Section');
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
                                          <div class="panel-body bio-graph-info" style="padding:10px">
	
											
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
										  $statement1=$db->prepare("select sum(p_base_price) as base_total,sum(c_total) as sell_total, sum(c_last_payment) as payment, sum(c_due) as due,sum(p_base_price) as base_total from tbl_customers where c_date=?");
										  $statement1->execute(array(date('Y-m-d')));
										 $result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
										foreach($result1 as $row1){	
									    //--------------------------------------------------------------------------
											
											?>
											<div class="col-lg-3">
											
											<h4><?php echo "Date :".date('d-m-Y'); ?> </h4>
											
											
											<!--------------------Wheather account row is created or not , if not then insert default value------->
											<?php 	
											$statement1=$db->prepare('select * from tbl_accounting where a_date=?');
					$statement1->execute(array($c_date));
					$result1=$statement1->fetchColumn();
					if($result1<=0)
					{                       if($row1['base_total']==Null){ $row1['base_total']=0;}
											 if($row1['sell_total']==Null){ $row1['sell_total']=0;}
											  if($row1['payment']==Null){ $row1['payment']=0;}
											   if($row1['due']==Null){ $row1['due']=0;}
											$income_today=$row1['sell_total']-$row1['base_total']-$row1['due'];
											$statement3 = $db->prepare("insert into tbl_accounting(base_today,sell_today,payment_today,income_today,due_today,cost_today,balance_today,a_date) values(?,?,?,?,?,?,?,?)");
										  $statement3->execute(array($row1['base_total'],$row1['sell_total'],$row1['payment'],$income_today,$row1['due'],0,$row1['payment'],date('Y-m-d')));
					}
					                   //----------------------------------------------------------------------------------------------------------
											
					else{
						$income_today=$row1['sell_total']-$row1['base_total']-$row1['due'];
						
						
						$statement5=$db->prepare('select cost_today from tbl_accounting where a_date=?');
					$statement5->execute(array($c_date));
					$result5=$statement5->fetch();
						$balance= $income_today-$result5['cost_today'];
						
						
						$statement3 = $db->prepare("update tbl_accounting set base_today=?,sell_today=?,payment_today=?,income_today=?,due_today=? , balance_today=? where a_date=?");
										  $statement3->execute(array($row1['base_total'],$row1['sell_total'],$row1['payment'],$income_today,$row1['due'],$balance,date('Y-m-d')));
						
						
					}						
											
											?>
						
											<?php
											
										//-------------------------select  income_today,balance_today,cost_today---from tbl_accounting----------------	
											 $statement3 = $db->prepare("SELECT * FROM tbl_accounting where a_date=?");
										  $statement3->execute(array(date('Y-m-d')));
										  $result3 = $statement3->fetch();
										  
											
											?>
											<h5>Total Sell price:
											<?php  echo $result3['sell_today']; ?>
											</h5>
											
											<h5>Total Base Price :
											<?php echo $result3['base_today']; ?></h5>
										    
											<h5>Total Due Today :
											<?php echo $result3['due_today']; ?></h5>
											
											<h5>Total Income Today :
											<?php echo $result3['income_today']; ?></h5>
											
											<h5>Total Cost Today :
											<?php echo $result3['cost_today']; ?></h5>
											
											<h5>Todays Balance  :
											<?php echo $result3['balance_today']; ?></h5>
											
											
													
											<?php
											}
											?>
										
											<!---------------------------------------------------------------->
											</div>
											
								            <div class="col-lg-3">
											<?php
											
											
											
											$statement4=$db->prepare("select sum(p_base_price) as base_total,sum(c_total) as sell_total, sum(c_last_payment) as payment, sum(c_due) as due from tbl_customers where c_date=? and p_shop=1");
										  $statement4->execute(array(date('Y-m-d')));
										 $result4 = $statement4->fetchAll(PDO::FETCH_ASSOC);
										foreach($result4 as $row4){	?>
											
											<h4>Khalek One</h4>
											<h5>Sell Today:<?php echo $row4['sell_total']; ?></h5>
											<h5>Total Base Price :
											<?php echo $row4['base_total']; ?></h5>
										    
											<h5>Total Due Today :
											<?php echo $row4['due']; ?></h5>
											<h5>Total Income Today :
											<?php 
												$income_today1=$row4['sell_total']-$row4['base_total']-$row4['due'];
											echo $income_today1; ?></h5>
											
											
												<?php
											}
											?>
											</div>
											 
											 <div class="col-lg-3">
											<?php
											
											
											
											$statement4=$db->prepare("select sum(p_base_price) as base_total,sum(c_total) as sell_total, sum(c_last_payment) as payment, sum(c_due) as due from tbl_customers where c_date=? and p_shop=2");
										  $statement4->execute(array(date('Y-m-d')));
										 $result4 = $statement4->fetchAll(PDO::FETCH_ASSOC);
										foreach($result4 as $row4){	?>
											
											<h4>Khalek Two</h4>
											<h5>Sell Today:<?php echo $row4['sell_total']; ?></h5>
											<h5>Total Base Price :
											<?php echo $row4['base_total']; ?></h5>
										    
											<h5>Total Due Today :
											<?php echo $row4['due']; ?></h5>
											<h5>Total Income Today :
											<?php 
												$income_today2=$row4['sell_total']-$row4['base_total']-$row4['due'];
											echo $income_today2; ?></h5>
											
											
											
												<?php
											}
											?>
											</div>
											<div class="col-lg-3">
											<?php
											
											
											
											$statement4=$db->prepare("select sum(p_base_price) as base_total,sum(c_total) as sell_total, sum(c_last_payment) as payment, sum(c_due) as due from tbl_customers where c_date=? and p_shop=3");
										  $statement4->execute(array(date('Y-m-d')));
										 $result4 = $statement4->fetchAll(PDO::FETCH_ASSOC);
										foreach($result4 as $row4){	?>
											
											<h4>store House</h4>
											<h5>Sell Today:<?php echo $row4['sell_total']; ?></h5>
											<h5>Total Base Price :
											<?php echo $row4['base_total']; ?></h5>
										    
											<h5>Total Due Today :
											<?php echo $row4['due']; ?></h5>
											<h5>Total Income Today :
											<?php 
												$income_today3=$row4['sell_total']-$row4['base_total']-$row4['due'];
											echo $income_today3; ?></h5>
											
											
											
												<?php
											}
											?>
											</div>
											
									
								
								  </div>
								  
								  	
														
									
											<form class="form-horizontal" role="form" data-toggle="validator" method="post">                                                  
                                                 <div class="form-group">
                                                      <label class="col-lg-2 control-label">Count Todays Cost</label>
                                                      <div class="col-lg-8">
                                                          <input type="number" min=0 name="todays_cost" value="" class="form-control"  placeholder="Total Cost of today " required>
                                                      </div>
                                                  </div>
                                                 
                                                  <div class="form-group">
                                                      <div class="col-lg-offset-8 col-lg-2">
													
                                                          <button type="submit" name="form2" class="btn btn-primary">Update Banlance</button>
                                                        
                                                      </div>
                                                  </div>
                                              </form>
								  
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
                  <th>Total Sell </th> 
				  <th>Total Base </th> 
				  <th>Total Due</th>
                  <th>Total Income</th>
				  <th>Total Cost</th>
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
                   <td><?php echo $row['sell_today']; ?></td>
				   
					 <td> <?php echo $row['base_today'];?></td> 
					 <td> <?php echo $row['due_today'];?></td>	 
					 <td> <?php echo $row['income_today'];?></td>
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