<?php
add_action('theme_wc_categories_loop', 'theme_wc_categories_loop_func');
function theme_wc_categories_loop_func($data_arr)
{

  $parent = 0;

  if ($data_arr) {
    $cat_data = get_term_by('slug', $data_arr['slug'], 'product_cat');
    if ($cat_data) {
      $parent = $cat_data->term_id;
    }
  }

  $cats = get_categories([
    'taxonomy'     => 'product_cat',
    'parent'       => $parent,
    'hide_empty'   => 0,
    'exclude'      => 15, //без категории
    'orderby'      => 'term_id',
    'order'        => 'ASC',
  ]);
?>

  <?php if ($data_arr && $data_arr['page'] == 'home') : ?>

    <?php if ($cats) : ?>
      <div class="row">
        <?php foreach ($cats as $cat) : ?>
          <?php
          $thumbnail_id = get_term_meta($cat->term_id, 'thumbnail_id', true);
          $img = $thumbnail_id ? wp_get_attachment_image($thumbnail_id, 'medium', false, ['alt' => $cat->name]) : '';
          ?>
          <div class="col-12 col-sm-6 col-md-3 pb-4">
            <a href="<?php echo get_category_link($cat->cat_ID); ?>" class="card card_category">
              <div class="card__image">
                <?php echo $img; ?>
              </div>
              <div class="card__title">
                <span><?php echo $cat->name; ?></span>
              </div>
            </a>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

  <?php else : ?>

    <?php if ($cats) : ?>
      <div class="row">
        <?php foreach ($cats as $cat) : ?>
          <?php
          $thumbnail_id = get_term_meta($cat->term_id, 'thumbnail_id', true);
          $img = $thumbnail_id ? wp_get_attachment_image($thumbnail_id, 'medium', false, ['alt' => $cat->name]) : '';
          ?>
          <div class="col-12 col-sm-6 col-md-3 pb-4">
            <a href="<?php echo get_category_link($cat->cat_ID); ?>" class="card card_category">
              <div class="card__image">
                <?php echo $img; ?>
              </div>
              <div class="card__title">
                <span><?php echo $cat->name; ?></span>
              </div>
            </a>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

  <?php endif; ?>

<?php
}

add_action('theme_wc_tags_loop', 'theme_wc_tags_loop_func');
function theme_wc_tags_loop_func($data_arr)
{
  $tags = get_terms(
    [
      'taxonomy' => 'product_tag',
      'hide_empty'    => false,
    ]
  );
?>

  <?php if ($data_arr && $data_arr['page'] == 'home') : ?>

    <?php if ($tags) : ?>
      <div class="row">
        <?php foreach ($tags as $tag) : ?>
          <?php
          $thumbnail_id = get_term_meta($tag->term_id, 'thumbnail_id', true);
          $img = $thumbnail_id ? wp_get_attachment_image($thumbnail_id, 'medium', false, ['alt' => $tag->name]) : '';
          ?>
          <div class="col-12 col-sm-6 col-md-4 col-lg-3 pb-4">
            <a href="<?php echo get_term_link($tag->term_id); ?>" class="card card_category">
              <!-- <?php if ($img) : ?>
                <div class="card__image">
                  <?php echo $img; ?>
                </div>
              <?php endif; ?> -->
              <div class="card__title">
                <span><?php echo $tag->name; ?></span>
              </div>
            </a>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

  <?php else : ?>

    <?php if ($tags) : ?>
      <div class="row">
        <?php foreach ($tags as $tag) : ?>
          <?php
          $thumbnail_id = get_term_meta($tag->term_id, 'thumbnail_id', true);
          $img = $thumbnail_id ? wp_get_attachment_image($thumbnail_id, 'medium', false, ['alt' => $tag->name]) : '';
          ?>
          <div class="col-12 col-sm-6 col-md-4 col-lg-3 pb-4">
            <a href="<?php echo get_term_link($tag->term_id); ?>" class="card card_category">
              <!-- <?php if ($img) : ?>
                <div class="card__image">
                  <?php echo $img; ?>
                </div>
              <?php endif; ?> -->
              <div class="card__title">
                <span><?php echo $tag->name; ?></span>
              </div>
            </a>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

  <?php endif; ?>

<?php
}

