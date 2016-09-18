<?php
ob_start();
session_start();
if($_SESSION['name']!='snchousebd')
{
header('location: login.php');
}
include('config.php');
?>



<?php include_once('header.php'); ?>
<?php include_once('sidebar.php'); ?>

    <!-- Main content -->
    <section class="content" >
        <?php include_once('header_shop.php'); ?>
      <!-- Main row -->
      <div class="row"style="margin-top:5px">
        <!-- Left col --> <center style="margin-bottom:60px"><u><h3 >Accounting Information By Product</h3><h5> <br>( For Last 30 Days )</u></h5></center>
        <section class="col-lg-8 connectedSortable">
          <!-- Custom tabs (Charts with tabs)-->
		 
            <div class="form-group">
			<div class="col-lg-12">
                                                      <label class="col-lg-2 control-label">Product Category</label>
                                                      <div class="col-lg-8">
					<form class="form-horizontal" role="form" data-toggle="validator" method="post">   								          
                <select class="form-control select2" name="p_category" style="width: 100%;" required>
               									     
                      <?php
                      $statement = $db->prepare("SELECT * FROM tbl_category");
                      $statement->execute();
                      $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                      foreach ($result as $row) {
                        ?>
                      
                      <option value="<?php echo $row['cat_id'];?>" ><?php echo $row['cat_name'];?></option>
                      <?php
                      }
                      ?>
                </select> 
                 				
                                                      </div>
													   <div class=" col-lg-2">
                                                          <button type="submit" name="form1" class="btn btn-primary">Search</button>
                                                      </div>
													  </form>
			
                 </div>
				 </div>
        </section>
        <!-- /.Left col -->
        <!-- right col (We are only adding the ID to make the widgets sortable)-->
        <section class="col-lg-4 connectedSortable">
					  <?php
					  if(isset($_POST['form1']))
{
	try{  
					  $cat_id=$_POST['p_category'];
					  
					  
					  
                      $statement = $db->prepare("SELECT cat_name FROM tbl_category where cat_id=?");
                      $statement->execute(array($cat_id));
                      $result = $statement->fetch();
                              $value=30;
					 $statement1= $db->prepare("SELECT p_id,p_amount,sum(p_base_price) as total_base_price FROM tbl_category,tbl_products where  tbl_category.cat_id=? and tbl_products.p_category=? and tbl_products.p_date>DATE_SUB(CURDATE(), INTERVAL ? DAY)");
                      $statement1->execute(array($cat_id,$cat_id,$value));
                      $result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
                      foreach ($result1 as $row1) {
						  
						  
						  $initial_amount=$row1['p_amount'];
						  $total_base_price=$row1['total_base_price'];
						  
						        $statement2 = $db->prepare("SELECT sum(p_amount) as sell_amount,sum(p_base_price) as base_price_sold,sum(c_total) as sold_price,sum(c_cash) as cash_amoount FROM tbl_sell where p_id=? and c_date>DATE_SUB(CURDATE(), INTERVAL ? DAY)");
                      $statement2->execute(array($row1['p_id'],$value));
                      $result2 = $statement2->fetchAll(PDO::FETCH_ASSOC);
                      foreach ($result2 as $row2) {
                        ?>
								<h4>Category :<?php echo $result['cat_name']; ?> </h4>
			<h5>Available Amount : <?php echo $initial_amount; ?> </h5>
				<h5>Sold Amount : <?php echo $row2['sell_amount']; ?> </h5>
			<h5>Sold Product Base Price(Total) : <?php echo $row2['base_price_sold']; ?> </h5>
			<h5>Sold Product Sell Price(Total) : <?php echo $row2['sold_price']; ?> </h5>
			<?php $income=$row2['sold_price']-$row2['base_price_sold'];?>
			<h5>Total Income : <?php echo $income; ?> </h5>
            
			
						

						<?php
					  }
					  }
                   
                     
                     
					  
	}
	 catch(Exception $e) {
    $error_message1 = $e->getMessage();
  
			  
		  }
}  
		  ?>
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
        </section>
		
		
        <!-- right col -->
      </div>
      <!-- /.row (main row) -->

    </section>
    <!-- /.content -->

  

  <!-- /.control-sidebar -->
 <?php include_once('footer.php'); ?>