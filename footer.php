<?php global $SMTheme; ?>

</div></div></div>

<?php
if ($SMTheme->get('social', 'showsocial')) {
    $SMTheme->block_social();
}
?>
<div id='back-footer-border'>
    <div class='footer-border'></div
</div>
<div id='content-bottom' class='container'></div>
<div id='footer'>
    <div class='container clearfix'>

        <?php if ($SMTheme->get("layout", "footerwidgets")) { ?>
            <div class='footer-widgets-container'><div class='footer-widgets'>
                    <div class='widgetf'>
                        <?php
                        if (!function_exists("dynamic_sidebar") || !dynamic_sidebar("footer_1")) {
                            ;
                        }
                        ?>
                    </div>

                    <div class='widgetf'>
                        <?php
                        if (!function_exists("dynamic_sidebar") || !dynamic_sidebar("footer_2")) {
                            ;
                        }
                        ?>
                    </div>

                    <div class='widgetf widgetf_last'>
                        <?php
                        if (!function_exists("dynamic_sidebar") || !dynamic_sidebar("footer_3")) {
                            ;
                        }
                        ?>
                    </div>
                </div></div>
        <?php } ?>

    </div>

    <div class='footer_txt'>
        <div class='container'>
            <div class='top_text'>
                <?php
                if ($SMTheme->get("layout", "footertext")) {
                    echo $SMTheme->get("layout", "footertext");
                } else {
                    ?>Copyright &copy; <?php echo date("Y"); ?>  <a href="<?php echo home_url(); ?>"><?php bloginfo("name"); ?></a><?php
                    echo (get_bloginfo('description')) ? ' - ' . get_bloginfo('description') : '';
                }
                ?>
            </div>
            <?php /*
              All links in the tag <div class='smthemes'> are attribution of the theme developers and should remain intact.
              It's protected by Creative Commons License (http://creativecommons.org/licenses/by/3.0/).
              Warning! Your site will not be able to work if these links are edited or deleted.
              You can buy this theme without footer links online at http://smthemes.com/buy/artdevil/
             */ ?>
            <div class='smthemes'>Designed by <a href='http://themesquirrel.com/themeblog/wordpress/portfolio-themes/' target='_blank'>ThemeSquirrel</a>, thanks to: <a href='http://wpdis.co' target='_blank'>WPdis.co</a>, <a href='http://www.havrix.ru' target='_blank'>http://www.havrix.ru</a> and <a href='http://corstone.biz' target='_blank'>http://corstone.biz</a></div>
        </div>
    </div>
    <?php wp_footer(); ?>
</div> <?php //footer   ?>
</div> <?php //all    ?>
<?php
echo $SMTheme->get("integration", "footercode");
?>
</body>
</html>