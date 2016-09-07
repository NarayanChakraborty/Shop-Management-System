<?php
ob_start();
session_start();
if($_SESSION['name']!='snchousebd')
{
header('location: login.php');
}
include('config.php');
?>

<?php
if(isset($_POST['form1']))
{
	try{ 
	     
		 if(empty($_POST['d_date']))
		{
			throw new Exception("Date can not be empty");
		} 
		if(empty($_POST['d_close']))
		{
			throw new Exception("Close Balance can not be empty");
		}
		

          $statement1=$db->prepare('insert into tbl_dealer_one(d_date,d_company,d_sales,d_adj1,d_cash,d_return,d_adj2,d_close) value(?,?,?,?,?,?,?)');
		  $statement1->execute(array($_POST['d_date'],$_POST['d_company'],$_POST['d_sales'],$_POST['d_adj1'],$_POST['d_cash'],$_POST['d_return'],$_POST['d_adj2'],$_POST['d_close']));
		  
		
		  
	}
	
	
	catch(Exception $e)
	{
		$error_message1=$e->getMessage();
	}
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
		<div class="col-lg-12">
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
                            <i class="icon-remove">X</i>
                          </button>
                          <strong>Well done!&nbsp; </strong><?php echo $success_message1;?>
                       </div>
                       <?php
                        }
                      ?> 
			  
			  
		
		
		
												 <h5 class="col-lg-2"></h5>
												 <center> <h4 class="col-lg-3">Debit</h4></center>
												  <center> <h4 class="col-lg-5">Credit</h4></center>
												   <center>  <h4 class="col-lg-2">Closing Balance</h4></center>
												 </div>
        <section class="col-lg-12 connectedSortable">
          <!-- Custom tabs (Charts with tabs)-->
												
			                                               
                                                 <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover"  >
												 
												 
												 <thead>
												
												 
												 <tr>
												 <th>Date</th>
												 <th>Company</th>
												 <th>Sales</th>
												 <th>Adj</th>
												 <th>Cash/Bandk</th>
												 <th>Return</th>
												 <th>Adjacent</th>
												 
												 
												 
												 </tr>
												 </thead>
												<tbody> 
												<form class="form-horizontal" role="form" data-toggle="validator" method="post">   
												 <td class="col-lg-1">
												<input type="date" name="d_date" class="form-control" data-inputmask="" data-mask></td>
												 <td class="col-lg-1"><input type="text" min=0 name="d_company" value="" class="form-control"  placeholder=" " required ></td>
												 
												
												 <td class="col-lg-2"><input type="number" min=0 name="d_sales" value="0" class="form-control"  placeholder=" " required ></td>
												 <td class="col-lg-1"><input type="number" min=0 name="d_adj1" value="0" class="form-control"  placeholder=" " required></td>
											
												
												<td class="col-lg-2"><input type="number" min=0 name="d_cash" value="0" class="form-control"  placeholder="" required></td>
												 <td class="col-lg-1"><input type="number" min=0 name="d_return" value="0" class="form-control"  placeholder="" required></td>
												 <td class="col-lg-2"><input type="number" min=0 name="d_adj2" value="0" class="form-control"  placeholder="" required></td>
												<td class="col-lg-2"><input type="number" min=0 name="d_close" value="0" class="form-control"  placeholder="" required></td>
												 
												 
												 </tbody>
												 </table>
												 </div>
												 
												  <div class="form-group">
                                                      <div class="col-lg-offset-11 col-lg-1">
                                                          <button type="submit" name="form1" class="btn btn-primary">Update</button>
                                                      </div>
                                                  </div>
               </form>
		   

        </section>
        <!-- /.Left col -->
        <!-- right col (We are only adding the ID to make the widgets sortable)-->
        
	
        <!-- right col -->
      </div>
      <!-- /.row (main row) -->
	  
	  
	  
	        <div class="row" style="margin-top:10px">
        <!-- Left col -->
        <section class="col-lg-12 connectedSortable">
          <!-- Custom tabs (Charts with tabs)-->
                     <section class="panel">                                          
                                          <div class="panel-body bio-graph-info">
		             
		  
		                      
				                   <form method="POST" >
                                        <div class="form-group">
                                            <h3>Select For :</h3>
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
												 <th>Company</th>
												 <th>Sales</th>
												 <th>Adj</th>
												 <th>Cash/Bandk</th>
												 <th>Return</th>
												 <th>Adjacent</th>
												 <th>Close</th>
				  
                </tr>
                </thead>
                <tbody style="text-align:center">
                 <?php
										 if($value!="All")
										 {
										  $statement =$db->prepare("SELECT * FROM tbl_dealer_one where d_date>DATE_SUB(CURDATE(), INTERVAL ? DAY)");
										  $statement->execute(array($value));
										 }
										 else
										 {
											 $statement =$db->prepare("SELECT * FROM tbl_dealer_one");
										    $statement->execute(array());
										 }
										  $result = $statement->fetchAll(PDO::FETCH_ASSOC);
										  foreach ($result as $row) {
                                          ?> 
                
               
                <tr>
                   <td><?php echo $row['d_date']; ?></td>
				   <td><?php echo $row['d_company']; ?></td>
				   <td><?php echo $row['d_sales']; ?></td>
				   <td><?php echo $row['d_adj1']; ?></td>
				   <td><?php echo $row['d_cash']; ?></td>
				   <td><?php echo $row['d_return']; ?></td>		
				   <td><?php echo $row['d_adj2']; ?></td>
                  
					<td><?php echo $row['d_close']; ?></td>	          
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
	  
	  
	  
	  
	  
	  
	  
	  
	  

    </section>
    <!-- /.content -->

  

  <!-- /.control-sidebar -->
 <?php include_once('footer.php'); ?>