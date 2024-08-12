<?php get_header(); ?>

<main role="main">
  <div class="container">

    <?php echo page_breadcrumbs_html(); ?>

    <div class="row">
      <div class="col-12">
        <?php
        while (have_posts()) :
          the_post();
        ?>
          <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <?php
            if ($post->post_type == 'course') {
              get_template_part('parts/single/content', 'course');
            } else {
              get_template_part('parts/single/content');
            }
            ?>
          </article>
        <?php endwhile;
        ?>
      </div>
    </div>
  </div>
</main>

<?php get_footer(); ?>