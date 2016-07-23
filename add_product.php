<?php include_once('header.php'); ?>
<?php include_once('sidebar.php'); ?>
<?php require_once('config.php'); ?>


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
                                              <form class="form-horizontal" role="form" data-toggle="validator" method="post"enctype="multipart/form-data">                                                  
                                                  <div class="form-group">
                                                      <label class="col-lg-2 control-label">Product Model</label>
                                                      <div class="col-lg-8">
                                                          <input type="text" class="form-control" name="p_model" id="f-name" placeholder=" " required>
                                                      </div>
                                                  </div><hr>
												    <div class="form-group">
                                                      <label class="col-lg-2 control-label">Product Image</label>
                                                      <div class="col-lg-8">
                                                           <input type="file"class="form-control" name="p_image" required>
                                                      </div>
                                                  </div><hr>
												    <div class="form-group">
                                                      <label class="col-lg-2 control-label">Product Category</label>
                                                      <div class="col-lg-8">
													          
                <select class="form-control select2" style="width: 100%;" required>
               									     
                      <?php
                      $statement = $db->prepare("SELECT * FROM tbl_category");
                      $statement->execute();
                      $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                      foreach ($result as $row) {
                        ?>
                      
                      <option value="<?php echo $row['cat_id'];?>"><?php echo $row['cat_name'];?></option>
                      <?php
                      }
                      ?>
                </select>
                                                         
                                                      </div>
                                                  </div><hr>
                                                  <div class="form-group">
                                                      <label class="col-lg-2 control-label">Product Amount</label>
                                                      <div class="col-lg-8">
                                                          <input type="number" min=0 name="p_amount" class="form-control" id="l-name" placeholder=" " required>
                                                      </div>
                                                  </div>
												  <hr>                                                  <div class="form-group">
                                                      <label class="col-lg-2 control-label">Product Price</label>
                                                      <div class="col-lg-8">
                                                          <input type="number" min=0 name="p_price" class="form-control" id="l-name" placeholder=" " required>
                                                      </div>
                                                  </div><hr>
                                                  <div class="form-group">
                                                      <label class="col-lg-2 control-label">Details of Product</label>
                                                      <div class="col-lg-8">
                                                         <textarea name="p_details" cols="60 rows="10"></textarea>
				<script type="text/javascript">
				if ( typeof CKEDITOR == 'undefined' )
				{
					document.write(
						'<strong><span style="color: #ff0000">Error</span>: CKEditor not found</strong>.' +
						'This sample assumes that CKEditor (not included with CKFinder) is installed in' +
						'the "/ckeditor/" path. If you have it installed in a different place, just edit' +
						'this file, changing the wrong paths in the &lt;head&gt; (line 5) and the "BasePath"' +
						'value (line 32).' ) ;
				}
				else
				{
					var editor = CKEDITOR.replace( 'p_details' );
					//editor.setData( '<p>Just click the <b>Image</b> or <b>Link</b> button, and then <b>&quot;Browse Server&quot;</b>.</p>' );
				}

			</script>
                                                      </div>
                                                  </div><hr>
                                                  <div class="form-group">
                                                      <label class="col-lg-2 control-label">Select Shop</label>
                                                      <div class="col-lg-8">
                                                      
													  <select class="form-control" name="p_shop" reuired>
														<option value="1">Khalek One</option>
														<option value="2">Khalek Two</option>
														<option value="3">Store House</option>
													  </select>

                                                      </div>
                                                  </div><hr>
												  <div class="form-group">
                                                      <label class="col-lg-2 control-label">Arival Date</label>
                                                      <div class="col-lg-8">
                                                                         <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="date" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask>
                </div>
                                                      </div>
                                                  </div><hr>
                                                 <br>

                                                  <div class="form-group">
                                                      <div class="col-lg-offset-8 col-lg-2">
                                                          <button type="submit" class="btn btn-primary">Save</button>
                                                      </div>
                                                  </div>
                                              </form>
                                          </div>
                                      </section>
                                  </div>


        </section>
        <!-- /.Left col -->
     
      </div>
      <!-- /.row (main row) -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  
 <?php include_once('footer.php'); ?>