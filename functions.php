<?php
if(!class_exists('CustomPostTexonomy'))
{
	class CustomPostTexonomy
	{
		public function __construct()
    	{
			add_action('init', array(&$this, 'create_post_type'));
    		add_action('init', array(&$this, 'create_gift_taxonomies'));
			add_action('init', array(&$this, 'register_new_terms'));
    	} 
		
		public function create_post_type()
		{
			register_post_type('gift-post',
				array(
					'labels' => array(
						'name'               => _x( 'Manage Gifts', 'Manage Gifts', 'gift-post'),
						'singular_name'      => _x( 'Gift', 'Manage Gifts', 'gift-post' ),
						'menu_name'          => _x( 'Manage Gifts', 'admin menu', 'gift-post'),
						'add_new'            => _x( 'Add New Gift', 'Gift', 'gift-post' ),
						'add_new_item'       => __( 'Add New Gift', 'gift-post' ),
						
					),
					'public' => true,
					'has_archive' => true,
					'description' => __("This is a sample post type meant only to illustrate a preferred structure of plugin development"),
					'supports' => array(
						'title', 'editor', 'excerpt', 'thumbnail'
					),
				)
			);
		}

		public function create_gift_taxonomies()
		{
			$labels = array(
				'name' => _x('Gift Categories', 'taxonomy general name'),
				'singular_name' => _x('Gift', 'taxonomy singular name'),
				'search_items' => __('Search Gifts'),
				'all_items' => __('All Gifts'),
				'parent_item' => __('Parent Gift'),
				'parent_item_colon' => __('Parent Gift:'),
				'edit_item' => __('Edit Gift'),
				'update_item' => __('Update Gift'),
				'add_new_item' => __('Add Gift Category'),
				'new_item_name' => __('New Gift Name'),
				'menu_name' => __('Gift Categories')
			);
			$args   = array(
				'hierarchical' => true,
				'labels' => $labels,
				'show_ui' => true,
				'show_admin_column' => true,
				'query_var' => true,
				'rewrite' => array(
					'slug' => 'gift'
				)
			);
			register_taxonomy('gifts', 'gift-post', $args);
		}
		
		function register_new_terms() {
			$this->taxonomy = 'gifts';
			$this->terms = array (
				'0' => array (
					'name'          => 'All',
					'slug'          => 'all',
					'description'   => 'General Gifts',
				),
				'1' => array (
					'name'          => 'Birthday',
					'slug'          => 'birthday',
					'description'   => 'Birthday Special Gift',
				),
				'2' => array (
					'name'          => 'Valentine',
					'slug'          => 'valentine',
					'description'   => 'Valentine Special Gift',
				),
			);  

			foreach ( $this->terms as $term_key=>$term) {
					wp_insert_term(
						$term['name'],
						$this->taxonomy, 
						array(
							'description'   => $term['description'],
							'slug'          => $term['slug'],
						)
					);
				unset( $term ); 
			}
		}
	}
}

?>