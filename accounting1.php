<?php
ob_start();
session_start();
if($_SESSION['name']!='snchousebd')
{
header('location: login.php');
}
include('config.php');
$c_date=date('Y-m-d');
?>

<?php
		  try
		  {
			  
		      
		         if(isset($_POST['form2']))
				 {
					$statement1=$db->prepare('select * from tbl_accounting where a_date=?');
					$statement1->execute(array(date('Y-m-d')));
					$result1=$statement1->fetchColumn();
					if($result1>0)
					{
						$statement=$db->prepare("select * from tbl_shop");
						$statement->execute();
						$result=$statement->fetchAll(PDO::FETCH_ASSOC);
						foreach($result as $row)
						{
											$statement3 = $db->prepare("SELECT * FROM tbl_accounting where a_date=? and p_shop=?");
										  $statement3->execute(array(date('Y-m-d'),$row['shop_id']));
										  $result3 = $statement3->fetchAll(PDO::FETCH_ASSOC);
										  foreach($result3 as $row3)
										  {
											  if($row3['p_shop']==1){
												   $cost_today_one=$_POST['todays_cost_one']+$row3['cost_today'];
						
						$statement2=$db->prepare("update tbl_accounting set cost_today=? where a_date=? and p_shop=? ");
		             $statement2->execute(array($cost_today_one,date('Y-m-d'),1));
											  } 
											  if($row3['p_shop']==2){
												   $cost_today_two=$_POST['todays_cost_two']+$row3['cost_today'];
						
						$statement3=$db->prepare("update tbl_accounting set cost_today=? where a_date=? and p_shop=? ");
		             $statement3->execute(array($cost_today_two,$c_date,2));
											  } 
											  if($row3['p_shop']==3){
												   $cost_today_three=$_POST['todays_cost_three']+$row3['cost_today'];
						
						 $statement4=$db->prepare("update tbl_accounting set cost_today=? where a_date=? and p_shop=? ");
		             $statement4->execute(array($cost_today_three,$c_date,3));
											  }
										  }
					 
					 
					
							
						}
				
					 }
											
						
						
						
						
						
					}
					else
					{
						
						throw new Exception('Fill Up This Insert Section');
					}
					 
				 }
		 
		  catch(Exception $e) {
    $error_message1 = $e->getMessage();
  
			  
		  }
		   
		  ?>



