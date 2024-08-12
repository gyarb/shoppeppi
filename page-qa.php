<?php

/**
 * Template Name: Вопрос-Ответ
 */
?>

<?php get_header(); ?>

<main role="main">
  <div class="container">

    <?php echo page_breadcrumbs_html(); ?>

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

    <?php
    $qa_terms = get_terms([
      'taxonomy' => 'qa_category',
      'hide_empty' => false,
      'orderby' => 'meta_value_num',
      'meta_key' => 'qa_category_order',
      'order' => 'ASC',
    ]);
    ?>
    <?php foreach ($qa_terms as $qa_term) : ?>

      <?php
      $posts_qa = get_posts([
        'numberposts' => -1,
        'post_type'   => 'question-answer',
        'tax_query' => array(
          array(
            'taxonomy' => 'qa_category',
            'field'    => 'slug',
            'terms'    => $qa_term->slug,
          )
        ),
        'orderby' => 'meta_value_num',
        'meta_key' => 'qa_order',
        'order' => 'ASC',
      ]);
      ?>
      <?php if ($posts_qa) : ?>
        <div class="box box_faq box_qa">
          <div class="box__title title_has_border">
            <h2><?php echo $qa_term->name; ?></h2>
          </div>
          <div class="accordion_qa">
            <?php foreach ($posts_qa as $item) : ?>
              <h3><?php echo $item->post_title; ?></h3>
              <div class="qa__content">
                <?php
                echo $item->post_content;
                ?>
                <?php if (current_user_can('edit_post', $item->ID)) : ?>
                  <div style="text-align: right; font-size: 15px;"><a href="<?php echo get_edit_post_link($item->ID); ?>" target="_blank">Редактировать</a></div>
                <?php endif; ?>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      <?php endif; ?>

    <?php endforeach; ?>

  </div>
</main>

<?php get_footer(); ?>