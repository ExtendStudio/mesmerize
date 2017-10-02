<?php
/**
 * The template for displaying the "footer simple"
 *
 */
?>
<div <?php echo mesmerize_footer_background('footer-simple') ?>>
    <div class="gridContainer">
        <div class="row bottom-xs">
            <div class="col-xs-12">
                <p class="footer-copyright text-center middle-xs">
					<?php echo mesmerize_get_footer_copyright(); ?>
                </p>
            </div>
        </div>
    </div>
    <div id="footer-overlay"></div>
</div>
<?php wp_footer(); ?>
</body>
</html>
