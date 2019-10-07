<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       a
 * @since      1.0.0
 *
 * @package    Bb_Git_History
 * @subpackage Bb_Git_History/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Bb_Git_History
 * @subpackage Bb_Git_History/admin
 * @author     Natali Honda - oneRhino <natalihonda@gmail.com>
 */
class Bb_Git_History_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/bb-git-history-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/bb-git-history-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Add Top Level Menu on Admin Dashboard
	 *
	 * @since    1.0.0
	 */
	public function add_top_menu() {

		add_menu_page(
			_('BeaverBuilder Git History Settings'),
			_('BeaverBuilder Git History'),
			'manage_options',
			'bb-git-history',
			array( $this , 'admin_display' ),
			'dashicons-admin-generic',
			null
		);

	}

	function register_settings() {

		/*
	
		register_setting(
			string   $option_group,
			string   $option_name,
			callable $sanitize_callback = ''
		);
	
		*/

		register_setting(
			'bb_git_history_options',
			'bb_git_history_github_repository'
		);

		register_setting(
			'bb_git_history_options',
			'bb_git_history_github_branch'
		);
	
		/*
	
		add_settings_section(
			string   $id,
			string   $title,
			callable $callback,
			string   $page
		);
	
		*/
	
		add_settings_section(
			'bb_git_history_section_setup',
			'Setup Github Credentials',
			array( $this , 'settings_setup' ),
			'bb-git-history'
		);
	
		/*
	
		add_settings_field(
			string   $id,
			string   $title,
			callable $callback,
			string   $page,
			string   $section = 'default',
			array    $args = []
		);
	
		*/
	
		add_settings_field(
			'bb_git_history_github_account',
			'Github Account',
			array( $this , 'settings_account' ),
			'bb-git-history',
			'bb_git_history_section_setup',
			[ 'id' => 'bb_git_history_github_account', 'label' => 'Github Account' ]
		);

		add_settings_field(
			'bb_git_history_github_repository',
			'Github Reposity',
			array( $this , 'settings_repository' ),
			'bb-git-history',
			'bb_git_history_section_setup',
			[ 'id' => 'bb_git_history_github_repository', 'label' => 'Github Repository' ]
		);

		add_settings_field(
			'bb_git_history_github_branch',
			'Repository Branch',
			array( $this , 'settings_branch' ),
			'bb-git-history',
			'bb_git_history_section_setup',
			[ 'id' => 'bb_git_history_github_branch', 'label' => 'Repository branch' ]
		);
	
	}

	/**
	 * Setup Settings
	 *
	 * @since    1.0.0
	 */
	public function settings_setup() {

		echo '<p>Fill in the information needed to enable automatic backup.</p>';
	}

	/**
	 * Account Settings
	 *
	 * @since    1.0.0
	 */
	public function settings_account() {
		$github_mark = plugin_dir_url( __FILE__ ) . 'assets/github-mark.png';
		$github_mark_light = plugin_dir_url( __FILE__ ) . 'assets/github-mark-light.png';
		if( get_option( 'bb_git_history_installation_id' ) ){
			echo '<p> Logged in as <img class="icon-img" src="' . $github_mark . '">' . get_option( 'bb_git_history_github_user' ) . '</p>';
		}
		else{
			echo '<p><a class="login-link" href="'. BB_GIT_HISTORY_APP_URL . '?state=' . get_home_url() . '"><img class="login-img" src="' . $github_mark_light . '">Login with Github</a></p>';
		}

	}

	/**
	 * Repository Settings
	 *
	 * @since    1.0.0
	 */
	public function settings_repository() {
		if( get_option( 'bb_git_history_installation_id' ) ){
			echo '<select name="bb_git_history_github_repository" id="bb_git_history_github_repository_select">';
			$repositories = unserialize(get_option( 'bb_git_history_repositories' ));
			foreach ($repositories as $key => $repo) {
				echo '<option data-id="' . $repo->id . '" value="' . $repo->full_name . '" ' .
				 selected(get_option( 'bb_git_history_github_repository' , $repo->full_name )) . '>' . 
				 $repo->full_name . '</option>';
			}
      echo '</select>';
		}
		else{
			echo '<p> Not logged in </p>';
		}

	}

	/**
	 * Branch Settings
	 *
	 * @since    1.0.0
	 */
	public function settings_branch() {
		$repositories = unserialize(get_option( 'bb_git_history_repositories' ));
		$repo_full_name = get_option( 'bb_git_history_github_repository' );
		foreach ($repositories as $key => $repo) {
			if($repo_full_name == $repo->full_name ){
				$active = 'active';
			}
			elseif ($key == 0){
				$active = 'active';
			}
			else $active = '';
			echo '<select class="branch-select '. $active .'" name="bb_git_history_github_branch" id="bb_git_history_github_branches_repo_'. $repo->id .'">';
			foreach($repo->branches as $k => $branch){
				echo '<option value="' . $branch->name . '" ' .
				selected(get_option( 'bb_git_history_github_branch' , $branch->name )) . '>' . 
				$branch->name . '</option>';
			}
			 echo '</select>';
		}
	}

	/**
	 * Display Settings
	 *
	 * @since    1.0.0
	 */
	public function admin_display() {

		if ( ! current_user_can( 'manage_options' ) ) return;
	
		include_once 'partials/bb-git-history-admin-display.php';

	}

	/**
	 * Hook to the BeaverBuilder before data is saved to a layout.
	 *
	 * @since    1.0.0
	 */
	public function before_save_layout( $post_id, $publish, $data, $settings ) {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Bb_Git_History_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Bb_Git_History_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		$slug = get_post_field( 'post_name', get_post( $post_id ) );
		$changes = array(
			'css' => $settings->css,
			'js' => $settings->js,
		);
		//file_put_contents( BB_GIT_HISTORY_LOG_FILE, print_r($changes, true) , FILE_APPEND );
		$this->commit_changes( $slug, $changes );

	}

	/**
	 * Hook to the BeaverBuilder before global settings are saved.
	 *
	 * @since    1.0.0
	 */
	public function before_save_global_settings( $args ) {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Bb_Git_History_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Bb_Git_History_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		$changes = array(
			'css' => $args['settings']['css'],
			'js' => $args['settings']['js'],
		);
		//file_put_contents( BB_GIT_HISTORY_LOG_FILE, print_r($changes, true) , FILE_APPEND );
		$this->commit_changes( 'global', $changes );

	}

	/**
	 * Send Page Changes to Github
	 *
	 * @since    1.0.0
	 */
	public function commit_changes($file_prefix, $changes) {
		$token = get_option( 'bb_git_history_installation_api_token' );
		$repo = get_option( 'bb_git_history_github_repository' );
		$branch = get_option( 'bb_git_history_github_branch' );

		$body = array(
			'repo' => $repo,
			'branch' => $branch,
			'changes' => $changes,
			'file_prefix' => $file_prefix
		);
		$http_options = array(
			'method' => 'POST',
			'timeout' => 45,
			'redirection' => 5,
			'httpversion' => '1.0',
			'blocking' => true,
			'headers' => array(
				'Authorization' => 'Bearer ' . $token
			),
			'body' => $body,
		);
		$url = BB_GIT_HISTORY_APP_API . 'commit';
		$response = wp_remote_post( $url, $http_options );
}


	/**
	 * REST Route for Github App Post Setup
	 *
	 * @since    1.0.0
	 */
	public function register_rest_route() {
    //Path to REST route and the callback function
    register_rest_route( 'bb-git-history', '/save_installation/', array(
            'methods' => 'POST', 
            'callback' => array( $this, 'rest_save_installation' ) 
    ) );
	}
	/**
	 * Save Installation from Github App
	 * 
	 * @since 1.0.0
	 */
	public function rest_save_installation($data)
	{
		if(isset($data)){
			update_option( 'bb_git_history_installation_id', $data['installation']['id']);
			update_option( 'bb_git_history_installation_api_token', $data['installation']['api_token']);
			update_option( 'bb_git_history_github_user', $data['github_user']);
			update_option( 'bb_git_history_repositories', serialize(json_decode($data['repositories'])));
			wp_send_json( ['message'=> 'Installation saved'] );
		}
		else{
			wp_send_json( ['message'=> 'No installation found'] );
		}
	}



}
