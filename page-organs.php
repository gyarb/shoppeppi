<?php

/**
 * Template Name: По органам
 */
?>

<?php get_header(); ?>

<main class="main main_organs" role="main">
  <div class="container">

    <?php echo page_breadcrumbs_html(); ?>

    <div class="row">
      <div class="col-12">
        <?php
        while (have_posts()) :
          the_post();
        ?>
          <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <header class="entry-header">
              <h1 class="entry_title"><?php the_title(); ?></h1>
            </header>
            <?php if ($post->post_content) : ?>
              <div class="entry_content pb-3">
                <?php the_content(); ?>
              </div>
            <?php endif; ?>
          </article>
        <?php endwhile;
        ?>
      </div>
    </div>

    <div class="box box_organs">
      <!-- <div class="box__title title_has_border">
        <h2>Пептиды по органам</h2>
      </div> -->
      <?php do_action('theme_wc_tags_loop', ['page' => 'organs']); ?>
    </div>

  </div>
</main>

<?php get_footer(); ?>