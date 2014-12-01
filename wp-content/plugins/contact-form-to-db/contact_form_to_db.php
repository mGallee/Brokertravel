<?php 
/*
Plugin Name: Contact Form to DB
Plugin URI: http://bestwebsoft.com/plugin/
Description: Add-on for Contact Form Plugin by BestWebSoft.
Author: BestWebSoft
Version: 1.4.3
Author URI: http://bestwebsoft.com/
License: GPLv2 or later
*/
/*  @ Copyright 2014  BestWebSoft  ( http://support.bestwebsoft.com )

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

*/

/*
* Function for adding menu and submenu 
*/
if ( ! function_exists( 'cntctfrmtdb_admin_menu' ) ) {
	function cntctfrmtdb_admin_menu() {
		global $bstwbsftwppdtplgns_options, $wpmu, $bstwbsftwppdtplgns_added_menu;
		$bws_menu_info = get_plugin_data( plugin_dir_path( __FILE__ ) . "bws_menu/bws_menu.php" );
		$bws_menu_version = $bws_menu_info["Version"];
		$base = plugin_basename(__FILE__);

		if ( ! isset( $bstwbsftwppdtplgns_options ) ) {
			if ( 1 == $wpmu ) {
				if ( ! get_site_option( 'bstwbsftwppdtplgns_options' ) )
					add_site_option( 'bstwbsftwppdtplgns_options', array(), '', 'yes' );
				$bstwbsftwppdtplgns_options = get_site_option( 'bstwbsftwppdtplgns_options' );
			} else {
				if ( ! get_option( 'bstwbsftwppdtplgns_options' ) )
					add_option( 'bstwbsftwppdtplgns_options', array(), '', 'yes' );
				$bstwbsftwppdtplgns_options = get_option( 'bstwbsftwppdtplgns_options' );
			}
		}

		if ( isset( $bstwbsftwppdtplgns_options['bws_menu_version'] ) ) {
			$bstwbsftwppdtplgns_options['bws_menu']['version'][ $base ] = $bws_menu_version;
			unset( $bstwbsftwppdtplgns_options['bws_menu_version'] );
			update_option( 'bstwbsftwppdtplgns_options', $bstwbsftwppdtplgns_options, '', 'yes' );
			require_once( dirname( __FILE__ ) . '/bws_menu/bws_menu.php' );
		} else if ( ! isset( $bstwbsftwppdtplgns_options['bws_menu']['version'][ $base ] ) || $bstwbsftwppdtplgns_options['bws_menu']['version'][ $base ] < $bws_menu_version ) {
			$bstwbsftwppdtplgns_options['bws_menu']['version'][ $base ] = $bws_menu_version;
			update_option( 'bstwbsftwppdtplgns_options', $bstwbsftwppdtplgns_options, '', 'yes' );
			require_once( dirname( __FILE__ ) . '/bws_menu/bws_menu.php' );
		} else if ( ! isset( $bstwbsftwppdtplgns_added_menu ) ) {
			$plugin_with_newer_menu = $base;
			foreach ( $bstwbsftwppdtplgns_options['bws_menu']['version'] as $key => $value ) {
				if ( $bws_menu_version < $value && is_plugin_active( $base ) ) {
					$plugin_with_newer_menu = $key;
				}
			}
			$plugin_with_newer_menu = explode( '/', $plugin_with_newer_menu );
			$wp_content_dir = defined( 'WP_CONTENT_DIR' ) ? basename( WP_CONTENT_DIR ) : 'wp-content';
			if ( file_exists( ABSPATH . $wp_content_dir . '/plugins/' . $plugin_with_newer_menu[0] . '/bws_menu/bws_menu.php' ) )
				require_once( ABSPATH . $wp_content_dir . '/plugins/' . $plugin_with_newer_menu[0] . '/bws_menu/bws_menu.php' );
			else
				require_once( dirname( __FILE__ ) . '/bws_menu/bws_menu.php' );
			$bstwbsftwppdtplgns_added_menu = true;			
		}

		add_menu_page( 'BWS Plugins', 'BWS Plugins', 'edit_themes', 'bws_plugins', 'bws_add_menu_render', plugins_url( "images/px.png", __FILE__ ), 1001 ); 
		add_submenu_page( 'bws_plugins',__( 'Contact Form to DB', 'contact_form_to_db' ), __( 'Contact Form to DB', 'contact_form_to_db' ), 'edit_themes', 'cntctfrmtdb_settings', 'cntctfrmtdb_settings_page' );
		$hook = add_menu_page( __( 'CF to DB', 'contact_form_to_db' ), __( 'CF to DB', 'contact_form_to_db' ), 'edit_posts', 'cntctfrmtdb_manager', 'cntctfrmtdb_manager_page', plugins_url( "images/px.png", __FILE__ ), 30 );
	}
}

