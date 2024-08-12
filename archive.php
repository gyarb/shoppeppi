<?php get_header(); ?>

<main role="main">
  <div class="container">

    <?php echo page_breadcrumbs_html(); ?>

    <?php global $wp_query; ?>

    <?php if (isset($wp_query->queried_object->taxonomy) && $wp_query->queried_object->taxonomy == 'course_category') : ?>
      <?php
      $term_id = $wp_query->queried_object->term_id;
      $taxonomy = $wp_query->queried_object->taxonomy;
      $children = get_terms([
        'taxonomy' => $taxonomy,
        'hide_empty' => false,
        'parent' => $term_id,
      ]);
      $term_description = term_description();
      ?>

      <div class="box__title title_has_border">
        <h1><?php echo $wp_query->queried_object->name; ?></h1>
      </div>

      <?php if ($term_description) : ?>
        <div class="term-description">
          <?php echo $term_description; ?>
        </div>
      <?php endif; ?>

      <?php if ($children) : ?>

        <div class="box box_catalog">
          <div class="row">
            <?php foreach ($children as $item) : ?>
              <?php
              $term_image = wp_get_attachment_image(get_term_meta($item->term_id, 'course_category_image', true), 'medium', false, ['alt' => $item->name]);
              ?>
              <div class="col-12 col-sm-6 col-md-3 pb-4">
                <a href="<?php echo get_term_link($item->term_id, $taxonomy); ?>" class="card card_category">
                  <div class="card__image">
                    <?php echo $term_image; ?>
                  </div>
                  <div class="card__title">
                    <span><?php echo $item->name; ?></span>
                  </div>
                </a>
              </div>

            <?php endforeach; ?>
          </div>
        </div>

      <?php else : ?>
        <?php
        $arr_posts = get_posts(
          [
            'numberposts' => -1,
            'post_type'   => 'course',
            'orderby'     => 'id',
            'order'       => 'ASC',
            'tax_query' => [
              [
                'taxonomy' => $taxonomy,
                'field' => 'term_id',
                'terms' => $term_id,
              ],
            ]
          ]
        );
        ?>

        <?php if ($arr_posts) : ?>
          <div class="box box_catalog">
            <div class="row">
              <?php foreach ($arr_posts as $item) : ?>
                <?php
                $image = get_the_post_thumbnail($item->ID, 'medium', ['alt' => $item->post_title]);
                $products = get_field('course_products', $item->ID);
                $total = 0;
                foreach ($products as $ps_item) {
                  $total += (int)get_post_meta($ps_item['product'], '_price', true) * $ps_item['product_qty'];
                }
                $price = price_format($total) . ' ₽';
                ?>
                <div class="col-12 col-sm-6 col-md-3 pb-4">
                  <a href="<?php echo get_permalink($item->ID); ?>" class="card card_category">
                    <div class="card__image">
                      <?php echo $image; ?>
                    </div>
                    <div>
                      <div class="card__price">
                        <span><?php echo $price; ?></span>
                      </div>
                      <div class="card__title">
                        <span><?php echo $item->post_title; ?></span>
                      </div>
                    </div>
                  </a>
                </div>

              <?php endforeach; ?>
            </div>
          </div>
        <?php endif; ?>

      <?php endif; ?>

    <?php endif; ?>

  </div>
</main>

<?php get_footer(); ?>