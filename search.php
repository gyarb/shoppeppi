<?php get_header(); ?>

<?php
$s = (isset($_GET['s']) && $_GET['s']) ? $_GET['s'] : '_empty_search_';
query_posts([
  's' => $s,
  'post_type' => 'product',
  'posts_per_page' => -1,
]);
?>

<main role="main" class="main_search woocommerce">
  <div class="container">
    <div class="box box_search mb-5">
      <div class="row">
        <div class="col-12 col-md-8 col-lg-6">
          <div class="searh">
            <form role="search" method="get" id="searchform" action="<?php echo home_url('/'); ?>" class="form form_search">
              <input type="text" name="s" id="s" placeholder="Поиск по продуктам" class="input input_search" value="<?php echo $_GET['s'] ?? ''; ?>">
              <button type="submit" id="searchsubmit" class="button button_search"><i class="fa fa-search" aria-hidden="true"></i></button>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="box">
      <div class="row">
        <div class="col-12">
          <h3>
            Результаты поиска для &laquo;<?php echo $_GET['s']; ?>&raquo;:
          </h3>
        </div>
      </div>
    </div>
    <div class="box">
      <div class="row products">
        <?php
        if (have_posts()) {
          while (have_posts()) {
            the_post();
            do_action('woocommerce_shop_loop');
            wc_get_template_part('content', 'product');
          }
        } else {
        ?>
          <p>Ничего не найдено. Попробуйте ввести другой запрос.</p>
        <?php
        }
        ?>
      </div>
      <?php //the_posts_pagination(); 
      ?>
    </div>
  </div>
</main>

<?php get_footer(); ?>