<?php include_once('header.php'); ?>
<?php include_once('sidebar.php'); ?>
<?php include_once('config.php'); ?>
    <!-- Main content -->
    <section class="content">
        <?php include_once('header_shop.php'); ?>
      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
		<section class=" col-lg-12 connectedSortable">
		
		 <section class="panel" >  
		 
		 
							<div class="panel-body bio-graph-info" style="padding:10px">
		
					<?php 
					                   $statement=$db->prepare("select * from tbl_shop");
									   $statement->execute();
									   $result=$statement->fetchAll(PDO::FETCH_ASSOC);
									   foreach($result as $row){
										   
										   
										  
										   
										   	 //--------------------TO Find The daily balance ,due-------------------------
										  $statement1=$db->prepare("select sum(p_base_price) as base_total,sum(c_total) as sell_total, sum(c_total) as sell_total,sum(c_cash) as cash_total from tbl_sell where c_date=? and p_shop=?");
										  $statement1->execute(array(date('Y-m-d'),$row['shop_id']));
										 $result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
										foreach($result1 as $row1){	
									    //--------------------------------------------------------------------------
																			
											$statement2=$db->prepare('select * from tbl_accounting where a_date=? and p_shop=?');
											$statement2->execute(array(date('Y-m-d'),$row['shop_id']));
											$result2=$statement2->fetchColumn();
											if($result2>0)

											{                    

													    if($row1['base_total']==Null){ $row1['base_total']=0;}
																	 if($row1['sell_total']==Null){ $row1['sell_total']=0;}
																	  if($row1['cash_total']==Null){ $row1['cash_total']=0;}
																	   $due_total= $row1['sell_total']- $row1['cash_total'];
																	   
																	 	$statement5=$db->prepare('select due_payment,cost_today from tbl_accounting where a_date=? and p_shop=?');
											$statement5->execute(array(date('Y-m-d'),$row['shop_id']));
											$result5=$statement5->fetch();  
																	   
																	   
																	   
																	   $balance=$row1['cash_total']+$result5['due_payment']-$result5['cost_today'];
																	$statement3 = $db->prepare("update tbl_accounting set base_today=?,sell_today=?,cash_today=?,due_today=?,balance_today=? where p_shop=? and a_date=? ");
																  $statement3->execute(array($row1['base_total'],$row1['sell_total'],$row1['cash_total'],$due_total,$balance,$row['shop_id'],date('Y-m-d')));


											}
											else if($result2<=0){
												   if($row1['base_total']==Null){ $row1['base_total']=0;}
																	 if($row1['sell_total']==Null){ $row1['sell_total']=0;}
																	  if($row1['cash_total']==Null){ $row1['cash_total']=0;}
																	   $due_total= $row1['sell_total']- $row1['cash_total'];
																	
																	$statement3 = $db->prepare("insert into tbl_accounting(base_today,sell_today,cash_today,due_today,cost_today,balance_today,p_shop,a_date) values(?,?,?,?,?,?,?,?)");
																  $statement3->execute(array($row1['base_total'],$row1['sell_total'],$row1['cash_total'],$due_total,0,$row1['cash_total'],$row['shop_id'],date('Y-m-d')));                
											}
											
											
											
		
										}
										   
										   
										   
										   
										   
										   
										   
										   
									   }
									
				                      
	       $statement3=$db->prepare("select * from tbl_accounting where a_date=?");
		   $statement3->execute(array(date('Y-m-d')));
		   $result3=$statement3->fetchAll(PDO::FETCH_ASSOC);
		   foreach($result3 as $row3){
			   
			   
			   $statement4=$db->prepare("select shop_name from tbl_shop where shop_id=?");
		   $statement4->execute(array($row3['p_shop']));
		   $result4=$statement4->fetch();
		    
			   ?>
			   
			   <section class="col-lg-3 connectedSortable">
          <!-- Custom tabs (Charts with tabs)-->
			<h4>Shop :<?php echo $result4['shop_name']; ?> </h4>
			<h5>Total Base Price : <?php echo $row3['base_today']; ?> </h5>
			<h5>Total Sell Price : <?php echo $row3['sell_today']; ?> </h5>
			<h5>Total Income : <?php echo $row3['sell_today']-$row3['base_today']; ?> </h5>
            <h5>Total Cash : <?php echo $row3['cash_today']; ?> </h5>
			<h5>Total Due: <?php echo $row3['sell_today']-$row3['cash_today']; ?> </h5>
			<h5>Total Due Payment: <?php echo $row3['due_payment']; ?> </h5>
			<h5>Total Balance: <?php echo $row3['cash_today']+$row3['due_payment']-$row3['cost_today']; ?> </h5>
        </section>
			   
			   <?php
		   }
		   ?>
        
		
        <!-- /.Left col -->
        <!-- right col (We are only adding the ID to make the widgets sortable)-->
        <section class="col-lg-3 connectedSortable">
     <?php
            $statement3=$db->prepare("select sum(base_today) as base_today,sum(balance_today) as balance_today ,sum(due_today) as due_today,sum(cost_today) as cost_today,sum(sell_today) as sell_today, sum(cash_today) as cash_today ,sum(due_payment) as due_payment from tbl_accounting where a_date=?");
		   $statement3->execute(array(date('Y-m-d')));
		   $result3=$statement3->fetchAll(PDO::FETCH_ASSOC);
		   foreach($result3 as $row3){
			   
			?>
			   
			  
          <!-- Custom tabs (Charts with tabs)-->
			<h4>Shop :<?php echo "Total"; ?> </h4>
			<h5>Total Base Price : <?php echo $row3['base_today']; ?> </h5>
			<h5>Total Sell Price : <?php echo $row3['sell_today']; ?> </h5>
			<?php $income= $row3['sell_today']-$row3['base_today']; ?>
			<h5>Total Income : <?php echo $income; ?> </h5>
            <h5>Total Cash : <?php echo $row3['cash_today']; ?> </h5>
			<h5>Total Due: <?php echo $row3['due_today']; ?> </h5>
			<h5>Total Due Payment: <?php echo $row3['due_payment']; ?> </h5>
			<h5>Total Cost: <?php echo $row3['cost_today']; ?> </h5>
			<?php
			$balance=$row3['cash_today']-$row3['cost_today']+$row3['due_payment'];?>
			<h5>Total Balance: <?php echo $balance; ?> </h5>
     
			   <?php
		   }
		   ?>
		   
		         </div>
				 
				 
				 
				 			
									
											<form class="form-horizontal" role="form" data-toggle="validator" method="post">                                                  
                                                 <div class="form-group">
                                                      <label class="col-lg-2 control-label"> Cost(Shop One)</label>
                                                      <div class="col-lg-8">
                                                          <input type="number" min=0 name="todays_cost_one" value="0" class="form-control"  placeholder="Total Cost of today " >
                                                      </div>
                                                  </div>
												  <div class="form-group">
                                                      <label class="col-lg-2 control-label">Cost(Shop Two)</label>
                                                      <div class="col-lg-8">
                                                          <input type="number" min=0 name="todays_cost_two" value="0" class="form-control"  placeholder="Total Cost of today " >
                                                      </div>
                                                  </div>
												  <div class="form-group">
                                                      <label class="col-lg-2 control-label">Cost(Shop Three)</label>
                                                      <div class="col-lg-8">
                                                          <input type="number" min=0 name="todays_cost_three" value="0" class="form-control"  placeholder="Total Cost of today ">
                                                      </div>
                                                  </div>
                                                 
                                                  <div class="form-group">
                                                      <div class="col-lg-offset-8 col-lg-2">
													
                                                          <button type="submit" name="form2" class="btn btn-primary">Update Banlance</button>
                                                        
                                                      </div>
                                                  </div>
                                              </form>
		   
		   
		   
						</section>  
		</section>
		
		<!---------------------------------------------------------------------------------->
	
	   <section class="panel" >
	
	
						<div class="panel-body bio-graph-info"style="margin-top:10px" >
		
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
	
	     
		<section class="panel">  
		 
		 
			  
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
				  <th>Shop Name</th>
				  <th>Total Base price </th>
                  <th>Total Sell price </th> 
				    <th>Total Income</th>
				  <th>Total Cash amount</th>
				  <th>Total Due Payment</th>
                 
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
				   
				   
				   <?php 
				   $statement4=$db->prepare("select shop_name from tbl_shop where shop_id=?");
				   $statement4->execute(array($row['p_shop']));
				   $result4=$statement4->fetch(); ?>
				   <td><?php echo $result4['shop_name']; ?></td>
				
				 <td> <?php echo $row['base_today'];?></td> 
                   <td><?php echo $row['sell_today']; ?></td>
				           <?php $income=$row['sell_today']-$row['base_today']; ?>				 
					 <td> <?php echo $income;?></td>
					
					 <td><?php echo $row['cash_today']; ?></td>
					 <td> <?php echo $row['due_payment'];?></td>	
              
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

				
				
				
				
				
				
				
				
				


										<section class="  col-lg-12 connectedSortable">
	 
								        <section class="panel">                                          
                                          <div class="panel-body bio-graph-info">
										
										
										 <table class="table table-striped table-bordered table-hover" id="dataTables-example" >
                <thead>
                <tr>
                  <th>Total</th>
				  <th>Total Base price </th>
                  <th>Total Sell price </th> 
				     <th>Total Income</th>
				  <th>Total Cash amount</th>
				  <th>Total Due Payment</th>
				  <th>Total Due</th>
                
				  <th>Total Cost</th>
                  <th>Total Balance</th>
				  <th>For</th>
				  
                </tr>
                </thead>
                <tbody style="text-align:center">
                 <?php
										 if($value!="All")
										 {
											 $statement=$db->prepare("select sum(base_today) as base_today,sum(balance_today) as balance_today ,sum(due_payment) as due_payment,sum(cost_today) as cost_today,sum(sell_today) as sell_today, sum(cash_today) as cash_today from tbl_accounting where a_date>DATE_SUB(CURDATE(), INTERVAL ? DAY)");
		   $statement->execute(array($value));
		 
											 
										 
										 }
										 else if($value=="All")
										 {
											 $statement=$db->prepare("select sum(base_today) as base_today,sum(balance_today) as balance_today ,sum(due_payment) as due_payment,sum(cost_today) as cost_today,sum(sell_today) as sell_today, sum(cash_today) as cash_today from tbl_accounting ");
										    $statement->execute();
										 }
										  $result = $statement->fetchAll(PDO::FETCH_ASSOC);
										  foreach ($result as $row) {
                                          ?> 
                <tr>
				   
				   
				  
				
				   <td>    </td>
				   
				    <td> <?php echo $row['base_today'];?></td> 
                   <td><?php echo $row['sell_today']; ?></td>
				    <?php $income=$row['sell_today']-$row['base_today']; ?>				 
					 <td> <?php echo $income;?></td>
					
					 <td><?php echo $row['cash_today']; ?></td>
					 <td> <?php echo $row['due_payment'];?></td>	
					 
					  <?php $due=$row['sell_today']-$row['cash_today']-$row['due_payment']; ?>	
						<td> <?php echo $due;?></td>	
					 
                     		

					 
					 <td> <?php echo $row['cost_today'];?></td>				
					 <td> <?php echo $row['balance_today'];?></td>
					<td><?php echo $value."DAYS"; ?></td>
					 
						
					                    
												
					
					
					
					</div></center>
                  </td>
                </tr>
				
					<?php  
										}
										?>
                </tbody>
               
              </table>
										
										
										
	  
	                                        </div>
											</section>
	                             </section>







				
		
		</section>
        <!-- right col -->
      </div>
      <!-- /.row (main row) -->
	  
	                         

    </section>
    <!-- /.content -->

  

  <!-- /.control-sidebar -->
 <?php include_once('footer.php'); ?>