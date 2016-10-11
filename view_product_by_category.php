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
                    <div class="panel panel-default">
                </div>
            <!-- /.box-header -->
			<div class="panel">
            <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example" >
                <thead>
                <tr>
                
                  <th style="background-color:#aca;">Product Category</th> 
				  <th style="background-color:#bac;">Khalek One<br>(Amount)</th>
				  <th style="background-color:#bac;">Khalek One<br>(Total Price)</th>
				  <th style="background-color:#4ab;">Khalek Two<br>(Amount)</th>
				  <th style="background-color:#4ab;">Khalek Two<br>(Total Price)</th>
				  <th  style="background-color:#4a6;">Store House<br>(Amount)</th>
				  <th  style="background-color:#4a6;">Store House<br>(Total Price)</th>
				  <th  style="background-color:#ace;">Final<br>(Amount)</th>
				  <th  style="background-color:#acf;">Final<br>(Total Price)</th>
                  
				 
                </tr>
                </thead>
                <tbody style="text-align:center">
                 <?php
				 
							$amount1=0;
							$amount2=0;
							$amount3=0;
							$price1=0;
							$price2=0;
							$price3=0;
							$total_amount=0;
							$total_price=0;
				 
										$statement1 = $db->prepare("SELECT * FROM tbl_category");
										  $statement1->execute();
										  $result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
										  foreach($result1 as $row1)
										  {
                                          ?> 
                
               
                <tr>
               
                  <td style="background-color:#aca;"><?php 
                                   
											  echo $row1['cat_name'];	
										  
												
					?></td>
				
						<td style="background-color:#bac;"><?php 
                                    $statement2 = $db->prepare("SELECT sum(p_amount) as total_amount,p_base_price FROM tbl_products where p_category=? and p_shop=?");
										  $statement2->execute(array($row1['cat_id'],1));
										  $result2= $statement2->fetch();
										  
										  if($result2['total_amount']==0)
										  {
											  $amount1=0;
											  echo $amount1;
											  
										  }
										  else
										  {
											   $amount1=$result2['total_amount'];
											  echo $amount1;
										  }
						                  
										  
										
						?></td>
						<td style="background-color:#bac;"><?php $price1=$result2['total_amount']*$result2['p_base_price'];
							echo $price1;
						?></td>
						<td style="background-color:#4ab;"><?php 
                                    $statement3 = $db->prepare("SELECT sum(p_amount) as total_amount,p_base_price FROM tbl_products where p_category=? and p_shop=?");
										  $statement3->execute(array($row1['cat_id'],2));
										  $result3= $statement3->fetch();
						                   if($result3['total_amount']==0)
										  {
											  $amount2=0;
											  echo $amount2;
											  
										  }
										  else
										  {
											   $amount2=$result3['total_amount'];
											  echo $amount2;
										  }
						                  
										  
										
						?></td>
						<td style="background-color:#4ab;"><?php $price2=$result3['total_amount']*$result3['p_base_price'];
							echo $price2;
						?></td>
						<td style="background-color:#4a6;"><?php 
                                    $statement4 = $db->prepare("SELECT sum(p_amount) as total_amount,p_base_price FROM tbl_products where p_category=? and p_shop=?");
										  $statement4->execute(array($row1['cat_id'],3));
										  $result4= $statement4->fetch();
						                  if($result4['total_amount']==0)
										  {
											  $amount3=0;
											  echo $amount3;
											  
										  }
										  else
										  {
											   $amount3=$result4['total_amount'];
											  echo $amount3;
										  }
						                  
										  
										
						?></td>
						<td  style="background-color:#4a6;"><?php $price3=$result4['total_amount']*$result4['p_base_price'];
							echo $price3;
						?></td>
						<td  style="background-color:#acd;"><?php 
							$totalamount=$amount1+$amount2+$amount3;
							$total_amount=$total_amount+$totalamount;
							echo $totalamount;
						?></td>
						<td  style="background-color:#acd;"><?php 
							$totalprice=$price1+$price2+$price3;
							$total_price=$total_price+$totalprice;
							echo $totalprice;
						?></td>
					                   
                </tr>
				
					<?php  
										}
										?>
										
										<tr style="background-color:#acd;">
										<td style="background-color:#aca;" ><strong>TOTAL</strong></td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td><strong><?php echo $total_amount;?></strong></td><td><strong><?php echo $total_price; ?> </strong></td>
										</tr>
                </tbody>
               
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
  
		  </div>
		    

        </section>
	</div>	  
		  


    </section>
    <!-- /.content -->

  

  <!-- /.control-sidebar -->
  
  
 <?php include_once('footer.php'); ?>
