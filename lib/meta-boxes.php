<?php

/* Get post objects for select field options */
function get_post_objects( $query_args ) {
$args = wp_parse_args( $query_args, array(
    'posts_per_page' => -1,
) );
$posts = get_posts( $args );
$post_options = array(" " => null);
if ( $posts ) {
    foreach ( $posts as $post ) {
        $post_options [ $post->ID ] = $post->post_title;
    }
}
return $post_options;
}



/**
 * Include and setup custom metaboxes and fields.
 *
 * @category YourThemeOrPlugin
 * @package  Metaboxes
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/webdevstudios/Custom-Metaboxes-and-Fields-for-WordPress
 */
add_filter( 'cmb2_meta_boxes', 'cmb_sample_metaboxes' );

function cmb_sample_metaboxes( array $meta_boxes ) {

	if (isset($_GET['post'])) {
		$post_ID = $_GET['post'];
	} else {
		$post_ID = null;
	}

	$prefix = '_igv_';

	$director_args = array(
		'post_type' => 'director'
	);

	$showreel_args = array(
		'post_type'			=> 'video',
	    'meta_query' => array(
			array(
				'key' => '_igv_director',
				'value' => $post_ID,
				'type' => 'NUMERIC',
				'compare' => '='
			)
		)
  );

	$meta_boxes['posts_metabox'] = array(
		'id'         => 'post_metabox',
		'title'      => __( 'Post Options', 'cmb' ),
		'object_types'      => array( 'post' ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		'fields'     => array(
  		  array(
          'name' => 'Long title',
          'desc' => 'longer title that also allows formatting',
          'id' => $prefix . 'longtitle',
          'type' => 'wysiwyg'
        ),
  		  array(
          'name' => 'Read More post?',
          'desc' => 'show read more',
          'id' => $prefix . 'readmore',
          'type' => 'checkbox'
        ),
  		  array(
          'name' => 'Thumbnail background?',
          'desc' => 'shows thumbnail as title background',
          'id' => $prefix . 'thumbbackground',
          'type' => 'checkbox'
        ),
        array(
            'name' => 'Background Color Picker',
            'id'   => $prefix . 'color',
            'type' => 'colorpicker',
            'default'  => '#000000',
            'repeatable' => false,
        ),
		)
	);

	$meta_boxes['director_metabox'] = array(
		'id'         => 'director_metabox',
		'title'      => __( 'Director', 'cmb' ),
		'object_types'      => array( 'video' ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		'fields'     => array(
			array(
				'name'    => __( 'Title', 'cmb' ),
				'desc'    => __( '', 'cmb' ),
				'id'      => $prefix . 'title',
				'type'    => 'text',
			),
			array(
				'name'    => __( 'Brand', 'cmb' ),
				'desc'    => __( '', 'cmb' ),
				'id'      => $prefix . 'brand',
				'type'    => 'text',
			),
			array(
				'name'    => __( 'Director', 'cmb' ),
				'desc'    => __( '', 'cmb' ),
				'id'      => $prefix . 'director',
				'type'    => 'select',
				'options' => get_post_objects($director_args),
			),
		)
	);

	$meta_boxes['showreel_1_metabox'] = array(
		'id'         => 'showreel_1_metabox',
		'title'      => __( 'Showreel 1', 'cmb' ),
		'object_types'      => array( 'director', ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		// 'cmb_styles' => true, // Enqueue the CMB stylesheet on the frontend
		'fields'     => array(
			array(
				'id'          => $prefix . 'showreel_1',
				'type'        => 'group',
				'description' => __( '', 'cmb' ),
				'options'     => array(
					'group_title'   => __( 'Video {#}', 'cmb' ), // {#} gets replaced by row number
					'add_button'    => __( 'Add Another Video', 'cmb' ),
					'remove_button' => __( 'Remove Video', 'cmb' ),
					'sortable'      => true, // beta
				),
				'fields'      => array(
					array(
						'name'    => __( 'Video', 'cmb' ),
						'desc'    => __( '', 'cmb' ),
						'id'      => 'video',
						'type'    => 'select',
						'options' => get_post_objects($showreel_args),
					),
				),
			),
		),
	);

	/*
$meta_boxes['showreel_2_metabox'] = array(
		'id'         => 'showreel_2_metabox',
		'title'      => __( 'Showreel 2', 'cmb' ),
		'object_types'      => array( 'director', ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		// 'cmb_styles' => true, // Enqueue the CMB stylesheet on the frontend
		'fields'     => array(
			array(
				'id'          => $prefix . 'showreel_2',
				'type'        => 'group',
				'description' => __( '', 'cmb' ),
				'options'     => array(
					'group_title'   => __( 'Video {#}', 'cmb' ), // {#} gets replaced by row number
					'add_button'    => __( 'Add Another Video', 'cmb' ),
					'remove_button' => __( 'Remove Video', 'cmb' ),
					'sortable'      => true, // beta
				),
				'fields'      => array(
					array(
						'name'    => __( 'Video', 'cmb' ),
						'desc'    => __( '', 'cmb' ),
						'id'      => 'video',
						'type'    => 'select',
						'options' => get_post_objects($showreel_args),
					),
				),
			),
		),
	);
*/

	/*
$meta_boxes['showreel_3_metabox'] = array(
		'id'         => 'showreel_3_metabox',
		'title'      => __( 'Showreel 3', 'cmb' ),
		'object_types'      => array( 'director', ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		// 'cmb_styles' => true, // Enqueue the CMB stylesheet on the frontend
		'fields'     => array(
			array(
				'id'          => $prefix . 'showreel_3',
				'type'        => 'group',
				'description' => __( '', 'cmb' ),
				'options'     => array(
					'group_title'   => __( 'Video {#}', 'cmb' ), // {#} gets replaced by row number
					'add_button'    => __( 'Add Another Video', 'cmb' ),
					'remove_button' => __( 'Remove Video', 'cmb' ),
					'sortable'      => true, // beta
				),
				'fields'      => array(
					array(
						'name'    => __( 'Video', 'cmb' ),
						'desc'    => __( '', 'cmb' ),
						'id'      => 'video',
						'type'    => 'select',
						'options' => get_post_objects($showreel_args),
					),
				),
			),
		),
	);
*/

	return $meta_boxes;
}
?>
