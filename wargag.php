<?php
global $SMTheme;

get_header();

get_template_part('theloop');

the_tags("<div class='tags'><span>" . $SMTheme->_('tags') . ":&nbsp;&nbsp;</span>", ", ", "</div>");

//	get_template_part('relatedposts');
//	comments_template();

get_template_part('navigation');

include_once get_template_directory() . '/WGApi/Wargag.php';

$Wargag = new Wargag();

$content = $Wargag->getContent('picture');
print_r($_GET);die();
?>
<form action="https://api.worldoftanks.ru/wot/auth/login/" method="POST">
    <!--<input type="hidden" name="method" value="post">-->
    <input type="hidden" name="redirect_uri" value="http://wp.local/wargag/">
    <input type="hidden" name="application_id" value="a1a5502d2265a9846fc71927679f46f7">
    <input type="submit" value="Авторизация">
</form>

<?php
$i = 0;
foreach ($content as $post) {
    if($i > 5)
        break;
    echo '<img src="' . $post->media_url . '"><br>';
    echo '<h2>' . $post->description . '</h2><h1>' . $post->rating . '</h1> <br>';
    $i++;
}

get_footer();
?>