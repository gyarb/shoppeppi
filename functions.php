<?php


add_theme_support('html5');
add_theme_support('menus');
add_theme_support('widgets');
add_theme_support('post-thumbnails');
add_theme_support('woocommerce');
// add_theme_support('wc-product-gallery-zoom');
add_theme_support('wc-product-gallery-lightbox');
add_theme_support('wc-product-gallery-slider');

$peppishop_options = get_option('peppishop_options');

function get_ver()
{
  return '001';
}

add_action('wp_enqueue_scripts', 'theme_scripts');
function theme_scripts()
{
  $ver = get_ver();

  wp_enqueue_style('style-bootstrap-grid-min', get_template_directory_uri() . '/css/bootstrap-grid.min.css');
  wp_enqueue_style('style-main', get_template_directory_uri() . '/css/main.css', array(), $ver);

  wp_enqueue_script('script-jquery-maskedinput-min', get_template_directory_uri() . '/js/jquery.maskedinput.min.js', array('jquery'), false, true);
  wp_enqueue_script('script-jquery-ui', get_template_directory_uri() . '/js/jquery-ui.js', array('jquery'), false, true);
  wp_enqueue_script('script-main', get_template_directory_uri() . '/js/main.js', array('jquery'), $ver, true);

  $data = [
    'ajaxUrl' => admin_url('admin-ajax.php'),
    'homeUrl' => home_url('/'),
    'cartUrl' => wc_get_cart_url(),
    'shopUrl' => '/shop',
  ];
  wp_add_inline_script('script-main', 'const scriptData = ' . wp_json_encode($data), 'before');
}

add_action('admin_enqueue_scripts', 'theme_admin_scripts', 25);
function theme_admin_scripts()
{
  $ver = get_ver();

  wp_enqueue_script('script-admin-main', get_template_directory_uri() . '/js/admin/main.js', array('jquery'), $ver, true);
}

add_action('admin_menu', 'theme_remove_default_menus');
function theme_remove_default_menus()
{
  remove_menu_page('edit-comments.php');          // Комментарии
}

add_action('after_setup_theme', function () {
  register_nav_menus([
    'header_menu' => 'Меню в шапке',
    'footer_menu_1' => 'Меню в подвале - 1',
    'footer_menu_2' => 'Меню в подвале - 2',
    'footer_menu_3' => 'Меню в подвале - 3',
  ]);
});

add_action('init', 'start_session', 1);
function start_session()
{
  if (!session_id()) {
    session_start();
  }
}

add_action('wp_logout', 'end_session');
add_action('wp_login', 'end_session');

add_action('end_session_action', 'end_session');
function end_session()
{
  session_destroy();
}

function clear_phone($phone)
{
  $phone = str_replace(' ', '', $phone);
  $phone = str_replace('(', '', $phone);
  $phone = str_replace(')', '', $phone);
  $phone = str_replace('-', '', $phone);
  return $phone;
}
function phone_link_html()
{
  global $peppishop_options;
  $phone_text = $peppishop_options['phone'];
  $phone_link = clear_phone($phone_text);
  $html = $phone_link  ? '<a href="tel:' . $phone_link . '">' . $phone_text . '</a>' : '';
  return $html;
}
function telegram_link_html()
{
  global $peppishop_options;
  $link = $peppishop_options['tg'];
  $html = $link ? '<a href="' . $link . '" target="_blank">Telegram</a>' : '';
  return $html;
}
function email_link_html()
{
  global $peppishop_options;
  $link = $peppishop_options['email'];
  $html = $link ? '<a href="mailto:' . $link . '" target="_blank">' . $link . '</a>' : '';
  return $html;
}

function page_breadcrumbs_html()
{

  $html_links = '';
  $data_links = '';
  if (is_single() || is_page()) {
    global $post;
    if ($post->post_type == 'course') {
      $terms = wp_get_post_terms($post->ID, 'course_category');
      $term = $terms[array_key_last($terms)];
      $html_links = get_term_parents_list(
        $term->term_id,
        $term->taxonomy,
        array(
          'format'    => 'name',
          'separator' => '&nbsp;/&nbsp;',
          'link'      => true,
          'inclusive' => true,
        )
      );
    }
    $data_links = $html_links . $post->post_title;
  }
  if (is_archive()) {
    global $wp_query;
    if (isset($wp_query->queried_object->taxonomy) && $wp_query->queried_object->taxonomy == 'course_category') {
      $term_id = $wp_query->queried_object->term_id;
      $taxonomy = $wp_query->queried_object->taxonomy;
      $term_name = $wp_query->queried_object->name;
      $html_links = get_term_parents_list(
        $term_id,
        $taxonomy,
        array(
          'format'    => 'name',
          'separator' => '&nbsp;/&nbsp;',
          'link'      => true,
          'inclusive' => false,
        )
      );
      $data_links = $html_links . $term_name;
    }
  }
  $html = '<nav class="breadcrumbs page_breadcrumbs"><a href="' . home_url('/') . '">Главная</a>&nbsp;/&nbsp;' . $data_links . '</nav>';
  return $html;
}

function p_arr($arr)
{
  echo '<pre>';
  print_r($arr);
  echo '</pre>';
}

require_once 'functions/functions-shop.php';
require_once 'functions/admin/functions-shop.php';
