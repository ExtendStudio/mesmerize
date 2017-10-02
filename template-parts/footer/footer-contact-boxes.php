<div <?php echo mesmerize_footer_background('footer') ?>>
    <div class="row_201">
        <div class="column_209 gridContainer">
            <div class="row_202">
                <div class="column_210 footer-box-1">
                    <i class="font-icon-18 fa <?php echo esc_attr(get_theme_mod('footer_box1_content_icon', 'fa-map-marker')); ?>"></i>
                    <p>
                        <?php echo wp_kses_post(get_theme_mod('footer_box1_content_text', 'San Francisco - Adress - 18 California Street 1100.')); ?>
                    </p>
                </div>
                <div class="column_210 footer-box-2">
                    <i class="font-icon-18 fa <?php echo esc_attr(get_theme_mod('footer_box2_content_icon', 'fa-envelope-o')); ?> "></i>
                    <p >
                        <?php echo wp_kses_post(get_theme_mod('footer_box2_content_text', 'hello@mycoolsite.com')); ?>
                    </p>
                </div>
                <div class="column_210 footer-box-3">
                    <i class="font-icon-18 fa <?php echo esc_attr(get_theme_mod('footer_box3_content_icon', 'fa-phone')); ?> "></i>
                    <p>
                        <?php echo wp_kses_post(get_theme_mod('footer_box3_content_text', '+1 (555) 345 234343')); ?>
                    </p>
                </div>
                <div class="footer-column-colored-1">
                    <div>
                        <?php mesmerize_print_area_social_icons('footer', 'content', 'row_205', 5);?>
                    </div>
                    <p class="paragraph10"><?php echo mesmerize_get_footer_copyright();?></p>
                </div>
            </div>
        </div>
   </div>
   <div id="footer-overlay"></div>
</div>
<?php wp_footer();?>
    </body>
</html>
