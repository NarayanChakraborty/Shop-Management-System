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

 <section class="content">
        <?php include_once('header_shop.php'); ?>
		
		
		
		
		<div class="row">
        <!-- Left col --><div id="printableArea">
        <section class="col-lg-offset-4 col-lg-8 connectedSortable">
		
		
		
		
			
			<div class="col-md-6 validation-grids widget-shadow" style="padding-top:40px;padding-left:30px;" data-example-id="basic-forms"> 
			                 
					<div class="navbar-header navbar-left">
					<h1><a href="index.php">Khalek Electronics</a>
					<h5 style="margin-left:80px;margin-top:-10px;">Imargency:01713687237</h5>
					<h5 style="margin-left:80px;margin-top:-10px;">Date:<?php echo date('d-m-Y'); ?></h5>
					</h1>
					<br>
						
				</div>
							<div class="form-title" style="margin-top:130px;">
							      	<?php 
											
											
										
								  
								  
								  $statement=$db->prepare('SELECT * FROM tbl_customer,tbl_sell where tbl_customer.s_id=tbl_sell.s_id ORDER BY c_id DESC LIMIT 1');
								  $statement->execute();
								  $result=$statement->fetchAll(PDO::FETCH_ASSOC);
								  foreach( $result as $row)
								  {
									  ?>
									  <table>
									  	   <tr> <td> <strong>Customer Name </strong></td><td><?php echo ": ".$row['c_name']; ?> </td> </tr>
											<tr> <td><strong>Mobile No     </strong></td><td><?php echo ": ".$row['c_mobile']; ?> </td> </tr>
											<tr> <td><strong>Product Category     </strong></td><td>
														<?php 
														
														$statement2 = $db->prepare("SELECT * FROM tbl_products where p_id=?");
                      $statement2->execute(array($row['p_id']));
                      $result2 = $statement2->fetchAll(PDO::FETCH_ASSOC);
                      foreach ($result2 as $row2) {
                                                    
										  $statement3 = $db->prepare("SELECT cat_name FROM tbl_category where cat_id=?");
										  $statement3->execute(array($row2['p_category']));
										  $result3 = $statement3->fetch();
												echo ": ".$result3['cat_name'];	
											?>
											</td> </tr>
											<tr> <td><strong>Product Model    </strong></td><td><?php 
											
                      
                        echo ": ".$row2['p_model']; 
						
					  }
						?>
											 </td> </tr>
											 <tr>
											<td><strong>product Amount     </strong></td><td><?php echo ": ".$row['p_amount']; ?> </td> </tr>
                                             <tr> <td> <strong>Total Cost </strong></td><td><?php echo ": ".$row['c_total']; ?></td> </tr>
											
                                            <tr> <td><strong>Due    </strong></td><td><?php echo ": ".$row['c_due']; ?> </td> </tr>
											
										
												
											
											
											
									 </table>		
										<?php
									  
									  
								  }
										   ?>
							</div><br><br><br>
							<h5> THANKS FOR TAKING OUR SERVICE</h5><br>
				
								
                 		
							
			</div>
		

	
		
		</section>
		</div>
		  <div class="col-lg-offset-6 col-lg-6" style="margin-bottom:20px">
	   <a  href="javascript:void(0);" name="release" class="btn btn-default"  onclick="printPageArea('printableArea')"> <i class="fa fa-print"></i> Print</a>
      </div>
     </div>
	
	
	
	
	</section>
	
<?php include_once("footer.php");?>