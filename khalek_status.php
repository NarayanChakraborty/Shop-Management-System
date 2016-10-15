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
		
        <section class="col-lg-4 connectedSortable">
		<section class="panel" style="padding-left:25px;">  
          <!-- Custom tabs (Charts with tabs)-->
			<?php 
			
			 $statement2 =$db->prepare("SELECT sum(loan_take) as total_loan ,sum(loan) as remaining_loan FROM tbl_khalek");
										    $statement2->execute(array());
										 
										  $result2 = $statement2->fetch();
			
			
			?>
            <h4><?php echo "Total Loan Taken : ".$result2['total_loan']; ?> </h4>
			<h4><?php echo "Total Remaining Loan : ".$result2['remaining_loan']; ?> </h4>
        </section>
       </section>
      </div>
	  
	  
	  
	  
	  
	  
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-12 connectedSortable">
          <!-- Custom tabs (Charts with tabs)-->
                     <section class="panel">                                          
                                          <div class="panel-body bio-graph-info">
		             
		  
		                      
				                   <form method="POST" >
                                        <div class="form-group">
                                            <h3>Cost Management For :</h3>
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
                  <th>Date</th>
				  <th>Shop Cost</th>
				  <th>Bank Cost</th>
                  <th>Salary Cost</th>
                  <th>Payment To Company</th>
                  <th>Loan Taken</th>
                  <th>Remaining Loan</th>
				  <th>Total Balance</th>
				  
                </tr>
                </thead>
                <tbody style="text-align:center">
                 <?php
										 if($value!="All")
										 {
										  $statement =$db->prepare("SELECT * FROM tbl_khalek where date>DATE_SUB(CURDATE(), INTERVAL ? DAY)");
										  $statement->execute(array($value));
										 }
										 else
										 {
											 $statement =$db->prepare("SELECT * FROM tbl_khalek");
										    $statement->execute(array());
										 }
										  $result = $statement->fetchAll(PDO::FETCH_ASSOC);
										  foreach ($result as $row) {
                                          ?> 
                
               
                <tr>
				<td><?php echo $row['date']; ?></td>
                   <td><?php echo $row['total_cost']; ?></td>
				   <td><?php echo $row['bank_cost']; ?></td>
				   <td><?php echo $row['salary_cost']; ?></td>
                  
				   <td><?php echo $row['payment_company']; ?></td>
				    <td><?php echo $row['loan_take']; ?></td>
					<td><?php echo $row['loan']; ?></td>
				    <td><?php echo $row['balance']; ?></td>
					 
						
                    
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
