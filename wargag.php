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

$content = $Wargag->getContent();


$Wargag->putContent('picture');

if (isset($_GET['access_token']) && isset($_GET['nickname']) && isset($_GET['account_id'])) {
    $Wargag::authWG($_GET['access_token'], $_GET['nickname'], $_GET['account_id']);
}

//if(!isset($_SESSION['User'])){
?>
<form action="https://api.worldoftanks.ru/wot/auth/login/" method="POST">

    <input type="hidden" name="redirect_uri" value="http://wp.local/wargag/">
    <input type="hidden" name="application_id" value="a1a5502d2265a9846fc71927679f46f7">

    <div class="l-big-orange-button l-big-orange-button__mt">
        <span class="b-big-orange-button">
            <input type="submit" class="b-big-orange-button_right" value="Авторизация">
        </span>
    </div>


</form>
<?php
//}
$i = 0;
foreach ($content as $post) {
    if ($i > 1)
        break;
    echo '<img src="' . $post->media_url . '"><br>';
    echo '<h2>' . $post->description . '</h2><h1>' . $post->rating . '</h1> <br>';
    $i++;
}



get_footer();
?>