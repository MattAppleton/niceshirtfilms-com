<?php
get_header();
?>

<!-- main content -->

<main id="main-content">

<?php
if( have_posts() ) {
  while( have_posts() ) {
    the_post();
    $meta = get_post_meta($post->ID);
?>

  <article id="page" <?php post_class(); ?>>

    <header class="page-header u-cf">

      <div class="col col2 colpad1left">

        <h3><?php the_title(); ?></h3>

      </div>

    </header>

    <section class="row u-cf">

      <div class="col col2 colpad1left">

        <div class="copy">

          <?php the_content(); ?>

        </div>

      </div>

  </article>

<?php
  }
} else {
?>
  <section class="error">
    <article class="u-alert"><?php _e('Sorry, nothing matched your criteria :{'); ?></article>
  </section>
<?php
} ?>

<!-- end main-content -->

</main>

<?php
get_footer();
?>