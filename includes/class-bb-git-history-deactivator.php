<?php

/**
 * Fired during plugin deactivation
 *
 * @link       a
 * @since      1.0.0
 *
 * @package    Bb_Git_History
 * @subpackage Bb_Git_History/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Bb_Git_History
 * @subpackage Bb_Git_History/includes
 * @author     Natali Honda - oneRhino <natalihonda@gmail.com>
 */
class Bb_Git_History_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		delete_option( 'bb_git_history_installation_id' );
		delete_option( 'bb_git_history_installation_api_token' );
		delete_option( 'bb_git_history_github_user' );
		delete_option( 'bb_git_history_repositories' );
		unregister_setting(
			'bb_git_history_options',
			'bb_git_history_github_repository'
		);

		unregister_setting(
			'bb_git_history_options',
			'bb_git_history_github_branch'
		);
		
	}

}