function theme_get_list_data($data)
{
  $separator = '___';
  $no_simbol_arr = ['.', '-', ',', ';', '*'];
  $data_arr = explode($separator, str_replace(array("\r\n", "\r", "\n"), $separator, $data));
  $list_arr = [];
  foreach ($data_arr as $item) {
    $item = str_replace('•', '', $item);
    $item = trim($item);
    if ($item) {
      $item = in_array($item[0], $no_simbol_arr) ? trim(substr($item, 1)) : $item;
      $list_arr[] = in_array($item[strlen($item) - 1], $no_simbol_arr) ? substr($item, 0, -1) : $item;
    }
  }
  return $list_arr;
}

function clear_data($data)
{
  $data = trim($data);
  $data = preg_replace('/[^\w-]/u', '', $data);
  return $data;
}

function price_format($data)
{
  return number_format($data, 2, ',', ' ');
}

add_action('wp_ajax_saveorder', 'saveorder_fn');
add_action('wp_ajax_nopriv_saveorder', 'saveorder_fn');
function saveorder_fn()
{
  $return_data = createOrder($_POST);
  if ($return_data) {
    echo json_encode($return_data);
  } else {
    echo 0;
  }
  wp_die();
}

function createOrder($data)
{
  $data_cart = WC()->cart->get_cart_contents();
  if ($data_cart) {
    $order = wc_create_order();
    $data_clear = [];
    foreach ($data as $key => $item) {
      $data_clear[$key] = clear_data($item);
    }
    $address = array(
      'first_name' => $data_clear['first_name'],
      'last_name'  => $data_clear['last_name'],
      'company'    => '',
      'email'      => '',
      'phone'      => $data_clear['phone'],
      'address_1'  => '',
      'address_2'  => '',
      'city'       => $data_clear['city'],
      'state'      => '',
      'postcode'   => '',
      'country'    => 'RU'
    );
    $order->set_address($address, 'billing');
    $order->set_address($address, 'shipping');

    $data_order = [];

    foreach ($data_cart as $item) {
      $p = wc_get_product($item['product_id']);
      $data_order[] = [
        'id' => $item['product_id'],
        'name' => $p->name,
        'price' => $p->price,
        'quantity' => $item['quantity'],
        'item_total' => $p->price * $item['quantity'],
      ];
      $order->add_product($p, $item['quantity']);
    }

    $payment_gateways = WC()->payment_gateways->payment_gateways();
    if (
      !empty($payment_gateways['cod'])
    ) {
      $order->set_payment_method($payment_gateways['cod']);
    }

    // $item = new WC_Order_Item_Shipping();
    // $item->set_method_title("Доставочка"); // название
    // $item->set_method_id("flat_rate:14"); // указываем ID существующего способа доставки
    // $item->set_total(5); // стоимость доставки (необязательно)
    // $order->add_item($item);

    $order->calculate_totals();
    $order->set_status('pending');

    $order_total = price_format($order->get_total());

    $data_order_html = '';
    $data_order_html .= '<table class="create_order_table" cellpadding="3" cellspacing="0" border="1" style="width: 100%; text-align: left;">';
    $data_order_html .= '<tbody>';
    $data_order_html .= '<tr>';
    $data_order_html .= '<th style="text-align: left;">Продукт</th>';
    $data_order_html .= '<th style="width: 15%; text-align: left;">Цена, ₽</th>';
    $data_order_html .= '<th style="width: 15%; text-align: left;">Количество</th>';
    $data_order_html .= '<th style="width: 15%; text-align: left;">Стоимость, ₽</th>';
    $data_order_html .= '</tr>';
    foreach ($data_order as $item) {
      $data_order_html .= '<tr>';
      $data_order_html .= '<td><a href="' . get_permalink($item['id']) . '">' . $item['name'] . '</a></td>';
      $data_order_html .= '<td>' . price_format($item['price']) . '</td>';
      $data_order_html .= '<td>' . $item['quantity'] . '</td>';
      $data_order_html .= '<td>' . price_format($item['item_total']) . '</td>';
      $data_order_html .= '</tr>';
    }
    $data_order_html .= '</tbody>';
    $data_order_html .= '</table>';
    $data_order_html .= '<p class="create_order_total" style="text-align: right;">ИТОГО: ' . $order_total . ' ₽</p>';

    if ($order->save()) {
      WC()->cart->empty_cart();
      $data_return = [
        'first_name' => $data_clear['first_name'],
        'last_name' => $data_clear['last_name'],
        'city' => $data_clear['city'],
        'phone' => $data_clear['phone'],
        'total' => $order_total,
        'data_order' => $data_order,
        'data_order_html' => $data_order_html,
      ];
      send_new_order_mail($data_return);
      return $data_return;
    } else {
      return 0;
    }
  } else {
    return 0;
  }
}

