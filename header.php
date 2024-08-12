<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php wp_title('|', true, 'right'); ?><?php bloginfo('name'); ?></title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Roboto:ital,wght@0,300;0,400;0,500;1,300;1,400;1,500&display=swap" rel="stylesheet">
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

  <header class="header">
    <div class="container">

      <div class="row">
        <div class="col-8 col-sm-6 col-md-5">
          <div class="logo">
            <a href="<?php echo home_url('/'); ?>">
              <span class="logo__colors">
                <div class="item item_1"></div>
                <div class="item item_2"></div>
                <div class="item item_3"></div>
              </span>
              <span class="logo__text">Пептиды Хавинсона</span>
            </a>
          </div>
        </div>
        <div class="col-4 d-sm-none d-flex justify-content-end">
          <a href="<?php echo wc_get_cart_url(); ?>" class="cart cart_header">
            <i class="icon icon_cart fa fa-opencart" aria-hidden="true"></i>
            <span class="cart__text d-none d-md-inline-block">Корзина</span>
            <span class="cart__amount"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
          </a>
        </div>
        <div class="col-12 col-sm-6 col-md-7">
          <div class="header__contacts">
            <div class="title_contact d-none d-md-block">
              Задать вопрос:
            </div>
            <?php if ($telegram_link_html = telegram_link_html()) : ?>
              <div class="contact">
                <i class="icon icon_contact fa fa-telegram" aria-hidden="true"></i>
                <span class="text_contact"><?php echo $telegram_link_html; ?></span>
              </div>
            <?php endif; ?>
            <?php if ($phone_link_html = phone_link_html()) : ?>
              <div class="contact">
                <i class="icon icon_contact fa fa-phone" aria-hidden="true"></i>
                <span class="text_contact"><?php echo $phone_link_html; ?></span>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-3 d-none d-md-block">
          <div class="header__text">
            Здоровье и молодость возвращаются!
          </div>
        </div>
        <div class="col-12 col-sm-8 col-md-6">
          <div class="searh searh_header">
            <form role="search" method="get" id="searchform" action="<?php echo home_url('/'); ?>" class="form form_search">
              <input type="text" name="s" id="s" placeholder="Поиск по продуктам" class="input input_search input_search_header" value="<?php echo $_GET['s'] ?? ''; ?>">
              <button type="submit" id="searchsubmit" class="button button_search"><i class="fa fa-search" aria-hidden="true"></i></button>
            </form>
            <div class="search_result" id="search_header_result"></div>
          </div>
        </div>
        <div class="col-12 col-sm-4 col-md-3 d-none d-sm-block">
          <a href="<?php echo wc_get_cart_url(); ?>" class="cart cart_header">
            <i class="icon icon_cart fa fa-opencart" aria-hidden="true"></i>
            <span class="cart__text d-none d-md-inline-block">Корзина</span>
            <span class="cart__amount"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
          </a>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <div class="header__menu">
            <?php
            wp_nav_menu([
              'theme_location' => 'header_menu',
              'container' => 'nav',
              'menu_class' => 'menu menu_header',
              'items_wrap' => '<ul class="%2$s">%3$s</ul>',
              'depth' => 2,
            ]);
            ?>
          </div>
        </div>
      </div>
    </div>
  </header>

  <div class="content">