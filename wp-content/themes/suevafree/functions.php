<?php
/**
 *
 * Sueva Theme Functions
 *
 * This is your standard WordPress
 * functions.php file.
 *
 * @author  Alessandro Vellutini
 *
*/

/* CORE */
require_once get_template_directory() . '/core/core.php';
require_once get_template_directory() . '/core/post-formats.php';

/* STYLE  */
require_once get_template_directory() . '/core/add-style.php';

/* WIDGET  */
require_once get_template_directory() . '/core/add-widgets.php';
require_once get_template_directory() . '/core/register-metaboxes.php';
require_once get_template_directory() . '/core/admin/function_panel.php';

?>