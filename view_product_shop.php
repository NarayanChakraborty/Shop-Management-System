<?php include_once('header.php'); ?>
<?php include_once('sidebar.php'); ?>


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

    <!-- Main content -->
    <section class="content">
        <?php include_once('header_shop.php'); ?>
      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-12 connectedSortable">
          <!-- Custom tabs (Charts with tabs)-->

		                <div style="padding:10px;margin-bottom:20px">
		  
		                      
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
			  
			<div class="box">
            <div class="box-header">
              <h3 class="box-title">List of Products  For Last <?php 

                 if($value==7)
				 {
					 echo "  Week";
				 }else if($value==30)
				 {
					 echo "  Month";
				 }else  if($value==180)
				 {
					 echo "  6 Months";
				 } else if($value==365)
				 {
					 echo "  Last Year";
				 }

			  ?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Product Model</th>
                  <th>Product Category</th>
                  <th>Product Price</th>
                  <th>Product Amount</th>
                  <th>Shop Name</th>
				  <th>Action</th>
				  
                </tr>
                </thead>
                <tbody>
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
					                    <td><center>
                    <div class="btn-group">
                     <a href="#inline<?php echo $row['p_id'];?>" class="fancybox"title="View product"> <button type="button" class="btn btn-info"><span class="glyphicon glyphicon-eye-open"></span></button></a>

					 
					 <div id="inline<?php echo $row['p_id'];?>"style="display:none;width:700px;margin:10px 30px">
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
													<label>Product Price :&nbsp;&nbsp;</label>
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
													<label>Product Shop :&nbsp;&nbsp;</label>
													<?php echo $row['p_details']; ?>
													</h4>	
													
													<h4> 
													<label>Product Arival Date :&nbsp;&nbsp;</label>
													<?php echo $row['p_date']; ?>
													</h4>	  
														  
														</div>
						 </div>
                      <a href="" title="Edit product"><button type="button" class="btn btn-info"><span class="glyphicon glyphicon-pencil"></span></button></a>
                      <a href="" title="Delete product"><button type="button" class="btn btn-info"><span class="glyphicon glyphicon-remove"></span></button></a>
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
		  

		  

        </section>
        
     
      </div>
      <!-- /.row (main row) -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  

  <!-- /.control-sidebar -->
 <?php include_once('footer.php'); ?>