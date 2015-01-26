<?php get_header(); ?>
	<div class="row boxshadow">
    	<div class="col-xs-12 col-md-12">
        	<?php 
			$blogID = $_POST["blogID"];
			if (has_post_thumbnail($blogID)) {
					$src = wp_get_attachment_image_src( get_post_thumbnail_id($blogID),full , false, '' );
				}
			?>
            <div class="row entryheader" style="background:url(<?php echo $src[0]; ?>) center">
                 <div class="col-xs-12 col-md-12">
                        <div class="row entrytitle">
                            <div class="col-xs-8 col-md-8">
                                <div class="title"><?php echo get_the_title($blogID); ?></div>
                                <div class="subtitle"> 
                                    <?php
                                        $subtitle = get_post_meta($blogID, 'Untertitel', true);
                                        if($subtitle != '')
                                            echo  $subtitle ;  
                                    ?>
                                </div>
                            </div>
                            <div class="col-xs-4 col-md-4">
                                <div class="stars">
                                    <?php
                                    $stars = get_post_meta($blogID, 'Sterne', true);
                                    if($stars != '')
                                        for($i=1; $i<=$stars; $i++) 
                                            echo "&#9733;";                 
                                    ?>
                                </div>
                            </div>
                        </div>
                  </div>
            </div>
            <div class="row entrycontent">
            	<div class="col-xs-12 col-md-12">
                    <br />				
                    <form class="form-horizontal" role="form" action="<?php echo get_page_link(184); ?>" method="post">
                    	<div class="form-group">
                        	<label for="title" class="col-sm-2 control-label">Anrede</label>
                       	  <div class="col-sm-2">
                                <select class="form-control" name="title" onchange="formchange(this.value)" required>
                                	<option value="Herr" selected="selected">Herr</option>
                                    <option value="Frau">Frau</option>
                                    <option value="Firma">Firma</option>
                              </select> 
                        	</div>
                            <div id="changeonselect" style="display:none">
                            	<label for="company" class="col-sm-2 control-label">Firmenname</label>
                        		<div class="col-sm-6">
                        			<input type="text" class="form-control" name="company" placeholder="Firmenname" data-validation="custom" data-validation-regexp="^[A-Za-z]*$" pattern="^[A-Za-z]*$">
                        		</div>
                            </div>
                      	</div>
                    	<div class="form-group">
                        	<label for="givenname" class="col-sm-2 control-label">Vorname</label>
                        	<div class="col-sm-4">
                        		<input type="text" class="form-control" name="givenname" placeholder="Vorname" data-validation="custom" data-validation-regexp="^[A-Za-z]+$" required pattern="^[A-Za-z]+$">
                        	</div>
                        	<label for="surname" class="col-sm-2 control-label">Nachname</label>
                        	<div class="col-sm-4">
                          		<input type="text" class="form-control" name="surname" placeholder="Nachname" data-validation="custom" data-validation-regexp="^[A-Za-z]+$" required pattern="^[A-Za-z]+$">
                        	</div>
                      	</div>
                      	<div class="form-group">
                        	<label for="email" class="col-sm-2 control-label">Email</label>
                       		<div class="col-sm-10">
                        		<input type="email" class="form-control" name="email" placeholder="office@brokertravel.at" data-validation="email" required>
                       		</div>
                      	</div>
                      	<div class="form-group">
                        	<label for="number" class="col-sm-2 control-label">Telefonnummer</label>
                        	<div class="col-sm-10">
                          		<input type="text" class="form-control" name="number" placeholder="+43 2243 32888" data-validation="custom" data-validation-regexp="^[+]?[0-9]*$">
                        	</div>
                      	</div>
                      	<div class="form-group">
                        	<label for="comment" class="col-sm-2 control-label">Anmerkungen</label>
                        	<div class="col-sm-10">
                          		<textarea class="form-control" rows="7" name="comment" maxlength="700" data-validation="length" data-validation-length="max700"></textarea>
                        	</div>
                      	</div>
                      	<input type="hidden" name="blogID" value="<?php echo $blogID ?>" />
                      	<div class="form-group">
                        	<div class="col-sm-offset-2 col-sm-10">
                          		<button type="submit" class="btn btn-default validate">Anfrage senden</button>
                        	</div>
                      	</div>
                    </form>
                    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.1.47/jquery.form-validator.min.js"></script>
					<script> $.validate({language : myLanguage}); </script>
            	</div>
        	</div>
        </div>
	</div>
    <br />
<?php get_footer(); ?>