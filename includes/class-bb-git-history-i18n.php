<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       a
 * @since      1.0.0
 *
 * @package    Bb_Git_History
 * @subpackage Bb_Git_History/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Bb_Git_History
 * @subpackage Bb_Git_History/includes
 * @author     Natali Honda - oneRhino <natalihonda@gmail.com>
 */
class Bb_Git_History_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'bb-git-history',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
