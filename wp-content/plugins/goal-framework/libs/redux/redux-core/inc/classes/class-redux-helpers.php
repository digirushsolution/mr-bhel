<?php
/**
 * Redux Helper Class
 *
 * @class   Redux_Helpers
 * @version 3.0.0
 * @package Redux Framework/Classes
 */

defined( 'ABSPATH' ) || exit;

// Don't duplicate me!
if ( ! class_exists( 'Redux_Helpers', false ) ) {

	/**
	 * Redux Helpers Class
	 * Class of useful functions that can/should be shared among all Redux files.
	 *
	 * @since       3.0.0
	 */
	class Redux_Helpers {

		/**
		 * Resuable supported unit array.
		 *
		 * @var array
		 */
		public static $array_units = array( '', '%', 'in', 'cm', 'mm', 'em', 'rem', 'ex', 'pt', 'pc', 'px', 'vh', 'vw', 'vmin', 'vmax', 'ch' );

		/**
		 * Retrieve section array from field ID.
		 *
		 * @param string $opt_name Panel opt_name.
		 * @param string $field_id Field ID.
		 */
		public static function section_from_field_id( $opt_name = '', $field_id = '' ) {
			if ( '' !== $opt_name ) {
				$redux = Redux::instance( $opt_name );

				if ( is_object( $redux ) ) {
					$sections = $redux->sections;

					if ( is_array( $sections ) && ! empty( $sections ) ) {
						foreach ( $sections as $idx => $section ) {
							if ( isset( $section['fields'] ) && ! empty( $section['fields'] ) ) {
								foreach ( $section['fields'] as $i => $field ) {
									if ( is_array( $field ) && ! empty( $field ) ) {
										if ( isset( $field['id'] ) && $field['id'] === $field_id ) {
											return $section;
										}
									}
								}
							}
						}
					}
				}
			}
		}

		/**
		 * Verify integer value.
		 *
		 * @param mixed $val Value to test.
		 *
		 * @return bool|false|int
		 */
		public static function is_integer( $val ) {
			if ( ! is_scalar( $val ) || is_bool( $val ) ) {
				return false;
			}

			return is_float( $val ) ? false : preg_match( '~^((?:\+|-)?[0-9]+)$~', $val );
		}

		/**
		 * Deprecated. Gets panel tab number from specified field.
		 *
		 * @param object $parent ReduxFramework object.
		 * @param array  $field  Field array.
		 *
		 * @return int|string
		 * @deprecated No longer using camelCase naming convention.
		 */
		public static function tabFromField( $parent, $field ) { // phpcs:ignore WordPress.NamingConventions.ValidFunctionName
			_deprecated_function( __CLASS__ . '::' . __FUNCTION__, 'Redux 4.0', 'Redux_Helpers::tab_from_field( $parent, $field )' );

			return self::tab_from_field( $parent, $field );
		}

		/**
		 * Gets panel tab number from specified field.
		 *
		 * @param object $parent ReduxFramework object.
		 * @param array  $field  Field array.
		 *
		 * @return int|string
		 */
		public static function tab_from_field( $parent, $field ) {
			foreach ( $parent->sections as $k => $section ) {
				if ( ! isset( $section['title'] ) ) {
					continue;
				}

				if ( isset( $section['fields'] ) && ! empty( $section['fields'] ) ) {
					if ( self::recursive_array_search( $field, $section['fields'] ) ) {
						return $k;
					}
				}
			}
		}

		/**
		 * Deprecated. Verifies if specified field type is in use.
		 *
		 * @param object $fields Field arrays.
		 * @param array  $field  Field array.
		 *
		 * @return int|string
		 * @deprecated No longer using camelCase naming convention.
		 */
		public static function isFieldInUseByType( $fields, $field = array() ) { // phpcs:ignore WordPress.NamingConventions.ValidFunctionName
			// TODO - Uncomment this at release.
			// phpcs:ignore Squiz.PHP.CommentedOutCode
			// _deprecated_function( __CLASS__ . '::' . __FUNCTION__, 'Redux 4.0', 'Redux_Helpers::tab_from_field( $parent, $field )' );
			return self::is_field_in_use_by_type( $fields, $field );
		}

		/**
		 * Verifies if specified field type is in use.
		 *
		 * @param array $fields Field arrays.
		 * @param array $field  Field array to check.
		 *
		 * @return bool
		 */
		public static function is_field_in_use_by_type( $fields, $field = array() ) {
			foreach ( $field as $name ) {
				if ( array_key_exists( $name, $fields ) ) {
					return true;
				}
			}

			return false;
		}

		/**
		 * Deprecated Verifies if field is in use.
		 *
		 * @param object $parent ReduxFramework object.
		 * @param array  $field  Field type.
		 *
		 * @return bool
		 * @deprecated No longer using camelCase function names.
		 */
		public static function isFieldInUse( $parent, $field ) { // phpcs:ignore WordPress.NamingConventions.ValidFunctionName
			// TODO - Uncomment this at release.
			// phpcs:ignore Squiz.PHP.CommentedOutCode
			// _deprecated_function( __CLASS__ . '::' . __FUNCTION__, 'Redux 4.0', 'Redux_Helpers::is_field_in_use( $parent, $field )' );
			return self::is_field_in_use( $parent, $field );
		}

		/**
		 * Verifies if field is in use.
		 *
		 * @param object $parent ReduxFramework object.
		 * @param array  $field  Field type.
		 *
		 * @return bool
		 */
		public static function is_field_in_use( $parent, $field ) {
			if ( empty( $parent->sections ) ) {
				return;
			}
			foreach ( $parent->sections as $k => $section ) {
				if ( ! isset( $section['title'] ) ) {
					continue;
				}

				if ( isset( $section['fields'] ) && ! empty( $section['fields'] ) ) {
					if ( self::recursive_array_search( $field, $section['fields'] ) ) {
						return true;
					}
				}
			}
		}

		/**
		 * Returns major version from version number.
		 *
		 * @param string $v Version number.
		 *
		 * @return string
		 */
		public static function major_version( $v ) {
			$version = explode( '.', $v );
			if ( count( $version ) > 1 ) {
				return $version[0] . '.' . $version[1];
			} else {
				return $v;
			}
		}


		/**
		 * Deprecated. Checks for localhost environment.
		 *
		 * @return Redux_Helpers::is_local_host()
		 * @deprecated No longer using camelCase naming convention.
		 * @since      4.0
		 */
		public static function isLocalHost() { // phpcs:ignore WordPress.NamingConventions.ValidFunctionName
			_deprecated_function( __CLASS__ . '::' . __FUNCTION__, 'Redux 4.0', 'Redux_Helpers::is_local_host()' );

			return self::is_local_host();
		}

		/**
		 * Checks for localhost environment.
		 *
		 * @return bool
		 */
		public static function is_local_host() {
			$is_local = false;

			$domains_to_check = array_unique(
				array(
					'siteurl' => wp_parse_url( get_site_url(), PHP_URL_HOST ),
					'homeurl' => wp_parse_url( get_home_url(), PHP_URL_HOST ),
				)
			);

			$forbidden_domains = array(
				'wordpress.com',
				'localhost',
				'localhost.localdomain',
				'127.0.0.1',
				'::1',
				'local.wordpress.test',         // VVV pattern.
				'local.wordpress-trunk.test',   // VVV pattern.
				'src.wordpress-develop.test',   // VVV pattern.
				'build.wordpress-develop.test', // VVV pattern.
			);

			foreach ( $domains_to_check as $domain ) {
				// If it's empty, just fail out.
				if ( ! $domain ) {
					$is_local = true;
					break;
				}

				// None of the explicit localhosts.
				if ( in_array( $domain, $forbidden_domains, true ) ) {
					$is_local = true;
					break;
				}

				// No .test or .local domains.
				if ( preg_match( '#\.(test|local)$#i', $domain ) ) {
					$is_local = true;
					break;
				}
			}

			return $is_local;
		}

		/**
		 * Deprecated. Checks if WP_DEBUG is enabled.
		 *
		 * @return Redux_Helpers::is_wp_debug()
		 * @deprecated No longer using camelCase naming convention.
		 * @since      4.0
		 */
		public static function isWpDebug() { // phpcs:ignore WordPress.NamingConventions.ValidFunctionName
			_deprecated_function( __CLASS__ . '::' . __FUNCTION__, 'Redux 4.0', 'Redux_Functions_Ex::is_wp_debug()' );

			return self::is_wp_debug();
		}

		/**
		 * Checks if WP_DEBUG is enabled.
		 *
		 * @return bool
		 */
		public static function is_wp_debug() {
			return ( defined( 'WP_DEBUG' ) && true === WP_DEBUG );
		}

		/**
		 * Deprecated. Return tracking object.
		 *
		 * @return Redux_Helpers::get_statistics_object()
		 * @deprecated No longer using camelCase naming convention.
		 */
		public static function getTrackingObject() { // phpcs:ignore WordPress.NamingConventions.ValidFunctionName
			// phpcs:ignore: Squiz.PHP.CommentedOutCode
			/* _deprecated_function( __CLASS__ . '::' . __FUNCTION__, 'Redux 4.0.0', 'Redux_Instances::get_statistics_object()' ); */

			return self::get_statistics_object();
		}

		/**
		 * Deprecated. Return tracking object.
		 *
		 * @return Redux_Helpers::get_statistics_object()
		 * @deprecated No longer using camelCase naming convention.
		 */
		public static function trackingObject() { // phpcs:ignore WordPress.NamingConventions.ValidFunctionName
			// phpcs:ignore Squiz.PHP.CommentedOutCode
			/* _deprecated_function( __CLASS__ . '::' . __FUNCTION__, 'Redux 4.0.0', 'Redux_Instances::get_statistics_object()' ); */

			return self::get_statistics_object();
		}

		/**
		 * Return tracking object.
		 *
		 * @return array
		 */
		public static function get_statistics_object() {
			$hash = self::get_hash();

			global $blog_id, $wpdb;
			$pts = array();

			foreach ( get_post_types( array( 'public' => true ) ) as $pt ) {
				$count      = wp_count_posts( $pt );
				$pts[ $pt ] = $count->publish;
			}

			$comments_count = wp_count_comments();

			if ( ! function_exists( 'get_plugin_data' ) ) {
				if ( file_exists( ABSPATH . 'wp-admin/includes/plugin.php' ) ) {
					require_once ABSPATH . 'wp-admin/includes/plugin.php';
				}
				if ( file_exists( ABSPATH . 'wp-admin/includes/admin.php' ) ) {
					require_once ABSPATH . 'wp-admin/includes/admin.php';
				}
			}

			$plugins = array();

			foreach ( get_option( 'active_plugins', array() ) as $plugin_path ) {
				if ( file_exists( WP_PLUGIN_DIR . '/' . $plugin_path ) ) {
					$plugin_info = get_plugin_data( WP_PLUGIN_DIR . '/' . $plugin_path );
					$slug        = str_replace( '/' . basename( $plugin_path ), '', $plugin_path );

					$plugins[ $slug ] = array(
						'version'    => $plugin_info['Version'],
						'name'       => $plugin_info['Name'],
						'plugin_uri' => $plugin_info['PluginURI'],
						'author'     => $plugin_info['AuthorName'],
						'author_uri' => $plugin_info['AuthorURI'],
					);
				}
			}

			if ( is_multisite() ) {
				foreach ( get_option( 'active_sitewide_plugins', array() ) as $plugin_path ) {
					if ( file_exists( WP_PLUGIN_DIR . '/' . $plugin_path ) ) {
						$plugin_info      = get_plugin_data( WP_PLUGIN_DIR . '/' . $plugin_path );
						$slug             = str_replace( '/' . basename( $plugin_path ), '', $plugin_path );
						$plugins[ $slug ] = array(
							'version'    => $plugin_info['Version'],
							'name'       => $plugin_info['Name'],
							'plugin_uri' => $plugin_info['PluginURI'],
							'author'     => $plugin_info['AuthorName'],
							'author_uri' => $plugin_info['AuthorURI'],
						);
					}
				}
			}

			$user_query = new WP_User_Query(
				array(
					'blog_id'     => $blog_id,
					'count_total' => true,
				)
			);

			$comments_query = new WP_Comment_Query();

			$demo_mode = get_option( 'ReduxFrameworkPlugin', false );
			if ( ! empty( $demo_mode ) ) {
				$demo_mode = true;
			}

			$data = array(
				'hash'            => $hash,
				'wp_version'      => get_bloginfo( 'version' ),
				'multisite'       => is_multisite(),
				'users'           => $user_query->get_total(),
				'lang'            => get_locale(),
				'wp_debug'        => ( defined( 'WP_DEBUG' ) ? WP_DEBUG ? true : false : false ),
				'memory'          => WP_MEMORY_LIMIT,
				'localhost'       => Redux_Helpers::is_local_host(),
				'php'             => PHP_VERSION,
				'posts'           => $pts,
				'comments'        => array(
					'total'    => $comments_count->total_comments,
					'approved' => $comments_count->approved,
					'spam'     => $comments_count->spam,
					'pings'    => $comments_query->query(
						array(
							'count' => true,
							'type'  => 'pingback',
						)
					),
				),

				// phpcs:ignore WordPress.NamingConventions.ValidHookName
				'options'         => apply_filters( 'redux/tracking/options', array() ), // TODO - What is this?!

				'redux_installed' => Redux_Core::$installed,
				'redux_version'   => Redux_Core::$version,
				'redux_demo_mode' => $demo_mode,
				'redux_plugin'    => Redux_Core::$as_plugin,
				'developer'       => self::get_developer_keys(),
				'plugins'         => $plugins,
			);

			$theme_data = wp_get_theme();

			$theme = array(
				'theme_version'    => $theme_data->get( 'Version' ),
				'theme_name'       => $theme_data->get( 'Name' ),
				'theme_author'     => $theme_data->get( 'Author' ),
				'theme_author_uri' => $theme_data->get( 'AuthorURI' ),
				'theme_uri'        => $theme_data->get( 'ThemeURI' ),
				'theme_template'   => $theme_data->get( 'Template' ),
			);

			if ( is_child_theme() ) {
				$parent_theme = wp_get_theme( $theme_data->Template ); // phpcs:ignore WordPress.NamingConventions.ValidVariableName

				$theme['theme_is_child']          = true;
				$theme['theme_parent']            = $theme_data->Template;  // phpcs:ignore WordPress.NamingConventions.ValidVariableName,
				$theme['theme_parent_name']       = $parent_theme->get( 'Name' );
				$theme['theme_parent_version']    = $parent_theme->get( 'Version' );
				$theme['theme_parent_author']     = $parent_theme->get( 'Author' );
				$theme['theme_parent_author_uri'] = $parent_theme->get( 'AuthorURI' );
				$theme['theme_parent_uri']        = $parent_theme->get( 'ThemeURI' );
			}

			$data = wp_parse_args( $data, $theme );

			$parts    = explode( ' ', Redux_Core::$server['SERVER_SOFTWARE'] );
			$software = array();
			foreach ( $parts as $part ) {
				if ( '(' === $part[0] ) {
					continue;
				}
				if ( false !== strpos( $part, '/' ) ) {
					$chunk = explode( '/', $part );
					$software[ Redux_Core::strtolower( $chunk[0] ) ] = $chunk[1];
				}
			}
			$data['server']     = Redux_Core::$server['SERVER_SOFTWARE'];
			$data['db_version'] = $wpdb->db_version();

			$data['callers'] = self::process_redux_callers( true );

			if ( empty( $data['developer'] ) ) {
				unset( $data['developer'] );
			} else { // phpcs:ignore Generic.CodeAnalysis.EmptyStatement
				// phpcs:disable Squiz.PHP.CommentedOutCode

				/*
				 * print_r($data['developer']);
				 * echo "NOOO";
				 */
				// phpcs:enable Squiz.PHP.CommentedOutCode
			}

			ksort( $data );

			$data['extensions'] = self::get_extensions();

			return $data;
		}

		/**
		 * Get extensions.
		 *
		 * @param string $opt_name Panel opt_name.
		 *
		 * @return array
		 */
		public static function get_extensions( $opt_name = '' ) {
			if ( empty( $opt_name ) ) {
				$instances = Redux_Instances::get_all_instances();
			} else {
				$instances = array(
					Redux_Instances::get_instance( $opt_name ),
				);
			}

			$extensions = array();

			if ( ! empty( $instances ) ) {
				foreach ( $instances as $instance ) {
					if ( isset( $instance->extensions ) && is_array( $instance->extensions ) && ! empty( $instance->extensions ) ) {
						foreach ( $instance->extensions as $key => $extension ) {
							if ( in_array(
								$key,
								array(
									'metaboxes_lite',
									'import_export',
									'customizer',
									'options_object',
								),
								true
							)
							) {
								continue;
							}

							if ( isset( $extension::$version ) ) {
								$extensions[ $key ] = $extension::$version;
							} elseif ( isset( $extension->version ) ) {
								$extensions[ $key ] = $extension->version;
							} else {
								$extensions[ $key ] = true;
							}
						}
					}
				}
			}

			return $extensions;

		}

		/**
		 * Get encrypted tracking object.
		 *
		 * @return array
		 */
		// phpcs:ignore Squiz.PHP.CommentedOutCode
		// public static function tracking_object() {
		// $data = wp_remote_post(
		// 'http://verify.redux.io',
		// array(
		// 'body' => array(
		// 'hash' => $_GET['action'], // phpcs:ignore WordPress.Security.NonceVerification, sanitization ok.
		// 'site' => esc_url( home_url( '/' ) ),
		// ),
		// )
		// );
		// $data['body'] = urldecode( $data['body'] );
		// if ( ! isset( $_GET['code'] ) || $data['body'] !== $_GET['code'] ) { // phpcs:ignore WordPress.Security.NonceVerification
		// die();
		// }
		// return self::get_statistics_object();
		// } .

		/**
		 * Deprecated. Determines if theme is parent.
		 *
		 * @param string $file Path to file.
		 *
		 * @return Redux_Instances::isParentTheme( $file )
		 * @deprecated No longer using camelCase naming convention.
		 */
		public static function isParentTheme( $file ) { // phpcs:ignore WordPress.NamingConventions.ValidFunctionName
			_deprecated_function( __CLASS__ . '::' . __FUNCTION__, 'Redux 4.0.0', 'Redux_Instances::is_parent_theme( $file )' );

			return self::is_parent_theme( $file );
		}

		/**
		 * Determines if theme is parent.
		 *
		 * @param string $file Path to theme dir.
		 *
		 * @return bool
		 */
		public static function is_parent_theme( $file ) {
			$file = Redux_Functions_Ex::wp_normalize_path( $file );
			$dir  = Redux_Functions_Ex::wp_normalize_path( get_template_directory() );

			$file = str_replace( '//', '/', $file );
			$dir  = str_replace( '//', '/', $dir );

			if ( strpos( $file, $dir ) !== false ) {
				return true;
			}

			return false;
		}

		/**
		 * Deprecated. Moved to another class.
		 *
		 * @param string $file Path to file.
		 *
		 * @return Redux_Instances::wp_normalize_path( $file )
		 * @deprecated Moved to another class.
		 */
		public static function wp_normalize_path( $file ) { // phpcs:ignore WordPress.NamingConventions.ValidFunctionName
			_deprecated_function( __CLASS__ . '::' . __FUNCTION__, 'Redux 4.0.0', 'Redux_Functions_Ex::wp_normalize_path( $file )' );

			return Redux_Functions_Ex::wp_normalize_path( $file );
		}

		/**
		 * Deprecated. Determines if theme is child.
		 *
		 * @param string $file Path to file.
		 *
		 * @return Redux_Instances::is_child_theme( $file )
		 * @deprecated No longer using camelCase naming convention.
		 */
		public static function isChildTheme( $file ) { // phpcs:ignore WordPress.NamingConventions.ValidFunctionName
			_deprecated_function( __CLASS__ . '::' . __FUNCTION__, 'Redux 4.0.0', 'Redux_Instances::is_child_theme( $file )' );

			return self::is_child_theme( $file );
		}

		/**
		 * Deprecated. Returns true if Redux is running as a plugin.
		 *
		 * @return Redux_Helpers::()
		 * @deprecated No longer using camelCase naming convention.
		 */
		private static function reduxAsPlugin() { // phpcs:ignore WordPress.NamingConventions.ValidFunctionName
			_deprecated_function( __CLASS__ . '::' . __FUNCTION__, 'Redux 4.0.0', 'Redux_Core::$as_plugin()' );

			return Redux_Core::$as_plugin;
		}

		/**
		 * Determines if theme is child.
		 *
		 * @param string $file Path to theme dir.
		 *
		 * @return bool
		 */
		public static function is_child_theme( $file ) {
			$file = Redux_Functions_Ex::wp_normalize_path( $file );
			$dir  = Redux_Functions_Ex::wp_normalize_path( get_stylesheet_directory() );

			$file = str_replace( '//', '/', $file );
			$dir  = str_replace( '//', '/', $dir );

			if ( strpos( $file, $dir ) !== false ) {
				return true;
			}

			return false;
		}

		/**
		 * Deprecated. Determines if file is a theme.
		 *
		 * @param string $file Path to file.
		 *
		 * @return Redux_Instances::is_theme( $file )
		 * @deprecated No longer using camelCase naming convention.
		 */
		public static function isTheme( $file ) { // phpcs:ignore WordPress.NamingConventions.ValidFunctionName
			// phpcs:ignore Squiz.PHP.CommentedOutCode
			// _deprecated_function( __CLASS__ . '::' . __FUNCTION__, 'Redux 4.0.0', 'Redux_Instances::is_theme( $file )' );

			return self::is_theme( $file );
		}

		/**
		 * Determines if file is a theme.
		 *
		 * @param string $file Path to fle to test.
		 *
		 * @return bool
		 */
		public static function is_theme( $file ) {
			if ( true === self::is_child_theme( $file ) || true === self::is_parent_theme( $file ) ) {
				return true;
			}

			return false;
		}

		/**
		 * Determines deep array status.
		 *
		 * @param array $needle   array to test.
		 * @param array $haystack Array to search.
		 *
		 * @return bool
		 */
		public static function array_in_array( $needle, $haystack ) {
			// Make sure $needle is an array for foreach.
			if ( ! is_array( $needle ) ) {
				$needle = array( $needle );
			}
			// For each value in $needle, return TRUE if in $haystack.
			foreach ( $needle as $pin ) {
				if ( in_array( $pin, $haystack, true ) ) {
					return true;
				}
			}

			// Return FALSE if none of the values from $needle are found in $haystack.
			return false;
		}

		/**
		 * Enum through an entire deep array.
		 *
		 * @param string $needle   String to search for.
		 * @param array  $haystack Array in which to search.
		 *
		 * @return bool
		 */
		public static function recursive_array_search( $needle, $haystack ) {
			foreach ( $haystack as $key => $value ) {
				if ( $needle === $value || ( is_array( $value ) && self::recursive_array_search( $needle, $value ) !== false ) ) {
					return true;
				}
			}

			return false;
		}

		/**
		 * Take a path and return it clean.
		 *
		 * @param string $path Path to clean.
		 *
		 * @return Redux_Functions_Ex::wp_normalize_path($path)
		 * @deprecated Replaced with wp_normalize_path.
		 * @since      3.1.7
		 */
		public static function cleanFilePath( $path ) { // phpcs:ignore WordPress.NamingConventions.ValidFunctionName
			// TODO - Uncomment this at release.
			// phpcs:ignore Squiz.PHP.CommentedOutCode
			// _deprecated_function( __CLASS__ . '::' . __FUNCTION__, 'Redux 4.0', 'Redux_Functions_Ex::wp_normalize_path( $path )' );
			return Redux_Functions_Ex::wp_normalize_path( $path );
		}

		/**
		 * Create unique hash.
		 *
		 * @return string
		 */
		public static function get_hash() {
			$remote_addr = isset( Redux_Core::$server['REMOTE_ADDR'] )
				? Redux_Core::$server['REMOTE_ADDR']
				: '127.0.0.1';
			return md5( network_site_url() . '-' . $remote_addr );
		}

		/**
		 * Return array of installed themes.
		 *
		 * @return array
		 */
		public static function get_wp_themes() {
			global $wp_theme_paths;

			$wp_theme_paths = array();
			$themes         = wp_get_themes();
			$theme_paths    = array();

			foreach ( $themes as $theme ) {
				$path          = Redux_Functions_Ex::wp_normalize_path( trailingslashit( $theme->get_theme_root() ) . $theme->get_template() );
				$theme_paths[] = $path;

				if ( Redux_Functions_Ex::wp_normalize_path( realpath( $path ) ) !== $path ) {
					$theme_paths[] = Redux_Functions_Ex::wp_normalize_path( realpath( $path ) );
				}

				$wp_theme_paths[ $path ] = Redux_Functions_Ex::wp_normalize_path( realpath( $path ) );
			}

			return array(
				'full_paths'  => $wp_theme_paths,
				'theme_paths' => $theme,
			);
		}

		/**
		 * Get info for specified file.
		 *
		 * @param string $file File to check.
		 *
		 * @return array|bool
		 */
		public static function path_info( $file ) {
			$theme_info  = Redux_Functions_Ex::is_inside_theme( $file );
			$plugin_info = Redux_Functions_Ex::is_inside_plugin( $file );

			if ( false !== $theme_info ) {
				return $theme_info;
			} elseif ( false !== $plugin_info ) {
				return $plugin_info;
			}

			return array();
		}

		/**
		 * Compiles caller data for Redux.
		 *
		 * @param book $simple Mode.
		 *
		 * @return array
		 */
		public static function process_redux_callers( $simple = false ) {
			$data = array();

			foreach ( Redux_Core::$callers as $opt_name => $callers ) {
				foreach ( $callers as $caller ) {
					$plugin_info = self::is_inside_plugin( $caller );
					$theme_info  = self::is_inside_theme( $caller );

					if ( $theme_info ) {
						if ( ! isset( $data['theme'][ $theme_info['slug'] ] ) ) {
							$data['theme'][ $theme_info['slug'] ] = array();
						}
						if ( ! isset( $data['theme'][ $theme_info['slug'] ][ $opt_name ] ) ) {
							$data['theme'][ $theme_info['slug'] ][ $opt_name ] = array();
						}
						if ( $simple ) {
							$data['theme'][ $theme_info['slug'] ][ $opt_name ][] = $theme_info['basename'];
						} else {
							$data['theme'][ $theme_info['slug'] ][ $opt_name ][] = $theme_info;
						}
					} elseif ( $plugin_info ) {
						if ( ! isset( $data['plugin'][ $plugin_info['slug'] ] ) ) {
							$data['plugin'][ $plugin_info['slug'] ] = array();
						}
						if ( ! in_array( $opt_name, $data['plugin'][ $plugin_info['slug'] ], true ) ) {
							if ( ! isset( $data['plugin'][ $plugin_info['slug'] ][ $opt_name ] ) ) {
								$data['plugin'][ $plugin_info['slug'] ][ $opt_name ] = array();
							}
							if ( $simple ) {
								$data['plugin'][ $plugin_info['slug'] ][ $opt_name ][] = $plugin_info['basename'];
							} else {
								$data['plugin'][ $plugin_info['slug'] ][ $opt_name ][] = $plugin_info;
							}
						}
					} else {
						continue;
					}
				}
			}

			return $data;
		}

		/**
		 * Take a path and delete it
		 *
		 * @param string $dir Dir to remove.
		 *
		 * @since    3.3.3
		 */
		public static function rmdir( $dir ) {
			if ( is_dir( $dir ) ) {
				$objects = scandir( $dir );

				foreach ( $objects as $object ) {
					if ( '.' !== $object && '..' !== $object ) {
						if ( filetype( $dir . '/' . $object ) === 'dir' ) {
							rmdir( $dir . '/' . $object );
						} else {
							unlink( $dir . '/' . $object );
						}
					}
				}

				reset( $objects );

				rmdir( $dir );
			}
		}

		/**
		 * Field Render Function.
		 * Takes the color hex value and converts to a rgba.
		 *
		 * @param string $hex   Color value.
		 * @param string $alpha Alpha value.
		 *
		 * @since ReduxFramework 3.0.4
		 */
		public static function hex2rgba( $hex, $alpha = '' ) {
			$hex = str_replace( '#', '', $hex );
			if ( 3 === strlen( $hex ) ) {
				$r = hexdec( substr( $hex, 0, 1 ) . substr( $hex, 0, 1 ) );
				$g = hexdec( substr( $hex, 1, 1 ) . substr( $hex, 1, 1 ) );
				$b = hexdec( substr( $hex, 2, 1 ) . substr( $hex, 2, 1 ) );
			} else {
				$r = hexdec( substr( $hex, 0, 2 ) );
				$g = hexdec( substr( $hex, 2, 2 ) );
				$b = hexdec( substr( $hex, 4, 2 ) );
			}
			$rgb = $r . ',' . $g . ',' . $b;

			if ( '' === $alpha ) {
				return $rgb;
			} else {
				$alpha = floatval( $alpha );

				return 'rgba(' . $rgb . ',' . $alpha . ')';
			}
		}

		/**
		 * Deprecated. Returns string boolean value.
		 *
		 * @param string $var String to convert to true boolean.
		 *
		 * @return Redux_Helpers::make_bool_str( $var )
		 * @deprecated No longer using camelCase naming convention.
		 */
		public static function makeBoolStr( $var ) { // phpcs:ignore WordPress.NamingConventions.ValidFunctionName
			_deprecated_function( __CLASS__ . '::' . __FUNCTION__, 'Redux 4.0.0', 'Redux_Instances::make_bool_str( $var )' );

			return self::make_bool_str( $var );
		}

		/**
		 * Returns string boolean value.
		 *
		 * @param mixed $var true|false to convert.
		 *
		 * @return string
		 */
		public static function make_bool_str( $var ) {
			if ( false === $var || 'false' === $var || 0 === $var || '0' === $var || '' === $var || empty( $var ) ) {
				return 'false';
			} elseif ( true === $var || 'true' === $var || 1 === $var || '1' === $var ) {
				return 'true';
			} else {
				return $var;
			}
		}

		/**
		 * Compile localized array.
		 *
		 * @param array $localize Array of localized strings.
		 *
		 * @return mixed
		 */
		public static function localize( $localize ) {
			$redux = Redux::instance( $localize['args']['opt_name'] );
			$nonce = wp_create_nonce( 'redux-ads-nonce' );
			$base  = admin_url( 'admin-ajax.php' ) . '?t=' . $redux->core_thread . '&action=redux_p&nonce=' . $nonce . '&url=';

			return $localize;
		}

		/**
		 * Retrieved request headers.
		 *
		 * @param array $args array of headers.
		 *
		 * @return array
		 */
		public static function get_request_headers( $args = array() ) {
			$instances = Redux_Instances::get_all_instances();

			$array = array(
				'hash'       => self::get_hash(),
				'developers' => wp_json_encode( self::get_developer_keys() ),
				'redux'      => Redux_Core::$version,
				'installed'  => Redux_Core::$installed,
				'debug'      => defined( 'WP_DEBUG' ) && WP_DEBUG ? true : false,
				'local'      => self::is_local_host(),
				'wordpress'  => get_bloginfo( 'version' ),
				'site'       => esc_url( home_url( '/' ) ),
				'auto_fonts' => get_option( 'auto_update_redux_google_fonts', false ),
				'extensions' => join( '|', array_keys( self::get_extensions() ) ),
			);
			if ( ! empty( $instances ) ) {
				$array['opt_names'] = join( '|', array_keys( $instances ) );
			}

			if ( ! empty( $args ) ) {
				return wp_parse_args( $args, $array );
			}

			return $array;
		}

		/**
		 * Check mokama.
		 *
		 * @access public
		 * @since 4.0.0
		 * @return bool
		 */
		public static function mokama() {
			if ( defined( 'RDX_MOKAMA' ) ) {
				return Redux_Functions_Ex::s();
			}
			return false;
		}

		/**
		 * Deprecated. Compiles array of system specs.
		 *
		 * @param boolean $json_output   Enable/Disable return in JSON format.
		 * @param boolean $remote_checks Enable/Disable remote URL testing.
		 *
		 * @return Redux_Helpers::compile_system_status( $json_output, $remote_checks )
		 * @deprecated No longer using camelCase naming convention.
		 */
		public static function compileSystemStatus( $json_output = false, $remote_checks = false ) { // phpcs:ignore WordPress.NamingConventions.ValidFunctionName
			_deprecated_function( __CLASS__ . '::' . __FUNCTION__, 'Redux 4.0.0', 'Redux_Instances::compile_system_status( $json_output, $remote_checks )' );

			return self::compile_system_status( $json_output, $remote_checks );
		}

		/**
		 * Compiles array of stsyem specs.
		 *
		 * @param bool $json_output   Output file as JSON string.
		 * @param bool $remote_checks Perform remote checks.
		 *
		 * @return array
		 */
		public static function compile_system_status( $json_output = false, $remote_checks = false ) {
			global $wpdb;

			$sysinfo = array();

			$sysinfo['home_url']       = home_url();
			$sysinfo['site_url']       = site_url();
			$sysinfo['redux_ver']      = esc_html( Redux_Core::$version );
			$sysinfo['redux_data_dir'] = Redux_Core::$upload_dir;

			$fs        = Redux_Filesystem::get_instance();
			$test_file = Redux_Core::$upload_dir . 'test-log.log';
			if ( $fs->is_file( $test_file ) ) {
				$res = $fs->unlink( $test_file );
			} else {
				$res = $fs->touch( $test_file );
				$fs->unlink( $test_file );
			}

			// Only is a file-write check.
			$sysinfo['redux_data_writeable'] = $res;
			$sysinfo['wp_content_url']       = WP_CONTENT_URL;
			$sysinfo['wp_ver']               = get_bloginfo( 'version' );
			$sysinfo['wp_multisite']         = is_multisite();
			$sysinfo['permalink_structure']  = get_option( 'permalink_structure' ) ? get_option( 'permalink_structure' ) : 'Default';
			$sysinfo['front_page_display']   = get_option( 'show_on_front' );
			if ( 'page' === $sysinfo['front_page_display'] ) {
				$front_page_id = get_option( 'page_on_front' );
				$blog_page_id  = get_option( 'page_for_posts' );

				$sysinfo['front_page'] = 0 !== $front_page_id ? get_the_title( $front_page_id ) . ' (#' . $front_page_id . ')' : 'Unset';
				$sysinfo['posts_page'] = 0 !== $blog_page_id ? get_the_title( $blog_page_id ) . ' (#' . $blog_page_id . ')' : 'Unset';
			}

			$sysinfo['wp_mem_limit']['raw']  = self::let_to_num( WP_MEMORY_LIMIT );
			$sysinfo['wp_mem_limit']['size'] = size_format( $sysinfo['wp_mem_limit']['raw'] );

			$sysinfo['db_table_prefix'] = 'Length: ' . strlen( $wpdb->prefix ) . ' - Status: ' . ( strlen( $wpdb->prefix ) > 16 ? 'ERROR: Too long' : 'Acceptable' );

			$sysinfo['wp_debug'] = false;
			if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
				$sysinfo['wp_debug'] = true;
			}

			$sysinfo['wp_lang'] = get_locale();

			if ( ! class_exists( 'Browser' ) ) {
				require_once Redux_Core::$dir . 'inc/lib/browser.php';
			}

			$browser = new Browser();

			$sysinfo['browser'] = array(
				'agent'    => $browser->getUserAgent(),
				'browser'  => $browser->getBrowser(),
				'version'  => $browser->getVersion(),
				'platform' => $browser->getPlatform(),
			);

			$sysinfo['server_info'] = esc_html( Redux_Core::$server['SERVER_SOFTWARE'] );
			$sysinfo['localhost']   = self::make_bool_str( self::is_local_host() );
			$sysinfo['php_ver']     = function_exists( 'phpversion' ) ? esc_html( phpversion() ) : 'phpversion() function does not exist.';
			$sysinfo['abspath']     = ABSPATH;

			if ( function_exists( 'ini_get' ) ) {
				$sysinfo['php_mem_limit']      = size_format( self::let_to_num( ini_get( 'memory_limit' ) ) );
				$sysinfo['php_post_max_size']  = size_format( self::let_to_num( ini_get( 'post_max_size' ) ) );
				$sysinfo['php_time_limit']     = ini_get( 'max_execution_time' );
				$sysinfo['php_max_input_var']  = ini_get( 'max_input_vars' );
				$sysinfo['php_display_errors'] = self::make_bool_str( ini_get( 'display_errors' ) );
			}

			$sysinfo['suhosin_installed'] = extension_loaded( 'suhosin' );
			$sysinfo['mysql_ver']         = $wpdb->db_version();
			$sysinfo['max_upload_size']   = size_format( wp_max_upload_size() );

			$sysinfo['def_tz_is_utc'] = true;
			if ( date_default_timezone_get() !== 'UTC' ) {
				$sysinfo['def_tz_is_utc'] = false;
			}

			$sysinfo['fsockopen_curl'] = false;

			if ( function_exists( 'fsockopen' ) || function_exists( 'curl_init' ) ) {
				$sysinfo['fsockopen_curl'] = true;
			}

			if ( true === $remote_checks ) {
				$response = wp_remote_post(
					'https://api.redux.io/status',
					array(
						'sslverify' => true,
						'timeout'   => 60,
						'headers'   => self::get_request_headers(),
					)
				);

				// if ( ! is_wp_error( $response ) && $response['response']['code'] >= 200 && $response['response']['code'] < 300 ) {
				// 	$sysinfo['wp_remote_post']       = true;
				// 	$sysinfo['wp_remote_post_error'] = '';
				// } else {
				// 	$sysinfo['wp_remote_post']       = false;
				// 	$sysinfo['wp_remote_post_error'] = $response->get_error_message();
				// }

				// phpcs:ignore WordPress.PHP.NoSilencedErrors
				$response = @wp_remote_get( 'https://raw.githubusercontent.com/dovy/redux-framework/master/CONTRIBUTING.md' );

				if ( ! is_wp_error( $response ) && $response['response']['code'] >= 200 && $response['response']['code'] < 300 ) {
					$sysinfo['wp_remote_get']       = true;
					$sysinfo['wp_remote_get_error'] = '';
				} else {
					$sysinfo['wp_remote_get']       = false;
					$sysinfo['wp_remote_get_error'] = $response->get_error_message();
				}
			}

			$active_plugins = (array) get_option( 'active_plugins', array() );

			if ( is_multisite() ) {
				$active_plugins = array_merge( $active_plugins, get_site_option( 'active_sitewide_plugins', array() ) );
			}

			$sysinfo['plugins'] = array();

			foreach ( $active_plugins as $plugin ) {
				if ( file_exists( WP_PLUGIN_DIR . '/' . $plugin ) ) {
					// phpcs:ignore WordPress.PHP.NoSilencedErrors
					$plugin_data = @get_plugin_data( WP_PLUGIN_DIR . '/' . $plugin );
					$plugin_name = esc_html( $plugin_data['Name'] );

					$sysinfo['plugins'][ $plugin_name ] = $plugin_data;
				}
			}

			$redux = Redux::all_instances();

			$sysinfo['redux_instances'] = array();

			if ( ! empty( $redux ) && is_array( $redux ) ) {
				foreach ( $redux as $inst => $data ) {
					Redux::init( $inst );

					$sysinfo['redux_instances'][ $inst ]['args']     = $data->args;
					$sysinfo['redux_instances'][ $inst ]['sections'] = $data->sections;
					foreach ( $sysinfo['redux_instances'][ $inst ]['sections'] as $key => $section ) {
						if ( isset( $section['fields'] ) && is_array( $section['fields'] ) ) {
							foreach ( $section['fields'] as $field_key => $field ) {
								if ( isset( $field['validate_callback'] ) ) {
									unset( $sysinfo['redux_instances'][ $inst ]['sections'][ $key ]['fields'][ $field_key ]['validate_callback'] );
								}
								if ( 'js_button' === $field['type'] ) {
									if ( isset( $field['script'] ) && isset( $field['script']['ver'] ) ) {
										unset( $sysinfo['redux_instances'][ $inst ]['sections'][ $key ]['fields'][ $field_key ]['script']['ver'] );
									}
								}
							}
						}
					}

					$sysinfo['redux_instances'][ $inst ]['extensions'] = Redux::get_extensions( $inst );

					$metabox_key = isset( $data->extensions['metaboxes'] ) ? 'metaboxes' : 'metaboxes_lite';

					if ( isset( $data->extensions[ $metabox_key ] ) ) {
						$data->extensions[ $metabox_key ]->init();
						$sysinfo['redux_instances'][ $inst ][ $metabox_key ] = $data->extensions[ $metabox_key ]->boxes;
					}

					if ( isset( $data->args['templates_path'] ) && '' !== $data->args['templates_path'] ) {
						$sysinfo['redux_instances'][ $inst ]['templates'] = self::get_redux_templates( $data->args['templates_path'] );
					}
				}
			}

			$active_theme = wp_get_theme();

			$sysinfo['theme']['name']       = $active_theme->Name; // phpcs:ignore WordPress.NamingConventions.ValidVariableName
			$sysinfo['theme']['version']    = $active_theme->Version; // phpcs:ignore WordPress.NamingConventions.ValidVariableName
			$sysinfo['theme']['author_uri'] = $active_theme->{'Author URI'};
			$sysinfo['theme']['is_child']   = self::make_bool_str( is_child_theme() );

			if ( is_child_theme() ) {
				$parent_theme = wp_get_theme( $active_theme->Template ); // phpcs:ignore WordPress.NamingConventions.ValidVariableName

				$sysinfo['theme']['parent_name']       = $parent_theme->Name; // phpcs:ignore WordPress.NamingConventions.ValidVariableName
				$sysinfo['theme']['parent_version']    = $parent_theme->Version; // phpcs:ignore WordPress.NamingConventions.ValidVariableName
				$sysinfo['theme']['parent_author_uri'] = $parent_theme->{'Author URI'};
			}

			return $sysinfo;
		}

		/**
		 * Deprecated. Returns array of Redux templates.
		 *
		 * @param string $custom_template_path Path to custom template.
		 *
		 * @return Redux_Helpers::get_redux_templates( $custom_template_path )
		 * @deprecated No longer using camelCase naming convention.
		 */
		private static function getReduxTemplates( $custom_template_path ) { // phpcs:ignore WordPress.NamingConventions.ValidFunctionName
			_deprecated_function( __CLASS__ . '::' . __FUNCTION__, 'Redux 4.0.0', 'Redux_Instances::get_redux_templates( $custom_template_path )' );

			return self::get_redux_templates( $custom_template_path );
		}

		/**
		 * Returns array of Redux templates.
		 *
		 * @param string $custom_template_path Path to template dir.
		 *
		 * @return array
		 */
		private static function get_redux_templates( $custom_template_path ) {
			$filesystem         = Redux_Filesystem::get_instance();
			$template_paths     = array( 'ReduxFramework' => Redux_Core::$dir . 'templates/panel' );
			$scanned_files      = array();
			$found_files        = array();
			$outdated_templates = false;

			foreach ( $template_paths as $plugin_name => $template_path ) {
				$scanned_files[ $plugin_name ] = self::scan_template_files( $template_path );
			}

			foreach ( $scanned_files as $plugin_name => $files ) {
				foreach ( $files as $file ) {
					if ( file_exists( $custom_template_path . '/' . $file ) ) {
						$theme_file = $custom_template_path . '/' . $file;
					} else {
						$theme_file = false;
					}

					if ( $theme_file ) {
						$core_version  = self::get_template_version( Redux_Core::$dir . 'templates/panel/' . $file );
						$theme_version = self::get_template_version( $theme_file );

						if ( $core_version && ( empty( $theme_version ) || version_compare( $theme_version, $core_version, '<' ) ) ) {
							if ( ! $outdated_templates ) {
								$outdated_templates = true;
							}

							$found_files[ $plugin_name ][] = sprintf( '<code>%s</code> ' . esc_html__( 'version', 'redux-framework' ) . ' <strong style="color:red">%s</strong> ' . esc_html__( 'is out of date. The core version is', 'redux-framework' ) . ' %s', str_replace( WP_CONTENT_DIR . '/themes/', '', $theme_file ), $theme_version ? $theme_version : '-', $core_version );
						} else {
							$found_files[ $plugin_name ][] = sprintf( '<code>%s</code>', str_replace( WP_CONTENT_DIR . '/themes/', '', $theme_file ) );
						}
					}
				}
			}

			return $found_files;
		}

		/**
		 * Deprecated. URL Fix.
		 *
		 * @param string $base     Base string of site.
		 * @param string $opt_name Redux instance opt_name.
		 *
		 * @return Redux_Helpers::r_url_fix( $base, $opt_name )
		 * @deprecated No longer using camelCase naming convention.
		 */
		public static function rURL_fix( $base, $opt_name ) { // phpcs:ignore WordPress.NamingConventions.ValidFunctionName
			_deprecated_function( __CLASS__ . '::' . __FUNCTION__, 'Redux 4.0.0', 'Redux_Instances::r_url_fix( $base, $opt_name )' );

			return self::r_url_fix( $base, $opt_name );
		}

		/**
		 * URL Fix.
		 *
		 * @param string $base     Base.
		 * @param string $opt_name Panel opt_name.
		 *
		 * @return mixed|string|void
		 */
		public static function r_url_fix( $base, $opt_name ) {
			$url = $base . rawurlencode( 'https://look.redux.io/api/index.php?js&g&1&v=2' ) . '&proxy=' . rawurlencode( $base ) . '';

			return Redux_Functions::tru( $url, $opt_name );
		}

		/**
		 * Scan template files for ver changes.
		 *
		 * @param string $template_path Path to templates.
		 *
		 * @return array
		 */
		private static function scan_template_files( $template_path ) {
			$files  = scandir( $template_path );
			$result = array();

			if ( $files ) {
				foreach ( $files as $key => $value ) {
					if ( ! in_array( $value, array( '.', '..' ), true ) ) {
						if ( is_dir( $template_path . DIRECTORY_SEPARATOR . $value ) ) {
							$sub_files = redux_scan_template_files( $template_path . DIRECTORY_SEPARATOR . $value );
							foreach ( $sub_files as $sub_file ) {
								$result[] = $value . DIRECTORY_SEPARATOR . $sub_file;
							}
						} else {
							$result[] = $value;
						}
					}
				}
			}

			return $result;
		}

		/**
		 * Retrieves template version.
		 *
		 * @param string $file Path to template file.
		 *
		 * @return string
		 */
		public static function get_template_version( $file ) {
			$filesystem = Redux_Filesystem::get_instance();
			// Avoid notices if file does not exist.
			if ( ! file_exists( $file ) ) {
				return '';
			}

			$data = get_file_data( $file, array( 'version' ), 'plugin' );

			if ( ! empty( $data[0] ) ) {
				return $data[0];
			} else {
				$file_data = $filesystem->get_contents( $file );

				$file_data = str_replace( "\r", "\n", $file_data );
				$version   = '1.0.0';

				if ( preg_match( '/^[ \t\/*#@]*' . preg_quote( '@version', '/' ) . '(.*)$/mi', $file_data, $match ) && $match[1] ) {
					$version = _cleanup_header_comment( $match[1] );
				}

				return $version;
			}
		}

		/**
		 * Create HTML attribute string.
		 *
		 * @param array $attributes Array of attributes.
		 */
		public static function html_attributes( $attributes = array() ) {
			$string = join(
				' ',
				array_map(
					function ( $key ) use ( $attributes ) {
						if ( is_bool( $attributes[ $key ] ) ) {
							return $attributes[ $key ] ? $key : '';
						}

						return $key . '="' . $attributes[ $key ] . '"';
					},
					array_keys( $attributes )
				)
			) . ' ';
		}

		/**
		 * Output filesize based on letter indicator.
		 *
		 * @param string $size Size with letter.
		 *
		 * @return bool|int|string
		 */
		private static function let_to_num( $size ) {
			$l   = substr( $size, - 1 );
			$ret = substr( $size, 0, - 1 );

			switch ( strtoupper( $l ) ) {
				case 'P':
					$ret *= 1024;
					// Must remain recursive, do not use 'break'.
				case 'T':
					$ret *= 1024;
					// Must remain recursive, do not use 'break'.
				case 'G':
					$ret *= 1024;
					// Must remain recursive, do not use 'break'.
				case 'M':
					$ret *= 1024;
					// Must remain recursive, do not use 'break'.
				case 'K':
					$ret *= 1024;
			}

			return $ret;
		}

		/**
		 * Normalize extensions dir.
		 *
		 * @param string $dir Path to extensions.
		 *
		 * @return string
		 */
		public static function get_extension_dir( $dir ) {
			return trailingslashit( Redux_Functions_Ex::wp_normalize_path( dirname( $dir ) ) );
		}

		/**
		 * Normalize extensions URL.
		 *
		 * @param string $dir Path to extensions.
		 *
		 * @return mixed
		 */
		public static function get_extension_url( $dir ) {
			$ext_dir = self::get_extension_dir( $dir );
			$ext_url = str_replace( Redux_Functions_Ex::wp_normalize_path( WP_CONTENT_DIR ), WP_CONTENT_URL, $ext_dir );

			return $ext_url;
		}

		/**
		 * Checks a nested capabilities array or string to determine if the current user meets the requirements.
		 *
		 * @param string|array $capabilities Permission string or array to check. See self::user_can() for details.
		 *
		 * @return bool Whether or not the user meets the requirements. False on invalid user.
		 * @since 3.6.3.4
		 */
		public static function current_user_can( $capabilities ) {
			$current_user = wp_get_current_user();

			if ( empty( $current_user ) ) {
				return false;
			}

			$name_arr = func_get_args();
			$args     = array_merge( array( $current_user ), $name_arr );

			return call_user_func_array( array( 'self', 'user_can' ), $args );
		}

		/**
		 * Checks a nested capabilities array or string to determine if the user meets the requirements.
		 * You can pass in a simple string like 'edit_posts' or an array of conditions.
		 * The capability 'relation' is reserved for controlling the relation mode (AND/OR), which defaults to AND.
		 * Max depth of 30 levels.  False is returned for any conditions exceeding max depth.
		 * If you want to check meta caps, you must also pass the object ID on which to check against.
		 * If you get the error: PHP Notice:  Undefined offset: 0 in /wp-includes/capabilities.php, you didn't
		 * pass the required $object_id.
		 *
		 * @param int|object   $user          User ID or WP_User object to check. Defaults to the current user.
		 * @param string|array $capabilities  Capability string or array to check. The array lets you use multiple
		 *                                    conditions to determine if a user has permission.
		 *                                    Invalid conditions are skipped (conditions which aren't a string/array/bool/number(cast to bool)).
		 *                                    Example array where the user needs to have either the 'edit_posts' capability OR doesn't have the
		 *                                    'delete_pages' cap OR has the 'update_plugins' AND 'add_users' capabilities.
		 *                                    array(
		 *                                    'relation'     => 'OR',      // Optional, defaults to AND.
		 *                                    'edit_posts',                // Equivalent to 'edit_posts' => true,
		 *                                    'delete_pages' => false,     // Tests that the user DOESN'T have this capability
		 *                                    array(                       // Nested conditions array (up to 30 nestings)
		 *                                    'update_plugins',
		 *                                    'add_users',
		 *                                    ),
		 *                                    ).
		 * @param int          $object_id     (Optional) ID of the specific object to check against if capability is a "meta" cap.
		 *                                    e.g. 'edit_post', 'edit_user', 'edit_page', etc.
		 *
		 * @return bool Whether or not the user meets the requirements.
		 *              Will always return false for:
		 *              - Invalid/missing user
		 *              - If the $capabilities is not a string or array
		 *              - Max nesting depth exceeded (for that level)
		 * @since 3.6.3.4
		 * @example
		 *        ::user_can( 42, 'edit_pages' );                        // Checks if user ID 42 has the 'edit_pages' cap.
		 *        ::user_can( 42, 'edit_page', 17433 );                  // Checks if user ID 42 has the 'edit_page' cap for post ID 17433.
		 *        ::user_can( 42, array( 'edit_pages', 'edit_posts' ) ); // Checks if user ID 42 has both the 'edit_pages' and 'edit_posts' caps.
		 */
		public static function user_can( $user, $capabilities, $object_id = null ) {
			static $depth = 0;

			if ( $depth >= 30 ) {
				return false;
			}

			if ( empty( $user ) ) {
				return false;
			}

			if ( ! is_object( $user ) ) {
				$user = get_userdata( $user );
			}

			if ( is_string( $capabilities ) ) {
				// Simple string capability check.
				$args = array( $user, $capabilities );

				if ( null !== $object_id ) {
					$args[] = $object_id;
				}

				return call_user_func_array( 'user_can', $args );
			} else {
				// Only strings and arrays are allowed as valid capabilities.
				if ( ! is_array( $capabilities ) ) {
					return false;
				}
			}

			// Capability array check.
			$or = false;

			foreach ( $capabilities as $key => $value ) {
				if ( 'relation' === $key ) {
					if ( 'OR' === $value ) {
						$or = true;
					}

					continue;
				}

				/**
				 * Rules can be in 4 different formats:
				 * [
				 *   [0]      => 'foobar',
				 *   [1]      => array(...),
				 *   'foobar' => false,
				 *   'foobar' => array(...),
				 * ]
				 */
				if ( is_numeric( $key ) ) {
					// Numeric key.
					if ( is_string( $value ) ) {
						// Numeric key with a string value is the capability string to check
						// [0] => 'foobar'.
						$args = array( $user, $value );

						if ( null !== $object_id ) {
							$args[] = $object_id;
						}

						$expression_result = call_user_func_array( 'user_can', $args ) === true;
					} elseif ( is_array( $value ) ) {
						$depth ++;

						$expression_result = self::user_can( $user, $value, $object_id );

						$depth --;
					} else {
						// Invalid types are skipped.
						continue;
					}
				} else {
					// Non-numeric key.
					if ( is_scalar( $value ) ) {
						$args = array( $user, $key );

						if ( null !== $object_id ) {
							$args[] = $object_id;
						}

						$expression_result = call_user_func_array( 'user_can', $args ) === (bool) $value;
					} elseif ( is_array( $value ) ) {
						$depth ++;

						$expression_result = self::user_can( $user, $value, $object_id );

						$depth --;
					} else {
						// Invalid types are skipped.
						continue;
					}
				}

				// Check after every evaluation if we know enough to return a definitive answer.
				if ( $or ) {
					if ( $expression_result ) {
						// If the relation is OR, return on the first true expression.
						return true;
					}
				} else {
					if ( ! $expression_result ) {
						// If the relation is AND, return on the first false expression.
						return false;
					}
				}
			}

			// If we get this far on an OR, then it failed.
			// If we get this far on an AND, then it succeeded.
			return ! $or;
		}

		/**
		 * Check if Google font update is needed.
		 *
		 * @return bool
		 */
		public static function google_fonts_update_needed() {

			$path = trailingslashit( Redux_Core::$upload_dir ) . 'google_fonts.json';
			$now  = time();
			$secs = 60 * 60 * 24 * 7;
			if ( file_exists( $path ) ) {
				if ( ( $now - filemtime( $path ) ) < $secs ) {
					return false;
				}
			}

			return true;
		}

		/**
		 * Retrieve list of dev keys.
		 *
		 * @return array|false|string
		 */
		public static function get_developer_keys() {

			// TODO - Get shim values for here.
			// phpcs:ignore WordPress.NamingConventions.ValidHookName
			$data = array( apply_filters( 'redux/tracking/developer', array() ) );
			if ( 1 === count( $data ) ) {
				if ( empty( $data[0] ) ) {
					$data = array();
				}
			}
			$instances = Redux_Instances::get_all_instances();
			$data      = array();
			if ( ! empty( $instance ) ) {
				foreach ( $instances as $instance ) {
					if ( isset( $instance->args['developer'] ) && ! empty( $instance->args['developer'] ) ) {
						$data[] = $instance->args['developer'];
					}
				}
			}

			return $data;
		}

		/**
		 * Retrieve updated Google font array.
		 *
		 * @param bool $download Flag to download to file.
		 *
		 * @return array|WP_Error
		 */
		public static function google_fonts_array( $download = false ) {
			if ( ! empty( Redux_Core::$google_fonts ) && ! self::google_fonts_update_needed() ) {
				return Redux_Core::$google_fonts;
			}

			$filesystem = Redux_Filesystem::get_instance();

			$path = trailingslashit( Redux_Core::$upload_dir ) . 'google_fonts.json';

			if ( ! file_exists( $path ) || ( file_exists( $path ) && $download && self::google_fonts_update_needed() ) ) {
				if ( $download ) {
					$url = 'http://api.redux.io/gfonts';

					$request = wp_remote_get(
						$url,
						array(
							'timeout' => 20,
							'headers' => self::get_request_headers(),
						)
					);

					if ( ! is_wp_error( $request ) ) {
						$body = wp_remote_retrieve_body( $request );
						if ( ! empty( $body ) ) {
							$filesystem->put_contents( $path, $body );
							Redux_Core::$google_fonts = json_decode( $body, true );
						}
					} else {
						return $request;
					}
				}
			} elseif ( file_exists( $path ) ) {
				Redux_Core::$google_fonts = json_decode( $filesystem->get_contents( $path ), true );
				if ( empty( Redux_Core::$google_fonts ) ) {
					$filesystem->unlink( $path );
				}
			}

			return Redux_Core::$google_fonts;
		}

		/**
		 * Deprecated. Gets all Redux instances
		 *
		 * @return Redux_Instances::get_all_instances()
		 * @deprecated No longer using camelCase naming convention and moved to a different class.
		 */
		public static function getReduxInstances() { // phpcs:ignore WordPress.NamingConventions.ValidFunctionName
			_deprecated_function( __CLASS__ . '::' . __FUNCTION__, 'Redux 4.0.0', 'Redux_Instances::get_all_instances()' );

			return Redux_Instances::get_all_instances();
		}

		/**
		 * Is Inside Plugin
		 *
		 * @param string $file File name.
		 *
		 * @return array|bool
		 */
		public static function is_inside_plugin( $file ) {

			// phpcs:ignore Squiz.PHP.CommentedOutCode
			// if ( substr( strtoupper( $file ), 0, 2 ) === 'C:' ) {
			// $file = ltrim( $file, 'C:' );
			// $file = ltrim( $file, 'c:' );
			// } .
			//
			$plugin_basename = plugin_basename( $file );

			if ( Redux_Functions_Ex::wp_normalize_path( $file ) !== '/' . $plugin_basename ) {
				$slug = explode( '/', $plugin_basename );
				$slug = $slug[0];

				return array(
					'slug'      => $slug,
					'basename'  => $plugin_basename,
					'path'      => Redux_Functions_Ex::wp_normalize_path( $file ),
					'url'       => plugins_url( $plugin_basename ),
					'real_path' => Redux_Functions_Ex::wp_normalize_path( dirname( realpath( $file ) ) ),
				);
			}

			return false;
		}

		/**
		 * Is inside theme.
		 *
		 * @param string $file File name.
		 *
		 * @return array|bool
		 */
		public static function is_inside_theme( $file = '' ) {
			$theme_paths = array(
				Redux_Functions_Ex::wp_normalize_path( get_template_directory() )   => get_template_directory_uri(),
				Redux_Functions_Ex::wp_normalize_path( get_stylesheet_directory() ) => get_stylesheet_directory_uri(),
			);

			$theme_paths = array_unique( $theme_paths );

			$file_path = Redux_Functions_Ex::wp_normalize_path( $file );
			$filename  = explode( '/', $file_path );
			$filename  = end( $filename );
			foreach ( $theme_paths as $theme_path => $url ) {

				$real_path = Redux_Functions_Ex::wp_normalize_path( realpath( $theme_path ) );

				if ( strpos( $file_path, trailingslashit( $real_path ) ) !== false ) {
					$slug = explode( '/', Redux_Functions_Ex::wp_normalize_path( $theme_path ) );
					if ( empty( $slug ) ) {
						continue;
					}
					$slug          = end( $slug );
					$relative_path = explode( $slug, dirname( $file_path ) );

					if ( 1 === count( $relative_path ) ) {
						$relative_path = $file_path;
					} else {
						$relative_path = $relative_path[1];
					}
					$relative_path = ltrim( $relative_path, '/' );

					$data = array(
						'slug'      => $slug,
						'path'      => trailingslashit( trailingslashit( $theme_path ) . $relative_path ) . $filename,
						'real_path' => trailingslashit( trailingslashit( $real_path ) . $relative_path ) . $filename,
						'url'       => trailingslashit( trailingslashit( $url ) . $relative_path ) . $filename,
					);

					$basename         = explode( $data['slug'], $data['path'] );
					$basename         = end( $basename );
					$basename         = ltrim( $basename, '/' );
					$data['basename'] = trailingslashit( $data['slug'] ) . $basename;

					if ( is_child_theme() ) {
						$parent              = get_template_directory();
						$data['parent_slug'] = explode( '/', $parent );
						$data['parent_slug'] = end( $data['parent_slug'] );
						if ( $data['slug'] === $data['parent_slug'] ) {
							unset( $data['parent_slug'] );
						}
					}

					return $data;
				}
			}

			return false;
		}

		/**
		 * Nonces.
		 *
		 * @return array
		 */
		public static function nonces() {
			$array = array(
				'9fced129522f128b2445a41fb0b6ef9f',
				'70dda5dfb8053dc6d1c492574bce9bfd',
				'62933a2951ef01f4eafd9bdf4d3cd2f0',
				'a398fb77df76e6153df57cd65fd0a7c5',
				'1cb251ec0d568de6a929b520c4aed8d1',
				'6394d816bfb4220289a6f4b29cfb1834',
			);

			return $array;
		}

		/**
		 * Get plugin options.
		 *
		 * @return array|mixed|void
		 */
		public static function get_plugin_options() {
			$defaults = array(
				'demo' => false,
			);
			$options  = array();

			// If multisite is enabled.
			if ( is_multisite() ) {

				// Get network activated plugins.
				$plugins = get_site_option( 'active_sitewide_plugins' );

				foreach ( $plugins as $file => $plugin ) {
					if ( strpos( $file, 'redux-framework.php' ) !== false ) {
						$plugin_network_activated = true;
						$options                  = get_site_option( 'ReduxFrameworkPlugin', $defaults );
					}
				}
			}

			// If options aren't set, grab them now!
			if ( empty( $options ) ) {
				$options = get_option( 'ReduxFrameworkPlugin', $defaults );
			}

			return $options;
		}

		/**
		 * Sanitize array keys and values.
		 *
		 * @param array $array Array to sanitize.
		 */
		public static function sanitize_array( $array ) {
			return self::array_map_r( 'sanitize_text_field', $array );
		}

		/**
		 * Recursive array map.
		 *
		 * @param string $func function to run.
		 * @param array  $arr  Array to clean.
		 *
		 * @return array
		 */
		private static function array_map_r( $func, $arr ) {
			$new_arr = array();

			foreach ( $arr as $key => $value ) {
				$new_arr[ $key ] = ( is_array( $value ) ? self::array_map_r( $func, $value ) : ( is_array( $func ) ? call_user_func_array( $func, $value ) : $func( $value ) ) );
			}

			return $new_arr;
		}

		/**
		 * AJAX callback.
		 */
		public static function hash_arg() {
			echo esc_html( md5( Redux_Functions_Ex::hash_key() . '-redux' ) );
			die();
		}

		/**
		 * Adds stats parameters for Redux settings. Outside of the main class as the class could also be in use in other ways.
		 *
		 * @param array $options Stats options.
		 *
		 * @return array
		 */
		public static function redux_stats_additions( $options ) {
			$options['redux'] = array(
				'demo_mode' => get_option( 'ReduxFrameworkPlugin' ),
			);

			return $options;
		}

		/**
		 * AJAX callback Compile support arg.
		 */
		public static function support_args() {
			header( 'Expires: Mon, 26 Jul 1997 05:00:00 GMT' );
			header( 'Last-Modified: ' . gmdate( 'D, d M Y H:i:s' ) . 'GMT' );
			header( 'Expires: Sat, 26 Jul 1997 05:00:00 GMT' );
			header( 'Cache-Control: no-store, no-cache, must-revalidate' );
			header( 'Cache-Control: post-check=0, pre-check=0', false );
			header( 'Pragma: no-cache' );

			$instances = Redux::all_instances();

			if ( isset( $_REQUEST['i'] ) && ! empty( $_REQUEST['i'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification
				if ( is_array( $instances ) && ! empty( $instances ) ) {
					foreach ( $instances as $opt_name => $data ) {
						if ( md5( $opt_name . '-debug' ) === $_REQUEST['i'] ) { // phpcs:ignore WordPress.Security.NonceVerification
							$array = $data;
						}
					}
				}

				if ( isset( $array ) ) {

					// We only want the extension names and versions.
					$array->extensions = self::get_extensions( $opt_name );
					$to_return         = array();

					// Filter out all the unwanted data.
					foreach ( $array as $key => $value ) {
						if ( in_array(
							$key,
							array(
								// 'fields',
								'extensions',
								'sections',
								'args',
								// 'field_types'
							),
							true
						) ) {
							$to_return[ $key ] = $value;
						} else { // phpcs:ignore Generic.CodeAnalysis.EmptyStatement
							// phpcs:ignore Squiz.PHP.CommentedOutCode
							/* echo $key.PHP_EOL; */
						}
					}
					$array = $to_return;
				} else {
					die();
				}
			} else {
				$array = self::get_statistics_object();
				if ( is_array( $instances ) && ! empty( $instances ) ) {
					$array['instances'] = array();
					foreach ( $instances as $opt_name => $data ) {
						$array['instances'][] = $opt_name;
					}
				}
				$array['key'] = md5( Redux_Functions_Ex::hash_key() );
			}

			ksort( $array ); // Let's make that pretty.

			// phpcs:ignored WordPress.PHP.NoSilencedErrors, WordPress.Security.EscapeOutput
			echo @htmlspecialchars( @wp_json_encode( $array, true ), ENT_QUOTES, 'UTF-8' );

			die();
		}

		/**
		 * Detect if Gutenberg is running on the current page.
		 *
		 * @return bool
		 */
		public static function is_gutenberg_page() {
			if ( function_exists( 'is_gutenberg_page' ) && is_gutenberg_page() ) {
				// The Gutenberg plugin is on.
				return true;
			}
			$current_screen = get_current_screen();
			if ( method_exists( $current_screen, 'is_block_editor' ) && $current_screen->is_block_editor() ) {
				// Gutenberg page on 5+.
				return true;
			}
			return false;
		}


	}
}
