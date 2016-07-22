<?php include_once('header.php'); ?>
<?php include_once('sidebar.php'); ?>

    <!-- Main content -->
    <section class="content">
      <?php include_once('header_shop.php'); ?>
      <!-- /.row -->
      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-12 ">
          <div id="edit-profile" class="tab-pane">
                                    <section class="panel">                                          
                                          <div class="panel-body bio-graph-info">
                                             <center> <h2>Add Product</h2></center><hr>
                                              <form class="form-horizontal" role="form">                                                  
                                                  <div class="form-group">
                                                      <label class="col-lg-2 control-label">Product Model</label>
                                                      <div class="col-lg-6">
                                                          <input type="text" class="form-control" id="f-name" placeholder=" ">
                                                      </div>
                                                  </div><hr>
												    <div class="form-group">
                                                      <label class="col-lg-2 control-label">Product Category</label>
                                                      <div class="col-lg-6">
                                                      
													  <select class="form-control">
														<option>Khalek One</option>
														<option>Khalek Two</option>
														<option>Store House</option>
													  </select>

                                                      </div>
                                                  </div><hr>
                                                  <div class="form-group">
                                                      <label class="col-lg-2 control-label">Product Price</label>
                                                      <div class="col-lg-6">
                                                          <input type="text" class="form-control" id="l-name" placeholder=" ">
                                                      </div>
                                                  </div><hr>
                                                  <div class="form-group">
                                                      <label class="col-lg-2 control-label">Details of Product</label>
                                                      <div class="col-lg-6">
                                                          <textarea name="" id="" class="form-control" cols="30" rows="5"></textarea>
                                                      </div>
                                                  </div><hr>
                                                  <div class="form-group">
                                                      <label class="col-lg-2 control-label">Select Shop</label>
                                                      <div class="col-lg-6">
                                                      
													  <select class="form-control">
														<option>Khalek One</option>
														<option>Khalek Two</option>
														<option>Store House</option>
													  </select>

                                                      </div>
                                                  </div><hr>
                                                 <br>

                                                  <div class="form-group">
                                                      <div class="col-lg-offset-8 col-lg-2">
                                                          <button type="submit" class="btn btn-primary">Save</button>
                                                          <button type="button" class="btn btn-danger">Cancel</button>
                                                      </div>
                                                  </div>
                                              </form>
                                          </div>
                                      </section>
                                  </div>


        </section>
        <!-- /.Left col -->
        <!-- right col (We are only adding the ID to make the widgets sortabl
      </div>
      <!-- /.row (main row) -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  
 <?php include_once('footer.php'); ?>