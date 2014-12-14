<?php get_header(); ?>
	<div class="row entrycontent boxshadow">
    	<div class="col-xs-12 col-md-12">
            <h3>Jetzt Anfragen für Citybreak in Prag</h3>
            <br />				
            <form class="form-horizontal" role="form" action="<?php echo get_page_link(167); ?>" method="post">
              <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Vorname</label>
                <div class="col-sm-4">
                  <input type="text" class="form-control" id="name" placeholder="Vorname" required pattern="[A-Za-z]+">
                </div>
                <label for="surname" class="col-sm-2 control-label">Nachname</label>
                <div class="col-sm-4">
                  <input type="text" class="form-control" id="surname" placeholder="Nachname" required pattern="[A-Za-z]+">
                </div>
              </div>
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Email</label>
                <div class="col-sm-10">
                  <input type="email" class="form-control" id="inputEmail3" placeholder="Email" required>
                </div>
              </div>
              <div class="form-group">
                <label for="message" class="col-sm-2 control-label">Anmerkungen</label>
                <div class="col-sm-10">
                  <textarea class="form-control" rows="7" name="message" maxlength="700"></textarea>
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                  <button type="submit" class="btn btn-default validate">Anfrage senden</button>
                </div>
              </div>
            </form>
            <?php echo $_POST['postid']; ?>
        </div>
	</div>
    <br />
<?php get_footer(); ?>