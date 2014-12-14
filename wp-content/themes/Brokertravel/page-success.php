<?php get_header(); ?>
	<div class="row entrycontent boxshadow">
    	<div class="col-xs-12 col-md-12">
             <?php 
			 $errormsg = "Buchung war leider nicht erfolgreich. Bitte versuchen Sie es nocheinmal. <br />Zur&uuml;ck zum Formular";
			 if ( isset( $_POST['name'] ) &&  isset( $_POST['surname']) ) {
				 $to = "";
				 $subject="";
				 $message="";
				$success = wp_mail( $to, $subject, $message); 
				if($success){

					echo "Buchung war erfolgreich!";

				}else{
					echo $errormsg;
				}
			 }else{
				echo $errormsg."!"; 
			  }
			 ?>
        </div>
	</div>
    <br />
<?php get_footer(); ?>