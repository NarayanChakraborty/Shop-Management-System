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
                    

			  <!--------- page start-->
			  <?php include_once("config.php");?>

			  
			<div class="panel panel-default">
                        <div class="panel-heading">List of Products   <?php 

           

			  ?>
            </div>
            <!-- /.box-header -->
            <div class="panel-body">
                            <div class="table-responsive">
							
							
							
							  
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example" >
								<form class="form-horizontal" role="form" data-toggle="validator" method="post"enctype="multipart/form-data" name="form3" >
                <thead>
                <tr>
				  <th>Click</th>
				  <th>Category</th>
                  <th>Product Model</th>
				  <th>Product Base Price</th>
				  <th>Product Sell Price</th>
				  <th>Quantity</th>
				
                  <th>Final Amount</th>
                
				
				
				
				  
                </tr>
                </thead>
				
				
				<form class="form-horizontal" role="form" data-toggle="validator" method="post"enctype="multipart/form-data" name="form3" > 
				
                <tbody style="text-align:center">
				
				
				<?php
				 $statement =$db->prepare("SELECT * FROM tbl_products where p_amount!=0");
										    $statement->execute(array());
											$result = $statement->fetchAll(PDO::FETCH_ASSOC);
										  foreach ($result as $row) {
                                          ?> 
				
                 <tr class="txtMult"><td><input type="checkbox" name="p_id"></td>
				 
				 <td><?php 
                                                    
										  $statement1 = $db->prepare("SELECT cat_name FROM tbl_category where cat_id=?");
										  $statement1->execute(array($row['p_category']));
										  $result1 = $statement1->fetch();
												echo $result1['cat_name'];	
											?></td>
                     <td><?php echo $row['p_model']; ?></td>
					 <td><?php echo $row['p_base_price']; ?>
					 </td><td><input type="number" class="val1" value="<?php echo $row['p_price']; ?>" ></td>
                      
                     <td><input type="number" min=0 max=<?php echo $row['p_amount']; ?>   value="" class="val2"  placeholder=" " required></div></td>
                     <td>  <span class="multTotal">0.00</span></td>
                  
				  <script type="text/javascript">
												$(document).ready(function () {
       $(".txtMult input").keyup(multInputs);

       function multInputs() {
           var mult = 0;
           // for each row:
           $("tr.txtMult").each(function () {
               // get the values from this row:
               var $val1 = $('.val1', this).val();
               var $val2 = $('.val2', this).val();
               var $total = ($val1 * 1) * ($val2 * 1)
               $('.multTotal',this).text($total);
               
           });
          
       }
  });

													</script>
												
				  
				  </tr>
				  
				  
				  <?php
										  }
				  ?>
				  
				  
                                             
                </tbody>
               
              </table>
			  
			  
			  <div class="form-group">
                                                      <div class="col-lg-offset-10 col-lg-2">
													  <input type="hidden" name="hidden_id" value="<?php echo $row['p_id'];?>">
													  <input type="hidden" name="hidden_id_base_price" value="<?php echo $row['p_base_price'];?>">
													   <input type="hidden" name="hidden_id_shop" value="<?php echo $row['p_shop'];?>">
                                                          <button type="submit" name="form1" class="btn btn-primary">Calculate</button>
                                                      </div>
                                                  </div>
                                              </form>
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
