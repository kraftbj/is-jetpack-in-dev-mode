<?php
/**
 * Is Jetpack in Dev Mode
 *
 * @package     Is_Jetpack_In_Dev_Mode
 * @author      Brandon Kraft
 * @author      Gary Jones
 * @link        https://github.com/kraftbj/is-jetpack-in-dev-mode
 * @copyright   2014 Brandon Kraft
 * @license     GPL-2.0+
 *
 * @wordpress-plugin
 * Plugin Name: Is Jetpack in Dev Mode?
 * Plugin URI:  https://github.com/kraftbj/is-jetpack-in-dev-mode
 * Description: Is Jetpack in dev mode? Why? Who goes there?
 * Version:     1.0.0-beta3
 * Author:      Brandon Kraft
 * Author URI:  http://brandonkraft.com
 * Text Domain: is-jetpack-in-dev-mode
 * Domain Path: /languages
 * License:     GPL2+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

/**
 * Get Jetpack development mode notice text and notice class.
 *
 * Mirrors the checks made in Jetpack::is_development_mode
 *
 * @since 1.0.0
 *
 * @return array Notice text and class.
 */
function bk_jp_get_development_mode_notice() {
	$notice = __( 'Not in Development Mode', 'is-jetpack-in-dev-mode' );
	$class  = 'updated';

	if ( defined( 'JETPACK_DEV_DEBUG' ) && JETPACK_DEV_DEBUG ) {
		$notice = __( 'In Dev Mode, via wp-config.php or constant being defined elsewhere.', 'is-jetpack-in-dev-mode' );
		$class  = 'error';
	} elseif ( site_url() && false === strpos( site_url(), '.' ) ) {
		$notice = __( 'In Dev Mode, via site URL lacking a dot', 'is-jetpack-in-dev-mode' );
		$class  = 'error';
	}

	/** This filter should be documented in jetpack/class.jetpack.php */
	if ( apply_filters( 'jetpack_development_mode', false ) ) {
		$notice = __( 'In Dev Mode, via an add_filter call in a plugin.', 'is-jetpack-in-dev-mode' );
		$class  = 'error';
	}

	return compact( $notice, $class );
}

add_action( 'jetpack_notices', 'bk_jp_show_development_mode_notice' );
/**
 * Show Jetpack development mode notice.
 *
 * @since 1.0.0
 * 
 * @uses bk_jp_get_development_mode_notice() Get Jetpack development mode notice text and notice class.
 */
function bk_jp_show_development_mode_notice() {
	list( $notice, $class ) = bk_jp_get_development_mode_notice();
	?>
	<div class="<?php echo $class;?>">
		<p><?php echo $notice;?></p>
	</div>
	<?php
}