/*
* Function initialisation plugin 
*/
if ( ! function_exists( 'cntctfrmtdb_init' ) ) {
	function cntctfrmtdb_init() {
		if ( ! session_id() )
			@session_start();
		//textdomain of plugin
		load_plugin_textdomain( 'contact_form_to_db', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

		/* Call register settings function */
		$cntctfrmtdb_pages = array(
			'cntctfrmtdb_manager',
			'cntctfrmtdb_settings'
		);
		if ( ! is_admin() || ( isset( $_REQUEST['page'] ) && in_array( $_REQUEST['page'], $cntctfrmtdb_pages ) ) )
			cntctfrmtdb_settings();
	}
}

if ( ! function_exists( 'cntctfrmtdb_admin_init' ) ) {
	function cntctfrmtdb_admin_init() {
		global $bws_plugin_info, $cntctfrmtdb_plugin_info;
		
		$cntctfrmtdb_plugin_info = get_plugin_data( __FILE__, false );
		/* Add variable for bws_menu */
		if ( ! isset( $bws_plugin_info ) || empty( $bws_plugin_info ) )
			$bws_plugin_info = array( 'id' => '91', 'version' => $cntctfrmtdb_plugin_info["Version"] );

		/* Function check if plugin is compatible with current WP version  */
		cntctfrmtdb_version_check();					

		if ( isset( $_REQUEST['page'] ) && 'cntctfrmtdb_manager' == $_REQUEST['page'] )
			cntctfrmtdb_action_links();	

		/* Сhecking for the existence of Contact Form Plugin or Contact Form Pro Plugin */
		cntctfrmtdb_check_contact_form();
	}
}

/*
* Function to register default settings of plugin
*/
if ( ! function_exists( 'cntctfrmtdb_settings' ) ) {
	function cntctfrmtdb_settings() {
		global $wpmu, $cntctfrmtdb_options, $cntctfrmtdb_option_defaults, $cntctfrmtdb_plugin_info;

		if ( ! $cntctfrmtdb_plugin_info ) {
			if ( ! function_exists( 'get_plugin_data' ) )
				require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
			$cntctfrmtdb_plugin_info = get_plugin_data( __FILE__ );	
		}

		$cntctfrmtdb_db_version = '1.2';
		// set default settings
		$cntctfrmtdb_option_defaults = array (
			'plugin_option_version' 			=> $cntctfrmtdb_plugin_info["Version"],
			'plugin_db_version' 				=> $cntctfrmtdb_db_version,
			'cntctfrmtdb_save_messages_to_db'   => 1,
			'cntctfrmtdb_format_save_messages'  => 'xml',
			'cntctfrmtdb_csv_separator'         => ",",
			'cntctfrmtdb_csv_enclosure'         => "\"",
			'cntctfrmtdb_mail_address'          => 1,
			'cntctfrmtdb_delete_messages'       => 1,
			'cntctfrmtdb_delete_messages_after' => 'daily',
			'cntctfrmtdb_messages_per_page'     => 10,
		);
		// add options to database
		if ( 1 == $wpmu ) {
			if ( ! get_site_option( 'cntctfrmtdb_options' ) )
				add_site_option( 'cntctfrmtdb_options', $cntctfrmtdb_option_defaults, '', 'yes' );
		} else {
			if ( ! get_option( 'cntctfrmtdb_options' ) )
				add_option( 'cntctfrmtdb_options', $cntctfrmtdb_option_defaults, '', 'yes' );
		}
		// get options from database to operate with them
		if ( 1 == $wpmu )
			$cntctfrmtdb_options = get_site_option( 'cntctfrmtdb_options' );
		else
			$cntctfrmtdb_options = get_option( 'cntctfrmtdb_options' );

				/* Array merge incase this version has added new options */
		if ( ! isset( $cntctfrmtdb_options['plugin_option_version'] ) || $cntctfrmtdb_options['plugin_option_version'] != $cntctfrmtdb_plugin_info["Version"] ) {
			$cntctfrmtdb_options = array_merge( $cntctfrmtdb_option_defaults, $cntctfrmtdb_options );
			$cntctfrmtdb_options['plugin_option_version'] = $cntctfrmtdb_plugin_info["Version"];
			update_option( 'cntctfrmtdb_options', $cntctfrmtdb_options );
		}	

		/* create or update db table */
		if ( ! isset( $cntctfrmtdb_options['plugin_db_version'] ) || $cntctfrmtdb_options['plugin_db_version'] != $cntctfrmtdb_db_version ) {
			cntctfrmtdb_create_table();
			$cntctfrmtdb_options['plugin_db_version'] = $cntctfrmtdb_db_version;
			update_option( 'cntctfrmtdb_options', $cntctfrmtdb_options );
		}		
	}
}

/* Function check if plugin is compatible with current WP version  */
if ( ! function_exists ( 'cntctfrmtdb_version_check' ) ) {
	function cntctfrmtdb_version_check() {
		global $wp_version, $cntctfrmtdb_plugin_info;
		$require_wp		=	"3.2"; /* Wordpress at least requires version */
		$plugin			=	plugin_basename( __FILE__ );
	 	if ( version_compare( $wp_version, $require_wp, "<" ) ) {
			if ( is_plugin_active( $plugin ) ) {
				deactivate_plugins( $plugin );
				wp_die( "<strong>" . $cntctfrmtdb_plugin_info['Name'] . " </strong> " . __( 'requires', 'contact_form_to_db' ) . " <strong>WordPress " . $require_wp . "</strong> " . __( 'or higher, that is why it has been deactivated! Please upgrade WordPress and try again.', 'contact_form_to_db') . "<br /><br />" . __( 'Back to the WordPress', 'contact_form_to_db') . " <a href='" . get_admin_url( null, 'plugins.php' ) . "'>" . __( 'Plugins page', 'contact_form_to_db') . "</a>." );
			}
		}
	}
}

/* 
* Function to create a new tables in database 
*/
if ( ! function_exists( 'cntctfrmtdb_create_table' ) ) {
	function cntctfrmtdb_create_table() {
		global $wpdb;
		$prefix = $wpdb->prefix . 'cntctfrmtdb_';
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		$sql = "CREATE TABLE IF NOT EXISTS `" . $prefix . "message_status` (
			`id` TINYINT(2) UNSIGNED NOT NULL AUTO_INCREMENT,
			`name` CHAR(30) NOT NULL,
			PRIMARY KEY  (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
		dbDelta( $sql );
		$sql = "CREATE TABLE IF NOT EXISTS `" . $prefix . "blogname` (
			`id` TINYINT(2) UNSIGNED NOT NULL AUTO_INCREMENT,
			`blogname` CHAR(100) NOT NULL,
			PRIMARY KEY  (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
		dbDelta( $sql );
		$sql = "CREATE TABLE IF NOT EXISTS `" . $prefix . "to_email` (
			`id` SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
			`email` CHAR(50) NOT NULL,
			PRIMARY KEY  (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
		dbDelta( $sql );
		$sql = "CREATE TABLE IF NOT EXISTS `" . $prefix . "hosted_site` (
			`id` TINYINT(2) UNSIGNED NOT NULL AUTO_INCREMENT,
			`site` CHAR(50) NOT NULL,
			PRIMARY KEY  (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
		dbDelta( $sql );
		$sql = "CREATE TABLE IF NOT EXISTS `" . $prefix . "refer` (
			`id` TINYINT(2) UNSIGNED NOT NULL AUTO_INCREMENT,
			`refer` CHAR(50) NOT NULL,
			PRIMARY KEY  (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
		dbDelta( $sql );
		$sql = "CREATE TABLE IF NOT EXISTS `" . $prefix . "message` (
			`id` INT(6) UNSIGNED NOT NULL AUTO_INCREMENT,
			`from_user` CHAR(50) NOT NULL,
			`user_email` CHAR(50) NOT NULL,
			`send_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
			`subject` TINYTEXT NOT NULL,
			`message_text` TEXT NOT NULL,
			`was_read` TINYINT(1) NOT NULL,
			`sent` TINYINT(1) NOT NULL,
			`dispatch_counter` SMALLINT UNSIGNED NOT NULL,
			`status_id` TINYINT(2) UNSIGNED NOT NULL,
			`to_id` SMALLINT UNSIGNED NOT NULL, 
			`blogname_id` TINYINT UNSIGNED NOT NULL,
			`hosted_site_id` TINYINT(2) UNSIGNED NOT NULL,
			`refer_id` TINYINT(2) UNSIGNED NOT NULL,
			`attachment_status` INT(1) UNSIGNED NOT NULL,
			PRIMARY KEY  (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
		dbDelta( $sql );
		$sql = "CREATE TABLE IF NOT EXISTS `" . $prefix . "field_selection` (
			`cntctfrm_field_id` INT NOT NULL,
			`message_id` MEDIUMINT(6) UNSIGNED NOT NULL,
			`field_value` CHAR(50) NOT NULL
			) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
		dbDelta( $sql );
		$status = array( 'normal',
			'spam',
			'trash',
		);
		foreach ( $status as $key => $value ) {
			$db_row = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM `" . $prefix . "message_status` WHERE `name` = %s", $value  ), ARRAY_A );
			if ( ! isset( $db_row ) || empty( $db_row ) ) {
				$wpdb->insert(  $prefix . "message_status", array( 'name' => $value ), array( '%s' ) );	
			}
		}
	}
}

/*
* Function to translate several variables from javascript 
*/
if ( ! function_exists( 'cntctfrmtdb_script_var' ) ) {
	function cntctfrmtdb_script_var() { ?>
		<script type="text/javascript">
			var fancyBoxError = "<?php _e( 'The requested content cannot be loaded.<br/>Please try again later.' , 'contact_form_to_db' ); ?>";
			var letter = "<?php _e( 'Letter' , 'contact_form_to_db' ); ?>";
			var spam = "<?php _e( 'Spam!' , 'contact_form_to_db' ); ?>";
			var trash = "<?php _e( 'in Trash' , 'contact_form_to_db' ); ?>";
			var statusNotChanged = "<?php _e( 'Status was not changed' , 'contact_form_to_db' ); ?>";
			var preloaderSrc = "<?php echo plugins_url( 'images/preloader.gif', __FILE__ ); ?>";
		</script>
<?php }
}

/*
* Function to add stylesheets and scripts for admin bar 
*/
if ( ! function_exists ( 'cntctfrmtdb_admin_head' ) ) {
	function cntctfrmtdb_admin_head() {
		global $wp_version;
		if ( $wp_version < 3.8 )
			wp_enqueue_style( 'cntctfrmtdb_stylesheet', plugins_url( 'css/style_wp_before_3.8.css', __FILE__ ) );	
		else
			wp_enqueue_style( 'cntctfrmtdb_stylesheet', plugins_url( 'css/style.css', __FILE__ ) );

		$cntctfrmtdb_pages = array(
			'cntctfrmtdb_manager',
			'cntctfrmtdb_settings'
		);
		if ( isset( $_REQUEST['page'] ) && in_array( $_REQUEST['page'], $cntctfrmtdb_pages ) ) {			
			wp_enqueue_script( 'cntctfrmtdb_var', cntctfrmtdb_script_var() );
			wp_enqueue_script( 'cntctfrmtdb_script', plugins_url( 'js/script.js', __FILE__ ) );
		}
	}
}

/*
* Сhecking for the existence of Contact Form Plugin or Contact Form Pro Plugin
*/
if ( ! function_exists( 'cntctfrmtdb_check_contact_form' ) ) {
	function cntctfrmtdb_check_contact_form() {
		global $cntctfrmtdb_contact_form_not_found, $cntctfrmtdb_contact_form_not_active;
		if ( ! function_exists( 'is_plugin_active_for_network' ) )
			require_once( ABSPATH . 'wp-admin/includes/plugin.php' );

		$all_plugins = get_plugins();
		
		if ( ! ( array_key_exists( 'contact-form-plugin/contact_form.php', $all_plugins ) || array_key_exists( 'contact-form-pro/contact_form_pro.php', $all_plugins ) ) ) {
			$cntctfrmtdb_contact_form_not_found = __( 'Contact Form Plugin is not found.</br>You need install and activate this plugin for correct  work with Contact Form to DB plugin.</br>You can download Contact Form Plugin from ', 'contact_form_to_db' ) . '<a href="' . esc_url( 'http://bestwebsoft.com/plugin/contact-form-pro/' ) . '" title="' . __( 'Developers website', 'contact_form_to_db' ). '"target="_blank">' . __( 'website of plugin Authors ', 'contact_form_to_db' ) . '</a>' . __( 'or ', 'contact_form_to_db' ) . '<a href="' . esc_url( 'http://wordpress.org/plugins/contact-form-plugin/' ) .'" title="Wordpress" target="_blank">'. __( 'Wordpress.', 'contact_form_to_db' ) . '</a>';
		} else {
			if ( ! ( is_plugin_active( 'contact-form-plugin/contact_form.php' ) || is_plugin_active( 'contact-form-pro/contact_form_pro.php' ) || is_plugin_active_for_network( 'contact-form-plugin/contact_form.php' ) || is_plugin_active_for_network( 'contact-form-pro/contact_form_pro.php' ) ) ) {
				$cntctfrmtdb_contact_form_not_active = __( 'Contact Form Plugin is not active.</br>You need activate this plugin for correct work with Contact Form to DB plugin.', 'contact_form_to_db' );
			}
			/* old version */
			if ( ( ( is_plugin_active( 'contact-form-plugin/contact_form.php' ) || is_plugin_active_for_network( 'contact-form-plugin/contact_form.php' ) ) && isset( $all_plugins['contact-form-plugin/contact_form.php']['Version'] ) && $all_plugins['contact-form-plugin/contact_form.php']['Version'] < '3.60' ) || 
				( ( is_plugin_active( 'contact-form-pro/contact_form_pro.php' ) || is_plugin_active_for_network( 'contact-form-pro/contact_form_pro.php' ) ) && isset( $all_plugins['contact-form-pro/contact_form_pro.php']['Version'] ) && $all_plugins['contact-form-pro/contact_form_pro.php']['Version'] < '1.12' ) ) {
				$cntctfrmtdb_contact_form_not_found = __( 'Contact Form Plugin has old version.</br>You need update this plugin for correct work with Contact Form to DB plugin.', 'contact_form_to_db' );
			}
		}
	}
}

/*
* Function for displaying settings page of plugin 
*/
if ( ! function_exists( 'cntctfrmtdb_settings_page' ) ) {
	function cntctfrmtdb_settings_page() {
		global $cntctfrmtdb_options, $cntctfrmtdb_contact_form_not_found, $cntctfrmtdb_contact_form_not_active, $wp_version, $cntctfrmtdb_plugin_info;
		$error = '';

		// set value of input type="hidden" when options is changed
		if ( isset( $_POST['cntctfrmtdb_form_submit'] ) && check_admin_referer( plugin_basename( __FILE__ ), 'cntctfrmtdb_nonce_name' ) ) {
			$cntctfrmtdb_options_submit['cntctfrmtdb_save_messages_to_db'] = isset( $_POST['cntctfrmtdb_save_messages_to_db'] ) ? 1 : 0;
			$cntctfrmtdb_options_submit['cntctfrmtdb_format_save_messages'] = $_POST['cntctfrmtdb_format_save_messages'];
			if ( 'csv' == $cntctfrmtdb_options_submit['cntctfrmtdb_format_save_messages'] ) {
				$cntctfrmtdb_options_submit['cntctfrmtdb_csv_separator'] = $_POST['cntctfrmtdb_csv_separator'];
				$cntctfrmtdb_options_submit['cntctfrmtdb_csv_enclosure'] = $_POST['cntctfrmtdb_csv_enclosure'];
			} else {
				$cntctfrmtdb_options_submit['cntctfrmtdb_csv_separator'] = ",";
				$cntctfrmtdb_options_submit['cntctfrmtdb_csv_enclosure'] = '"';
			}
			$cntctfrmtdb_options_submit['cntctfrmtdb_messages_per_page'] = $_POST['cntctfrmtdb_messages_per_page'];
			// update options of plugin in database
			$cntctfrmtdb_options = array_merge( $cntctfrmtdb_options, $cntctfrmtdb_options_submit );
			update_option( 'cntctfrmtdb_options', $cntctfrmtdb_options, '', 'yes' );
		}

		/* GO PRO */
		if ( isset( $_GET['action'] ) && 'go_pro' == $_GET['action'] ) {
			global $wpmu, $bstwbsftwppdtplgns_options;			

			$bws_license_key = ( isset( $_POST['bws_license_key'] ) ) ? trim( esc_html( $_POST['bws_license_key'] ) ) : "";

			if ( isset( $_POST['bws_license_submit'] ) && check_admin_referer( plugin_basename( __FILE__ ), 'bws_license_nonce_name' ) ) {
				if ( '' != $bws_license_key ) { 
					if ( strlen( $bws_license_key ) != 18 ) {
						$error = __( "Wrong license key", 'contact_form_to_db' );
					} else {
						$bws_license_plugin = stripslashes( esc_html( $_POST['bws_license_plugin'] ) );
						if ( isset( $bstwbsftwppdtplgns_options['go_pro'][ $bws_license_plugin ]['count'] ) && $bstwbsftwppdtplgns_options['go_pro'][ $bws_license_plugin ]['time'] < ( time() + (24 * 60 * 60) ) ) {
							$bstwbsftwppdtplgns_options['go_pro'][ $bws_license_plugin ]['count'] = $bstwbsftwppdtplgns_options['go_pro'][ $bws_license_plugin ]['count'] + 1;
						} else {
							$bstwbsftwppdtplgns_options['go_pro'][ $bws_license_plugin ]['count'] = 1;
							$bstwbsftwppdtplgns_options['go_pro'][ $bws_license_plugin ]['time'] = time();
						}	

						/* download Pro */
						if ( ! function_exists( 'get_plugins' ) || ! function_exists( 'is_plugin_active_for_network' ) )
							require_once( ABSPATH . 'wp-admin/includes/plugin.php' );

						$all_plugins = get_plugins();
						$active_plugins = get_option( 'active_plugins' );
						
						if ( ! array_key_exists( $bws_license_plugin, $all_plugins ) ) {
							$current = get_site_transient( 'update_plugins' );
							if ( is_array( $all_plugins ) && !empty( $all_plugins ) && isset( $current ) && is_array( $current->response ) ) {
								$to_send = array();
								$to_send["plugins"][ $bws_license_plugin ] = array();
								$to_send["plugins"][ $bws_license_plugin ]["bws_license_key"] = $bws_license_key;
								$to_send["plugins"][ $bws_license_plugin ]["bws_illegal_client"] = true;
								$options = array(
									'timeout' => ( ( defined('DOING_CRON') && DOING_CRON ) ? 30 : 3 ),
									'body' => array( 'plugins' => serialize( $to_send ) ),
									'user-agent' => 'WordPress/' . $wp_version . '; ' . get_bloginfo( 'url' ) );
								$raw_response = wp_remote_post( 'http://bestwebsoft.com/wp-content/plugins/paid-products/plugins/update-check/1.0/', $options );

								if ( is_wp_error( $raw_response ) || 200 != wp_remote_retrieve_response_code( $raw_response ) ) {
									$error = __( "Something went wrong. Try again later. If the error will appear again, please, contact us <a href=http://support.bestwebsoft.com>BestWebSoft</a>. We are sorry for inconvenience.", 'contact_form_to_db' );
								} else {
									$response = maybe_unserialize( wp_remote_retrieve_body( $raw_response ) );
									
									if ( is_array( $response ) && !empty( $response ) ) {
										foreach ( $response as $key => $value ) {
											if ( "wrong_license_key" == $value->package ) {
												$error = __( "Wrong license key", 'contact_form_to_db' ); 
											} elseif ( "wrong_domain" == $value->package ) {
												$error = __( "This license key is bind to another site", 'contact_form_to_db' );
											} elseif ( "you_are_banned" == $value->package ) {
												$error = __( "Unfortunately, you have exceeded the number of available tries per day. Please, upload the plugin manually.", 'contact_form_to_db' );
											}
										}
										if ( '' == $error ) {																	
											$bstwbsftwppdtplgns_options[ $bws_license_plugin ] = $bws_license_key;

											$url = 'http://bestwebsoft.com/wp-content/plugins/paid-products/plugins/downloads/?bws_first_download=' . $bws_license_plugin . '&bws_license_key=' . $bws_license_key . '&download_from=5';
											$uploadDir = wp_upload_dir();
											$zip_name = explode( '/', $bws_license_plugin );
										    if ( file_put_contents( $uploadDir["path"] . "/" . $zip_name[0] . ".zip", file_get_contents( $url ) ) ) {
										    	@chmod( $uploadDir["path"] . "/" . $zip_name[0] . ".zip", octdec( 755 ) );
										    	if ( class_exists( 'ZipArchive' ) ) {
													$zip = new ZipArchive();
													if ( $zip->open( $uploadDir["path"] . "/" . $zip_name[0] . ".zip" ) === TRUE ) {
														$zip->extractTo( WP_PLUGIN_DIR );
														$zip->close();
													} else {
														$error = __( "Failed to open the zip archive. Please, upload the plugin manually", 'contact_form_to_db' );
													}								
												} elseif ( class_exists( 'Phar' ) ) {
													$phar = new PharData( $uploadDir["path"] . "/" . $zip_name[0] . ".zip" );
													$phar->extractTo( WP_PLUGIN_DIR );
												} else {
													$error = __( "Your server does not support either ZipArchive or Phar. Please, upload the plugin manually", 'contact_form_to_db' );
												}
												@unlink( $uploadDir["path"] . "/" . $zip_name[0] . ".zip" );										    
											} else {
												$error = __( "Failed to download the zip archive. Please, upload the plugin manually", 'contact_form_to_db' );
											}

											/* activate Pro */
											if ( file_exists( WP_PLUGIN_DIR . '/' . $zip_name[0] ) ) {			
												array_push( $active_plugins, $bws_license_plugin );
												update_option( 'active_plugins', $active_plugins );
												$pro_plugin_is_activated = true;
											} elseif ( '' == $error ) {
												$error = __( "Failed to download the zip archive. Please, upload the plugin manually", 'contact_form_to_db' );
											}																				
										}
									} else {
										$error = __( "Something went wrong. Try again later or upload the plugin manually. We are sorry for inconvienience.", 'contact_form_to_db' ); 
					 				}
					 			}
				 			}
						} else {
							/* activate Pro */
							if ( ! ( in_array( $bws_license_plugin, $active_plugins ) || is_plugin_active_for_network( $bws_license_plugin ) ) ) {			
								array_push( $active_plugins, $bws_license_plugin );
								update_option( 'active_plugins', $active_plugins );
								$pro_plugin_is_activated = true;
							}						
						}
						update_option( 'bstwbsftwppdtplgns_options', $bstwbsftwppdtplgns_options, '', 'yes' );
			 		}
			 	} else {
		 			$error = __( "Please, enter Your license key", 'contact_form_to_db' );
		 		}
		 	}
		} ?>
		<!-- creating page of options -->
		<div class="wrap">
			<div class="icon32 icon32-bws" id="icon-options-general"></div>
			<h2><?php _e( "Contact Form to DB Settings", 'contact_form_to_db' ); ?></h2>
			<h2 class="nav-tab-wrapper">
				<a class="nav-tab<?php if ( isset( $_GET['page'] ) && 'cntctfrmtdb_settings' == $_GET['page'] ) echo ' nav-tab-active'; ?>" href="admin.php?page=cntctfrmtdb_settings"><?php _e( 'Settings', 'contact_form_to_db' ); ?></a>
				<a class="nav-tab" href="http://bestwebsoft.com/plugin/contact-form-to-db/#faq" target="_blank"><?php _e( 'FAQ', 'contact_form_to_db' ); ?></a>
				<a class="bws_plugin_menu_pro_version nav-tab" href="http://bestwebsoft.com/plugin/contact-form-to-db-pro/?k=5906020043c50e2eab1528d63b126791&pn=91&v=<?php echo $cntctfrmtdb_plugin_info["Version"]; ?>&wp_v=<?php echo $wp_version; ?>" target="_blank" title="<?php _e( 'This setting is available in Pro version', 'contact_form_to_db' ); ?>"><?php _e( 'User guide', 'contact_form_to_db' ); ?></a>
				<a class="nav-tab bws_go_pro_tab<?php if ( isset( $_GET['action'] ) && 'go_pro' == $_GET['action'] ) echo ' nav-tab-active'; ?>" href="admin.php?page=cntctfrmtdb_settings&amp;action=go_pro"><?php _e( 'Go PRO', 'contact_form_to_db' ); ?></a>
			</h2>
			<div id="cntctfrmtdb_settings_notice" class="updated fade" style="display:none"><p><strong><?php _e( "Notice:", 'contact_form_to_db' ); ?></strong> <?php _e( "The plugin's settings have been changed. In order to save them please don't forget to click the 'Save Changes' button.", 'contact_form_to_db' ); ?></p></div>
			<div class="error" <?php if ( "" == $error ) echo "style=\"display:none\""; ?>><p><strong><?php echo $error; ?></strong></p></div>
			<div class="updated fade" <?php if ( ! isset( $_POST['cntctfrmtdb_form_submit'] ) ) echo 'style="display:none"'; ?>><p><strong><?php _e( "Settings saved.", 'contact_form_to_db' ); ?></strong></p></div>
			<?php if ( ! isset( $_GET['action'] ) ) { ?>
				<form id="cntctfrmtdb_settings_form" method="post" action="admin.php?page=cntctfrmtdb_settings">
					<table class="form-table cntctfrmtdb_form_table" style="width:auto;">
						<tr valign="top">
							<th scope="row"><label for="cntctfrmtdb_save_messages_to_db" class="cntctfrmtdb_info"><?php _e( 'Save messages to database', 'contact_form_to_db' ); ?></label></th>
							<td>
								<input type="checkbox" id="cntctfrmtdb_save_messages_to_db" name="cntctfrmtdb_save_messages_to_db" value="1" <?php if( 1 == $cntctfrmtdb_options['cntctfrmtdb_save_messages_to_db'] ) echo "checked=\"checked\" "; ?>/>
							</td>
						</tr>					
						<tr valign="top" class="cntctfrmtdb_options" <?php if ( ! 1 == $cntctfrmtdb_options['cntctfrmtdb_save_messages_to_db'] ) echo 'style="display: none;"' ;?>>
							<th scope="row"><?php _e( 'Download messages in', 'contact_form_to_db' ); ?></th>
							<td>
								<select name="cntctfrmtdb_format_save_messages" id="cntctfrmtdb_format_save_messages">
									<option value='xml' <?php if ( 'xml' == $cntctfrmtdb_options['cntctfrmtdb_format_save_messages'] ) echo "selected=\"selected\" "; ?>><?php echo '.xml'; ?></option>
									<option value='eml' <?php if ( 'eml' == $cntctfrmtdb_options['cntctfrmtdb_format_save_messages'] ) echo "selected=\"selected\" "; ?>><?php echo '.eml'; ?></option>
									<option value='csv' <?php if ( 'csv' == $cntctfrmtdb_options['cntctfrmtdb_format_save_messages'] ) echo "selected=\"selected\" "; ?>><?php echo '.csv'; ?></option>
								</select>
								<label class="cntctfrmtdb_info"> <?php _e( 'format', 'contact_form_to_db' ); ?></label><br/>
								<div class="cntctfrmtdb_csv_separators" <?php if ( 'csv' != $cntctfrmtdb_options['cntctfrmtdb_format_save_messages'] ) echo 'style="display: none;"'; ?>>
									<label class="cntctfrmtdb_info"><?php _e( 'Input symbols for separator and enclosure', 'contact_form_to_db' ); ?></label></br>
									<select name="cntctfrmtdb_csv_separator" id="cntctfrmtdb_csv_separator">
										<option value="," <?php if ( "," == $cntctfrmtdb_options['cntctfrmtdb_csv_separator'] ) echo "selected=\"selected\" "; ?>><?php echo ","; ?></option>
										<option value=";" <?php if ( ";" == $cntctfrmtdb_options['cntctfrmtdb_csv_separator'] ) echo "selected=\"selected\" "; ?>><?php echo ";"; ?></option>
										<option value="t" <?php if ( "t" == $cntctfrmtdb_options['cntctfrmtdb_csv_separator'] ) echo "selected=\"selected\" "; ?>><?php echo "\\t"; ?></option>
									</select>
									<label for="cntctfrmtdb_csv_separator" class="cntctfrmtdb_info"><?php _e( ' separator', 'contact_form_to_db' ); ?></label><br/>
									<select name="cntctfrmtdb_csv_enclosure" id="cntctfrmtdb_csv_enclosure">
										<option value='"' <?php if ( "\"" == $cntctfrmtdb_options['cntctfrmtdb_csv_enclosure'] ) echo "selected=\"selected\" "; ?>><?php echo "\""; ?></option>
										<option value="'" <?php if ( "'" == $cntctfrmtdb_options['cntctfrmtdb_csv_enclosure'] ) echo "selected=\"selected\" "; ?>><?php echo "'"; ?></option>
										<option value="`" <?php if ( "`" == $cntctfrmtdb_options['cntctfrmtdb_csv_enclosure'] ) echo "selected=\"selected\" "; ?>><?php echo "`"; ?></option>
									</select>
									<label for="cntctfrmtdb_csv_enclosure" class="cntctfrmtdb_info"><?php _e( ' enclosure', 'contact_form_to_db' ); ?></label><br/>
								</div><!-- .cntctfrmtdb_csv_separators -->
							</td>
						</tr>										
						<tr valign="top" class="cntctfrmtdb_options" <?php if( '1' != $cntctfrmtdb_options['cntctfrmtdb_save_messages_to_db'] ) echo 'style="display: none;"' ;?>>
							<th scope="row"><?php _e( 'Show messages per page', 'contact_form_to_db' ); ?></th>
							<td>
								<select name="cntctfrmtdb_messages_per_page" id="cntctfrmtdb_messages_per_page">
									<option value='5' <?php if( '5' == $cntctfrmtdb_options['cntctfrmtdb_messages_per_page'] ) echo "selected=\"selected\" ";?>>5</option>
									<option value='10' <?php if( '10' == $cntctfrmtdb_options['cntctfrmtdb_messages_per_page'] ) echo "selected=\"selected\" ";?>>10</option>
									<option value='20' <?php if( '20' == $cntctfrmtdb_options['cntctfrmtdb_messages_per_page'] ) echo "selected=\"selected\" ";?>>20</option>
									<option value='30' <?php if( '30' == $cntctfrmtdb_options['cntctfrmtdb_messages_per_page'] ) echo "selected=\"selected\" ";?>>30</option>
									<option value='50' <?php if( '50' == $cntctfrmtdb_options['cntctfrmtdb_messages_per_page'] ) echo "selected=\"selected\" ";?>>50</option>
									<option value='100' <?php if( '100' == $cntctfrmtdb_options['cntctfrmtdb_messages_per_page'] ) echo "selected=\"selected\" ";?>>100</option>
								</select>
								
							</td>
						</tr>
					</table>
					<div class="bws_pro_version_bloc">
						<div class="bws_pro_version_table_bloc">	
							<div class="bws_table_bg"></div>											
							<table class="form-table bws_pro_version">
								<tr valign="top">
									<th scope="row"><label for="cntctfrmtdb_save_attachments" class="cntctfrmtdb_info"><?php _e( 'Save attachments', 'contact_form_to_db' ); ?></label></th>
									<td>							
										<input disabled="disabled" checked="checked" type="checkbox" id="cntctfrmtdb_save_attachments" name="cntctfrmtdb_save_attachments" value="1" />
										<br/>
										<div class="cntctfrmtdb_save_to_block">
											<input disabled="disabled" type="radio" id="cntctfrmtdb_save_to_database" name="cntctfrmtdb_save_attachments_to" value="database" />
											<label for="cntctfrmtdb_save_to_database" class="cntctfrmtdb_info"><?php _e( 'Save attachments to database.', 'contact_form_to_db' ); ?></label><br/>
											<input disabled="disabled" type="radio" id="cntctfrmtdb_save_to_uploads" name="cntctfrmtdb_save_attachments_to" value="uploads" />
											<label for="cntctfrmtdb_save_to_uploads" class="cntctfrmtdb_info"><?php _e( 'Save attachments to "Uploads".', 'contact_form_to_db' ); ?></label>
										</div>
									</td>
								</tr>					
								<tr valign="top">
									<th scope="row"><label for="cntctfrmtdb_delete_messages" class="cntctfrmtdb_info"><?php _e( 'Periodically delete old messages', 'contact_form_to_db' ); ?></label></th>
									<td>
										<input disabled="disabled" checked="checked" type="checkbox" id="cntctfrmtdb_delete_messages" name="cntctfrmtdb_delete_messages"/>
										<div class="cntctfrmtdb_delete_block">
											<select name="cntctfrmtdb_delete_messages_after" id="cntctfrmtdb_delete_messages_after">
												<option value='daily'><?php _e( 'every 24 hours', 'contact_form_to_db' ); ?></option>
												<option value='every_three_days'><?php _e( 'every 3 days', 'contact_form_to_db' ); ?></option>
												<option value='weekly'><?php _e( 'every 1 week', 'contact_form_to_db' ); ?></option>
												<option value='every_two_weeks'><?php _e( 'every 2 weeks', 'contact_form_to_db' ); ?></option>
												<option value='monthly'><?php _e( 'every 1 month', 'contact_form_to_db' ); ?></option>
												<option value='every_six_months'><?php _e( 'every 6 months', 'contact_form_to_db' ); ?></option>
												<option value='yearly'><?php _e( 'every 1 year', 'contact_form_to_db' ); ?></option>
											</select><br/>
											<span class="cntctfrmtdb_tips"><?php _e( '(All messages older than the specified period will be deleted at the end of the same period)', 'contact_form_to_db' ); ?></span>
										</div>
									</td>
								</tr>					
								<tr valign="top">
									<th scope="row"><label for="cntctfrmtdb_show_attachments" class="cntctfrmtdb_info"><?php _e( 'Show attachments', 'contact_form_to_db' ); ?></label></th>
									<td><input disabled="disabled" type="checkbox" id="cntctfrmtdb_show_attachments" name="cntctfrmtdb_show_attachments" value="1" /></td>
								</tr>
								<tr valign="top">
									<th><label for="cntctfrmtdb_use_fancybox" class="cntctfrmtdb_info"><?php _e( 'Use fancybox to image view', 'contact_form_to_db' ); ?></label></th>
									<td><input disabled="disabled" type="checkbox" id="cntctfrmtdb_use_fancybox" name="cntctfrmtdb_use_fancybox" value="1" /></td>
								</tr>
								<tr valign="top">
									<th scope="row" colspan="2">
										* <?php _e( 'If you upgrade to Pro version all your settings will be saved.', 'contact_form_to_db' ); ?>
									</th>
								</tr>				
							</table>	
						</div>
						<div class="bws_pro_version_tooltip">
							<div class="bws_info">
								<?php _e( 'Unlock premium options by upgrading to a PRO version.', 'contact_form_to_db' ); ?> 
								<a href="http://bestwebsoft.com/plugin/contact-form-to-db-pro/?k=5906020043c50e2eab1528d63b126791&pn=91&v=<?php echo $cntctfrmtdb_plugin_info["Version"]; ?>&wp_v=<?php echo $wp_version; ?>" target="_blank" title="Contact Form to DB Pro"><?php _e( 'Learn More', 'contact_form_to_db' ); ?></a>				
							</div>
							<a class="bws_button" href="http://bestwebsoft.com/plugin/contact-form-to-db-pro/?k=5906020043c50e2eab1528d63b126791&pn=91&v=<?php echo $cntctfrmtdb_plugin_info["Version"]; ?>&wp_v=<?php echo $wp_version; ?>#purchase" target="_blank" title="Contact Form to DB Pro">
								<?php _e( 'Go', 'contact_form_to_db' ); ?> <strong>PRO</strong>
							</a>	
							<div class="clear"></div>					
						</div>
					</div>
					<input type="hidden" name="cntctfrmtdb_form_submit" value="submit" />
					<p class="submit">
						<input type="submit" class="button-primary" value="<?php _e( 'Save Changes', 'contact_form_to_db' ) ?>" />
					</p>
					<?php wp_nonce_field( plugin_basename( __FILE__ ), 'cntctfrmtdb_nonce_name' ); ?>
				</form>
				<div class="bws-plugin-reviews">
					<div class="bws-plugin-reviews-rate">
						<?php _e( 'If you enjoy our plugin, please give it 5 stars on WordPress', 'contact_form_to_db' ); ?>: 
						<a href="http://wordpress.org/support/view/plugin-reviews/contact-form-to-db/" target="_blank" title="Contact Form To DB reviews"><?php _e( 'Rate the plugin', 'contact_form_to_db' ); ?></a>
					</div>
					<div class="bws-plugin-reviews-support">
						<?php _e( 'If there is something wrong about it, please contact us', 'contact_form_to_db' ); ?>: 
						<a href="http://support.bestwebsoft.com">http://support.bestwebsoft.com</a>
					</div>
				</div>
			<?php } elseif ( 'go_pro' == $_GET['action'] ) { ?>
				<?php if ( isset( $pro_plugin_is_activated ) && true === $pro_plugin_is_activated ) { ?>
					<script type="text/javascript">
						window.setTimeout( function() {
						    window.location.href = 'admin.php?page=cntctfrmtdbpr_settings';
						}, 5000 );
					</script>				
					<p><?php _e( "Congratulations! The PRO version of the plugin is successfully download and activated.", 'contact_form_to_db' ); ?></p>
					<p>
						<?php _e( "Please, go to", 'contact_form_to_db' ); ?> <a href="admin.php?page=cntctfrmtdbpr_settings"><?php _e( 'the setting page', 'contact_form_to_db' ); ?></a> 
						(<?php _e( "You will be redirected automatically in 5 seconds.", 'contact_form_to_db' ); ?>)
					</p>
				<?php } else { ?>
					<form method="post" action="admin.php?page=cntctfrmtdb_settings&amp;action=go_pro">
						<p>
							<?php _e( 'You can download and activate', 'contact_form_to_db' ); ?> 
							<a href="http://bestwebsoft.com/plugin/contact-form-to-db-pro/?k=5906020043c50e2eab1528d63b126791&pn=91&v=<?php echo $cntctfrmtdb_plugin_info["Version"]; ?>&wp_v=<?php echo $wp_version; ?>" target="_blank" title="Contact Form To DB Pro">PRO</a> 
							<?php _e( 'version of this plugin by entering Your license key.', 'contact_form_to_db' ); ?><br />
							<span style="color: #888888;font-size: 10px;">
								<?php _e( 'You can find your license key on your personal page Client area, by clicking on the link', 'contact_form_to_db' ); ?> 
								<a href="http://bestwebsoft.com/wp-login.php">http://bestwebsoft.com/wp-login.php</a> 
								<?php _e( '(your username is the email you specify when purchasing the product).', 'contact_form_to_db' ); ?>
							</span>
						</p>
						<?php if ( isset( $bstwbsftwppdtplgns_options['go_pro']['contact-form-to-db-pro/contact_form_to_db_pro.php']['count'] ) &&
							'5' < $bstwbsftwppdtplgns_options['go_pro']['contact-form-to-db-pro/contact_form_to_db_pro.php']['count'] &&
							$bstwbsftwppdtplgns_options['go_pro']['contact-form-to-db-pro/contact_form_to_db_pro.php']['time'] < ( time() + ( 24 * 60 * 60 ) ) ) { ?>
							<p>
								<input disabled="disabled" type="text" name="bws_license_key" value="<?php echo $bws_license_key; ?>" />
								<input disabled="disabled" type="submit" class="button-primary" value="<?php _e( 'Activate', 'contact_form_to_db' ); ?>" />
							</p>
							<p>
								<?php _e( "Unfortunately, you have exceeded the number of available tries per day. Please, upload the plugin manually.", 'contact_form_to_db' ); ?>
							</p>
						<?php } else { ?>
							<p>
								<input type="text" name="bws_license_key" value="<?php echo $bws_license_key; ?>" />
								<input type="hidden" name="bws_license_plugin" value="contact-form-to-db-pro/contact_form_to_db_pro.php" />
								<input type="hidden" name="bws_license_submit" value="submit" />
								<input type="submit" class="button-primary" value="<?php _e( 'Activate', 'contact_form_to_db' ); ?>" />
								<?php wp_nonce_field( plugin_basename( __FILE__ ), 'bws_license_nonce_name' ); ?>
							</p>
						<?php } ?>
					</form>
				<?php }
			} ?>
		</div>
	<?php }
}

/*
* Function to get mail data from contact form
*/
if ( ! function_exists( 'cntctfrmtdb_get_mail_data' ) ) {
	function cntctfrmtdb_get_mail_data( $to, $name, $email, $address, $phone, $subject, $message, $form_action_url, $user_agent, $userdomain, $location = '' ) {
		global $sendto, $username, $useremail, $useraddress, $userlocation, $userphone, $message_subject, $message_text, $refer, $useragent, $user_domain;
		$sendto					= $to;
		$username				= $name;
		$useremail				= $email;
		$userlocation			= $location;
		$useraddress			= $address;
		$userphone				= $phone;
		$message_subject		= $subject;
		$message_text			= $message;
		$refer					= $form_action_url;
		$useragent				= $user_agent;
		$user_domain			= $userdomain;
	}
}

/*
* Function to get attachments and thumbnails
*/
if ( ! function_exists( 'cntctfrmtdb_get_attachment_data' ) ) {
	function cntctfrmtdb_get_attachment_data( $path_of_uploaded_file ) {
		global $attachment_status;
		$attachment_status = 3;
	}
}


/*
* Function to check was sent message or not 
*/
if ( ! function_exists( 'cntctfrmtdb_check_dispatch' ) ) {
	function cntctfrmtdb_check_dispatch( $cntctfrm_result ) {
		global $dispatched, $cntctfrmtdb_options;

		if ( empty( $cntctfrmtdb_options ) )
			$cntctfrmtdb_options = get_option( 'cntctfrmtdb_options' );

		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

		$dispatched = $cntctfrm_result ? 1 : 0;

		if ( '1' == $cntctfrmtdb_options['cntctfrmtdb_save_messages_to_db'] ) {
			if ( ( ( is_plugin_active( 'contact-form-plugin/contact_form.php' ) || is_plugin_active_for_network( 'contact-form-plugin/contact_form.php' ) ) && isset( $_SESSION['cntctfrm_send_mail'] ) && true == $_SESSION['cntctfrm_send_mail'] ) || 
				 ( ( is_plugin_active( 'contact-form-pro/contact_form_pro.php' ) || is_plugin_active_for_network( 'contact-form-pro/contact_form_pro.php' ) ) && isset( $_SESSION['cntctfrmpr_send_mail'] ) && true == $_SESSION['cntctfrmpr_send_mail'] ) ) {
				// 
			} else {
				cntctfrmtdb_save_message();
			}
		}
	}
}

/*
 * Function to save new message in database
 */
if ( ! function_exists( 'cntctfrmtdb_save_new_message' ) ) {
	function cntctfrmtdb_save_new_message() {
		global $message_id, $sendto, $username, $useremail, $useraddress, $userlocation,
		$userphone, $message_subject, $message_text, $refer,
		$useragent, $user_domain, $attachment_status, $dispatched, $wpdb, $cntctfrm_options_for_this_plugin, $cntctfrmtdb_options;
		$prefix = $wpdb->prefix . 'cntctfrmtdb_';
		$wpdb->insert( $prefix . 'message', array(
			'from_user'         => $username,
			'user_email'        => $useremail,
			'subject'           => $message_subject,
			'message_text'      => $message_text,
			'sent'              => $dispatched,
			'dispatch_counter'  => '1',
			'was_read'          => '0',
			'sent'              => $dispatched,
			'status_id'         => '1',
			'attachment_status' => $attachment_status,
			)
		);
		$message_id = $wpdb->insert_id;
		
		// We fill necessary tables by Contact Form to DB plugin 
		$blogname_id = $to_email_id = $blogurl_id = $refer_id = '';
		$upload_path_id 	= 0;

		// get option from Contact form or Contact form PRO
		if ( ! $cntctfrm_options_for_this_plugin ) {
			include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
			if ( is_plugin_active( 'contact-form-plugin/contact_form.php' ) || is_plugin_active_for_network( 'contact-form-plugin/contact_form.php' ) ) {
				$cntctfrm_options_for_this_plugin = get_option( 'cntctfrm_options' );
			} elseif ( is_plugin_active( 'contact-form-pro/contact_form_pro.php' ) || is_plugin_active_for_network( 'contact-form-pro/contact_form_pro.php' ) ) {
				$cntctfrmpr_options = get_option( 'cntctfrmpr_options' );
				$cntctfrm_options_for_this_plugin = array();
				foreach ( $cntctfrmpr_options as $key => $value ) {
					if ( ! is_array( $value ) )
						$cntctfrm_options_for_this_plugin[ 'cntctfrm_'. $key ] = $cntctfrmpr_options[ $key ];
				}
			}
		}
		
		// insert data about blogname
		$blogname_id = $wpdb->get_var( "SELECT `id` FROM `" . $prefix . "blogname` WHERE `blogname`='" . get_bloginfo( 'name' ) . "'" );
		if ( ! isset( $blogname_id ) ) {
			$wpdb->insert( $prefix . 'blogname', array( 'blogname' => get_bloginfo( 'name' ) ) );
			$blogname_id = $wpdb->insert_id;
		}
		
		//insert data about who was addressed to email
		$to_email_id = $wpdb->get_var( "SELECT `id` FROM `" . $prefix . "to_email` WHERE `email`='" . $sendto . "'" );
		if ( ! isset( $to_email_id ) ) {
			$wpdb->insert( $prefix . 'to_email', array( 'email' => $sendto ) );
			$to_email_id = $wpdb->insert_id;
		}
		
		//insert URL of hosted site
		$blogurl_id = $wpdb->get_var( "SELECT `id` FROM `" . $prefix . "hosted_site` WHERE `site`='" . get_bloginfo( "url" ) . "'" );
		if ( ! isset( $blogurl_id ) ) {
			$wpdb->insert( $prefix . 'hosted_site', array( 'site' => get_bloginfo( "url" ) ) );
			$blogurl_id = $wpdb->insert_id;
		}
	
		//insert data about refer
		$refer_id = $wpdb->get_var( "SELECT `id` FROM `" . $prefix . "refer` WHERE `refer`='" . $refer . "'" );
		if ( ! isset( $refer_id ) ) {
			$wpdb->insert( $prefix . 'refer', array( 'refer' => $refer ) );
			$refer_id = $wpdb->insert_id;
		}

		//insert data about additionals fields
		if ( isset( $userlocation ) && '' != $userlocation ) {
			$field_id = $wpdb->get_var( 'SELECT `id` FROM `' . $wpdb->prefix . "cntctfrm_field` WHERE `name`='location'");
			$wpdb->insert( $prefix . 'field_selection', array( 
				'cntctfrm_field_id' => $field_id,
				'message_id'        => $message_id,
				'field_value'       =>  $userlocation,
				)
			);
		}
		if ( isset( $useraddress ) && '' != $useraddress ) {
			$field_id = $wpdb->get_var( 'SELECT `id` FROM `' . $wpdb->prefix . "cntctfrm_field` WHERE `name`='address'");
			$wpdb->insert( $prefix . 'field_selection', array( 
				'cntctfrm_field_id' => $field_id,
				'message_id'        => $message_id,
				'field_value'       =>  $useraddress,
				)
			);
		}
		if ( isset( $userphone ) && '' != $userphone ) {
			$field_id = $wpdb->get_var( 'SELECT `id` FROM `' . $wpdb->prefix . "cntctfrm_field` WHERE `name`='phone'");
			$wpdb->insert( $prefix . 'field_selection', array(
				'cntctfrm_field_id' => $field_id,
				'message_id'        => $message_id,
				'field_value'       => $userphone,
				)
			);
		}
		if ( '1' == $cntctfrm_options_for_this_plugin['cntctfrm_display_user_agent'] ) {
			if ( isset( $useragent ) && '' != $useragent ) {
				$field_id = $wpdb->get_var( 'SELECT `id` FROM `' . $wpdb->prefix . "cntctfrm_field` WHERE `name`='user_agent'");
				$wpdb->insert( $prefix . 'field_selection', array(
					'cntctfrm_field_id' => $field_id,
					'message_id'        => $message_id,
					'field_value'       => $useragent,
					)
				);
			}
		}
		
		// update row with current message in  database
		$wpdb->update( $prefix . 'message', array(
			'blogname_id'    => $blogname_id,
			'to_id'          => $to_email_id,
			'hosted_site_id' => $blogurl_id,
			'refer_id'       => $refer_id,
			 ), array( 
				'id' => $message_id )
		);
	}
}


/*
* Function to check if is a new message and save message in database 
*/
if ( ! function_exists( 'cntctfrmtdb_save_message' ) ) {
	function cntctfrmtdb_save_message() {
		global $username, $message_text, $dispatched, $wpdb;
		$prefix = $wpdb->prefix . 'cntctfrmtdb_';
		// If message was not sent for some reason and user click again on "submit", counter of dispathces will +1.
		// in details:
		// - We get content of previous message. If previous message is not exists, we save current message in database.
		// - If previous message exists: we check message text and author name of previous message with message text and author name of current message.
		// - If the same, then we increments the dispatch counter previous message, if message was sent in this time, we so update 'sent' column in 'message' table.
		// - If not - write new message in database.
		$previous_message_data = $wpdb->get_row( "SELECT `id`, `from_user`, `message_text`, `dispatch_counter`, `sent` FROM `" . $prefix . "message` WHERE `id` = ( SELECT MAX(`id`) FROM `" . $prefix . "message` )", ARRAY_A );
		if (  '' != $previous_message_data ) {
			if ( $message_text == $previous_message_data['message_text'] && $username == $previous_message_data['from_user'] ) {
				$counter = intval( $previous_message_data['dispatch_counter'] );
				$counter++;
				$wpdb->update( $prefix . 'message', array(
						'sent'             => $dispatched,
						'dispatch_counter' => $counter,
					), array(
						'id' => $previous_message_data['id'],
					)
				);
			} else {
				cntctfrmtdb_save_new_message();
			}
		} else {
			cntctfrmtdb_save_new_message();
		}
	}
}

/*
* Function to handle action links
*/
if ( ! function_exists( 'cntctfrmtdb_action_links' ) ) {
	function cntctfrmtdb_action_links() {
		global $wpdb, $cntctfrm_options_for_this_plugin, $cntctfrmtdb_done_message, $cntctfrmtdb_error_message;
		
		if ( empty( $cntctfrmtdb_options ) )
			$cntctfrmtdb_options = get_option( 'cntctfrmtdb_options' );

		// get option from Contact form or Contact form PRO
		if ( ! $cntctfrm_options_for_this_plugin ) {
			include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
			if ( is_plugin_active( 'contact-form-plugin/contact_form.php' ) || is_plugin_active_for_network( 'contact-form-plugin/contact_form.php' ) ) {
				$cntctfrm_options_for_this_plugin = get_option( 'cntctfrm_options' );
			} elseif ( is_plugin_active( 'contact-form-pro/contact_form_pro.php' ) || is_plugin_active_for_network( 'contact-form-pro/contact_form_pro.php' ) ) {
				$cntctfrmpr_options = get_option( 'cntctfrmpr_options' );
				$cntctfrm_options_for_this_plugin = array();
				foreach ( $cntctfrmpr_options as $key => $value ) {
					if ( ! is_array( $value ) )
						$cntctfrm_options_for_this_plugin[ 'cntctfrm_'. $key ] = $cntctfrmpr_options[ $key ];
				}
			}
		}
		
		$random_number = rand( 100, 999 ); //prefix to the names of files to be saved
		
		// We get path to 'attachments' folder
		if ( defined( 'UPLOADS' ) ) {
			if ( ! is_dir( ABSPATH . UPLOADS ) ) 
				wp_mkdir_p( ABSPATH . UPLOADS );
			$save_file_path = trailingslashit( ABSPATH . UPLOADS ) . 'attachments';
		} elseif ( defined( 'BLOGUPLOADDIR' ) ) {
			if ( ! is_dir( ABSPATH . BLOGUPLOADDIR ) )
				wp_mkdir_p( ABSPATH . BLOGUPLOADDIR );
			$save_file_path = trailingslashit( ABSPATH . BLOGUPLOADDIR ) . 'attachments';
		} else {
			$upload_path		= wp_upload_dir();
			$save_file_path = $upload_path['basedir'] . '/attachments';
		}
		if ( ! is_dir( $save_file_path ) ) {
			wp_mkdir_p( $save_file_path );
		}
		
		$prefix = $wpdb->prefix . 'cntctfrmtdb_';
		
		if ( isset( $_REQUEST['action'] ) || isset( $_REQUEST['action2'] ) ) {
			$ids = '';
			if ( isset( $_REQUEST['action'] ) && '-1' != $_REQUEST['action'] )
				$action = $_REQUEST['action'];
			else
				$action = $_REQUEST['action2'];
			if ( isset( $_REQUEST['message_id'] ) && '' !=  $_REQUEST['message_id'] ) {
				// when action is "undo", "restore" or "spam" - message id`s is a string like "2,3,4,5,6,"
				if ( preg_match( '|,|', $_REQUEST['message_id'][0] ) ) 
					$ids = explode(  ',', $_REQUEST['message_id'][0] );
				if ( '' != $ids ) {
					$message_id = $ids;
				} else {
					$message_id = $_REQUEST['message_id'];
				};
				$i = $error_counter = $counter = $have_not_attachment = $can_not_create_zip = $file_created = $can_not_create_file = $can_not_create_xml = 0;
				// Create ZIP-archive if:
				// create zip-archives is possible and  one embodiment of the:
				// 1) need to save several messages in "csv"-format
				// 2) need to save several messages in "eml"-format
				if ( class_exists( 'ZipArchive' ) && 'download_messages' == $action && ( 'csv' == $cntctfrmtdb_options['cntctfrmtdb_format_save_messages'] || 'eml' == $cntctfrmtdb_options['cntctfrmtdb_format_save_messages'] ) ) {
					//create new zip-archive
					$zip = new ZipArchive();
					$zip_name = $save_file_path . '/' .time() . ".zip";
					if ( ! $zip->open( $zip_name, ZIPARCHIVE::CREATE ) )
						$can_not_create_zip = 1;
				}
				// we create a new "xml"-file
				if ( in_array( $action, array( 'download_message', 'download_messages' ) ) && 'xml' == $cntctfrmtdb_options['cntctfrmtdb_format_save_messages'] ) {
					$xml = new DOMDocument( '1.0','utf-8' );
					$xml->formatOutput = true;
					$messages = $xml->appendChild( $xml->createElement( 'cnttfrmtdb_messages' ) ); //create main element <messages></messages>
				}
				foreach ( $message_id as $id ) {
					if ( '' != $id ) {
						switch ( $action ) {
							case 'download_message':
							case 'download_messages':
								if ( ( isset( $_GET['action'] ) && $action == $_GET['action'] && check_admin_referer( 'cntctfrmtdb_download_message' . $id ) ) || 
									( ( $action == $_POST['action'] || $action == $_POST['action2'] ) && check_admin_referer( plugin_basename( __FILE__ ), 'cntctfrmtdb_manager_nonce_name' ) ) ) {
									// we get message  content
									$message_text = '';
									$message_data = $wpdb->get_results(
										"SELECT `from_user`, `user_email`, `send_date`, `subject`, `message_text`, `blogname`, `site`, `refer`, `email`
										FROM `" . $prefix . "message`
										LEFT JOIN `" . $prefix . "blogname` ON " . $prefix . "message.blogname_id=" . $prefix . "blogname.id
										LEFT JOIN `" . $prefix . "hosted_site` ON " . $prefix . "message.hosted_site_id=" . $prefix . "hosted_site.id
										LEFT JOIN `" . $prefix . "refer` ON " . $prefix . "message.refer_id=" . $prefix . "refer.id
										LEFT JOIN `" . $prefix . "to_email` ON " . $prefix . "message.to_id=" . $prefix . "to_email.id
										WHERE " . $prefix . "message.id=" . $id
									);
									$additional_fields = $wpdb->get_results( 
										"SELECT `field_value`, `name` 
										FROM `" . $prefix . "field_selection`
										LEFT JOIN " . $wpdb->prefix . "cntctfrm_field ON " . $wpdb->prefix . "cntctfrm_field.id=" . $prefix . "field_selection.cntctfrm_field_id
										WHERE " . $prefix . "field_selection.message_id=" . $id
									);
									// forming file in "XML" format
									if ( 'xml' == $cntctfrmtdb_options['cntctfrmtdb_format_save_messages'] ) {
										foreach ( $message_data as $data ) {
											foreach ( $additional_fields as $field ) {
												if ( 'address' == $field->name )
													$data_address = $field->field_value;
												elseif ( 'phone' == $field->name )
													$data_phone = $field->field_value;
												elseif ( 'user_agent' == $field->name )
													$data_user_agent = $field->field_value;
											}
											
											$message	= $messages->appendChild( $xml->createElement( 'cnttfrmtdb_message' ) ); //creation main element for single message <message></message>
											$from		= $message->appendChild( $xml->createElement( 'cnttfrmtdb_from' ) ); // insert <from></from> in to <message></messsage>
											$from_text	= $from->appendChild( $xml->createTextNode( $data->blogname . '&lt;' . $data->user_email . '&gt;' ) ); // insert text  in to <from></from>
											$to			= $message->appendChild( $xml->createElement( 'cnttfrmtdb_to' ) );// insert <to></to> in to <message></messsage>
											$to_text	= $to->appendChild( $xml->createTextNode( $data->email ) );// insert text  in to <to></to>
											if ( '' !=  $data->subject ) {
												$subject		= $message->appendChild( $xml->createElement( 'cnttfrmtdb_subject' ) );// insert <subject></subject> in to <message></messsage>
												$subject_text	= $subject->appendChild( $xml->createTextNode( $data->subject ) );// insert text  in to <subject></subject>
											}
											$send_date	= $message->appendChild( $xml->createElement( 'cnttfrmtdb_send_date' ) );// insert <send_date></send_date> in to <message></messsage>
											$data_text	= $send_date->appendChild( $xml->createTextNode( $data->send_date ) );// insert text  in to <send_date></send_date>
											$content	= $message->appendChild( $xml->createElement( 'cnttfrmtdb_content' ) );// insert <content></content> in to <message></messsage>
											if ( '' !=  $data->subject ) {
												$name				= $content->appendChild( $xml->createElement( 'cnttfrmtdb_name' ) );// insert <name></name> in to <content></content>
												$name_text	= $name->appendChild( $xml->createTextNode( $data->from_user ) );// insert text  in to <name></name>
											}
											if ( isset( $data_address ) && '' != $data_address ) {
												$address		= $content->appendChild( $xml->createElement( 'cnttfrmtdb_address' ) );// insert <address></address> in to <content></content>
												$address_text	= $address->appendChild( $xml->createTextNode( $data_address ) );// insert text  in to <address></address>
											}
											if ( '' !=  $data->user_email ) {
												$from_email			= $content->appendChild( $xml->createElement( 'cnttfrmtdb_from_email' ) );// insert <from_email></from_email> in to <content></content>
												$from_email_text	= $from_email->appendChild( $xml->createTextNode( $data->user_email ) );// insert text  in to <from_email></from_email>
											}
											if ( isset( $data_phone ) && '' !=  $data_phone ) {
												$phone			= $content->appendChild( $xml->createElement( 'cnttfrmtdb_phone' ) );// insert <phone></phone> in to <content></content>
												$phone_text		= $phone->appendChild( $xml->createTextNode( $data_phone ) );// insert text  in to <phone></phone>
											}
											if ( '' !=  $data->message_text ) {
												$text			= $content->appendChild( $xml->createElement( 'cnttfrmtdb_text' ) );// insert <text></text> in to <content></content>
												$message_text	= $text->appendChild( $xml->createTextNode( $data->message_text ) );//insert message text in to <text></text>
											}
											$hosted_site		= $content->appendChild( $xml->createElement( 'cnttfrmtdb_hosted_site' ) );// insert <hosted_site></hosted_site> in to <content></content>
											$hosted_site_text	= $hosted_site->appendChild( $xml->createTextNode( $data->site ) );// insert text in to <hosted_site></hosted_site>
											$sent_from_refer	= $content->appendChild( $xml->createElement( 'cnttfrmtdb_sent_from_refer' ) ); // insert <sent_from_refer></sent_from_refer> in to <content></content>
											$refer_text			= $sent_from_refer->appendChild( $xml->createTextNode( $data->refer ) );// insert text in to <sent_from_refer></sent_from_refer>
											if ( isset( $data_user_agent ) && '' !=  $data_user_agent ) {
												$user_agent			= $content->appendChild( $xml->createElement( 'cnttfrmtdb_user_agent' ) );// insert <user_agent></user_agent> in to <content></content>
												$user_agent_text	= $user_agent->appendChild( $xml->createTextNode( $data_user_agent ) );// insert text in to <user_agent></user_agent>
											}											
										}
										
									// forming file in "EML" format
									} elseif ( 'eml' == $cntctfrmtdb_options['cntctfrmtdb_format_save_messages'] ) {
										foreach ( $message_data as $data ) {
											foreach ( $additional_fields as $field ) {
												if ( 'address' == $field->name )
													$data_address = $field->field_value;
												elseif ( 'phone' == $field->name )
													$data_phone = $field->field_value;
												elseif ( 'user_agent' == $field->name )
													$data_user_agent = $field->field_value;
											}
														
											$message_text .= 
												'<html>
													<head>
														<title>'. __( "Contact from to DB", 'contact_form' );
											if ( '' !=  $data->blogname ) {
												$message_text .= $data->blogname;
											} else {
												$message_text .= get_bloginfo( 'name' );
											}
											$message_text .= 
												'</title>
													</head>
														<body>
															<p>' . __( 'This message was re-sent from ', 'contact_form_to_db' ) . home_url() . '</p>
															<table>
																<tr>
																	<td width="160">'. __( "Name", 'contact_form_to_db' ) . '</td><td>' . $data->from_user . '</td>
																</tr>';
											if ( isset( $data_address ) && '' !=  $data_address ) {
												$message_text .= 
												'<tr>
													<td>'. __( "Address", 'contact_form_to_db' ) . '</td><td>'. $data_address .'</td>
												</tr>';
											}
											$message_text .= 
												'<tr>	
													<td>'. __( "Email", 'contact_form_to_db' ) .'</td><td>'. $data->user_email .'</td>
												</tr>';
											if ( isset( $data_address ) && '' !=  $data_phone ) {
												$message_text .= 
												'<tr>
													<td>'. __( "Phone", 'contact_form_to_db' ) . '</td><td>'. $data_phone .'</td>
												</tr>';
											}
											$message_text .=
												'<tr>
													<td>' . __( "Subject", 'contact_form_to_db' ) . '</td><td>'. $data->subject .'</td>
												</tr>
												<tr>
													<td>' . __( "Message", 'contact_form_to_db' ) . '</td><td>'. $data->message_text .'</td>
												</tr>
												<tr>
													<td>' . __( 'Site', 'contact_form_to_db' ) . '</td><td>'. $data->site .'</td>
												</tr>
												<tr>
													<td><br /></td><td><br /></td>
												</tr>
												<tr>
													<td><br /></td><td><br /></td>
												</tr>';
											if ( 1 == $cntctfrm_options_for_this_plugin['cntctfrm_display_sent_from'] ) {
												$message_text .= 
												'<tr>
													<td>' . __( 'Sent from (ip address)', 'contact_form_to_db' ) . ':</td><td>' . $_SERVER['REMOTE_ADDR'] . " ( " . @gethostbyaddr( $_SERVER['REMOTE_ADDR'] ) ." )".'</td>
												</tr>';
											}
											$message_text .= 
												'<tr>
													<td>' . __( 'Date/Time', 'contact_form_to_db' ) . ':</td><td>' . date_i18n( get_option( 'date_format' ) . ' ' . get_option( 'time_format' ), strtotime( $data->send_date ) ) . '</td>
												</tr>';
											if ( '' !=  $data->refer ) {
												$message_text .=
												'<tr>
													<td>' . __( 'Sent from (referer)', 'contact_form_to_db' ) . ':</td><td>' . $data->refer . '</td>
												</tr>';
											}
											if ( isset( $data_user_agent ) && '' !=  $data_user_agent ) {
												$message_text .=
												'<tr>
													<td>' .__( 'Sent from (referer)', 'contact_form' ) . ':</td><td>' . $data_user_agent . '</td>
												</tr>';
											}
											$message_text .=
														'</table>
													</body>
												</html>';
										}
										// get headers
										$headers = '';
										$headers .= 'MIME-Version: 1.0' . "\n";
										$headers .= 'Content-type: text/html; charset=utf-8' . "\n";
										if ( 'custom' == $cntctfrm_options_for_this_plugin['cntctfrm_from_email'] )
											$headers .= __( 'From: ', 'contact_form_to_db' ) . stripslashes( $cntctfrm_options_for_this_plugin['cntctfrm_from_field'] ) . ' <' . stripslashes( $cntctfrm_options_for_this_plugin['cntctfrm_custom_from_email'] ) . '>' . "\n";	
										else
											$headers .= __( 'From: ', 'contact_form_to_db' ) . stripslashes( $cntctfrm_options_for_this_plugin['cntctfrm_from_field'] ) . ' <' . $data->user_email . '>' . "\n";
										$headers .= __( 'To: ', 'contact_form_to_db' ) . $data->email . "\n";
										$headers .= __( 'Subject: ', 'contact_form_to_db' ) . $data->subject . "\n";
										$headers .= __( 'Date/Time: ', 'contact_form_to_db' ) . date_i18n( get_option( 'date_format' ) . ' ' . get_option( 'time_format' ), strtotime( current_time( 'mysql' ) ) ) . "\n";

										$message = $headers . $message_text;
										// generate a file name
										$random_prefix = $random_number + $i; //add numeric prefix to file name
										$i ++; // to names have been streamlined
										$file_name = 'message_' . 'ID_' . $id . '_' . $random_prefix . '.eml';
										if ( 'download_messages' == $action ) { 
											// add message to zip-archive if need save a several messages
											if ( class_exists( 'ZipArchive' ) ) {
												$zip->addFromString( $file_name, $message ); // add file content to zip - archive
												$counter ++;
											}
										} else {
											//save message to local computer if need save a single message
											if ( file_exists( $save_file_path . '/' . $file_name ) )
												$file_name = time() . '_' . $file_name;
											$fp = fopen( $save_file_path . '/' . $file_name, 'w');
											fwrite( $fp, $message );
											$file_created = fclose( $fp );
											if ( '0' != $file_created ) {
												header( 'Content-Description: File Transfer' );
												header( 'Content-Type: application/force-download' );
												header( 'Content-Disposition: attachment; filename=' . $file_name );
												header( 'Content-Transfer-Encoding: binary' );
												header( 'Expires: 0' );
												header( 'Cache-Control: must-revalidate');
												header( 'Pragma: public' );
												header( 'Content-Length: ' . filesize( $save_file_path . '/' . $file_name )  );
												flush();
												$file_downloaded = readfile( $save_file_path . '/' . $file_name );
												if ( $file_downloaded )
													unlink( $save_file_path . '/' . $file_name );
											} else {
												$error_counter ++;
											}
										}
									// forming files in to "CSV" format
									} elseif ( 'csv' == $cntctfrmtdb_options['cntctfrmtdb_format_save_messages'] ) {
										$count_messages = count( $message_id ); // number of messages which was chosen for downloading
										//we get enclosure anf separator from option
										$enclosure = stripslashes( $cntctfrmtdb_options['cntctfrmtdb_csv_enclosure'] );
										if ( 't' == $cntctfrmtdb_options['cntctfrmtdb_csv_separator'] )
											$separator = "\\" . stripslashes( $cntctfrmtdb_options['cntctfrmtdb_csv_separator'] );
										else
											$separator = stripslashes( $cntctfrmtdb_options['cntctfrmtdb_csv_separator'] );
										// forming file content 
										foreach ( $message_data as $data ) {
											foreach ( $additional_fields as $field ) {
												if ( 'address' == $field->name ) 
													$data_address = $field->field_value;
												elseif ( 'phone' == $field->name )
													$data_phone = $field->field_value;
												elseif ( 'user_agent' == $field->name )
													$data_user_agent = $field->field_value;
											}
											
											if ( ! isset( $message ) ) 
												$message = '';
											if( 'custom' == $cntctfrm_options_for_this_plugin['cntctfrm_from_email'] )
												$message .= $enclosure . stripslashes( $cntctfrm_options_for_this_plugin['cntctfrm_from_field'] ) . ' <' . stripslashes( $cntctfrm_options_for_this_plugin['cntctfrm_custom_from_email'] ) . '>' . $enclosure . $separator ;
											else
												$message .= $enclosure . stripslashes( $cntctfrm_options_for_this_plugin['cntctfrm_from_field'] ) . ' <' . $data->user_email . '>' . $enclosure . $separator ; 
											$message .= $enclosure . $data->email . $enclosure . $separator;
											if ( '' !=  $data->subject )
												$message .= $enclosure . $data->subject . $enclosure . $separator;
											if ( '' !=  $data->message_text )
												$message .= $enclosure . $data->message_text . $enclosure . $separator;
											$message .= $enclosure . date_i18n( get_option( 'date_format' ) . ' ' . get_option( 'time_format' ), strtotime( $data->send_date ) ) . $enclosure . $separator;
											$message .= $enclosure . $data->from_user . $enclosure . $separator;
											if ( isset( $data_address ) && '' !=  $data_address ) 
												$message .= $enclosure . $data_address . $enclosure . $separator;
											if ( '' !=  $data->user_email )
												$message .= $enclosure . $data->user_email . $enclosure . $separator;
											if ( isset( $data_phone ) && '' !=  $data_phone )
												$message .= $enclosure . $data_phone . $enclosure . $separator;
											$message .= $enclosure . $data->site . $enclosure . $separator;
											if ( 1 == $cntctfrm_options_for_this_plugin['cntctfrm_display_sent_from'] ) {
												$message .= $enclosure . __( 'Sent from (ip address): ', 'contact_form_to_db' ) . $_SERVER['REMOTE_ADDR'] . " ( " . @gethostbyaddr( $_SERVER['REMOTE_ADDR'] ) ." )" . $enclosure . $separator; 
											}

											if ( '' !=  $data->refer ) {
												$message .= $enclosure . $data->refer . $enclosure . $separator;
											}
											if ( isset( $data_user_agent ) && '' !=  $data_user_agent ) {
												$message .= $enclosure . $data_user_agent . $enclosure . $separator;
											}												
											// if was chosen only one message
											if ( 1 == $count_messages ) {
												// saving file to local computer
												$file_name = 'message_' . 'ID_' . $id . '_' . $random_number . '.csv';
												if ( file_exists( $save_file_path . '/' . $file_name ) )
													$file_name = time() . '_' . $file_name;
												$fp = fopen( $save_file_path . '/' . $file_name, 'w');
												fwrite( $fp, $message );
												$file_created = fclose( $fp );
												if ( '0' != $file_created ) {
													header( 'Content-Description: File Transfer' );
													header( 'Content-Type: application/force-download' );
													header( 'Content-Disposition: attachment; filename=' . $file_name );
													header( 'Content-Transfer-Encoding: binary' );
													header( 'Expires: 0' );
													header( 'Cache-Control: must-revalidate');
													header( 'Pragma: public' );
													header( 'Content-Length: ' . filesize( $save_file_path . '/' . $file_name )  );
													flush();
													$file_downloaded = readfile( $save_file_path . '/' . $file_name );
													if ( $file_downloaded )
														unlink( $save_file_path . '/' . $file_name );
												} else {
													$error_counter ++;
												}
											// if was chosen more then one message
											} elseif ( 1 < $count_messages ) {
												$message .= "\n";
											}
										}
									} else {
										$error_counter ++;
										$unknown_format = 1;
									}
								}
								break;
							case 'download_attachment':
							case 'download_attachments':
								
								break;
							case 'delete_message':
							case 'delete_messages':
								if ( ( ( isset( $_POST['action'] ) || isset( $_POST['action2'] ) ) && ( $action == $_POST['action'] || $action == $_POST['action2'] ) && check_admin_referer( plugin_basename( __FILE__ ), 'cntctfrmtdb_manager_nonce_name' ) ) || ( isset( $_GET['action'] ) && $action == $_GET['action'] && check_admin_referer( 'cntctfrmtdb_delete_message' . $id ) ) ) {
									// delete all records about choosen message from database 
									$error = 0;
									$wpdb->query( "DELETE FROM `" . $prefix . "message` WHERE " . $prefix . "message.id=" . $id );
									$error += $wpdb->last_error ? 1 : 0;
									$wpdb->query( "DELETE FROM `" . $prefix . "field_selection` WHERE `message_id`=" . $id );	
									$error += $wpdb->last_error ? 1 : 0;									
									if ( 0 == $error ) {
										$counter++;
									} else {
										$error_counter++;
									}
								}
								break;
							// marking messages as Spam
							case 'spam':
								if ( ( ( isset( $_POST['action'] ) || isset( $_POST['action2'] ) ) && ( $action == $_POST['action'] || $action == $_POST['action2'] ) && check_admin_referer( plugin_basename( __FILE__ ), 'cntctfrmtdb_manager_nonce_name' ) ) || ( isset( $_GET['action'] ) && $action == $_GET['action'] && check_admin_referer( 'cntctfrmtdb_spam' . $id ) ) ) {
									$wpdb->update( $prefix . 'message', array( 'status_id' => 2 ), array( 'id' => $id ) );
									if ( ! 0 == $wpdb->last_error ) 
										$error_counter ++; 
									else
										$counter ++;
								}
								break;
							// marking messages as Trash
							case 'trash':
								if ( ( ( isset( $_POST['action'] ) || isset( $_POST['action2'] ) ) && ( $action == $_POST['action'] || $action == $_POST['action2'] ) && check_admin_referer( plugin_basename( __FILE__ ), 'cntctfrmtdb_manager_nonce_name' ) ) || ( isset( $_GET['action'] ) && $action == $_GET['action'] && check_admin_referer( 'cntctfrmtdb_trash' . $id ) ) ) {
									$wpdb->update( $prefix . 'message', array( 'status_id' => 3 ), array( 'id' => $id ) );
									if ( ! 0 == $wpdb->last_error ) 
										$error_counter ++; 
									else
										$counter ++;
								}
								break;
							case 'unspam':
							case 'restore':
								if ( ( ( isset( $_POST['action'] ) || isset( $_POST['action2'] ) ) && ( $action == $_POST['action'] || $action == $_POST['action2'] ) && check_admin_referer( plugin_basename( __FILE__ ), 'cntctfrmtdb_manager_nonce_name' ) ) || ( isset( $_GET['action'] ) && $action == $_GET['action'] && check_admin_referer( 'cntctfrmtdb_unspam_restore_undo' . $id ) ) ) {
									if ( isset( $_REQUEST['old_status'] ) && '' != $_REQUEST['old_status'] ) {
										$wpdb->update( $prefix . 'message', array( 'status_id' => $_REQUEST['old_status'] ), array( 'id' => $id ) );
									} else {
										$wpdb->update( $prefix . 'message', array( 'status_id' => 1 ), array( 'id' => $id ) );
									}
									if ( ! 0 == $wpdb->last_error ) 
										$error_counter ++; 
									else
										$counter ++;
								}
								break;
							case 'undo':
								if ( ( isset( $_GET['action'] ) && $action == $_GET['action'] && check_admin_referer( 'cntctfrmtdb_unspam_restore_undo' . $_REQUEST['message_id'][0] ) ) ) {
									if ( isset( $_REQUEST['old_status'] ) && '' != $_REQUEST['old_status'] ) {
										$wpdb->update( $prefix . 'message', array( 'status_id' => $_REQUEST['old_status'] ), array( 'id' => $id ) );
									} else {
										$wpdb->update( $prefix . 'message', array( 'status_id' => 1 ), array( 'id' => $id ) );
									}
									if ( ! 0 == $wpdb->last_error ) 
										$error_counter ++; 
									else
										$counter ++;
								}
								break;
							case 'change_status':
								if ( isset( $_GET['action'] ) && $action == $_GET['action'] && check_admin_referer( 'cntctfrmtdb_change_status' . $id ) ) {
									$new_status = $_REQUEST['status'] + 1;
									if ( 3 <  $new_status || 1 > $new_status ) 
										$new_status = 1;
									$wpdb->update( $prefix . 'message', array( 'status_id' => $new_status ), array( 'id' => $id ) );
									break;
									if ( ! 0 == $wpdb->last_error ) 
										$error_counter ++;
								}
								break;
							case 'change_read_status':
								if ( isset( $_GET['action'] ) && $action == $_GET['action'] && check_admin_referer( 'cntctfrmtdb_change_read_status' . $id ) ) {
									$wpdb->update( $prefix . 'message', array( 'was_read' => 1 ), array( 'id' => $id ) );
									if ( ! 0 == $wpdb->last_error ) 
										$error_counter ++;
								}
								break;
							default:
								$unknown_action = 1;
								break;
						}
					}
				} // end of foreach
				// create zip-archives is possible and one embodiment of the:
				// 1) need to save several messages in "csv"-format
				// 2) need to save several messages in "eml"-format
				if ( 'download_messages' == $action && ( 'csv' == $cntctfrmtdb_options['cntctfrmtdb_format_save_messages'] || 'eml' == $cntctfrmtdb_options['cntctfrmtdb_format_save_messages'] ) ) {
					if ( class_exists( 'ZipArchive' ) ) {
						if ( 'download_messages' == $action && 1 < count( $message_id ) && 'csv' == $cntctfrmtdb_options['cntctfrmtdb_format_save_messages'] ) {
							$file_name = 'messages.csv';
							$zip->addFromString( $file_name, $message ); // add file content to zip - archive
						}
						$zip->close();
						if ( file_exists( $zip_name ) ) {
							// saving file to local computer
							header( 'Content-Description: File Transfer' );
							header( 'Content-Type: application/x-zip-compressed' );
							header( 'Content-Disposition: attachment; filename=' . time() . '.zip' );
							header( 'Content-Transfer-Encoding: binary' );
							header( 'Expires: 0' );
							header( 'Cache-Control: must-revalidate' );
							header( 'Pragma: public' );
							header( 'Content-Length: ' . filesize( $zip_name ) );
							flush();
							$file_downloaded = readfile( $zip_name );
							if ( $file_downloaded )
								unlink( $zip_name );
						}
					} else {
						$can_not_create_zip = 1;
					}
				} 
				if ( 'download_messages' == $action && 1 < count( $message_id ) ) {
					// saving single chosen "csv"-file to local computer if content of attachment was include in csv
					$file_name = 'messages.csv';
					if ( file_exists( $save_file_path . '/' . $file_name ) )
						$file_name = time() . '_' . $file_name;
					$fp = fopen( $save_file_path . '/' . $file_name, 'w');
					fwrite( $fp, $message );
					$file_created = fclose( $fp );
					if ( '0' != $file_created ) {
						header( 'Content-Description: File Transfer' );
						header( 'Content-Type: application/force-download' );
						header( 'Content-Disposition: attachment; filename=' . $file_name );
						header( 'Content-Transfer-Encoding: binary' );
						header( 'Expires: 0' );
						header( 'Cache-Control: must-revalidate');
						header( 'Pragma: public' );
						header( 'Content-Length: ' . filesize( $save_file_path . '/' . $file_name )  );
						flush();
						$file_downloaded = readfile( $save_file_path . '/' . $file_name );
						if ( $file_downloaded )
							unlink( $save_file_path . '/' . $file_name );
					} else {
						$error_counter ++;
					}
				}
				// saving "xml"-file to local computer
				if ( in_array( $action, array( 'download_message', 'download_messages' ) ) && 'xml' == $cntctfrmtdb_options['cntctfrmtdb_format_save_messages'] ) {
					if ( 'download_message' == $action ) {
						$random_prefix = $random_number; //name prefix
						$file_name = 'message_' . 'ID_' . $id . '_' . $random_prefix . '.xml';
					} else {
						$file_name = 'messages_' . time() . '.xml';
					}
					$file_xml = $xml->saveXML(); //create string with file content
					if( '' != $file_xml ) {
						if ( file_exists( $save_file_path . '/' . $file_name ) )
							$file_name = time() . '_' . $file_name;
						$fp = fopen( $save_file_path . '/' . $file_name, 'w');
						fwrite( $fp, $file_xml );
						$file_created = fclose( $fp );
						if ( '0' != $file_created ) {
							header( 'Content-Description: File Transfer' );
							header( 'Content-Type: application/force-download' );
							header( 'Content-Disposition: attachment; filename=' . $file_name );
							header( 'Content-Transfer-Encoding: binary' );
							header( 'Expires: 0' );
							header( 'Cache-Control: must-revalidate');
							header( 'Pragma: public' );
							header( 'Content-Length: ' . filesize( $save_file_path . '/' . $file_name )  );
							flush();
							$file_downloaded = readfile( $save_file_path . '/' . $file_name );
							if ( $file_downloaded )
								unlink( $save_file_path . '/' . $file_name );
						} else {
							$error_counter ++;
						}
					} else {
						$can_not_create_xml = 1;
					}
						
				}
				//display the operation results or error messages
				switch ( $action ) {
					case 'download_message':
					case 'download_messages':
						if ( 0 != $can_not_create_xml ) {
							$cntctfrmtdb_error_message = __( 'Can not create XML-files.', 'contact_form_to_db' );
						}
						if ( 0 != $can_not_create_zip ) {
							if ( '' == $cntctfrmtdb_error_message ) { 
								$cntctfrmtdb_error_message = __( 'Can not create ZIP-archive.', 'contact_form_to_db' );
							} 
						}
						if ( isset( $unknown_format ) )
							$cntctfrmtdb_error_message = __( 'Unknown format.', 'contact_form_to_db' );
						break;
					case 'download_attachment':
					case 'download_attachments':
						
						break;
					case 'delete_message':
					case 'delete_messages':
						if ( ( ( isset( $_POST['action'] ) || isset( $_POST['action2'] ) ) && ( $action == $_POST['action'] || $action == $_POST['action2'] ) && check_admin_referer( plugin_basename( __FILE__ ), 'cntctfrmtdb_manager_nonce_name' ) ) || ( isset( $_GET['action'] ) && $action == $_GET['action'] && check_admin_referer( 'cntctfrmtdb_delete_message' . $id ) ) ) {
							if ( 0 == $error_counter ) {
								$cntctfrmtdb_done_message = sprintf( _nx( __( 'One message was deleted successfully.', 'contact_form_to_db' ), '%s&nbsp;' . __( 'messages were deleted successfully.', 'contact_form_to_db' ), $counter, 'contact_form_to_db' ), number_format_i18n( $counter ) );
							} else { 
								$cntctfrmtdb_error_message = __( 'There are some problems while deleting message.', 'contact_form_to_db' );
							}
						}
						break;
					case 'spam':
						if ( ( ( isset( $_POST['action'] ) || isset( $_POST['action2'] ) ) && ( $action == $_POST['action'] || $action == $_POST['action2'] ) && check_admin_referer( plugin_basename( __FILE__ ), 'cntctfrmtdb_manager_nonce_name' ) ) || ( isset( $_GET['action'] ) && $action == $_GET['action'] && check_admin_referer( 'cntctfrmtdb_spam' . $id ) ) ) {
							$ids = '';
							if ( 0 == $error_counter ) {
								if ( 1 < count( $message_id ) ) {
									// get ID`s of message to string in format "1,2,3,4,5" to add in action link
									foreach( $message_id as $value )
										$ids .= $value . ',';
								} else {
									$ids = $message_id['0'];
								}
								$cntctfrmtdb_done_message = sprintf( _nx( __( 'One message was marked as Spam.', 'contact_form_to_db' ), '%s&nbsp;' . __( 'messages were marked as Spam.', 'contact_form_to_db' ), $counter, 'contact_form_to_db' ), number_format_i18n( $counter ) );
								$cntctfrmtdb_done_message .= ' <a href="' . wp_nonce_url( '?page=cntctfrmtdb_manager&action=undo&message_id[]=' . $ids, 'cntctfrmtdb_unspam_restore_undo' . $ids ) . '">' . __( 'Undo', 'contact_form_to_db' ) . '</a>';
							} else {
								$cntctfrmtdb_error_message = __( 'Problems while marking messages as Spam.', 'contact_form_to_db' );
							}
						}
						break;
					case 'trash':
						if ( ( ( isset( $_POST['action'] ) || isset( $_POST['action2'] ) ) && ( $action == $_POST['action'] || $action == $_POST['action2'] ) && check_admin_referer( plugin_basename( __FILE__ ), 'cntctfrmtdb_manager_nonce_name' ) ) || ( isset( $_GET['action'] ) && $action == $_GET['action'] && check_admin_referer( 'cntctfrmtdb_trash' . $id ) ) ) {
							$ids = '';
							if ( 0 == $error_counter ) {
								if ( 1 < count( $message_id ) ) {
									// get ID`s of message to string in format "1,2,3,4,5" to add in action link
									foreach( $message_id as $value )
										$ids .= $value . ',';
								} else {
									$ids = $message_id['0'];
								}
								$cntctfrmtdb_done_message = sprintf( _nx( __( 'One message was moved to Trash.', 'contact_form_to_db' ), '%s&nbsp;' . __( 'messages were moved to Trash.', 'contact_form_to_db' ), $counter, 'contact_form_to_db' ), number_format_i18n( $counter ) ); 
								$cntctfrmtdb_done_message .= ' <a href="' . wp_nonce_url( '?page=cntctfrmtdb_manager&action=undo&message_id[]=' . $ids, 'cntctfrmtdb_unspam_restore_undo' . $ids ) . '">' . __( 'Undo', 'contact_form_to_db' ) . '</a>';
							} else {
								$cntctfrmtdb_error_message .= __( "Problems while moving messages to Trash.", "contact_form_to_db" ) . __( " Please, try it later.", "contact_form_to_db" ); 
							}
						}
						break;
					case 'unspam':
					case 'restore':
						if ( ( ( isset( $_POST['action'] ) || isset( $_POST['action2'] ) ) && ( $action == $_POST['action'] || $action == $_POST['action2'] ) && check_admin_referer( plugin_basename( __FILE__ ), 'cntctfrmtdb_manager_nonce_name' ) ) || ( isset( $_GET['action'] ) && $action == $_GET['action'] && check_admin_referer( 'cntctfrmtdb_unspam_restore_undo' . $id ) ) ) {
							if ( 0 == $error_counter ) {
								$cntctfrmtdb_done_message = sprintf ( _nx( __( 'One message was restored.', 'contact_form_to_db' ), '%s&nbsp;' . __( 'messages were restored.', 'contact_form_to_db' ), $counter, 'contact_form_to_db' ), number_format_i18n( $counter ) );
							} else {
								$cntctfrmtdb_error_message = __( 'Problems during the restoration messages', 'contact_form_to_db' ); 
							}
						}
						break;
					case 'undo':
						if ( ( isset( $_GET['action'] ) && $action == $_GET['action'] && check_admin_referer( 'cntctfrmtdb_unspam_restore_undo' . $_REQUEST['message_id'][0] ) ) ) {
							if ( 0 == $error_counter ) {
								$cntctfrmtdb_done_message = sprintf ( _nx( __( 'One message was restored.', 'contact_form_to_db' ), '%s&nbsp;' . __( 'messages were restored.', 'contact_form_to_db' ), $counter, 'contact_form_to_db' ), number_format_i18n( $counter ) );
							} else {
								$cntctfrmtdb_error_message = __( 'Problems during the restoration messages', 'contact_form_to_db' ); 
							}
						}
						break;
					case 'change_status':
						if ( isset( $_GET['action'] ) && $action == $_GET['action'] && check_admin_referer( 'cntctfrmtdb_change_status' . $id ) ) {
							if ( 0 == $error_counter ) {
								switch ( $new_status ) {
									case 1:
										$cntctfrmtdb_done_message = __( 'One message was marked as Normal.', 'contact_form_to_db' );
										 break;
									case 2: 
										$cntctfrmtdb_done_message = __( 'One message was marked as Spam.', 'contact_form_to_db' ) . ' <a href="' . wp_nonce_url( '?page=cntctfrmtdb_manager&action=undo&message_id[]=' .  $id . '&old_status=' . $_REQUEST['status'], 'cntctfrmtdb_unspam_restore_undo' . $id ) . '">' . __( 'Undo', 'contact_form_to_db' ) . '</a>';
										break;
									case 3:
										$cntctfrmtdb_done_message = __( 'One message was marked as Trash.', 'contact_form_to_db' ) . ' <a href="' . wp_nonce_url( '?page=cntctfrmtdb_manager&action=undo&message_id[]=' .  $id . '&old_status=' . $_REQUEST['status'], 'cntctfrmtdb_unspam_restore_undo' . $id ) . '">' . __( 'Undo', 'contact_form_to_db' ) . '</a>';
										break;
									default:
										$cntctfrmtdb_error_message = __( 'Unknown result.', 'contact_form_to_db' ); 
										break;
								}
							} else { 
								$cntctfrmtdb_error_message = __( 'Problems while changing status of message.', 'contact_form_to_db' );
							}
						}
						break;
					case 'change_read_status':
						break;
					default:
						if ( 1 == $unknown_action ) { 
								$cntctfrmtdb_error_message = __( 'Unknown action.', 'contact_form_to_db' );
						} else {
							$cntctfrmtdb_error_message = __( 'Can not display results.', 'contact_form_to_db' );
						}
						break;
				}
			} else {
				if ( ! ( in_array( $_REQUEST['action'], array( 'cntctfrmtdb_show_attachment', 'cntctfrmtdb_read_message', 'cntctfrmtdb_change_staus' )  ) || isset( $_REQUEST['s'] ) ) ) {
					$cntctfrmtdb_error_message = __( 'Can not handle request. May be you need choose some messages to handle them.', 'contact_form_to_db' );
				}
			}
		}
	}
}
/*
* Function to get data in message list
*/
if ( ! function_exists( 'cntctfrmtdb_get_message_list' ) ) {
	function cntctfrmtdb_get_message_list() {
		global $wpdb, $cntctfrmtdb_options;
		$prefix = $wpdb->prefix . 'cntctfrmtdb_';
		$start_row = 0;
		if ( isset( $_REQUEST['paged'] ) && '1' != $_REQUEST['paged'] ) {
			$start_row = $cntctfrmtdb_options['cntctfrmtdb_messages_per_page'] * ( absint( $_REQUEST['paged'] - 1 ) );
		}
		$sql_query = "SELECT * FROM " . $prefix . "message ";
		if ( isset( $_REQUEST['message_status'] ) ) {
			// depending on request display different list of messages
			if ( 'sent' == $_REQUEST['message_status'] ) {
				$sql_query .= "WHERE " . $prefix . "message.sent=1 AND " . $prefix . "message.status_id NOT IN (2,3)";
			} elseif ( 'not_sent' == $_REQUEST['message_status'] ) {
				$sql_query .= "WHERE " . $prefix . "message.sent=0 AND " . $prefix . "message.status_id NOT IN (2,3)";
			} elseif ( 'read_messages' == $_REQUEST['message_status'] ) {
				$sql_query .= "WHERE " . $prefix . "message.was_read=1 AND " . $prefix . "message.status_id NOT IN (2,3)";
			} elseif ( 'not_read_messages' == $_REQUEST['message_status'] ) {
				$sql_query .= "WHERE " . $prefix . "message.was_read=0 AND " . $prefix . "message.status_id NOT IN (2,3)";
			} elseif ( 'has_attachment' == $_REQUEST['message_status'] ) {
				$sql_query .= "WHERE " . $prefix . "message.attachment_status<>0 AND " . $prefix . "message.status_id NOT IN (2,3)";
			} elseif ( 'all' == $_REQUEST['message_status'] ) {
				$sql_query .= "WHERE " . $prefix . "message.status_id=1";
			} elseif ( 'spam' == $_REQUEST['message_status'] ) {
				$sql_query .= "WHERE " . $prefix . "message.status_id=2";
			} elseif ( 'trash' == $_REQUEST['message_status'] ) {
				$sql_query .= "WHERE " . $prefix . "message.status_id=3";
			}
		} else {
			$sql_query .= "WHERE " . $prefix . "message.status_id=1";
		}
		$sql_query .= " ORDER BY send_date DESC LIMIT " . $cntctfrmtdb_options['cntctfrmtdb_messages_per_page'] . " OFFSET " . $start_row;
		$messages = $wpdb->get_results( $sql_query );
		$i = 0;
		$attachments_icon = '';
		$list_of_messages = array();
		foreach ( $messages as $value ) { 
			// fill "status" column 
			$the_message_status = '<a href="' . wp_nonce_url( '?page=cntctfrmtdb_manager&action=change_status&status=' . $value->status_id . '&message_id[]=' . $value->id, 'cntctfrmtdb_change_status' . $value->id ) .  '">';
			if ( '1' == $value->status_id )
				$the_message_status .= '<div class="cntctfrmtdb-letter" title="'. __( 'Mark as Spam', 'contact_form_to_db' ) . '">' . $value->status_id . '</div>';
			elseif ( '2' == $value->status_id )
				$the_message_status .= '<div class="cntctfrmtdb-spam" title="'. __( 'Mark as Trash', 'contact_form_to_db' ) . '">' . $value->status_id . '</div>';
			elseif ( '3' == $value->status_id )
				$the_message_status .= '<div class="cntctfrmtdb-trash" title="'. __( 'in Trash', 'contact_form_to_db' ) . '">' . $value->status_id . '</div>';
			else
				$the_message_status .= '<div class="cntctfrmtdb-unknown" title="'. __( 'unknown status', 'contact_form_to_db' ) . '">' . $value->status_id . '</div>';
			$the_message_status .= '</a>';
			$from_data = '<a class="from-name';
			if ( '1' != $value->was_read )
				$from_data .= ' not-read-message" href="' . wp_nonce_url( '?page=cntctfrmtdb_manager&action=change_read_status&message_id[]=' . $value->id, 'cntctfrmtdb_change_read_status' . $value->id ) . '">';
			else
				$from_data .= '" href="javascript:void(0);">'; 
			if ( '' !=  $value->from_user )
				$from_data .= $value->from_user;
			else
				$from_data .= '<i>' . __( '- Unknown name -', 'contact_form_to_db' ) . '</i>';
			$from_data .= '</a>';
			// fill "from" column
			$add_from_data = '';
			if ( '' !=  $value->user_email )
				$add_from_data .= '<strong>email: </strong>' . $value->user_email . '</br>';
			$additional_filelds = $wpdb->get_results( "SELECT `cntctfrm_field_id`, `field_value`, `name` 
FROM `" . $prefix . "field_selection` INNER JOIN `" . $wpdb->prefix . "cntctfrm_field` ON `cntctfrm_field_id`=`id` WHERE `message_id`='" . $value->id . "'" );
			if ( '' !=  $additional_filelds ) {
				foreach ( $additional_filelds as $field ) {
					$field_name = $wpdb->get_var( "SELECT `name` FROM `" . $wpdb->prefix . "cntctfrm_field` WHERE `id`='" . $field->cntctfrm_field_id . "'");
					if ( 'user_agent' != $field->name )
						$add_from_data .= $field->name . ': ' . $field->field_value . '</br>';
				}
			}
			$to_email = $wpdb->get_var( "SELECT `email` FROM `" . $prefix . "to_email` WHERE `id`='" . $value->to_id . "'" );
			$add_from_data .= '<strong>to: </strong>' . $to_email;
			if ( '' !=  $add_from_data ) {
				$from_data .= '<div class="from-info">' . $add_from_data . '</div>';
			}
			// fill "message" column and "attachment" column
			$message_content = '<div class="message-container">
				<div class="message-text"><strong>' . $value->subject . '</strong> - ';
				if ( '' !=  $value->message_text ) 
					$message_content .= $value->message_text . '</div>';
				else
					$message_content .= '<i>' . __( ' - No text in this message - ', 'contact_form_to_db' ) . '</i></div>';

			if ( $value->attachment_status != 0 ) {
				// display thumbnail
				$message_content .= '<table class="attachments-preview">
						<tbody>
							<tr class="attachment-img  bws_pro_version" align="center">
								<td class="attachment-info" valign="middle">
									<span>Attachment name</span></br>
									<span>Attachment size</span></br>
									<span><a class="cntctfrmtdb-download-attachment bws_plugin_menu_pro_version" title="' . __( "This option is available in Pro version", "contact_form_to_db" ) . '" href="#">' . __( 'Download', 'contact_form_to_db' ) . '</a></span></br>
									<span><a class="bws_plugin_menu_pro_version" title="' . __( "This option is available in Pro version", "contact_form_to_db" ) . '" href="#">' . __( 'View', 'contact_form_to_db' ) . '</a></span>
								</td>
							</tr>
						</tbody>
					</table>';

				$attachments_icon = '<div class="cntctfrmtdb-has-attachment" title="' . __( "This option is available in Pro version", "contact_form_to_db" ) . '"></div>';				
			} else {
				$attachments_icon = '';
			}

			$message_content .= '</div>';
			//display counter
			$counter_sent_status = '<span class="counter" title="' . __( 'The number of dispatches', 'contact_form_to_db' ) . '">' . $value->dispatch_counter . '</span>';
			if ( '0' == $value->sent )
				$counter_sent_status .= '<span class="warning" title="' . __( 'This message was not sent', 'contact_form_to_db' ) . '"></span>';
			//display date
			$send_date = strtotime( $value->send_date );
			$send_date = date( 'd M Y H:i', $send_date );
			// forming massiv of messages
			if ( ! isset( $_REQUEST['s'] ) ) {
				$list_of_messages[$i] = array(
					'id'         => $value->id,
					'status'     => $the_message_status,
					'from'       => $from_data,
					'message'    => $message_content,
					'attachment' => $attachments_icon,
					'sent'       => $counter_sent_status,
					'date'       => '<span style="text-align: center;">' . $send_date . '</span>',
				);
				$i++;
			} else {
				$search_request = '/' . $_REQUEST['s'] . '/';
				if ( preg_match( $search_request, stripslashes( $from_data ) ) || preg_match( $search_request, stripslashes( $message_content ) ) ) {
					$list_of_messages[$i] = array(
						'id'         => $value->id,
						'status'     => $the_message_status,
						'from'       => $from_data,
						'message'    => $message_content,
						'attachment' => $attachments_icon,
						'sent'       => $counter_sent_status,
						'date'       => '<span style="text-align: center;">' . $send_date . '</span>',
					);
					$i++;
				}
			}
		}
		return $list_of_messages;
	}
}
/*
 * Function to get number of messages 
 */
if ( ! function_exists( 'cntctfrmtdb_number_of_messages' ) ) {
	function cntctfrmtdb_number_of_messages() {
		global $wpdb;
		$prefix = $wpdb->prefix . 'cntctfrmtdb_';
		$sql_query = "SELECT COUNT(`id`) FROM " . $prefix . "message ";
		if ( isset( $_REQUEST['message_status'] ) ) { // depending on request display different list of messages
			if ( 'sent' == $_REQUEST['message_status'] ) {
				$sql_query .= "WHERE " . $prefix . "message.sent='1' AND " . $prefix . "message.status_id NOT IN (2,3)";
			} elseif ( 'not_sent' == $_REQUEST['message_status'] ) {
				$sql_query .= "WHERE " . $prefix . "message.sent='0' AND " . $prefix . "message.status_id NOT IN (2,3)";
			} elseif ( 'read_messages' == $_REQUEST['message_status'] ) {
				$sql_query .= "WHERE " . $prefix . "message.was_read='1' AND " . $prefix . "message.status_id NOT IN (2,3)";
			} elseif ( 'not_read_messages' == $_REQUEST['message_status'] ) {
				$sql_query .= "WHERE " . $prefix . "message.was_read='0' AND " . $prefix . "message.status_id NOT IN (2,3)";
			} elseif ( 'has_attachment' == $_REQUEST['message_status'] ) {
				$sql_query .= "WHERE " . $prefix . "message.attachment_status<>'0' AND " . $prefix . "message.status_id NOT IN (2,3)";
			} elseif ( 'all' == $_REQUEST['message_status'] ) {
				$sql_query .= "WHERE " . $prefix . "message.status_id='1'";
			} elseif ( 'spam' == $_REQUEST['message_status'] ) {
				$sql_query .= "WHERE " . $prefix . "message.status_id='2'";
			} elseif ( 'trash' == $_REQUEST['message_status'] ) {
				$sql_query .= "WHERE " . $prefix . "message.status_id='3'";
			}
		} else {
			$sql_query .= "WHERE " . $prefix . "message.status_id='1'";
		}
		$number_of_messages = $wpdb->get_var( $sql_query );
		return $number_of_messages;
	}
}

/*
* create class Cntctfrmtdb_Manager to display list of messages 
*/
if ( ! class_exists( 'WP_List_Table' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class Cntctfrmtdb_Manager extends WP_List_Table {

	/*
	* Constructor of class 
	*/
	function __construct() {
		global $status, $page;
		parent::__construct( array(
			'singular'  => __( 'message', 'contact_form_to_db' ),
			'plural'    => __( 'messages', 'contact_form_to_db' ),
			'ajax'      => true,
			)
		);
	}
	
	/*
	* Function to prepare data before display 
	*/
	function prepare_items() {
		global $message_status, $cntctfrmtdb_options, $wpdb;
		$message_status = isset( $_REQUEST['message_status'] ) ? $_REQUEST['message_status'] : 'all';
		if ( ! in_array( $message_status, array( 'all', 'sent', 'not_sent', 'read_messages', 'not_read_messages', 'has_attachment', 'spam', 'trash' ) ) )
			$message_status = 'all';
		$search		= ( isset( $_REQUEST['s'] ) ) ? $_REQUEST['s'] : '';
		$columns	= $this->get_columns();
		$hidden		= array( );
		$sortable = ''; // in manager sorting is doing during request handling to database by send date Desc, thats why value of this variable is NULL
		$this->_column_headers = array( $columns, $hidden, $sortable );
		$per_page			= $cntctfrmtdb_options['cntctfrmtdb_messages_per_page'];
		$current_page = $this->get_pagenum();
		$total_items	= intval( cntctfrmtdb_number_of_messages() );
		$this->found_data = cntctfrmtdb_get_message_list();
		$this->set_pagination_args( array(
			'total_items' => $total_items,
			'per_page'    => $per_page,
			)
		);
		$this->items = $this->found_data;
	}

	/*
	* Function to show message if no data found
	*/
	function no_items() {
		global $message_status;
		if ( 'sent' == $message_status ) {
			echo '<i>- ' . __( 'No messages that have been sent.', 'contact_form_to_db' ) . ' -<i>';
		} elseif ( 'not_sent' == $message_status ) {
			echo '<i>- ' . __( 'No messages that have not been sent.', 'contact_form_to_db' ) . '-<i>';
		} elseif ( 'read_messages' == $message_status ) {
			echo '<i>- ' . __( 'No messages that have was read.', 'contact_form_to_db' ) . ' -<i>';
		} elseif ( 'not_read_messages' == $message_status ) {
			echo '<i>- ' . __( 'No messages that have was not read.', 'contact_form_to_db' ) . ' -<i>';
		} elseif ( 'has_attachment' == $message_status ) {
			echo '<i>- ' . __( 'No messages that have attachments.', 'contact_form_to_db' ) . ' -<i>';
		} elseif ( 'spam' == $message_status ) {
			echo '<i>- ' . __( 'No messages that was marked as Spam.', 'contact_form_to_db' ) . ' -<i>';
		} elseif ( 'trash' == $message_status ) {
			echo '<i>- ' . __( 'No messages that was marked as Trash.', 'contact_form_to_db' ) . ' -<i>';
		} else {
			echo '<i>- ' . __( 'No messages found.', 'contact_form_to_db' ) . ' -<i>';
		}
	}

	/*
	* Function to add column names 
	*/
	function column_default( $item, $column_name ) {
		switch( $column_name ) { 
			case 'id':
			case 'status':
			case 'from':
			case 'message':
			case 'attachment':
			case 'sent':
			case 'date':
				return $item[ $column_name ];
			default:
				return print_r( $item, true ) ;
		}
	}

	/*
	* Function to add column titles 
	*/
	function get_columns(){
		$columns = array(
			'cb'         => '<input type="checkbox" />',
			'id'         => '',
			'status'     => '',
			'from'       => __( 'From', 'contact_form_to_db' ),
			'message'    => __( 'Message', 'contact_form_to_db' ),
			'attachment' => '<div class="cntctfrmtdb-attachment-column-title"></div>',
			'sent'       => __( 'Send Counter', 'contact_form_to_db' ),
			'date'       => __( 'Date', 'contact_form_to_db' ),
		);
		return $columns;
	}
	/*
	* Function to add action links before and after list of messages 
	*/
	function extra_tablenav( $which ) {
		global $message_status, $cntctfrmtdb_options,$wpdb;
		$status_links = array();
		$total_items = count( cntctfrmtdb_get_message_list() );
		$status = array(
			'all'               => __( 'All', 'contact_form_to_db' ),
			'sent'              => __( 'Sent', 'contact_form_to_db' ),
			'not_sent'          => __( 'Not sent',  'contact_form_to_db' ),
			'read_messages'     => __( 'Read', 'contact_form_to_db' ),
			'not_read_messages' => __( 'Unread', 'contact_form_to_db' ),
			'has_attachment'    => __( 'Has attachments', 'contact_form_to_db' ),
			'spam'              => __( 'Spam', 'contact_form_to_db' ),
			'trash'             => __( 'Trash', 'contact_form_to_db' ),
		);
		$prefix = $wpdb->prefix . 'cntctfrmtdb_';
		$filters_count = $wpdb->get_results(
			"SELECT COUNT(`id`) AS `All`,
				( SELECT COUNT(`id`) FROM " . $prefix . "message WHERE " . $prefix . "message.sent=1 AND " . $prefix . "message.status_id NOT IN (2,3) ) AS `sent`,
				( SELECT COUNT(`id`) FROM " . $prefix . "message WHERE " . $prefix . "message.sent=0 AND " . $prefix . "message.status_id NOT IN (2,3) ) AS `not_sent`,
				( SELECT COUNT(`id`) FROM " . $prefix . "message WHERE " . $prefix . "message.was_read=1 AND " . $prefix . "message.status_id NOT IN (2,3) ) AS `was_read`,
				( SELECT COUNT(`id`) FROM " . $prefix . "message WHERE " . $prefix . "message.was_read=0 AND " . $prefix . "message.status_id NOT IN (2,3) ) AS `was_not_read`,
				( SELECT COUNT(`id`) FROM " . $prefix . "message WHERE " . $prefix . "message.attachment_status<>0 AND " . $prefix . "message.status_id NOT IN (2,3) ) AS `has_attachment`,
				( SELECT COUNT(`id`) FROM " . $prefix . "message WHERE " . $prefix . "message.status_id=2 ) AS `spam`,
				( SELECT COUNT(`id`) FROM " . $prefix . "message WHERE " . $prefix . "message.status_id=3 ) AS `trash`
			FROM " . $prefix . "message WHERE " . $prefix . "message.status_id NOT IN (2,3)"
		);
		foreach( $filters_count as $value ) {
			$sent_count					= $value->sent;
			$not_sent_count				= $value->not_sent;
			$was_read_count				= $value->was_read;
			$not_read_cont				= $value->was_not_read;
			$has_attachment_count		= $value->has_attachment;
			$spam_count					= $value->spam;
			$trash_count				= $value->trash;
		} ?>
		<div class="cntctfrmtdb-manager-filters">
			<?php foreach ( $status as $key => $value ) {
				$class = ( $key == $message_status ) ? ' class="current"' : '';
				echo ' <a href="?page=cntctfrmtdb_manager&message_status=' . $key . '" ' . $class . '>' . $value;
				if ( 'all' != $key ) {
					echo ' <span class="count">(<span class="';
					if ( 'sent' == $key ) {
						echo 'sent-count">' . $sent_count;  
					} elseif ( 'not_sent' == $key ) {
						echo 'not-sent-count">' . $not_sent_count;
					} elseif ( 'read_messages' == $key ) {
						echo 'was-read-count">' . $was_read_count;
					} elseif ( 'not_read_messages' == $key ) {
						echo 'not-read-count">' . $not_read_cont;
					} elseif ( 'has_attachment' == $key ) {
						echo 'has-attachment-count">' . $has_attachment_count;
					} elseif ( 'spam' == $key ) {
						echo 'spam-count">' . $spam_count;
					} elseif ( 'trash' == $key ) {
						echo 'trash-count">' . $trash_count;
					}
					echo '</span>)</span></a>';
				}
				if ( 'trash' != $key)
					echo ' | ';
			} ?>
		</div>
		<?php }

	/*
	* Function to add action links to drop down menu before and after table depending on status page
	*/
	function get_bulk_actions() {
		global $message_status;
		$actions = array();
		if ( in_array( $message_status, array( 'all', 'sent', 'not_sent', 'read_messages', 'not_read_messages', 'has_attachment' ) ) ) {
			$actions['download_messages']		= __( 'Download messages', 'contact_form_to_db' );			
			$actions['spam']					= __( 'Mark as Spam', 'contact_form_to_db' );
		}
		if ( 'spam' == $message_status )
			$actions['unspam'] = __( 'Not Spam', 'contact_form_to_db' );
		if ( 'trash' == $message_status )
			$actions['restore'] = __( 'Restore', 'contact_form_to_db' );
		if ( in_array( $message_status, array( 'spam', 'trash' ) ) )
			$actions['delete_messages'] = __( 'Delete Permanently', 'contact_form_to_db' );
		else
			$actions['trash'] = __( 'Mark as Trash', 'contact_form_to_db' );
		if ( in_array( $message_status, array( 'all', 'sent', 'not_sent', 'read_messages', 'not_read_messages', 'has_attachment' ) ) ) {
			$actions['re_send_messages']		= __( 'Re-send messages', 'contact_form_to_db' );
			$actions['download_attachments']	= __( 'Download attachments', 'contact_form_to_db' );
		}
		return $actions;
	}

	/*
	* Function to add action links to  message column depenting on status page
	*/
	function column_message( $item ) {
		global $message_status;
		$actions = array();
		if ( in_array( $message_status, array( 'all', 'sent', 'not_sent', 'read_messages', 'not_read_messages', 'has_attachment' ) ) ) {
			$actions['re_send_message'] = sprintf( '<a href="#" class="bws_plugin_menu_pro_version" title="' . __( "This option is available in Pro version", "contact_form_to_db" ) . '" >' . __( 'Re-send Message', 'contact_form_to_db' ) . '</a>', $item['id'] );
			$actions['download_message'] = '<a href="' . wp_nonce_url( sprintf( '?page=cntctfrmtdb_manager&action=download_message&message_id[]=%s', $item['id'] ), 'cntctfrmtdb_download_message' . $item['id'] ) . '">' . __( 'Download Message', 'contact_form_to_db' ) . '</a>';				
			$actions['spam'] = '<a href="' . wp_nonce_url( sprintf( '?page=cntctfrmtdb_manager&action=spam&message_id[]=%s', $item['id'] ), 'cntctfrmtdb_spam' . $item['id'] ) . '">' . __( 'Spam', 'contact_form_to_db' ) . '</a>';
			$actions['trash'] = '<a href="' . wp_nonce_url( sprintf( '?page=cntctfrmtdb_manager&action=trash&message_id[]=%s', $item['id'] ), 'cntctfrmtdb_trash' . $item['id'] ) . '">' . __( 'Trash', 'contact_form_to_db' ) . '</a>';
		}
		if ( 'spam' == $message_status )
			$actions['unspam'] = '<a style="color:#006505" href="' . wp_nonce_url( sprintf(  '?page=cntctfrmtdb_manager&action=unspam&message_id[]=%s', $item['id'] ), 'cntctfrmtdb_unspam_restore_undo' . $item['id'] ) . '">' . __( 'Not spam', 'contact_form_to_db' ) . '</a>';
		if ( 'trash' == $message_status )
			$actions['untrash'] = '<a style="color:#006505" href="' . wp_nonce_url( sprintf( '?page=cntctfrmtdb_manager&action=restore&message_id[]=%s', $item['id'] ), 'cntctfrmtdb_unspam_restore_undo' . $item['id'] ) . '">' . __( 'Restore', 'contact_form_to_db' ) . '</a>';			
		if ( in_array( $message_status, array( 'spam', 'trash' ) ) )
			$actions['delete_message'] = '<a style="color:#BC0B0B" href="' . wp_nonce_url( sprintf( '?page=cntctfrmtdb_manager&action=delete_message&message_id[]=%s', $item['id'] ), 'cntctfrmtdb_delete_message' . $item['id'] ) . '">' . __( 'Delete Permanently', 'contact_form_to_db' ) . '</a>';
		else
			$actions['trash'] = '<a href="' . wp_nonce_url( sprintf( '?page=cntctfrmtdb_manager&action=trash&message_id[]=%s', $item['id'] ), 'cntctfrmtdb_trash' . $item['id'] ) . '">' . __( 'Trash', 'contact_form_to_db' ) . '</a>';
		return sprintf( '%1$s %2$s', $item['message'], $this->row_actions( $actions ) );
	}
	/*
	* Function to add column of checboxes 
	*/
	function column_cb( $item ) {
		return sprintf( '<input id="cb_%1s" type="checkbox" name="message_id[]" value="%2s" />', $item['id'], $item['id'] );
	}
}
//End of class

/*
* Function to display pugin page
*/
if ( ! function_exists( 'cntctfrmtdb_manager_page' ) ) {
	function cntctfrmtdb_manager_page() {
 		global $cntctfrmtdb_manager, $wp_version, $wpdb, $cntctfrmtdb_options, $cntctfrmtdb_done_message, $cntctfrmtdb_error_message, $cntctfrmtdb_plugin_info; 
		$cntctfrmtdb_manager = new Cntctfrmtdb_Manager(); ?>
		<div class="cntctfrmtdb-help-pages">
			<a href="http://bestwebsoft.com/plugin/contact-form-to-db-pro/?k=5906020043c50e2eab1528d63b126791&pn=91&v=<?php echo $cntctfrmtdb_plugin_info["Version"]; ?>&wp_v=<?php echo $wp_version; ?>" title="<?php _e( 'This option is available in Pro version', 'contact_form_to_db' ); ?>"><span class="user-guide-icon"></span><?php _e( 'User Guide', 'contact_form_to_db' ); ?></a>
			<a href="http://bestwebsoft.com/plugin/contact-form-to-db-pro/?k=5906020043c50e2eab1528d63b126791&pn=91&v=<?php echo $cntctfrmtdb_plugin_info["Version"]; ?>&wp_v=<?php echo $wp_version; ?>" title="<?php _e( 'This option is available in Pro version', 'contact_form_to_db' ); ?>"><span class="faq-icon"></span><?php _e( 'FAQ', 'contact_form_to_db' ); ?></a>
			<a href="http://bestwebsoft.com/plugin/contact-form-to-db-pro/?k=5906020043c50e2eab1528d63b126791&pn=91&v=<?php echo $cntctfrmtdb_plugin_info["Version"]; ?>&wp_v=<?php echo $wp_version; ?>" title="<?php _e( 'This option is available in Pro version', 'contact_form_to_db' ); ?>"><?php _e( 'Screen Options', 'contact_form_to_db' ); ?></a>
		</div>
		<div class="wrap cntctfrmtdb">
			<noscript>
				<div class="error">
					<p><strong><?php echo _e( 'WARNING: ', 'contact_form_to_db' ); ?></strong><?php echo _e( 'For fully-functional work of plugin, please, enable javascript.', 'contact_form_to_db' ); ?></p>
				</div>
			</noscript>
			<div class="icon32 icon32-contact-form-to-db" id="icon-options-general"></div>
			<h2>
				<?php _e( 'Contact Form to DB', 'contact_form_to_db' ); ?>
				<?php if ( isset( $_REQUEST['s'] ) && $_REQUEST['s'] )
					printf( '<span class="subtitle">' . sprintf( __( 'Search results for &#8220;%s&#8221;', 'contact_form_to_db' ), wp_html_excerpt( esc_html( stripslashes( $_REQUEST['s'] ) ), 50 ) ) . '</span>' );
				$cntctfrmtdb_manager->prepare_items(); ?>
			</h2>
			<div class="updated" <?php if ( '' == $cntctfrmtdb_done_message ) echo 'style="display: none;"'?>><p><?php echo $cntctfrmtdb_done_message ?></p></div>
			<div class="error" <?php if ( '' == $cntctfrmtdb_error_message ) echo 'style="display: none;"'?>><p><strong><?php __( 'WARNING: ', 'contact_form_to_db' ); ?></strong><?php echo $cntctfrmtdb_error_message .  __( ' Please, try it later.', 'contact_form_to_db' ); ?></p></div>
			<div class="updated fade" style="display: none;"></div>			
			<form method="post">
				<?php $cntctfrmtdb_manager->search_box( 'Search mails', 'search_id' );
				$bulk_actions = $cntctfrmtdb_manager->current_action();
				$cntctfrmtdb_manager->display(); 
				wp_nonce_field( plugin_basename( __FILE__ ), 'cntctfrmtdb_manager_nonce_name' ); ?>
			</form>
		</div>
	<?php }
}

/*
*
*                         AJAX functions
*
* Function to change read/not-read message status 
*/
if ( ! function_exists( 'cntctfrmtdb_read_message' ) ) {
	function cntctfrmtdb_read_message() {
		global $wpdb;
		$prefix = $wpdb->prefix . 'cntctfrmtdb_';
		check_ajax_referer( plugin_basename( __FILE__ ), 'cntctfrmtdb_ajax_nonce_field' );
		$wpdb->update( $prefix . 'message', array( 'was_read' => $_POST['cntctfrmtdb_ajax_read_status'] ), array( 'id' => $_POST['cntctfrmtdb_ajax_message_id'] ) );
		die();
	}
}

/*
* Function to show attachment of message 
*/
if ( ! function_exists( 'cntctfrmtdb_show_attachment' ) ) {
	function cntctfrmtdb_show_attachment() {
		if ( isset( $_POST['action'] ) && 'cntctfrmtdb_show_attachment' == $_POST['action'] ) {
			global $wp_version, $cntctfrmtdb_plugin_info;
			echo '<td valign="middle" class="cntctfrmtdb-thumbnail">
				<a href="http://bestwebsoft.com/plugin/contact-form-to-db-pro/?k=5906020043c50e2eab1528d63b126791&pn=91&v=' . $cntctfrmtdb_plugin_info["Version"] . '&wp_v=' . $wp_version . '" title="' . __( 'This option is available in Pro version', 'contact_form_to_db' ) . '">
					<img src="' . plugins_url( 'images/no-image.jpg', __FILE__ ) . '" title="' . __( 'This option is available in Pro version', 'contact_form_to_db' ) . '" alt="' . __( 'Can not display thumbnail','contact_form_to_db_plugin' ) . '" />
				</a>
			</td>';
			die();
		}
	}
}

/*
* Function to change message status 
*/
if ( ! function_exists( 'cntctfrmtdb_change_status' ) ) {
	function cntctfrmtdb_change_status() {
		global $wpdb;
		$prefix = $wpdb->prefix . 'cntctfrmtdb_';
		check_ajax_referer( plugin_basename( __FILE__ ), 'cntctfrmtdb_ajax_nonce_field' );
		$wpdb->update( $prefix . 'message', array( 'status_id' => $_POST['cntctfrmtdb_ajax_message_status'] ), array( 'id' => $_POST['cntctfrmtdb_ajax_message_id'] ) );
		if ( ! $wpdb->last_error ) {
			$message_status = $_POST['cntctfrmtdb_ajax_message_status'];
			switch ( $message_status ) {
				case 1:
					$result = '<div class="updated"><p>' . __( 'One message was marked as Normal.', 'contact_form_to_db' ) . '</a></p></div>';
					break;
				case 2:
					$result = '<div class="updated"><p>' . __( 'One message was marked as Spam.', 'contact_form_to_db' ) . ' <a href="' . wp_nonce_url( '?page=cntctfrmtdb_manager&action=undo&message_id[]=' . $_POST['cntctfrmtdb_ajax_message_id'] . '&old_status=' . $_POST['cntctfrmtdb_ajax_old_status'], 'cntctfrmtdb_unspam_restore_undo' . $_POST['cntctfrmtdb_ajax_message_id'] ) . '">' . __( 'Undo', 'contact_form_to_db' ) . '</a></p></div>';
					break;
				case 3:
					$result = '<div class="updated"><p>' . __( 'One message was marked as Trash.', 'contact_form_to_db' ) . ' <a href="' . wp_nonce_url( '?page=cntctfrmtdb_manager&action=undo&message_id[]=' . $_POST['cntctfrmtdb_ajax_message_id'] . '&old_status=' . $_POST['cntctfrmtdb_ajax_old_status'], 'cntctfrmtdb_unspam_restore_undo' . $_POST['cntctfrmtdb_ajax_message_id'] ) . '">' . __( 'Undo', 'contact_form_to_db' ) . '</a></p></div>';
					break;
				default:
					$result = '<div class="error"><p>' . __( '<strong>WARNING: </strong>Unknown result.', 'contact_form_to_db' ) . '</p></div>';
					break;
			}
		} else {
			$result = '<div class="error"><p>' . __( '<strong>WARNING: </strong>Problems while changing status of message. Please, try it later.', 'contact_form_to_db' ) . '</p></div>';
		}
		echo $result;
		die();
	}
}

/*
* Function to add actions link to block with plugins name on "Plugins" page 
*/
if ( ! function_exists( 'cntctfrmtdb_plugin_action_links' ) ) {
	function cntctfrmtdb_plugin_action_links( $links, $file ) {
		static $this_plugin;
		if ( ! $this_plugin ) 
			$this_plugin = plugin_basename( __FILE__ );
		if ( $file == $this_plugin ) {
			$settings_link = '<a href="admin.php?page=cntctfrmtdb_settings">' . __( 'Settings', 'contact_form_to_db' ) . '</a>';
			array_unshift( $links, $settings_link );
		}
		return $links;
	}
}

/*
* Function to add links to description block on "Plugins" page 
*/
if ( ! function_exists( 'cntctfrmtdb_register_plugin_links' ) ) {
	function cntctfrmtdb_register_plugin_links( $links, $file ) {
		$base = plugin_basename( __FILE__ );
		if ( $file == $base ) {
			$links[] = '<a href="admin.php?page=cntctfrmtdb_settings">' . __( 'Settings','contact_form_to_db' ) . '</a>';
			$links[] = '<a href="http://wordpress.org/plugins/contact-form-to-db/faq/" target="_blank">' . __( 'FAQ','contact_form_to_db' ) . '</a>';
			$links[] = '<a href="http://support.bestwebsoft.com">' . __( 'Support','contact_form_to_db' ) . '</a>';
		}
		return $links;
	}
}

/*
* Add notises on plugins page if Contact Form plugin is not installed or not active
*/
if ( ! function_exists( 'cntctfrmtdb_show_notices' ) ) {
	function cntctfrmtdb_show_notices() { 
		global $hook_suffix, $cntctfrmtdb_contact_form_not_found, $cntctfrmtdb_contact_form_not_active, $cntctfrmtdb_options, $bstwbsftwppdtplgns_cookie_add, $cntctfrmtdb_plugin_info;
		$cntctfrmtdb_pages = array(
			'cntctfrmtdb_manager',
			'cntctfrmtdb_settings'
		);
		if ( $hook_suffix == 'plugins.php' || ( isset( $_REQUEST['page'] ) && in_array( $_REQUEST['page'], $cntctfrmtdb_pages ) ) ) {
			if ( '' != $cntctfrmtdb_contact_form_not_found || '' != $cntctfrmtdb_contact_form_not_active ) { ?>
				<div class="error">
					<p><strong><?php _e( 'WARNING: ', 'contact_form_to_db'); ?></strong><?php echo $cntctfrmtdb_contact_form_not_found . $cntctfrmtdb_contact_form_not_active; ?></p>
				</div>
			<?php }
		}
		/* chech plugin settings and add notice */
		if ( isset( $_REQUEST['page'] ) && 'cntctfrmtdb_manager' == $_REQUEST['page'] ) {
			if ( ! isset( $cntctfrmtdb_options['cntctfrmtdb_save_messages_to_db'] ) )
				$cntctfrmtdb_options = get_option( 'cntctfrmtdb_options' );
			
			if ( isset( $cntctfrmtdb_options['cntctfrmtdb_save_messages_to_db'] ) && 0 == $cntctfrmtdb_options['cntctfrmtdb_save_messages_to_db'] ) {
				if ( ! isset( $bstwbsftwppdtplgns_cookie_add ) ) {
					echo '<script type="text/javascript" src="' . plugins_url( 'js/c_o_o_k_i_e.js', __FILE__ ) . '"></script>';
					$bstwbsftwppdtplgns_cookie_add = true;
				}?>
				<script type="text/javascript">		
					(function($) {
						$(document).ready( function() {		
							var hide_message = $.cookie( "cntctfrmtdb_save_messages_to_db" );
							if ( hide_message == "true" ) {
								$( ".cntctfrmtdb_save_messages_to_db" ).css( "display", "none" );
							} else {
								$( ".cntctfrmtdb_save_messages_to_db" ).css( "display", "block" );
							}
							$( ".cntctfrmtdb_close_icon" ).click( function() {
								$( ".cntctfrmtdb_save_messages_to_db" ).css( "display", "none" );
								$.cookie( "cntctfrmtdb_save_messages_to_db", "true", { expires: 7 } );
							});	
						});
					})(jQuery);				
				</script>
				<div class="updated fade cntctfrmtdb_save_messages_to_db" style="display: none;">		       							                      
					<img style="float: right;cursor: pointer;" class="cntctfrmtdb_close_icon" title="" src="<?php echo plugins_url( 'images/close_banner.png', __FILE__ ); ?>" alt=""/>
					<div style="float: left;margin: 5px;"><strong><?php _e( 'Notice:', 'contact_form_to_db'); ?></strong> <?php _e( 'Option "Save messages to database" was disabled on the plugin settings page.', 'contact_form_to_db'); ?> <a href="admin.php?page=cntctfrmtdb_settings"><?php _e( 'Enable it for saving messages from Contact Form', 'contact_form_to_db'); ?></a></div>
					<div style="clear:both;float: none;margin: 0;"></div>
				</div>
			<?php }
		}
		if ( $hook_suffix == 'plugins.php' ) {  
			$banner_array = array(
				array( 'lmtttmpts_hide_banner_on_plugin_page', 'limit-attempts/limit-attempts.php', '1.0.2' ),
				array( 'sndr_hide_banner_on_plugin_page', 'sender/sender.php', '0.5' ),
				array( 'srrl_hide_banner_on_plugin_page', 'user-role/user-role.php', '1.4' ),
				array( 'pdtr_hide_banner_on_plugin_page', 'updater/updater.php', '1.12' ),
				array( 'cntctfrmtdb_hide_banner_on_plugin_page', 'contact-form-to-db/contact_form_to_db.php', '1.2' ),
				array( 'cntctfrmmlt_hide_banner_on_plugin_page', 'contact-form-multi/contact-form-multi.php', '1.0.7' ),
				array( 'gglmps_hide_banner_on_plugin_page', 'bws-google-maps/bws-google-maps.php', '1.2' ),
				array( 'fcbkbttn_hide_banner_on_plugin_page', 'facebook-button-plugin/facebook-button-plugin.php', '2.29' ),
				array( 'twttr_hide_banner_on_plugin_page', 'twitter-plugin/twitter.php', '2.34' ),
				array( 'pdfprnt_hide_banner_on_plugin_page', 'pdf-print/pdf-print.php', '1.7.1' ),
				array( 'gglplsn_hide_banner_on_plugin_page', 'google-one/google-plus-one.php', '1.1.4' ),
				array( 'gglstmp_hide_banner_on_plugin_page', 'google-sitemap-plugin/google-sitemap-plugin.php', '2.8.4' ),
				array( 'cntctfrmpr_for_ctfrmtdb_hide_banner_on_plugin_page', 'contact-form-pro/contact_form_pro.php', '1.14' ),
				array( 'cntctfrm_for_ctfrmtdb_hide_banner_on_plugin_page', 'contact-form-plugin/contact_form.php', '3.62' ),
				array( 'cntctfrm_hide_banner_on_plugin_page', 'contact-form-plugin/contact_form.php', '3.47' ),	
				array( 'cptch_hide_banner_on_plugin_page', 'captcha/captcha.php', '3.8.4' ),
				array( 'gllr_hide_banner_on_plugin_page', 'gallery-plugin/gallery-plugin.php', '3.9.1' )				
			);
			if ( ! $cntctfrmtdb_plugin_info )
				$cntctfrmtdb_plugin_info = get_plugin_data( __FILE__ );

			if ( ! function_exists( 'is_plugin_active_for_network' ) )
				require_once( ABSPATH . 'wp-admin/includes/plugin.php' );

			$active_plugins = get_option( 'active_plugins' );			
			$all_plugins = get_plugins();
			$this_banner = 'cntctfrmtdb_hide_banner_on_plugin_page';
			foreach ( $banner_array as $key => $value ) {
				if ( $this_banner == $value[0] ) {  
					global $wp_version;     
					if ( ! isset( $bstwbsftwppdtplgns_cookie_add ) ) {
						echo '<script type="text/javascript" src="' . plugins_url( 'js/c_o_o_k_i_e.js', __FILE__ ) . '"></script>';
						$bstwbsftwppdtplgns_cookie_add = true;
					} ?> 					   
			       	<script type="text/javascript">		
						(function($) {
							$(document).ready( function() {		
								var hide_message = $.cookie( "cntctfrmtdb_hide_banner_on_plugin_page" );
								if ( hide_message == "true" ) {
									$( ".cntctfrmtdb_message" ).css( "display", "none" );
								} else {
									$( ".cntctfrmtdb_message" ).css( "display", "block" );
								}
								$( ".cntctfrmtdb_close_icon" ).click( function() {
									$( ".cntctfrmtdb_message" ).css( "display", "none" );
									$.cookie( "cntctfrmtdb_hide_banner_on_plugin_page", "true", { expires: 32 } );
								});	
							});
						})(jQuery);				
					</script>
					<div class="updated" style="padding: 0; margin: 0; border: none; background: none;">					                      
						<div class="cntctfrmtdb_message bws_banner_on_plugin_page" style="display: none;">
							<img class="cntctfrmtdb_close_icon close_icon" title="" src="<?php echo plugins_url( 'images/close_banner.png', __FILE__ ); ?>" alt=""/>
							<div class="button_div">
								<a class="button" target="_blank" href="http://bestwebsoft.com/plugin/contact-form-to-db-pro/?k=a0297729ff05dc9a4dee809c8b8e94bf&pn=91&v=<?php echo $cntctfrmtdb_plugin_info["Version"]; ?>&wp_v=<?php echo $wp_version; ?>"><?php _e( "Learn More", 'contact_form_to_db' ); ?></a>				
							</div>
							<div class="text">
								<?php _e( "It's time to upgrade your <strong>Contact Form to DB</strong> to <strong>PRO</strong> version", 'contact_form_to_db' ); ?>!<br />
								<span><?php _e( 'Extend standard plugin functionality with new great options', 'contact_form_to_db' ); ?>.</span>
							</div> 		
							<div class="icon">			
								<img title="" src="<?php echo plugins_url( 'images/banner.png', __FILE__ ); ?>" alt=""/>
							</div>	
						</div>  
					</div>
					<?php break;
				}
				if ( isset( $all_plugins[ $value[1] ] ) && $all_plugins[ $value[1] ]["Version"] >= $value[2] && ( 0 < count( preg_grep( '/' . str_replace( '/', '\/', $value[1] ) . '/', $active_plugins ) ) || is_plugin_active_for_network( $value[1] ) ) && ! isset( $_COOKIE[ $value[0] ] ) ) {
					break;
				}
			}    
		}
	}
}

/*
* Function for delete options and tables 
*/
if ( ! function_exists ( 'cntctfrmtdb_delete_options' ) ) {
	function cntctfrmtdb_delete_options() {
		global $wpdb;
		$all_plugins = get_plugins();
		if ( ! array_key_exists( 'contact-form-to-db-pro/contact_form_to_db_pro.php', $all_plugins ) ) {
			$prefix = $wpdb->prefix . 'cntctfrmtdb_';
			$sql = "DROP TABLE `" . $prefix . "message_status`, `" . $prefix . "blogname`, `" . $prefix . "to_email`, `" . $prefix . "hosted_site`, `" . $prefix . "refer`, `" . $prefix . "field_selection`, `" . $prefix . "message`;";
			$wpdb->query( $sql );
		}
		delete_option( "cntctfrmtdb_version" );
		delete_option( "cntctfrmtdb_options" );
		delete_site_option( "cntctfrmtdb_version" );
		delete_site_option( "cntctfrmtdb_options" );
	}
}

/* 
* Add all hooks
*/
/* Activate plugin */
register_activation_hook( __FILE__, 'cntctfrmtdb_create_table' );
// add menu items in to dashboard menu
add_action( 'admin_menu', 'cntctfrmtdb_admin_menu' );
// init hooks
add_action( 'init', 'cntctfrmtdb_init' );
add_action( 'admin_init', 'cntctfrmtdb_admin_init' );
// add pligin scripts and stylesheets
add_action( 'admin_enqueue_scripts', 'cntctfrmtdb_admin_head' );
// add action link of plugin on "Plugins" page
add_filter( 'plugin_action_links', 'cntctfrmtdb_plugin_action_links', 10, 2 );
add_filter( 'plugin_row_meta', 'cntctfrmtdb_register_plugin_links', 10, 2 );
// hooks for get mail data
add_action( 'cntctfrm_get_mail_data', 'cntctfrmtdb_get_mail_data', 10, 11 );
add_action( 'cntctfrm_get_attachment_data', 'cntctfrmtdb_get_attachment_data' );
add_action( 'cntctfrm_check_dispatch', 'cntctfrmtdb_check_dispatch', 10, 1 );
//hooks for ajax
add_action( 'wp_ajax_cntctfrmtdb_read_message', 'cntctfrmtdb_read_message' );
add_action( 'wp_ajax_cntctfrmtdb_show_attachment', 'cntctfrmtdb_show_attachment' );
add_action( 'wp_ajax_cntctfrmtdb_change_staus', 'cntctfrmtdb_change_status' );
// check for installed and activated Contact Form plugin ; add banner on the plugins page
add_action( 'admin_notices', 'cntctfrmtdb_show_notices' );
// uninstal hook
register_uninstall_hook( __FILE__, 'cntctfrmtdb_delete_options' );
?>