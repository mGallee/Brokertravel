<!DOCTYPE html>
<html lang="de" xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php
		include("header_include.php");
	?>
</head>

<body class="memberlogin">
<!-- Google Analytics -->
<?php include_once("analyticstracking.php") ?>

    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-md-12">
            	<div class="error-template">
                	<div class="memberlogin-container">
                        <a href="<?php bloginfo('url'); ?>"><div class="logo"></div></a>
                        <!-- MemberLogin mit Member Code
                        <h1>Member Login</h1>
                        <form class="form-inline" role="form" action="<?php echo get_page_link(364);?>" method="post">
                        <div class="form-group">
                            <input type="text" name="membercode" class="form-control" placeholder="Member Code">
                        </div>
                        <button type="submit" class="btn btn-primary">Senden</button>
                        </form>
                        <br />
                            <?php 
								if($_SESSION['logInSuccess']==false){
							?>
                                    <div class="alert alert-danger" role="alert">
                                    	<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                          				<span class="sr-only">Fehler:</span>
                                        Die Anmeldung war nicht erfolgreich!
                            <?php
									$_SESSION['logInSuccess']=true;
								}
							?>
                        </div>

                	</div> Ende -->
                    <h1>Willkommen Partner</h1>
                    <p>Sie sind nur einen Klick von Ihrer Traumreise entfernt!</p><br />
                    <a href="<?php echo get_page_link(364);?>"><button class="btn btn-primary">Betreten</button></a>
            	</div>
            </div>
        </div>
    </div>
    <?php wp_footer(); ?>
</body>
</html>