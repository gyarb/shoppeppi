jQuery(window).on('load', function() {
  // Phone Mask
  function phoneMask() {
    jQuery('.input_phone').mask('+79999999999')
  }

  // Cart Amount (on the Header)
  jQuery('.add_to_cart_button ').on('click', function() {
    const amountEl = jQuery('.cart__amount')
    let count = amountEl.text()
    count = +count + 1
    setTimeout(function() {
      amountEl.text(count)
    }, 2000)
  })

  // Empty Cart Page
  function box_cart_links() {
    return `<div class="box_cart_links">
    <a href="${scriptData.homeUrl}">Главная</a>
    <a href="${scriptData.shopUrl}">Каталог</a>
  </div>`
  }
  var cart_links = box_cart_links()
  function boxEmptyCart() {
    jQuery('.wp-block-woocommerce-empty-cart-block').append(cart_links)
  }
  boxEmptyCart()

  // Home page accordion
  jQuery(function() {
    jQuery('.accordion_qa').accordion({
      heightStyle: 'content'
    })
  })

  // Cart Page
  var html = `<div class="box_shipping">
      <form action="" method="post" id='form_save_order'>
        <input type="hidden" name="action" value="saveorder">
        <div class="box_shipping__item">
          <label for="first_name">Имя <span class="star">*</span></label>
          <input type="text" id="shipping_first_name" name="first_name" class="field_required">
        </div>
        <div class="box_shipping__item">
          <label for="last_name">Фамилия <span class="star">*</span></label>
          <input type="text" id="shipping_last_name" name="last_name" class="field_required">
        </div>
        <div class="box_shipping__item">
          <label for="city">Город <span class="star">*</span></label>
          <input type="text" id="shipping_city" name="city" class="field_required">
        </div>
        <div class="box_shipping__item">
          <label for="phone">Телефон <span class="star">*</span></label>
          <input type="text" id="shipping_phone" name="phone" class='input_phone field_required'>
        </div>
        <div class="box_shipping__submit">
          <button type="submit" class="button button_submit" id="button_submit_save_order">Оформить заказ</button>
        </div>
      </form>      
    </div>`
  jQuery(
    '.wc-block-components-sidebar.wc-block-cart__sidebar.wp-block-woocommerce-cart-totals-block'
  ).append(html)

  fieldError()
  phoneMask()
  changeCountCart()

  jQuery('body').on('click', '#button_submit_save_order', function(event) {
    event.preventDefault()
    var btnSubmit = jQuery('#button_submit_save_order')
    var valEmpty = 0
    jQuery('.field_required').each(function(ind, el) {
      if (!jQuery(el).val().trim()) {
        jQuery(el).addClass('field_error')
        valEmpty = 1
      }
    })
    if (!valEmpty) {
      var dataForm = jQuery('#form_save_order').serialize()
      jQuery.ajax({
        url: scriptData.ajaxUrl,
        type: 'post',
        data: dataForm,
        beforeSend: function(xhr) {
          btnSubmit.text('Подождите...')
          btnSubmit.prop('disabled', true)
          btnSubmit.addClass('button_disabled')
        },
        success: function(res) {
          replySuccess(res)
        }
      })
    }
  })
  function fieldError() {
    jQuery('.field_required').on('focus', function() {
      jQuery(this).removeClass('field_error')
    })
  }
  function replySuccess(res) {
    var container = jQuery('.entry_content')
    var resData = JSON.parse(res)
    if (resData.first_name) {
      var html = `
      <div class="box_create_order_success">
        <h2>Заказ оформлен!</h2>
        <ul>
          <li><strong>Имя:</strong> ${resData.first_name}</li>
          <li><strong>Фамилия:</strong> ${resData.last_name}</li>
          <li><strong>Город:</strong> ${resData.city}</li>
          <li><strong>Телефон:</strong> +${resData.phone} </li>
          <li><strong>Сумма заказа:</strong> ${resData.total} ₽</li>
        </ul>
        ${resData.data_order_html}
        <p>
          В ближайщее время наш менеджер позвонит Вам, чтобы уточнить детали доставки и оплаты.
        </p>        
        ${cart_links}
      </div>`
    } else {
      var html = `<p>Ошибка сохранения заказа. Попробуйте еще раз или свяжитесь с нами. <a href="/kontakty">Наши контакты</a>.</p>`
    }
    container.html(html)
    getCountCart()
  }

  function changeCountCart() {
    jQuery(
      '.wc-block-components-quantity-selector__input'
    ).on('change', function() {
      getCountCart()
    })
    jQuery(
      '.wc-block-components-quantity-selector__button'
    ).on('click', function() {
      getCountCart()
    })
    jQuery('.wc-block-cart-item__remove-link').on('click', function() {
      getCountCart()
      setTimeout(function() {
        boxEmptyCart()
      }, 2000)
    })
  }
  function getCountCart() {
    setTimeout(function() {
      jQuery.ajax({
        url: scriptData.ajaxUrl,
        type: 'post',
        data: 'action=countcart',
        success: function(res) {
          setCountCart(res)
        }
      })
    }, 1000)
  }
  function setCountCart(data) {
    jQuery('.cart__amount').text(data)
  }

  jQuery('#button_course_add_to_cart').on('click', function(event) {
    event.preventDefault()
    var btnSubmit = jQuery(this)
    var dataForm = jQuery('#form_save_course').serialize()
    console.log(dataForm)
    jQuery.ajax({
      url: scriptData.ajaxUrl,
      type: 'post',
      data: dataForm,
      beforeSend: function(xhr) {
        btnSubmit.text('Подождите...')
        btnSubmit.prop('disabled', true)
        btnSubmit.addClass('button_disabled')
      },
      success: function(res) {
        getCountCart()
        replyCourseAddToCart(res)
      }
    })
  })

  function replyCourseAddToCart(res) {
    if (res == 'ok') {
      jQuery('#wrapp_button_course_add_to_cart').html(
        `Продукты курса добавлены в корзину. <a href="${scriptData.cartUrl}">Перейти в корзину</a>`
      )
    }
  }

  jQuery('.course_description .description span').attr('style', '')

  jQuery('.input_search_header').on('input', function() {
    var inputVal = jQuery(this).val()
    var boxResult = jQuery('#search_header_result')
    if (inputVal.length > 3) {
      jQuery.ajax({
        url: scriptData.ajaxUrl,
        type: 'post',
        data: {
          action: 'livesearch',
          search: inputVal
        },
        // beforeSend: function(xhr) {
        // },
        success: function(res) {
          boxResult.show()
          boxResult.html(res)
        }
      })
    } else {
      boxResult.html('')
      boxResult.hide()
    }
  })
})
