<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 */
?>
<div <?php echo mesmerize_footer_background('footer') ?>>
    <div class="gridContainer">
        <div class="row middle-xs footer-content-row">
            <div class="footer-content-col col-xs-12">
                <p class="footer-copyright">
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
