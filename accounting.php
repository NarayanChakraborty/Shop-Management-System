<?php include_once('header.php'); ?>
<?php include_once('sidebar.php'); ?>
<?php require_once('config.php'); 
 $c_date=date('Y-m-d');
?>

   

		  <?php
		  try
		  {
		  
		  if(isset($_POST['form1']))
		  {
			 
		  $statement=$db->prepare("select sum(c_last_payment) as payment from tbl_customers where payment_date=?");
		  $statement->execute(array($c_date));
		   $result = $statement->fetch();
			$todays_balance=$result['payment'];
          			
					$statement1=$db->prepare('select * from tbl_accounting where a_date=?');
					$statement1->execute(array($c_date));
					$result1=$statement1->fetchColumn();
					if($result1>0)
					{
						$statement2=$db->prepare("update tbl_accounting set a_balance=? where a_date=?");
		  $statement2->execute(array($todays_balance,$c_date));
					}
					else{
						  $statement3=$db->prepare("insert into tbl_accounting(a_balance,a_date) values(?,?) ");
		  $statement3->execute(array($todays_balance,$c_date));

						
					}
					
		
		  
		  
		  
		   
		  
		
  }
		  }catch(Exception $e) {
    $error_message1 = $e->getMessage();
  
			  
		  }
		   
		  ?>



   <!-- Main content -->
    <section class="content">
        <?php include_once('header_shop.php'); ?>
      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-offset-4 col-lg-6 connectedSortable">
          <!-- Custom tabs (Charts with tabs)-->
		  <h4>Todays Balance :
		  	 
								
		  <?php 
		  $a_date=date('Y-m-d');
		  $statement1=$db->prepare("select * from tbl_accounting where a_date=?");
		  $statement1->execute(array($a_date));
		 $result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
											foreach($result1 as $row1){	?>
											
											
											
											<?php echo $row1['a_balance']; ?></h4>
											
											
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
											}
		  
		  ?>
		  
		  
		                                  <form class="form-horizontal" role="form" data-toggle="validator" method="post">                                                  
                                          
                                                 
                                                  <div class="form-group">
                                                      <div class="col-lg-offset-10 col-lg-2" style="margin-top:-30px;">
                                                          <button type="submit" name="form1" class="btn btn-primary "><i class= "glyphicon glyphicon-refresh"></i></button>
                                                        
                                                      </div>
                                                  </div>
                                              </form>
											  
<!-------<h4>								  
          <?php 
		   /* $statement2=$db->prepare("select sum(net_balance) as net_balance from tbl_accounting");
		  $statement2->execute(array($a_date));
		 $result2 = $statement2->fetch();
		  $net_balance=$result2['net_balance'];
		  echo "  Net Balance :".$net_balance; 
		  */?>
		  </h4>
		  ------>
									
									<form class="form-horizontal" role="form" data-toggle="validator" method="post">                                                  
                                                 <div class="form-group">
                                                      <label class="col-lg-2 control-label">Todays Cost</label>
                                                      <div class="col-lg-8">
                                                          <input type="number" min=0 name="todays_cost" value="" onkeyup="findTotal()" class="form-control" id="four" placeholder="Add Amount For Installment ">
                                                      </div>
                                                  </div>
                                                 
                                                  <div class="form-group">
                                                      <div class="col-lg-offset-2 col-lg-10">
                                                          <button type="submit" name="form2" class="btn btn-primary">Update Net Banlance</button>
                                                        
                                                      </div>
                                                  </div>
                                              </form>

        </section>

        <!-- right col -->
      </div>
      <!-- /.row (main row) -->

    </section>
    <!-- /.content -->

  

  <!-- /.control-sidebar -->
 <?php include_once('footer.php'); ?>