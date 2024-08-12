<?php

add_action('admin_menu', function () {
  add_menu_page('Настройки магазина', 'Магазин', 'manage_options', 'peppishop', 'peppishop_setting_func', '', 27);
  add_submenu_page('peppishop', 'Настройки магазина', 'Настройки', 'manage_options', 'peppishop', 'peppishop_setting_func');
  add_submenu_page('peppishop', 'Продукты: краткая информация', 'Кратко о продукте', 'manage_options', 'peppishop-products-short', 'peppishop_products_data_func');
  add_submenu_page('peppishop', 'Продукты: цены', 'Цены', 'manage_options', 'peppishop-products-price', 'peppishop_products_data_func');
  add_submenu_page('peppishop', 'Продукты: артикулы', 'Артикулы', 'manage_options', 'peppishop-products-sku', 'peppishop_products_data_func');
  add_submenu_page('peppishop', 'Продукты: бонусные баллы', 'Баллы', 'manage_options', 'peppishop-products-bally', 'peppishop_products_data_func');
  add_submenu_page('peppishop', 'Продукты: метки', 'Метки', 'manage_options', 'peppishop-products-tags', 'peppishop_products_data_func');
  add_submenu_page('peppishop', 'Продукты: порядок', 'Порядок', 'manage_options', 'peppishop-products-menuorder', 'peppishop_products_data_func');
  add_submenu_page('peppishop', 'Продукты: тексты', 'Тексты', 'manage_options', 'peppishop-products-content', 'peppishop_content_func');
});

function peppishop_content_func()
{
?>
  <div class="wrap">
    <h2><?php echo get_admin_page_title() ?></h2>
    <br>
    <?php peppishop_notice_html(); ?>
    <?php $options = get_option('peppishop_content'); ?>
    <form action="/wp-admin/admin.php?page=<?php echo $_GET['page']; ?>" method="POST">
      <input type="hidden" value="1" name="peppishop_content">
      <table class="form-table" role="presentation">
        <tbody>
          <tr>
            <th scope="row"><label for="contra">Противопоказания (Пептиды)</label></th>
            <td>
              <textarea name="data[contra]" type="text" id="contra" class="" rows="5" cols="50"><?php echo $options['contra']; ?></textarea>
              <p class="description">Отображается на странице товара.</p>
            </td>
          </tr>
        </tbody>
      </table>
      <?php submit_button(); ?>
    </form>
  </div>
  <?php
  if (isset($_POST['peppishop_content'])) {
    if (!is_admin()) {
      return false;
    }
    if (isset($_POST['data'])) {
      update_option('peppishop_content', $_POST['data']);
    }

    $_SESSION['notice'] = 1;
    wp_redirect('/wp-admin/admin.php?page=' . $_GET['page']);
  }
  ?>

<?php
}

function peppishop_setting_func()
{
?>
  <div class="wrap">
    <h2><?php echo get_admin_page_title() ?></h2>
    <br>
    <?php peppishop_notice_html(); ?>
    <?php $options = get_option('peppishop_options'); ?>
    <form action="/wp-admin/admin.php?page=<?php echo $_GET['page']; ?>" method="POST">
      <table class="form-table" role="presentation">
        <tbody>
          <tr>
            <th scope="row"><label for="phone">Телефон (основной)</label></th>
            <td>
              <input name="data[phone]" type="text" id="phone" class="regular-text" value="<?php echo $options['phone']; ?>">
              <p class="description">Отображается в подвале и/или шапке сайта.</p>
            </td>
          </tr>
          <tr>
            <th scope="row"><label for="address">Адрес</label></th>
            <td>
              <input name="data[address]" type="text" id="address" class="regular-text" value="<?php echo $options['address']; ?>">
              <p class="description">Отображается в подвале и/или шапке сайта.</p>
            </td>
          </tr>
          <tr>
            <th scope="row"><label for="email">E-mail (для клиентов)</label></th>
            <td>
              <input name="data[email]" type="text" id="email" class="regular-text" value="<?php echo $options['email']; ?>">
              <p class="description">Отображается в подвале и/или шапке сайта.</p>
            </td>
          </tr>
          <tr>
            <th scope="row"><label for="email_system">E-mail (для сообщений о заказах)</label></th>
            <td>
              <input name="data[email_system]" type="text" id="email_system" class="regular-text" value="<?php echo $options['email_system']; ?>">
              <p class="description">Email для системных сообщений о заказах и др.</p>
            </td>
          </tr>
          <tr>
            <th scope="row"><label for="link-vk">ВКонтакте (ссылка)</label></th>
            <td>
              <input name="data[vk]" type="text" id="link-vk" class="regular-text" value="<?php echo $options['vk']; ?>">
              <p class="description">Отображается в подвале и/или шапке сайта.</p>
            </td>
          </tr>
          <tr>
            <th scope="row"><label for="link-yt">YouTube (ссылка)</label></th>
            <td>
              <input name="data[yt]" type="text" id="link-yt" class="regular-text" value="<?php echo $options['yt']; ?>">
              <p class="description">Отображается в подвале и/или шапке сайта.</p>
            </td>
          </tr>
          <tr>
            <th scope="row"><label for="link-tg">Telegram (ссылка)</label></th>
            <td>
              <input name="data[tg]" type="text" id="link-tg" class="regular-text" value="<?php echo $options['tg']; ?>">
              <p class="description">Отображается в подвале и/или шапке сайта.</p>
            </td>
          </tr>
          <!-- <tr>
            <th scope="row"><label for="link-wa">Whatsapp (номер телефона)</label></th>
            <td>
              <input name="data[wa]" type="text" id="link-wa" class="regular-text" value="<?php echo $options['wa']; ?>">
              <p class="description">Отображается в подвале и/или шапке сайта.</p>
            </td>
          </tr> -->
        </tbody>
      </table>
      <input type="hidden" value="1" name="peppishop_setting">
      <?php submit_button(); ?>
    </form>
  </div>

  <?php
  if (isset($_POST['peppishop_setting'])) {
    if (!is_admin()) {
      return false;
    }
    update_option('peppishop_options', $_POST['data']);

    $_SESSION['notice'] = 1;
    wp_redirect('/wp-admin/admin.php?page=' . $_GET['page']);
  }
  ?>

<?php
}

