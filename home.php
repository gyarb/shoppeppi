<?php

/**
 * Template Name: Главная
 */
?>

<?php get_header(); ?>

<main class="main main_home" role="main">
  <div class="container">

    <div class="box box_home box_advantages">
      <div class="row">
        <div class="col-12 col-md-6 col-lg-3 mb-3 mb-lg-0">
          <div class="card card_advantage">
            <div class="card__image">
              <i class="icon icon_advantage fa fa-user-md" aria-hidden="true"></i>
            </div>
            <div class="card__text">
              Консультация специалистов
            </div>
          </div>
        </div>
        <div class="col-12 col-md-6 col-lg-3 mb-3 mb-lg-0">
          <div class="card card_advantage">
            <div class="card__image">
              <i class="icon icon_advantage fa fa-shield" aria-hidden="true"></i>
            </div>
            <div class="card__text">
              Гарантия качества и низкой цены
            </div>
          </div>
        </div>
        <div class="col-12 col-md-6 col-lg-3 mb-3 mb-lg-0">
          <div class="card card_advantage">
            <div class="card__image">
              <i class="icon icon_advantage fa fa-truck" aria-hidden="true"></i>
            </div>
            <div class="card__text">
              Быстрая доставка по всей России
            </div>
          </div>
        </div>
        <div class="col-12 col-md-6 col-lg-3 mb-3 mb-lg-0">
          <div class="card card_advantage">
            <div class="card__image">
              <i class="icon icon_advantage fa fa-gift" aria-hidden="true"></i>
            </div>
            <div class="card__text">
              Выгодная CashBack программа
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="box box_home box_havinson">
      <div class="row">
        <div class="col-12 col-lg-6 mb-5 mb-lg-0">
          <div class="box__card box__card_about">
            <div class="card__title">
              <h2>Пептидные биорегуляторы</h2>
            </div>
            <div class="card__text">
              <ul>
                <li><i class="icon icon_about fa fa-check" aria-hidden="true"></i> Восстанавливают правильную работу органов</li>
                <li><i class="icon icon_about fa fa-check" aria-hidden="true"></i> Эффективность доказана клиническими исследованиями</li>
                <li><i class="icon icon_about fa fa-check" aria-hidden="true"></i> Изучаются с 1971 года</li>
                <li><i class="icon icon_about fa fa-check" aria-hidden="true"></i> Побочных эффектов не выявлено</li>
                <li><i class="icon icon_about fa fa-check" aria-hidden="true"></i> Производятся в России</li>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-12 col-lg-6">
          <div class="box__card box__card_author">
            <div class="card__title">
              <img src="<?php echo get_template_directory_uri(); ?>/images/vladimir-havinson.png" alt="Владимир Хавинсон">
              <h3>Владимир Хавинсон</h3>
            </div>
            <div class="card__text">
              «Мы не создали ничего нового, мы просто узнали, как это происходит в природе и научились восполнять дефицит этих молекул, а значит, научились «помогать организму правильно жить»
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="box box_home box_categories">
      <div class="box__title title_has_border">
        <h2>Пептидные препараты для здоровья и долголетия</h2>
      </div>
      <?php do_action('theme_wc_categories_loop', ['slug' => 'peptidy', 'page' => 'home']); ?>
    </div>

    <div class="box box_home box_organs">
      <div class="box__title title_has_border">
        <h2>Пептиды по органам</h2>
      </div>
      <?php do_action('theme_wc_tags_loop', ['page' => 'home']); ?>
    </div>

    <?php
    $posts_qa = get_posts([
      'numberposts' => -1,
      'post_type'   => 'question-answer',
      'meta_query' => [[
        'key' => 'qa_show_home',
        'value' => '1',
      ]],
      'orderby' => 'meta_value_num',
      'meta_key' => 'qa_order_home',
      'order' => 'ASC',
    ]);
    ?>
    <?php if ($posts_qa) : ?>
      <div class="box box_home box_qa">
        <div class="box__title title_has_border">
          <h2>Вопросы и ответы</h2>
        </div>
        <div id="accordion_qa" class="accordion_qa">
          <?php foreach ($posts_qa as $item) : ?>
            <h3><?php echo $item->post_title; ?></h3>
            <div class="qa__content">
              <?php echo $item->post_content; ?>
            </div>
          <?php endforeach; ?>
        </div>
        <div class="show_more">
          <a href="<?php echo home_url('/'); ?>faq">Смотреть другие ответы &raquo;</a>
        </div>
      </div>
    <?php endif; ?>

    <div class="row">
      <div class="col-12">
        <?php
        while (have_posts()) :
          the_post();
        ?>
          <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
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