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
                <?php
                $blogID = $_POST["blogID"];
                $blogName = get_the_title($_POST["blogID"]);
				$title = $_POST["title"];
				$company = $_POST["company"];
                $givenname = $_POST["givenname"];
                $surname = $_POST["surname"];
                $email = $_POST["email"];
				$number = $_POST["number"];
                $comment = nl2br($_POST["comment"]);
				
                add_filter( 'wp_mail_content_type', 'set_html_content_type' );
                $headers = 'From: Brokertravel Exclsive <office@brokertravel.com>';
                $pagelink = get_page_link($blogID);
                $message =  "Eine Anfrage vom ".date('d m Y')." für ".$blogName."<br /><br />".
							
							"<b>Anrede:</b> ".$title."<br />".
							"<b>Firma:</b> ".$company."<br />".
                            "<b>Name:</b> ".$givenname."<br />".
                            "<b>Vorname:</b> ".$surname."<br />".
							"<b>E-Mail:</b> ".$email."<br />".
							"<b>Telefonnummer:</b> ".$number."<br />".
                            "<b>Anmerkung:</b>"."<br />".
                            $comment."<br /><br />".
                            
                            "<i>Link zum Angebot: <a href='".$pagelink."'>".$pagelink."</a></i>";
				
				$automessage =  "Sehr geehrte Damen und Herren!<br /><br />".
				
								"Vielen Dank, dass Sie bei uns angefragt haben! Wir werden Ihre Buchungsanfrage so schnell wie nur möglich bearbeiten und melden uns binnen 24 Stunden bei Ihnen.<br /><br />".
								
								"Dies ist eine automatisch generierte Nachricht, bitte antworten Sie auf diese nicht!<br /><br />".
								
								"Mit freundlichen Grüßen<br />".
								"Ihr Franz Vtelensky & das Team von Brokertravel Exclusive";
                
                wp_mail("office@brokertravel.at", "Anfrage - ".$blogName, $message, $headers);
				
				wp_mail($email, "Bestätigung für Buchungsanfrage", $automessage, $headers);
				
				// Reset content-type to avoid conflicts -- http://core.trac.wordpress.org/ticket/23578
				remove_filter( 'wp_mail_content_type', 'set_html_content_type' );
				
				function set_html_content_type(){
					return 'text/html';
				}
                ?>
               <div class="error-template">
                    <h1>Anfrage erfolgreich gesendet!</h1><br />     
                    <div class="error-actions">
                        <a href="<?php bloginfo('url'); ?>" class="btn btn-primary btn-lg"><span class="glyphicon glyphicon-home"></span> Zur Startseite</a>
                    </div>
                </div>
           </div>
        </div>
	</div>
    <?php wp_footer(); ?>
</body>
</html>