function get_category_goods()
{
  $goods = [];
  $category_id = $_GET['category'] ?? '-1';
  if ($category_id > -1) {
    $goods = get_posts(
      array(
        'post_type' => 'product',
        'numberposts' => -1,
        'tax_query' => array(
          array(
            'taxonomy' => 'product_cat',
            'field'    => 'term_id',
            'terms'    => $category_id
          )
        )
      )
    );
  }
  return $goods;
}

function peppishop_notice_html()
{
  if (isset($_SESSION['notice'])) {
    $text = $_SESSION['notice']['text'] ?? 'Данные сохранены.';
    $type = $_SESSION['notice']['type'] ?? 'success';
    wp_admin_notice($text, array(
      'type' => $type,
      'dismissible' => true
    ));
    unset($_SESSION['notice']);
  }
}

function peppishop_form_select_categories_html()
{
?>
  <form action="" method="get">
    <input type="hidden" name="page" value="<?php echo $_GET['page']; ?>">
    <div class="tablenav top">
      <div class="alignleft actions bulkactions">
        <?php wp_dropdown_categories([
          'hide_empty'         => 0,
          'taxonomy'           => 'product_cat',
          'hierarchical'       => 1,
          'selected'           => $_GET['category'] ?? 0,
          'exclude'            => 15,
          'depth'              => 2,
          'name'               => 'category',
          'id'                 => 'bulk-action-selector-top',
          'class'              => 'postform',
          'show_option_none'   => '- Выберите категорию -',
          'option_none_value'  => -1,
        ]); ?>
        <input type="submit" class="button action" value="Получить товары">
      </div>
      <br class="clear">
    </div>
  </form>
<?php
}

function peppishop_selects_tags_html($id)
{
?>
  <div class="wrap-select" style="display: flex;">
    <style>
      .wp-core-ui select {
        max-width: 144px;
      }
    </style>
    <?php
    $tags = wc_get_product_term_ids($id, 'product_tag');
    $i = 0;
    while ($i < 3) {
      wp_dropdown_categories([
        'hide_empty'         => 0,
        'taxonomy'           => 'product_tag',
        'selected'           => $tags[$i] ?? '',
        'name'               => 'data[' . $id . '][]',
        'show_option_none'   => '-',
        'option_none_value'  => '',
      ]);
      $i++;
    }
    ?>
  </div>
  <?php
}

function peppishop_page_description_html($data)
{
  if (isset($data['description'])) {
  ?>
    <p><?php echo $data['description']; ?></p>
  <?php
  }
}

