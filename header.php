<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<div class="header-top">
	<?php mesmerize_print_header_top_bar(); ?>
	<?php mesmerize_get_navigation(); ?>
</div>

<div id="page" class="site">
    <div class="header-wrapper">
        <div <?php echo mesmerize_background() ?>>
            <?php do_action( 'mesmerize_before_header_background' ); ?>
			<?php mesmerize_print_video_container(); ?>

            <div class="inner-header-description gridContainer">
                <div class="row header-description-row">
					<?php mesmerize_print_inner_pages_header_content(); ?>
                </div>
            </div>
			<?php
			mesmerize_print_header_separator( true );
			?>
        </div>
    </div>