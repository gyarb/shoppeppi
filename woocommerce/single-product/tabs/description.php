<?php

/**
 * Description tab
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/description.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 2.0.0
 */

defined('ABSPATH') || exit;

global $post;

$heading = apply_filters('woocommerce_product_description_heading', __('Description', 'woocommerce'));

?>

<?php if ($heading) : ?>
	<div class="box__title title_has_border">
		<h2><?php echo esc_html($heading); ?></h2>
	</div>
<?php endif; ?>

<div class="pb-3">
	<?php the_content(); ?>
</div>

<?php

function theme_get_list_html($data)
{
	$list = '<ul><li>' . implode('</li><li>', $data) . '</li></ul>';
	return $list;
}

$rekomendovan = theme_get_list_data(get_field('rekomendovan'));
$rezultaty = get_field('rezultaty');
$instrukcziya = get_field('instrukcziya');
$sostav = get_field('sostav');
$doza = get_field('doza');
$forma_data = get_field('forma_data');

if (isset($forma_data['p_forma'])) {
	if ($forma_data['p_forma']['value'] == 99) {
		$forma = $forma_data['p_forma_any'];
	} else {
		$forma = $forma_data['p_forma']['label'];
	}
} else {
	$forma = '';
}
$bally = get_field('bally');
$klin_issled = get_field('klin_issled');

$data_arr = [
	'Состав продукта' => theme_get_list_html(theme_get_list_data(get_field('sostav'))),
	'Инструкция по применению' => get_field('instrukcziya'),
	'Форма выпуска' => $forma,
	'Суточная доза содержит' => get_field('doza'),
	'Противопоказания' => get_option('peppishop_content')['contra'],
	'Бонусных баллов' => get_field('bally'),
];
?>

<?php if ($rekomendovan) : ?>
	<div class="mb-5">
		<h4>Рекомендован:</h4>
		<ul class="list">
			<?php foreach ($rekomendovan as $item) : ?>
				<li><i class="icon fa fa-check" aria-hidden="true"></i> <?php echo $item; ?></li>
			<?php endforeach; ?>
		</ul>
	</div>
<?php endif; ?>

<?php if ($rezultaty) : ?>
	<div class="mb-5">
		<h4>Результаты применения:</h4>
		<?php echo $rezultaty; ?>
	</div>
<?php endif; ?>

<?php if ($klin_issled) : ?>
	<div class="mb-5">
		<a href="<?php echo $klin_issled; ?>" target="_blank">Клинические исследования (PDF)</a>
	</div>
<?php endif; ?>

<div class="product__items pt-3">
	<?php foreach ($data_arr as $title => $item) : ?>
		<?php if ($item) : ?>
			<div class="item mb-3">
				<div class="row pb-3">
					<div class="col-12 col-sm-5 col-md-4 col-lg-3 mb-1 mb-sm-0">
						<h6 class="title_inline"><?php echo $title; ?>:</h6>
					</div>
					<div class="col-12 col-sm-7 col-md-8 col-lg-9">
						<?php echo trim($item); ?>
					</div>
				</div>
			</div>
		<?php endif; ?>
	<?php endforeach; ?>
</div>