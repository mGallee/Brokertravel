<!DOCTYPE html>
<html lang="de" xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php
		include("header_include.php");
	?>
</head>

<body class="memberlogin">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-md-12">
            	<div class="error-template">
                	<div class="memberlogin-container">
                        <div class="logo"></div>
                        <h1>Member Login</h1>
                        <form class="form-inline" role="form" action="<?php echo get_category_link(7); ?>" method="post">
                        <div class="form-group">
                            <input type="text" class="form-control" id="exampleInputName2" placeholder="Member Code">
                        </div>
                        <button type="submit" class="btn btn-primary">Senden</button>
                        </form>
                        <br />
                        <div class="error-details">
                            <p>Bitte geben Sie ihren Member Code ein!</p>
                        </div>
                	</div>
            	</div>
            </div>
        </div>
    </div>
    <?php wp_footer(); ?>
</body>
</html>