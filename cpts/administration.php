<?php
/*
 * Custom Post Type for Administration
 *
 * @since 1.0
 */

/**
 * class LWTV_Docs_CPT_Administration
 */
class LWTV_Docs_CPT_Administration {

	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'admin_init', array( $this, 'admin_init' ) );
		add_action( 'init', array( $this, 'create_post_type' ), 0 );
		add_action( 'amp_init', array( $this, 'amp_init' ) );
	}

	/**
	 * Admin Init
	 */
	public function admin_init() {
		add_action( 'admin_head', array( $this, 'admin_css' ) );
		add_action( 'dashboard_glance_items', array( $this, 'dashboard_glance_items' ) );
		add_filter( 'enter_title_here', array( $this, 'custom_enter_title' ) );
	}

	/*
	 * CPT Settings
	 *
	 */
	public function create_post_type() {

		$labels = array(
			'name'                     => 'Admin Docs',
			'singular_name'            => 'Admin Doc',
			'menu_name'                => 'Admin Docs',
			'add_new_item'             => 'Add New Admin Doc',
			'edit_item'                => 'Edit Admin Doc',
			'new_item'                 => 'New Admin Doc',
			'view_item'                => 'View Admin Doc',
			'all_items'                => 'All Admin Docs',
			'search_items'             => 'Search Admin Docs',
			'not_found'                => 'No Admin Docs found',
			'not_found_in_trash'       => 'No Admin Docs found in Trash',
			'update_item'              => 'Update Admin Doc',
			'featured_image'           => 'Admin Doc Image',
			'set_featured_image'       => 'Set Admin Doc image  (add me first)',
			'remove_featured_image'    => 'Remove Admin Doc image',
			'use_featured_image'       => 'Use as Admin Doc image',
			'archives'                 => 'Admin Doc archives',
			'insert_into_item'         => 'Insert into Admin Doc',
			'uploaded_to_this_item'    => 'Uploaded to this Admin Doc',
			'filter_items_list'        => 'Filter Admin Doc list',
			'items_list_navigation'    => 'Admin Doc list navigation',
			'items_list'               => 'Admin Doc list',
			'item_published'           => 'Admin Doc published.',
			'item_published_privately' => 'Admin Doc published privately.',
			'item_reverted_to_draft'   => 'Admin Doc reverted to draft.',
			'item_scheduled'           => 'Admin Doc scheduled.',
			'item_updated'             => 'Admin Doc updated.',
		);
		$args   = array(
			'label'               => 'post_type_admindoc',
			'description'         => 'Administration',
			'labels'              => $labels,
			'public'              => true,
			'show_in_rest'        => true,
			'rest_base'           => 'admin',
			'menu_position'       => 7,
			'menu_icon'           => 'dashicons-businesswoman',
			'hierarchical'        => true,
			'supports'            => array( 'title', 'editor', 'thumbnail', 'revisions', 'page-attributes' ),
			'has_archive'         => false,
			'capability_type'     => 'page',
			'rewrite'             => array( 'slug' => 'admin' ),
			'delete_with_user'    => false,
			'exclude_from_search' => false,
		);
		register_post_type( 'post_type_admindoc', $args );
	}

	/*
	 * AMP
	 */
	public function amp_init() {
		add_post_type_support( 'post_type_admindoc', AMP_QUERY_VAR );
	}

	/*
	 * Add to 'Right Now'
	 */
	public function dashboard_glance_items() {
		foreach ( array( 'post_type_admindoc' ) as $post_type ) {
			$num_posts = wp_count_posts( $post_type );
			if ( $num_posts && $num_posts->publish ) {
				if ( 'post_type_admindoc' === $post_type ) {
					// translators: %s is the number of Administration
					$text = _n( '%s Admin Doc', '%s Admin Docs', $num_posts->publish );
				}
				$text = sprintf( $text, number_format_i18n( $num_posts->publish ) );
				printf( '<li class="%1$s-count"><a href="edit.php?post_type=%1$s">%2$s</a></li>', esc_attr( $post_type ), esc_html( $text ) );
			}
		}
	}

	/*
	 * Style for dashboard
	 */
	public function admin_css() {
		echo "<style type='text/css'>
			#adminmenu #menu-posts-post_type_admindoc div.wp-menu-image:before, #dashboard_right_now li.post_type_admindoc-count a:before {
				content: '\\f12f';
				margin-left: -1px;
			}
		</style>";
	}

	/*
	 * Customize title
	 */
	public function custom_enter_title( $input ) {
		if ( 'post_type_admindoc' === get_post_type() ) {
			$input = 'Add Admin Doc';
		}
		return $input;
	}

}

new LWTV_Docs_CPT_Administration();
