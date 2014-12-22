<!DOCTYPE html>
<html lang="de" xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php
		include("header_include.php");
	?>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-md-12">
                <div class="error-template">
                    <h1> Uups!</h1>
                    <h2>404 Not Found</h2>
                    <div class="error-details">
                        Ein Fehler ist aufgetreten: Seite wurde nicht gefunden!
                    </div>
                    <div class="error-actions">
                        <a href="<?php bloginfo('url'); ?>" class="btn btn-primary btn-lg"><span class="glyphicon glyphicon-home"></span>
                            Zur Startseite </a><a href="<?php echo get_page_link(36); ?>" class="btn btn-default btn-lg"><span class="glyphicon glyphicon-envelope"></span> Fehler melden </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php wp_footer(); ?>
</body>
</html>