<?php
namespace um_ext\um_social_login\core;


if ( ! defined( 'ABSPATH' ) ) exit;


/**
 * Class Social_Login_Admin
 * @package um_ext\um_social_login\core
 */
class Social_Login_Admin {


	/**
	 * Social_Login_Admin constructor.
	 */
	function __construct() {
		add_action( 'um_extend_admin_menu',  array( &$this, 'extend_admin_menu' ), 100 );

		add_action( 'admin_menu', array(&$this, 'prepare_metabox' ), 20 );

		add_action( 'load-post.php', array(&$this, 'add_metabox' ), 9 );
		add_action( 'load-post-new.php', array(&$this, 'add_metabox' ), 9 );
	}


	/**
	 * Extends the admin menu
	 */
	function extend_admin_menu() {
		add_submenu_page( 'ultimatemember', __( 'Social Login', 'um-social-login' ), __( 'Social Login', 'um-social-login' ), 'manage_options', 'edit.php?post_type=um_social_login', '' );
	}


	/**
	 * Prepare metabox
	 */
	function prepare_metabox() {
		add_action( 'load-toplevel_page_ultimatemember', array( &$this, 'load_metabox' ) );
	}


	/**
	 * Load metabox
	 */
	function load_metabox() {
		wp_register_script('um-chart', '//www.gstatic.com/charts/loader.js');
		wp_enqueue_script('um-chart');

		add_meta_box('um-metaboxes-social', __( 'Social Signups', 'um-social-login' ), array( &$this, 'metabox_content' ), 'toplevel_page_ultimatemember', 'normal', 'core' );
	}


	/**
	 * Metabox content
	 */
	function metabox_content() {
		include_once um_social_login_path . 'includes/admin/templates/metabox.php';
	}


	/**
	 * Init the metaboxes
	 */
	function add_metabox() {
		global $current_screen;

		if ( $current_screen->id == 'um_form' ) {

			add_action( 'save_post', array( &$this, 'set_social_login_form_id' ), 10, 2 );

		} elseif( $current_screen->id == 'um_social_login' ) {

			add_action( 'add_meta_boxes', array(&$this, 'add_metabox_form'), 1 );
			add_action( 'save_post', array(&$this, 'save_metabox_form'), 11, 2 );

		}
	}


	/**
	 * Assign registration form as overlay fields
	 *
	 * @param $um_post_id
	 * @param $um_post
	 */
	function set_social_login_form_id( $um_post_id, $um_post ) {
		global $wpdb;

		if ( $um_post->post_type == 'um_form' ) {

			if ( isset( $_POST['form']['_um_social_login_form'] ) && $_POST['form']['_um_social_login_form'] > 0 ) {
				$wpdb->query( $wpdb->prepare("DELETE FROM $wpdb->postmeta WHERE post_id <> %d AND meta_key = %s ", $um_post_id, '_um_social_login_form' ) );
				update_option('um_social_login_form_installed', $um_post_id );
			} else {
				delete_post_meta( $um_post_id, '_um_social_login_form' );
			}

		}
	}


	/**
	 * Add form metabox
	 */
	function add_metabox_form() {

		add_meta_box('um-admin-social-login-buttons', __('Options','um-social-login'), array(&$this, 'load_metabox_form'), 'um_social_login', 'normal', 'default');
		add_meta_box('um-admin-social-login-shortcode', __('Shortcode','um-social-login'), array(&$this, 'load_metabox_form'), 'um_social_login', 'side', 'default');

	}


	/**
	 * Load a form metabox
	 *
	 * @param $object
	 * @param $box
	 */
	function load_metabox_form( $object, $box ) {
		$box['id'] = str_replace('um-admin-social-login-','', $box['id']);
		include_once um_social_login_path . 'includes/admin/templates/'. $box['id'] . '.php';
		wp_nonce_field( basename( __FILE__ ), 'um_admin_metabox_social_login_form_nonce' );
	}


	/**
	 * Save form metabox
	 *
	 * @param $um_post_id
	 * @param $um_post
	 *
	 * @return mixed
	 */
	function save_metabox_form( $um_post_id, $um_post ) {
		// validate nonce
		if ( !isset( $_POST['um_admin_metabox_social_login_form_nonce'] ) || !wp_verify_nonce( $_POST['um_admin_metabox_social_login_form_nonce'], basename( __FILE__ ) ) ) {
			return $um_post_id;
		}

		// validate post type
		if ( $um_post->post_type != 'um_social_login' ) {
			return $um_post_id;
		}

		// validate user
		$post_type = get_post_type_object( $um_post->post_type );
		if ( ! current_user_can( $post_type->cap->edit_post, $um_post_id ) ) {
			return $um_post_id;
		}

		// save
		foreach ( $_POST['social_login'] as $k => $v ) {
			if ( strstr( $k, '_um_' ) ) {
				update_post_meta( $um_post_id, $k, $v );
			}
		}

		return $um_post_id;
	}

}