function send_new_order_mail($data)
{
  $options = get_option('peppishop_options');
  $title = 'Новый заказ';
  $message = '';
  $message .= 'Имя: ' . $data['first_name'] . '<br>';
  $message .= 'Фамилия: ' . $data['last_name'] . '<br>';
  $message .= 'Город: ' . $data['city'] . '<br>';
  $message .= 'Телефон: ' . $data['phone'] . '<br>';
  $message .= 'Сумма заказа: ' . $data['total'] . ' ₽<br>';
  $message .= $data['data_order_html'] . '<br>';
  $message .= '-----<br>';
  $message .= 'Сообщение отправлено с сайта <a href="https://zdorovpeptid.ru">zdorovpeptid.ru</a>';

  wp_mail(
    $options['email_system'],
    $title,
    $message,
    array(
      'Content-type: text/html; charset=utf-8'
    )
  );
}

function get_package_name($qty)
{
  $name = 'упаковка';
  if ($qty > 1 && $qty < 5) {
    $name = 'упаковки';
  }
  if ($qty > 4) {
    $name = 'упаковок';
  }
  return $name;
}

add_action('wp_ajax_countcart', 'countcart_fn');
add_action('wp_ajax_nopriv_countcart', 'countcart_fn');

function countcart_fn()
{
  echo WC()->cart->get_cart_contents_count();
  wp_die();
}

add_action('wp_ajax_addcoursecart', 'addcoursecart_fn');
add_action('wp_ajax_nopriv_addcoursecart', 'addcoursecart_fn');

function addcoursecart_fn()
{
  if ($_POST['product']) {
    foreach ($_POST['product'] as $id => $qty) {
      WC()->cart->add_to_cart($id, $qty);
    }
    echo 'ok';
  }

  wp_die();
}

add_action('wp_ajax_livesearch', 'livesearch_fn');
add_action('wp_ajax_nopriv_livesearch', 'livesearch_fn');

function livesearch_fn()
{
  $search = sanitize_text_field($_POST['search']);

  $data = query_posts([
    'numberposts' => 10,
    'post_type'   => 'product',
    's' => $search,
  ]);

  wp_reset_query();

  if ($data) {
    $html = '<ul class="items">';
    foreach ($data as $item) {
      $html .= '<li class="item">';
      $html .= '<span class="item__image">' . get_the_post_thumbnail($item->ID, 'thumbnail') . '</span>';
      $html .= '<span class="item__link"><a href="' . get_permalink($item->ID) . '">' . $item->post_title . '</a></span>';
      $html .= '</li>';
    }
    $html .= '<ul>';
  } else {
    $html = '<span class="text_noresult">Ничего не найдено.</span>';
  }

  echo $html;

  wp_die();
}

add_action('woocommerce_single_product_summary', 'woocommerce_template_single_short_action', 7);
function woocommerce_template_single_short_action()
{
  global $product;
  $data_short = get_field('product_short', $product->id);
  $data_short['product_action_short'];
  if ($data_short && $data_short['product_action_short']) {
    echo '<p class="product_action_short">' . $data_short['product_action_short'] . '</p>';
  }
}
