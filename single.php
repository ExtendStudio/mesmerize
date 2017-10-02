<?php mesmerize_get_header(); ?>
    <div class="content post-page">
        <div class="gridContainer">
            <div class="row">
                <div class=" <?php echo( is_active_sidebar( 'sidebar-1' ) ? 'col-sm-9' : 'col-sm-12' ); ?>">
                    <div class="post-item">
						<?php
						if ( have_posts() ):
							while ( have_posts() ):
								the_post();
								get_template_part( 'template-parts/content', 'single' );
							endwhile;
						else :
							get_template_part( 'template-parts/content', 'none' );
						endif;
						?>
                    </div>
                </div>
				<?php get_sidebar(); ?>
            </div>
        </div>

    </div>
<?php mesmerize_get_footer(); ?>