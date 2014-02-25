<?php
/*
 * Plugin Name: Is Jetpack in Dev Mode?
 * Plugin URI: http://brandonkraft.com
 * Description: Is Jetpack in dev mode? Why? Who goes there?
 * Author: Brandon Kraft
 * Version: 1.0-beta2
 * Author URI: http://brandonkraft.com
 * License: GPL2+
 *
 */

function bk_jp_is_development_mode() {
	$development_mode = false;
	$development_mode_status = 'Not in Development Mode';
	$notice_status = "updated";

	if ( defined( 'JETPACK_DEV_DEBUG' ) ) {
		if ( JETPACK_DEV_DEBUG == true) {
			$development_mode_status = "In Dev Mode via wp-config.php or constant being defined elsewhere.";
			$notice_status = "error";
		}
	}

	elseif ( site_url() && false === strpos( site_url(), '.' ) ) {
		$development_mode_status = "In Dev Mode via site URL lacking a dot";
		$notice_status = "error";
	}

	if ( apply_filters( 'jetpack_development_mode', $development_mode ) == true ) {
		$development_mode_status = "In Dev Mode via an add_filter call in a plugin.";
		$notice_status = "error";
	}

	?>
	<div class="<?php echo $notice_status;?>">
		<p><?php echo $development_mode_status;?></p>
	</div>
	<?php
}

add_action( 'jetpack_notices', 'bk_jp_is_development_mode' );