<div <?php echo mesmerize_footer_background('footer') ?>>
    <div class="row_201">
        <div class="column_209 gridContainer">
            <div class="row_202">
                <div class="column_210">
                    <div >
                        <?php
                            if (!is_active_sidebar('first_box_widgets') && is_customize_preview()) {
                                echo "<div>".__("Go to widgets section to add a widget here.", 'mesmerize')."</div>";
                            } else {
                                dynamic_sidebar('first_box_widgets');
                            }
                        ?>
                    </div>
                </div>
                <div class="column_210">
                    <div  >
                        <?php
                            if (!is_active_sidebar('second_box_widgets') && is_customize_preview()) {
                                echo "<div>".__("Go to widgets section to add a widget here.", 'mesmerize')."</div>";
                            } else {
                                dynamic_sidebar('second_box_widgets');
                            }
                        ?>
                    </div>
                </div>
                <div class="column_210">
                    <div >
                        <?php
                            if (!is_active_sidebar('third_box_widgets') && is_customize_preview()) {
                                echo "<div>".__("Go to widgets section to add a widget here.", 'mesmerize')."</div>";
                            } else {
                                dynamic_sidebar('third_box_widgets');
                            }
                            ?>
                    </div>
                </div>
                <div  class="footer-column-colored">
                    <div class="footer-logo">
                        <?php mesmerize_print_logo(true); ?>
                    </div>
                    <p><?php echo mesmerize_get_footer_copyright(); ?></p>
                    <?php mesmerize_print_area_social_icons('footer', 'content', 'row_205', 5);?>
                </div>
            </div>
        </div>
   </div>
   <div id="footer-overlay"></div>
   </div>
<?php wp_footer();?>
    </body>
</html>
