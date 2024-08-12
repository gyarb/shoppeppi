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
            <header class="entry-header">
              <h1 class="entry_title"><?php the_title(); ?></h1>
            </header>
            <div class="entry_content">
              <?php the_content(); ?>
            </div>
          </article>
        <?php endwhile;
        ?>
      </div>
    </div>
  </div>
</main>

<?php get_footer(); ?>