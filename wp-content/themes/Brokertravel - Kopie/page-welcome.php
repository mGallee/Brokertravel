<?php get_header(); ?>
  	<div class="row">
    	<div class="col-xs-12 col-md-12 slider">
            <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                  <!-- Indicators -->
                  <ol class="carousel-indicators">
                    <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                    <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                    <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                  </ol>
                
                  <!-- Wrapper for slides -->
                  <div class="carousel-inner" role="listbox">
                    <div class="item active">
                      <img src="wp-content/themes/Brokertravel/images/blue.jpg" alt="...">
                      <div class="carousel-caption">
                         <?php echo get_the_title( 202 ); ?> 
                      </div>
                    </div>
                    <div class="item">
                      <img src="wp-content/themes/Brokertravel/images/red.jpg" alt="...">
                      <div class="carousel-caption">
                        test2
                      </div>
                    </div>
                    <div class="item">
                      <img src="wp-content/themes/Brokertravel/images/purple.jpg" alt="...">
                      <div class="carousel-caption">
                        test3
                      </div>
                    </div>
                  </div>
                
                  <!-- Controls -->
                  <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                  </a>
                  <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                  </a>
            </div>
		</div>
	</div>
    <br  />
  	<div class="row">
    	<div class="col-xs-5 col-md-5 entrycontent">
        	<p>Über Mich</p>
        </div>
        <div class="col-xs-1 col-md-1">
        </div>
    	<div class="col-xs-5 col-md-5 entrycontent">
			<?php 	
                $widgetNL = new WYSIJA_NL_Widget(true);
                echo $widgetNL->widget(array('form' => 1, 'form_type' => 'php')); 
            ?>
        </div>
	</div>
    <br />
<?php get_footer(); ?>