<?php
/**
 * Backwards Compatible Permalinks
 *
 * @package   Aprea\BackwardsCompatiblePermalinks
 * @author    Chris Aprea
 * @copyright Copyright (C) 2019, Chris Aprea
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License, version 3 or higher
 *
 * @wordpress-plugin
 * Plugin Name: Backwards Compatible Permalinks
 * Description: Provides a degree of backwards compatibility when switching between permalink structures.
 * Version:     0.1.0
 * Author:      Chris Aprea
 * Author URI:  https://twitter.com/chrisaprea
 * Text Domain: backwards-compatible-permalinks
 * License:     GPL v3
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace Aprea\BackwardsCompatiblePermalinks;

/**
 * The meta key used to store the backwards compatibile permalink structure.
 *
 * @var string The meta key used to store the backwards compatibile permalink structure.
 */
const BACK_COMPAT_PERMALINK_STRUCTURE_META_KEY = 'aprea_back_compat_permalink_structure';

register_uninstall_hook( __FILE__, __NAMESPACE__ . '\\uninstall' );

add_filter( 'post_rewrite_rules', __NAMESPACE__ . '\\post_rewrite_rules_back_compat' );
add_action( 'update_option_permalink_structure', __NAMESPACE__ . '\\update_permalink_structure' );

/**
 * Returns the backwards compatible permalink structure.
 *
 * @return string The backwards compatible permalink structure.
 */
function get_back_compat_permalink_structure() {
	$back_compat_permalink_structure = get_option( BACK_COMPAT_PERMALINK_STRUCTURE_META_KEY ) ?: '';

	/**
	 * Filters the backwards compatible permalink structure.
	 *
	 * @param string $permalink_structure The backwards compatible permalink structure.
	 */
	return apply_filters( 'aprea_back_compat_permalink_structure', $back_compat_permalink_structure );
}

/**
 * Remove our option on plugin removal.
 *
 * @return void
 */
function uninstall() {
	delete_option( BACK_COMPAT_PERMALINK_STRUCTURE_META_KEY );
}

/**
 * Appends a set of backwards compatible post rewrite rules to ensure
 * posts are still accessible at their previous permalink after the
 * permalink structure is updated.
 *
 * @param  array $post_rewrite The rewrite rules for posts.
 * @return array               The modified rewrite rules for posts.
 */
function post_rewrite_rules_back_compat( $post_rewrite ) {
	global $wp_rewrite;

	$back_compat_permalink_structure = get_back_compat_permalink_structure();

	if ( empty( $back_compat_permalink_structure ) ) {
		return $post_rewrite;
	}

	return $post_rewrite + $wp_rewrite->generate_rewrite_rules( $back_compat_permalink_structure, EP_PERMALINK );
}

/**
 * Store a copy of the previous permalink structure on permalink structure update.
 *
 * @param  string $previous_permalink_structure The previous permalink structure.
 * @return void
 */
function update_permalink_structure( $previous_permalink_structure ) {
	if ( empty( $previous_permalink_structure ) ) {
		delete_option( BACK_COMPAT_PERMALINK_STRUCTURE_META_KEY );
		return;
	}

	update_option( BACK_COMPAT_PERMALINK_STRUCTURE_META_KEY, $previous_permalink_structure );
}
