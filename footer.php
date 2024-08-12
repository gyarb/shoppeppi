</div>

<footer class="footer">

  <?php
  // $p = wc_get_product(165);
  // echo $p->id;
  // echo get_permalink($p->id);
  // p_arr($p);
  ?>

  <div class="footer__content">
    <div class="container">
      <div class="row">
        <div class="col-md-3">
          <div class="logo logo_footer">
            <a href="<?php echo home_url('/'); ?>">
              <span class="logo__colors">
                <div class="item item_1"></div>
                <div class="item item_2"></div>
                <div class="item item_3"></div>
              </span>
              <span class="logo__text">Пептиды Хавинсона</span>
            </a>
          </div>
          <div class="footer__contacts">
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
            <?php if ($email_link_html = email_link_html()) : ?>
              <div class="contact">
                <i class="icon icon_contact fa fa-envelope" aria-hidden="true"></i>
                <span class="text_contact"><?php echo $email_link_html; ?></span>
              </div>
            <?php endif; ?>
          </div>
        </div>
        <div class="col-md-9">
          <div class="row">
            <div class="col-md-4">
              <?php
              $args = [
                'taxonomy'      => 'product_cat',
                'orderby'       => 'id',
                'order'         => 'ASC',
                'hide_empty'    => false,
                'count'         => false,
                'parent'         => '0',
                'hierarchical'  => true,
                'child_of'      => 0,
                'pad_counts'    => false,
              ];
              $terms = get_terms($args);
              ?>
              <?php if ($terms) : ?>
                <h4>Каталог</h4>
                <ul class="menu menu_footer">
                  <?php foreach ($terms as $item) : ?>
                    <?php if ($item->term_id !== 15) : ?>
                      <li><a href="<?php echo get_term_link($item); ?>"><?php echo $item->name; ?></a></li>
                    <?php endif; ?>
                  <?php endforeach; ?>
                </ul>
              <?php endif; ?>
            </div>
            <div class="col-md-4">
              <h4>Информация</h4>
              <?php
              wp_nav_menu([
                'theme_location' => 'footer_menu_1',
                'container' => 'nav',
                'menu_class' => 'menu menu_footer',
                'items_wrap' => '<ul class="%2$s">%3$s</ul>',
                'depth' => 1,
              ]);
              ?>
            </div>
            <div class="col-md-4">

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="copy">
    <div class="container">
      <div class="row">
        <div class="col-12">&copy; <?php echo date('Y'); ?> г. Интернет-магазин. Пептиды Хавинсона. БАД. Не является лекарством.</div>
      </div>
    </div>
  </div>

</footer>

<?php wp_footer(); ?>
</body>

</html>