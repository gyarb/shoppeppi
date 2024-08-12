<header class="entry-header">
  <h1 class="entry_title"><?php the_title(); ?></h1>
</header>
<div class="entry_content box_course woocommerce">

  <?php
  $description = get_field('course_description');
  $note = get_field('course_note');
  $arr_products = get_field('course_products');
  $total = 0;
  $arr_short = [];
  ?>

  <?php if ($arr_products) : ?>
    <form action="" method="post" id="form_save_course" class="mb-4">
      <input type="hidden" name="action" value="addcoursecart">
      <div class="box_course_list mb-4">
        <?php foreach ($arr_products as $item) : ?>
          <?php if ($item['product']) : ?>
            <?php
            $p = wc_get_product($item['product']);
            $total += $p->price * $item['product_qty'];
            $item_data_short = get_field('product_short', $item['product']);
            $arr_short[] = [
              'qty' => $item['product_qty'],
              'data_short' => $item_data_short,
            ];
            ?>
            <input type="hidden" name="product[<?php echo $item['product']; ?>]" value="<?php echo $item['product_qty']; ?>">
            <div class="item">
              <div class="row">
                <div class="col-2">
                  <div class="image">
                    <?php echo $p->get_image('woocommerce_thumbnail', array('title' => $p->name)); ?>
                  </div>
                </div>
                <div class="col-6">
                  <div class="name pt-3">
                    <a href="<?php echo $p->get_permalink(); ?>"><?php echo $p->name; ?></a>
                    <span class="item_action"><?php echo $item_data_short['product_action_short']; ?></span>
                  </div>
                </div>
                <div class="col-2">
                  <div class="qty pt-3">
                    <span class="qty__sing">x</span> <?php echo $item['product_qty']; ?>
                  </div>
                </div>
                <div class="col-2">
                  <div class="price pt-3">
                    <?php echo $p->get_price_html(); ?>
                  </div>
                </div>
              </div>
            </div>
          <?php endif; ?>
        <?php endforeach; ?>
        <div class="item">
          <div class="total">
            <span class="total__text">Сумма комплекта:</span>
            <span class="total__price"><?php echo price_format($total); ?> ₽</span>
          </div>
        </div>
      </div>
      <div class="button_submit" id="wrapp_button_course_add_to_cart">
        <button type="submit" id="button_course_add_to_cart" class="single_add_to_cart_button button">В корзину</button>
      </div>
    </form>
  <?php endif; ?>

  <div class="box__title title_has_border">
    <h2>Описание</h2>
  </div>

  <div class="course_description">

    <div class="description">
      <?php echo $description; ?>
    </div>

    <?php if ($arr_short) : ?>
      <div class="mb-5">
        <h4>Состав курса:</h4>
        <ul class="list">
          <?php foreach ($arr_short as $item) : ?>
            <li>
              <i class="icon fa fa-check" aria-hidden="true"></i>
              <strong><?php echo $item['data_short']['product_title_short']; ?> (<?php echo $item['qty']; ?> <?php echo get_package_name($item['qty']); ?>):</strong> <?php echo $item['data_short']['product_action_short']; ?>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endif; ?>

    <?php if ($arr_short) : ?>
      <div class="mb-5">
        <h4>Способ применения курса:</h4>
        <ul class="list">
          <?php foreach ($arr_short as $item) : ?>
            <li>
              <i class="icon fa fa-check" aria-hidden="true"></i>
              <strong><?php echo $item['data_short']['product_title_short']; ?>:</strong> <?php echo $item['data_short']['product_method_short']; ?>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endif; ?>

    <?php if ($note) : ?>
      <div class="note">
        <span class="note__title">Примечание:</span>
        <span class="note__text"><?php echo $note; ?></span>
      </div>
    <?php endif; ?>

  </div>

</div>