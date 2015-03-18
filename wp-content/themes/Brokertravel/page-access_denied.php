<!DOCTYPE html>
<html lang="de" xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php
		include("header_include.php");
	?>
</head>

<body>
<!-- Google Analytics -->
<?php include_once("analyticstracking.php") ?>

    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-md-12">
                <div class="error-template">
                    <h1>Sorry</h1>
                    <h2>Kein Zugriff</h2>
                    <div class="error-details">
                        Ein Fehler ist aufgetreten: Sie haben keinen Zugriff auf diese Seite!
                    </div>
                    <div class="error-actions">
                        <a href="<?php echo get_page_link(342); ?>" class="btn btn-primary btn-lg"><span class="glyphicon glyphicon-lock"></span>
                            Zum Login </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php wp_footer(); ?>
</body>
</html>