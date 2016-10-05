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
                    
            <!-- /.box-header -->
            <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example" >
                <thead>
                <tr>
                
                  <th>Product Category</th> 
				  <th>Khalek One</th>
				  <th>Total Price</th>
				  <th>Khalek Two</th>
				  <th>Store House</th>
                  
				 
                </tr>
                </thead>
                <tbody style="text-align:center">
                 <?php
										$statement1 = $db->prepare("SELECT * FROM tbl_category");
										  $statement1->execute();
										  $result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
										  foreach($result1 as $row1)
										  {
                                          ?> 
                
               
                <tr>
               
                  <td><?php 
                                   
											  echo $row1['cat_name'];	
										  
												
					?></td>
				
						<td><?php 
                                    $statement2 = $db->prepare("SELECT sum(p_amount) as total_amount,p_base_price FROM tbl_products where p_category=? and p_shop=?");
										  $statement2->execute(array($row1['cat_id'],1));
										  $result2= $statement2->fetch();
										  
										  if($result2['total_amount']==0)
										  {
											  echo $value=0;
										  }
										  else
						                  echo $result2['total_amount'];
										  
										
						?></td><td><?php echo $result2['total_amount']*$result2['p_base_price']; ?></td>
						<td><?php 
                                    $statement3 = $db->prepare("SELECT sum(p_amount) as total_amount FROM tbl_products where p_category=? and p_shop=?");
										  $statement3->execute(array($row1['cat_id'],2));
										  $result3= $statement3->fetch();
						                    if($result3['total_amount']==0)
										  {
											  echo $value=0;
										  }
										  else
						                  echo $result3['total_amount'];
										  
										
						?></td>
						<td><?php 
                                    $statement4 = $db->prepare("SELECT sum(p_amount) as total_amount FROM tbl_products where p_category=? and p_shop=?");
										  $statement4->execute(array($row1['cat_id'],3));
										  $result4= $statement4->fetch();
						                  if($result4['total_amount']==0)
										  {
											  echo $value=0;
										  }
										  else
						                  echo $result4['total_amount'];
										  
										
						?></td>
						
					                   
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
