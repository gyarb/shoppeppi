<?php

/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.6.0
 */

defined('ABSPATH') || exit;

get_header('shop');

/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */
do_action('woocommerce_before_main_content');


if (is_shop()) {

	do_action('woocommerce_shop_loop_header');

	do_action('theme_wc_categories_loop');
} else {

	/**
	 * Hook: woocommerce_shop_loop_header.
	 *
	 * @since 8.6.0
	 *
	 * @hooked woocommerce_product_taxonomy_archive_header - 10
	 */
	do_action('woocommerce_shop_loop_header');

	if (is_product_category()) {

		global $wp_query;


		if (isset($wp_query->query_vars['product_cat']) && $wp_query->query_vars['product_cat'] !== 'peptidy') {
?>
			<div class="box box_catalog">
				<?php do_action('theme_wc_categories_loop', ['slug' => $wp_query->query_vars['product_cat'], 'page' => 'catalog']); ?>
			</div>

		<?php
		}

		if (isset($wp_query->query_vars['product_cat']) && $wp_query->query_vars['product_cat'] == 'peptidy') {
		?>
			<div class="box box_catalog">
				<div class="box__title title_has_border">
					<h2>Категории</h2>
				</div>
				<?php do_action('theme_wc_categories_loop', ['slug' => $wp_query->query_vars['product_cat'], 'page' => 'catalog']); ?>
			</div>
			<div class="box box_organs">
				<div class="box__title title_has_border">
					<h2>Пептидные препараты по органам</h2>
				</div>
				<?php do_action('theme_wc_tags_loop', ['page' => 'catalog']); ?>
			</div>
		<?php
		}
	}



	if (woocommerce_product_loop()) {

		/**
		 * Hook: woocommerce_before_shop_loop.
		 *
		 * @hooked woocommerce_output_all_notices - 10
		 * @hooked woocommerce_result_count - 20
		 * @hooked woocommerce_catalog_ordering - 30
		 */

		?>

		<div class="wrap_before_shop_loop">
			<div class="row">
				<div class="col-12">

					<?php

					do_action('woocommerce_before_shop_loop');

					?>

				</div>
			</div>
		</div>

		<?php

		// woocommerce_product_loop_start();

		?>

		<div class="row products">

			<?php

			if (wc_get_loop_prop('total')) {
				while (have_posts()) {
					the_post();

					/**
					 * Hook: woocommerce_shop_loop.
					 */
					do_action('woocommerce_shop_loop');

					wc_get_template_part('content', 'product');
				}
			}

			?>

		</div>

<?php

		// woocommerce_product_loop_end();

		/**
		 * Hook: woocommerce_after_shop_loop.
		 *
		 * @hooked woocommerce_pagination - 10
		 */
		do_action('woocommerce_after_shop_loop');
	} else {
		/**
		 * Hook: woocommerce_no_products_found.
		 *
		 * @hooked wc_no_products_found - 10
		 */
		do_action('woocommerce_no_products_found');
	}
}



/**
 * Hook: woocommerce_after_main_content.
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
do_action('woocommerce_after_main_content');

/**
 * Hook: woocommerce_sidebar.
 *
 * @hooked woocommerce_get_sidebar - 10
 */
do_action('woocommerce_sidebar');

get_footer('shop');
