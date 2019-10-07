<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @since      1.0.0
 *
 * @package    Bb_Git_History
 * @subpackage Bb_Git_History/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div class="wrap">
		<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
		<form action="options.php" method="post">
			
			<?php
			
			// output security fields
			settings_fields( 'bb_git_history_options' );
			
			// output setting sections
			do_settings_sections( 'bb-git-history' );
			
			// submit button
			submit_button();
			
			?>
			
		</form>
	</div>
