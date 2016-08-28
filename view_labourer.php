<?php include_once('header.php'); ?>
<?php include_once('sidebar.php'); ?>
 <?php include_once("config.php");?>






    <!-- Main content -->
    <section class="content">
        <?php include_once('header_shop.php'); ?><br>
      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-12 connectedSortable">
		
		 <section class="panel">                                          
                                          <div style="background-color:#3c8dbc;"  class="panel-body bio-graph-info">
		             
		  <center><h4 style="color:#fff;" >Labourer Information</h4></center>
								  </div>
								  </section>
		

             <div class="panel panel-default">
                        <div class="panel-heading"> 
			  <!--------- page start-->
			
                    Labourer List
			  
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
            <!-- /.box-header -->
            <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example" >
                <thead>
                <tr>
                  <th>Labourer Name</th>
				  <th>Contact No</th>
                  <th>Type</th>
                  <th>Address</th>
				  <th>Joining Date</th>
				  <th>Action</th>
                </tr>
                </thead>
                <tbody style="text-align:center">
                 <?php
										
											 $statement =$db->prepare("SELECT * FROM tbl_labourer");
										    $statement->execute(array());
										 
										  $result = $statement->fetchAll(PDO::FETCH_ASSOC);
										  foreach ($result as $row) {
                                          ?> 
                
               
                <tr>
                   <td><?php echo $row['l_name']; ?></td>
				   
                  	 <td>
				  
                            <?php echo $row['l_contact_no']; ?>		
				  </td>	  

				   
					  <td><?php echo $row['l_type']; ?> </td>
					 <td> <?php echo $row['l_address'];?></td>	
						 <td> <?php echo $row['l_joining_date'];?></td>	
					<td> 
                     <div class="btn-group">
                      <a class="btn btn-primary fancybox" href="#inline<?php echo $row['l_id'];?>"title="View image"><i class="glyphicon glyphicon-eye-open"></i></a>

					 
					 <div id="inline<?php echo $row['l_id'];?>"style="display:none;width:700px;margin:10px 30px">
														<h3 style= "border-bottom: 2px solid #295498; color:#0C86AC;margin-bottom:10px;" >Labourer Details</h3>
														<div class="shopper-info">
														  <h4> <label>Labourer Name :&nbsp;&nbsp;</label>
														  <?php echo $row['l_name']; ?></h4>
														  <h4><label>Labourer Image  :&nbsp;&nbsp;</label></h4>
														  <img src="images/labourer/<?php echo $row['l_image'];?>" alt="" width="320px" height="250px"><br>
														  <h4> <label>Mobile No :&nbsp;&nbsp;</label>
														  <?php echo $row['l_contact_no']; ?></h4>
														  <h4> <label>Type :&nbsp;&nbsp;</label>
														  <?php echo $row['l_type']; ?></h4>
														   <h4> <label>Customer NID:&nbsp;&nbsp;</label>
														  <?php echo $row['l_nid']; ?></h4>
														  <h4> <label>Address :&nbsp;&nbsp;</label>
														  <?php echo $row['l_address']; ?></h4>
														  <h4> <label>Sex :&nbsp;&nbsp;</label>
														  <?php echo $row['l_sex']; ?></h4>
														  <h4> <label>Joining Date:&nbsp;&nbsp;</label>
														  <?php echo $row['l_joining_date']; ?></h4>
														  
																  
														</div>
						 </div>
                      <a class="btn btn-success" title="Edit this Product" href="edit_labourer.php?ID=<?php echo $row['l_id']; ?>"><i class="glyphicon glyphicon-pencil"></i>
													  
													  </a>
                       <a class="btn btn-danger"  title="Delete This product" data-toggle="modal" data-target="#productModal<?php echo $row['p_id'];?>"><i class="glyphicon glyphicon-remove"></i>
													   </a>
													  
																		  
											<!-- Modal -->
													<div id="productModal<?php echo $row['p_id'];?>" class="modal fade " role="dialog">
													  <div class="modal-dialog">

														<!-- Modal content-->
														<div class="modal-content">
														  <div class="modal-header">
															<button type="button" class="close" data-dismiss="modal">&times;</button>
															<h4 class="modal-title">DELETE Confirmation</h4>
														  </div>
														  <div class="modal-body">
															<h4>Are You Confirm To Delete This Element?</h4>
														  </div>
														  <div class="modal-footer">
															<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
															<a class="btn btn-danger btn-ok" href="delete_product.php?id=<?php echo $row['p_id']; ?>" >Confirm</a>
														  </div>
														</div>

													  </div>
													</div>
												
					
					
					
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
