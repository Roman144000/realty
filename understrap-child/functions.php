<?
// Exit if accessed directly.
defined('ABSPATH') || exit;

add_action('wp_enqueue_scripts', 'enqueue_parent_styles');

function enqueue_parent_styles()
{
	wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
	wp_enqueue_script('custom-script', get_stylesheet_directory_uri() . '/custom.js', array(), false, true);
}

function register_tax_type_realty()
{
	/**
	 * Taxonomy: Тип недвижимости
	 */
	$labels = [
		"name" => __("Тип недвижимости", 'understrap-child'),
		"singular_name" => __("Тип недвижимости", 'understrap-child'),
	];
	$args = [
		"label" => __("Тип недвижимости", 'understrap-child'),
		"labels" => $labels,
		"public" => true,
		"publicly_queryable" => true,
		"hierarchical" => false,
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => ['slug' => 'type_realty', 'with_front' => true,],
		"show_admin_column" => false,
		"show_in_rest" => true,
		"rest_base" => "type_realty",
		"rest_controller_class" => "WP_REST_Terms_Controller",
		"show_in_quick_edit" => true,
		"show_in_graphql" => false,
	];
	register_taxonomy("type_realty", ["realty"], $args);
}
add_action('init', 'register_tax_type_realty');


function register_pt_realty()
{
	/**
	 * Post Type: Недвижимость
	 */
	$labels = [
		"name" => __("Недвижимость", 'understrap-child'),
		"singular_name" => __("Недвижимость", 'understrap-child'),
	];
	$args = [
		"label" => __("Недвижимость", 'understrap-child'),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => ["slug" => "realty", "with_front" => true],
		"query_var" => true,
		"supports" => ["title", "editor", "thumbnail"],
		"show_in_graphql" => false,
	];
	register_post_type("realty", $args);
}
add_action('init', 'register_pt_realty');

function register_pt_city()
{
	/**
	 * Post Type: Города
	 */
	$labels = [
		"name" => __("Города", 'understrap-child'),
		"singular_name" => __("Город", 'understrap-child'),
	];
	$args = [
		"label" => __("Города", 'understrap-child'),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => ["slug" => "city", "with_front" => true],
		"query_var" => true,
		"supports" => ["title", "editor", "thumbnail"],
		"show_in_graphql" => false,
	];
	register_post_type("city", $args);
}
add_action('init', 'register_pt_city');


add_action('add_meta_boxes', function () {
	add_meta_box('realty_city', 'Город недвижимости', 'realty_city_metabox', 'realty', 'side', 'low');
}, 1);

function realty_city_metabox($post)
{
	$cities = get_posts(array('post_type' => 'city', 'posts_per_page' => -1, 'orderby' => 'post_title', 'order' => 'ASC'));

	if ($cities) {
		echo '
		<div style="max-height:200px; overflow-y:auto;">
			<ul>
		';
		foreach ($cities as $city) {
			echo '
			<li><label>
				<input type="radio" name="post_parent" value="' . $city->ID . '" ' . checked($city->ID, $post->post_parent, 0) . '> ' . esc_html($city->post_title) . '
			</label></li>
			';
		}
		echo '
			</ul>
		</div>';
	} else
		echo 'Городов нет...';
}


// скрипт отправки формы

require_once(ABSPATH . 'wp-admin/includes/image.php');
require_once(ABSPATH . 'wp-admin/includes/file.php');
require_once(ABSPATH . 'wp-admin/includes/media.php');

function ajax_form()
{
	$address = htmlspecialchars(strip_tags($_POST['address']));
	$price = htmlspecialchars(strip_tags($_POST['price']));
	$square = htmlspecialchars(strip_tags($_POST['square']));
	$live_square = htmlspecialchars(strip_tags($_POST['liveSquare']));
	$floor = htmlspecialchars(strip_tags($_POST['floor']));
	$city = htmlspecialchars(strip_tags($_POST['city']));
	$category = htmlspecialchars(strip_tags($_POST['category']));

	$insert_post = wp_insert_post(wp_slash(array(
		'post_parent'    => $city,
		'post_title'     => $address,
		'post_type'      => 'realty',
		'tax_input'      => array('type_realty' => $category),
		'meta_input'     => [
			'price' => $price,
			'square' => $square,
			'live_square' => $live_square,
			'address' => $address,
			'floor' => $floor
		]
	)));

	if ($_FILES["image"]["error"] == UPLOAD_ERR_OK && $insert_post) {
		$media_id = media_handle_upload("image", $insert_post);
		$set_img = set_post_thumbnail( $insert_post, $media_id );
	}

	if ($set_img && $insert_post) {
		echo 'Недвижимость добавлена';
	} else {
		echo 'Произошла ошибка';
	}

	wp_die();
}

add_action('wp_ajax_nopriv_ajax_mail', 'ajax_form');
add_action('wp_ajax_ajax_mail', 'ajax_form');
