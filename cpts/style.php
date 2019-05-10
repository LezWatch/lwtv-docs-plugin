<?php
/*
 * Custom Post Type for Style Guide
 *
 * @since 1.0
 */

/**
 * class LWTV_Docs_CPT_Style
 */
class LWTV_Docs_CPT_Style {

	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'admin_init', array( $this, 'admin_init' ) );
		add_action( 'init', array( $this, 'create_post_type' ), 3 );
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
			'name'                     => 'Style Guides',
			'singular_name'            => 'Style Guide',
			'menu_name'                => 'Style Guide',
			'add_new_item'             => 'Add New Style Guide',
			'edit_item'                => 'Edit Style Guide',
			'new_item'                 => 'New Style Guide',
			'view_item'                => 'View Style Guide',
			'all_items'                => 'All Style Guides',
			'search_items'             => 'Search Style Guides',
			'not_found'                => 'No Style Guides found',
			'not_found_in_trash'       => 'No Style Guides found in Trash',
			'update_item'              => 'Update Style Guide',
			'featured_image'           => 'Style Guide Image',
			'set_featured_image'       => 'Set Style Guide image  (add me first)',
			'remove_featured_image'    => 'Remove Style Guide image',
			'use_featured_image'       => 'Use as Style Guide image',
			'archives'                 => 'Style Guide archives',
			'insert_into_item'         => 'Insert into Style Guide',
			'uploaded_to_this_item'    => 'Uploaded to this Style Guide',
			'filter_items_list'        => 'Filter Style Guide list',
			'items_list_navigation'    => 'Style Guide list navigation',
			'items_list'               => 'Style Guide list',
			'item_published'           => 'Style Guide published.',
			'item_published_privately' => 'Style Guide published privately.',
			'item_reverted_to_draft'   => 'Style Guide reverted to draft.',
			'item_scheduled'           => 'Style Guide scheduled.',
			'item_updated'             => 'Style Guide updated.',
		);
		$args   = array(
			'label'               => 'post_type_style',
			'description'         => 'Style',
			'labels'              => $labels,
			'public'              => true,
			'show_in_rest'        => true,
			'rest_base'           => 'style',
			'menu_position'       => 7,
			'menu_icon'           => 'dashicons-layout',
			'hierarchical'        => true,
			'supports'            => array( 'title', 'editor', 'thumbnail', 'revisions', 'page-attributes' ),
			'has_archive'         => false,
			'capability_type'     => 'page',
			'rewrite'             => array( 'slug' => 'style' ),
			'delete_with_user'    => false,
			'exclude_from_search' => false,
		);
		register_post_type( 'post_type_style', $args );
	}

	/*
	 * AMP
	 */
	public function amp_init() {
		add_post_type_support( 'post_type_style', AMP_QUERY_VAR );
	}

	/*
	 * Add to 'Right Now'
	 */
	public function dashboard_glance_items() {
		foreach ( array( 'post_type_style' ) as $post_type ) {
			$num_posts = wp_count_posts( $post_type );
			if ( $num_posts && $num_posts->publish ) {
				if ( 'post_type_style' === $post_type ) {
					// translators: %s is the number of Style
					$text = _n( '%s Style Guide', '%s Style Guides', $num_posts->publish );
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
			#adminmenu #menu-posts-post_type_style div.wp-menu-image:before, #dashboard_right_now li.post_type_style-count a:before {
				content: '\\f538';
				margin-left: -1px;
			}
		</style>";
	}

	/*
	 * Customize title
	 */
	public function custom_enter_title( $input ) {
		if ( 'post_type_style' === get_post_type() ) {
			$input = 'Add Style Guide';
		}
		return $input;
	}

}

new LWTV_Docs_CPT_Style();
