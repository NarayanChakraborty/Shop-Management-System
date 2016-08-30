


      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
		 
            <div class="inner">
              <h3> <?php 
		  require_once('config.php'); 
		  $statement=$db->prepare("select sum(p_amount) as total from tbl_products where p_shop=?");
		  $statement->execute(array(1));
		 $result = $statement->fetch(PDO::FETCH_ASSOC);
		 echo $result['total'];
              ?>        
		  </h3>

              <p>Khalek One</p>
            </div>
			
            <div class="icon" style="padding:10px">
              <i class="glyphicon glyphicon-shopping-cart"></i>
            </div>
			 
            <a href="view_product_shop.php?id=1" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
            <h3> <?php 
		  require_once('config.php'); 
		  $statement=$db->prepare("select sum(p_amount) as total from tbl_products where p_shop=?");
		  $statement->execute(array(2));
		 $result = $statement->fetch(PDO::FETCH_ASSOC);
		 echo $result['total'];
              ?>        
		  </h3>

              <p>Khalek Two</p>
            </div>
           <div class="icon" style="padding:10px">
              <i class="glyphicon glyphicon-shopping-cart"></i>
            </div>
            <a href="view_product_shop.php?id=2" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
             <h3> <?php 
		  require_once('config.php'); 
		  $statement=$db->prepare("select sum(p_amount) as total from tbl_products where p_shop=?");
		  $statement->execute(array(3));
		 $result = $statement->fetch(PDO::FETCH_ASSOC);
		 echo $result['total'];
              ?>        
		  </h3>

              <p>Store House</p>
            </div>
            <div class="icon" style="padding:10px">
              <i class="glyphicon glyphicon-lock"></i>
            </div>
            <a href="view_product_shop.php?id=3" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
   
      </div>