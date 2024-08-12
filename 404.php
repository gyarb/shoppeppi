<?php get_header(); ?>

<main role="main">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <span>Ошибка 404</span>
        <h1>Страница не существует</h1>
        <p><a href="<?php echo home_url('/'); ?>">Главная &raquo;</a></p>
        <p><a href="<?php echo home_url('/shop'); ?>">Каталог &raquo;</a></p>
      </div>
    </div>
  </div>
</main>

<?php get_footer(); ?>