function peppishop_form_table_goods_data_html()
{
  ?>
  <?php
  $data_page = [
    'peppishop-products-short' => [
      'table_col' => 'Поля продукта',
      'meta_name' => 'product_short',
    ],
    'peppishop-products-price' => [
      'table_col' => 'Цена, руб.',
      'meta_name' => '_regular_price',
    ],
    'peppishop-products-sku' => [
      'table_col' => 'Артикул',
      'meta_name' => '_sku',
    ],
    'peppishop-products-bally' => [
      'table_col' => 'Бонусные баллы',
      'meta_name' => 'bally',
    ],
    'peppishop-products-tags' => [
      'table_col' => 'Метки',
    ],
    'peppishop-products-menuorder' => [
      'table_col' => 'Порядок',
      'description' => 'Чем меньше значение, тем выше будет отображаться товар в каталоге. Значение может быть со знаком "минус".',
    ],
  ];
  $goods = get_category_goods();
  ?>

  <?php peppishop_page_description_html($data_page[$_GET['page']]); ?>

  <form action="/wp-admin/admin.php?page=<?php echo $_GET['page']; ?>" method="post">
    <table class="wp-list-table widefat striped">
      <thead>
        <tr>
          <th>Наменование</th>
          <th><?php echo $data_page[$_GET['page']]['table_col']; ?></th>
        </tr>
      </thead>
      <tbody>
        <?php if ($goods) : ?>
          <?php foreach ($goods as $item) : ?>
            <tr>
              <td>
                <a href="<?php echo get_permalink($item->ID); ?>" target="_blank" class="row-title"><?php echo $item->post_title; ?></a><br>
                <a href="<?php echo get_edit_post_link($item->ID, ''); ?>" target="_blank">Изменить</a>
              </td>
              <td>
                <?php if ($_GET['page'] == 'peppishop-products-tags') : ?>
                  <?php peppishop_selects_tags_html($item->ID); ?>
                <?php else : ?>
                  <?php
                  $value_one = 1;
                  if ($_GET['page'] == 'peppishop-products-short') {
                    $value_one = 0;
                    $arr_data_pshort = [
                      'product_title_short' => 'Название',
                      'product_action_short' => 'Действие',
                      'product_method_short' => 'Способ применения',
                    ];
                    $data_value = get_field('product_short', $item->ID);
                  } elseif ($_GET['page'] == 'peppishop-products-menuorder') {
                    $_post = get_post($item->ID);
                    $input_value = $_post->menu_order;
                  } else {
                    $input_value = get_post_meta($item->ID, $data_page[$_GET['page']]['meta_name'], true);
                  }
                  ?>
                  <?php if ($value_one) : ?>
                    <input type="text" name="data[<?php echo $item->ID; ?>]" value="<?php echo $input_value; ?>">
                  <?php else : ?>
                    <?php if ($_GET['page'] == 'peppishop-products-short'): ?>
                      <table style="width: 100%;">
                        <?php foreach ($arr_data_pshort as $_key => $_item) : ?>
                          <tr>
                            <td style="padding: 1px;"><?php echo $_item; ?></td>
                            <td style="padding: 1px;"><input type="text" name="data[<?php echo $item->ID; ?>][<?php echo $_key ?>]" value="<?php echo $data_value[$_key] ?? ''; ?>" style="min-width: 300px; width: 100%"></td>
                          </tr>
                        <?php endforeach; ?>
                      </table>
                    <?php endif; ?>
                  <?php endif; ?>
                <?php endif; ?>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
    <input type="hidden" name="category" value="<?php echo  $_GET['category'] ?? ''; ?>">
    <input type="hidden" name="peppishop_save_goods" value="1">
    <?php if ($goods) : ?>
      <?php submit_button(); ?>
    <?php endif; ?>
  </form>
<?php
}

function peppishop_products_data_func()
{
?>

  <div class="wrap">
    <h2><?php echo get_admin_page_title() ?></h2>
    <br>
    <?php peppishop_notice_html(); ?>
    <?php peppishop_form_select_categories_html(); ?>
    <?php peppishop_form_table_goods_data_html(); ?>
  </div>

  <?php


  if (isset($_POST['peppishop_save_goods']) && isset($_POST['data'])) {
    if (!is_admin()) {
      return false;
    }
    $product_pages = ['peppishop-products-price', 'peppishop-products-sku', 'peppishop-products-tags', 'peppishop-products-menuorder'];
    foreach ($_POST['data'] as $id => $item) {
      if ($_GET['page'] == 'peppishop-products-short') {
        update_field('product_short', $item, $id);
      }
      if ($_GET['page'] == 'peppishop-products-bally') {
        update_post_meta($id, 'bally', $item);
      }
      if (in_array($_GET['page'], $product_pages)) {
        $product = wc_get_product($id);
        if ($_GET['page'] == 'peppishop-products-price') {
          $product->set_regular_price($item);
        }
        if ($_GET['page'] == 'peppishop-products-sku') {
          $product->set_sku($item);
        }
        if ($_GET['page'] == 'peppishop-products-tags') {
          $product->set_tag_ids($item);
        }
        if ($_GET['page'] == 'peppishop-products-menuorder') {
          $product->set_menu_order($item);
        }
        $product->save();
      }
    }

    $_SESSION['notice'] = 1;
    wp_redirect('/wp-admin/admin.php?page=' . $_GET['page'] . '&' . 'category=' . $_POST['category']);
  }
  ?>

<?php
}
