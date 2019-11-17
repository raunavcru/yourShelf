<?php if ( ! defined( 'ABSPATH' ) ) exit;


/**
 * Avatar view
 *
 * @param $items
 *
 * @return mixed
 */
function um_social_login_user_photo_menu_edit( $items ) {
	wp_enqueue_script( 'um-social-login' );
	wp_enqueue_style( 'um-social-login' );

	$user_id = get_current_user_id();
	$networks = UM()->Social_Login_API()->networks;
	foreach ( $networks as $provider => $arr ) {

		if ( UM()->Social_Login_API()->is_connected( $user_id, $provider ) ) {
			if ( UM()->Social_Login_API()->get_user_photo( $user_id, $provider ) ) {
				$image_option ='<a href="javascript:void(0);" class="um-social-login-avatar-change"  data-provider="'.$provider .'" data-parent=".um-profile-photo" data-child=".um-btn-auto-width"><img src="'.UM()->Social_Login_API()->get_user_photo( $user_id, $provider ).'" class="um-provider-photo small" /><span class="um-social-login-avatar-change">'.__( 'Use this avatar','um-social-login').'</span></a><div class="um-clear"></div>';
				array_unshift( $items, $image_option );
			} elseif ( UM()->Social_Login_API()->get_dynamic_user_photo( $user_id, $provider ) ) {
				$image_option ='<a href="javascript:void(0);" class="um-social-login-avatar-change" data-provider="'.$provider .'"  data-parent=".um-profile-photo" data-child=".um-btn-auto-width"><img src="'.UM()->Social_Login_API()->get_dynamic_user_photo( $user_id, $provider ) .'" class="um-provider-photo small" /><span class="um-social-login-avatar-change">'.__( 'Use this avatar','um-social-login').'</span></a><div class="um-clear"></div>';
				array_unshift( $items, $image_option );
			}
		}

	}

	$profile_photo = get_user_meta( $user_id, 'profile_photo', true );
	if ( $profile_photo ) {
		$baseurl = UM()->uploader()->get_upload_base_url();
		if ( ! file_exists( UM()->uploader()->get_upload_base_dir() . $user_id . DIRECTORY_SEPARATOR . $profile_photo ) ) {
			if ( is_multisite() ) {
				//multisite fix for old customers
				$baseurl = str_replace( '/sites/' . get_current_blog_id() . '/', '/', $baseurl );
			}
		}

		$image_option ='<a href="javascript:void(0);" class="um-social-login-avatar-change" data-provider="core"  data-parent=".um-profile-photo" data-child=".um-btn-auto-width"><img src="' . $baseurl . $user_id . '/' . $profile_photo . '" class="um-provider-photo small" /><span class="um-social-login-avatar-change">'.__( 'Use this avatar','um-social-login').'</span></a><div class="um-clear"></div>';
		array_unshift( $items, $image_option );
	}

	return $items;
}
add_filter( 'um_user_photo_menu_edit', 'um_social_login_user_photo_menu_edit', 10, 1 );
add_filter( 'um_user_photo_menu_view', 'um_social_login_user_photo_menu_edit', 10, 1 );


/**
 * UM myCRED integration
 *
 * @param $installed
 * @param $point_type
 *
 * @return mixed
 */
function um_social_login_mycred_hooks( $installed, $point_type ) {
	// Connect
	$installed['um-mycred-social-login-connect'] = array(
		'title'        => __( 'UM - Connect Social Account', 'um-social-login' ),
		'description'  => __( 'Award points for users connecting Social Network.', 'um-social-login' ),
		'callback'     => array( 'UM_myCRED_Social_Login_Connect' )
	);

	// Disconnect
	$installed['um-mycred-social-login-disconnect'] = array(
		'title'        => __( 'UM - Disconnect Social Account', 'um-social-login' ),
		'description'  => __( 'Deduct points for users disconnecting Social Network.', 'um-social-login' ),
		'callback'     => array( 'UM_myCRED_Social_Login_Disconnect' )
	);

	return $installed;
}
add_filter( 'mycred_setup_hooks', 'um_social_login_mycred_hooks', 9, 2 );


/**
 * Profile Completeness integration
 *
 * @param $skip
 * @param $key
 * @param $result
 *
 * @return bool
 */
function um_profile_completeness_skip_field( $skip, $key, $result ) {
	if ( $key == 'profile_photo' && um_user( 'synced_profile_photo' ) ) {
		return true;
	}

	return $skip;
}
add_filter( 'um_profile_completeness_skip_field', 'um_profile_completeness_skip_field', 10, 3 );
