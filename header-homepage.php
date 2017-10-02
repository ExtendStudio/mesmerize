<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>


<div class="header-top homepage">
	<?php mesmerize_print_header_top_bar(); ?>
	<?php mesmerize_get_navigation(); ?>
</div>


<div id="page" class="site">
    <div class="header-wrapper">
        <div <?php echo mesmerize_background() ?>>
            <?php do_action( 'mesmerize_before_header_background' ); ?>
			<?php mesmerize_print_video_container(); ?>
			<?php mesmerize_print_front_page_header_content(); ?>
        </div>
		<?php
		mesmerize_print_header_separator();
		do_action( 'mesmerize_after_header_content' );
		?>
    </div>
