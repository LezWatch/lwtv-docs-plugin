<?php
/*
 * Custom Post Type for APIs
 *
 * @since 1.0
 */

/**
 * class LWTV_Docs_CPT_API
 */
class LWTV_Docs_CPT_API {

	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'admin_init', array( $this, 'admin_init' ) );
		add_action( 'init', array( $this, 'create_post_type' ), 1 );
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
			'name'                     => 'API Docs',
			'singular_name'            => 'API Doc',
			'menu_name'                => 'API Docs',
			'add_new_item'             => 'Add New API Doc',
			'edit_item'                => 'Edit API Doc',
			'new_item'                 => 'New API Doc',
			'view_item'                => 'View API Doc',
			'all_items'                => 'All API Docs',
			'search_items'             => 'Search API Docs',
			'not_found'                => 'No API Docs found',
			'not_found_in_trash'       => 'No API Docs found in Trash',
			'update_item'              => 'Update API Doc',
			'featured_image'           => 'API Doc Image',
			'set_featured_image'       => 'Set API Doc image  (add me first)',
			'remove_featured_image'    => 'Remove API Doc image',
			'use_featured_image'       => 'Use as API Doc image',
			'archives'                 => 'API Doc archives',
			'insert_into_item'         => 'Insert into API Doc',
			'uploaded_to_this_item'    => 'Uploaded to this API Doc',
			'filter_items_list'        => 'Filter API Doc list',
			'items_list_navigation'    => 'API Doc list navigation',
			'items_list'               => 'API Doc list',
			'item_published'           => 'API Doc published.',
			'item_published_privately' => 'API Doc published privately.',
			'item_reverted_to_draft'   => 'API Doc reverted to draft.',
			'item_scheduled'           => 'API Doc scheduled.',
			'item_updated'             => 'API Doc updated.',
		);
		$args   = array(
			'label'               => 'post_type_api',
			'description'         => 'API',
			'labels'              => $labels,
			'public'              => true,
			'show_in_rest'        => true,
			'rest_base'           => 'api',
			'menu_position'       => 7,
			'menu_icon'           => 'dashicons-rest-api',
			'hierarchical'        => true,
			'supports'            => array( 'title', 'editor', 'thumbnail', 'revisions', 'page-attributes' ),
			'has_archive'         => false,
			'capability_type'     => 'page',
			'rewrite'             => array( 'slug' => 'api' ),
			'delete_with_user'    => false,
			'exclude_from_search' => false,
		);
		register_post_type( 'post_type_api', $args );
	}

	/*
	 * AMP
	 */
	public function amp_init() {
		add_post_type_support( 'post_type_api', AMP_QUERY_VAR );
	}

	/*
	 * Add to 'Right Now'
	 */
	public function dashboard_glance_items() {
		foreach ( array( 'post_type_api' ) as $post_type ) {
			$num_posts = wp_count_posts( $post_type );
			if ( $num_posts && $num_posts->publish ) {
				if ( 'post_type_api' === $post_type ) {
					// translators: %s is the number of API
					$text = _n( '%s API Doc', '%s API Docs', $num_posts->publish );
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
			#adminmenu #menu-posts-post_type_api div.wp-menu-image:before, #dashboard_right_now li.post_type_api-count a:before {
				content: '\\f124';
				margin-left: -1px;
			}
		</style>";
	}

	/*
	 * Customize title
	 */
	public function custom_enter_title( $input ) {
		if ( 'post_type_api' === get_post_type() ) {
			$input = 'Add API Doc';
		}
		return $input;
	}

}

new LWTV_Docs_CPT_API();
