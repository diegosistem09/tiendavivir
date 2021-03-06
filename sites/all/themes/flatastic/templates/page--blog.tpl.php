<?php
global $theme_root;
$curr_uri = request_uri();
$array_curr_uri = explode('/', $curr_uri);
$data = arg(0);
foreach($array_curr_uri as $k => $v){
    if($v == ''){
        unset($array_curr_uri[$k]);
    }
}
array_push($array_curr_uri, $data);

$arrayTypeSettings = array(
    'page_wide_layout', 'page_boxed_layout',
    'header_1', 'header_2', 'header_3', 'header_4','header_5',
    'footer_1', 'footer_2', 'footer_3', 'footer_4', 'footer_5', 'footer_6'
);

$count = 1;
foreach ($arrayTypeSettings as $type) {
    $var1 = 'page_style' . $count;
    $var2 = 'arrayPageStyle' . $count;
    $var3 = 'getPageStyle' . $count;

    $$var1 = theme_get_setting($type);
    $$var1 = str_replace(" ", "", $$var1);
    $$var2 = explode(',', $$var1);
    $count++;

    $$var3 = array_intersect($$var2, $array_curr_uri);
}
$is_page_header = false;
$is_page_footer = false;
for ($i = 3; $i <= 7; $i++) {
    $header_page = 'getPageStyle' . $i;
    if (count($$header_page) > 0) {
        $header_option_page = 'header_' . ($i - 2);
        $is_page_header = true;
        break;
    }
}
for ($i = 8; $i <= 13; $i++) {
    $footer_page = 'getPageStyle' . $i;
    if (count($$footer_page) > 0) {
        $footer_option_page = 'footer_' . ($i - 7);
        $is_page_footer = true;
        break;
    }
}
?>
<?php
    if(count($getPageStyle1)){
        $layout_option = 'wide_layout'; 
    } elseif (count($getPageStyle2)) {
        $layout_option = 'boxed_layout'; 
    } else {
if (theme_get_setting('layout_option') == 'boxed') {
    $layout_option = 'boxed_layout';
} else {
    $layout_option = 'wide_layout';
}
    }    
?>

<!--boxed layout-->
<div class="<?php echo $layout_option; ?> relative">
    <!--[if (lt IE 9) | IE 9]>
            <div style="background:#fff;padding:8px 0 10px;">
            <div class="container" style="width:1170px;"><div class="row wrapper"><div class="clearfix" style="padding:9px 0 0;float:left;width:83%;"><i class="fa fa-exclamation-triangle scheme_color f_left m_right_10" style="font-size:25px;color:#e74c3c;"></i><b style="color:#e74c3c;">Attention! This page may not display correctly.</b> <b>You are using an outdated version of Internet Explorer. For a faster, safer browsing experience.</b></div><div class="t_align_r" style="float:left;width:16%;"><a href="http://windows.microsoft.com/en-US/internet-explorer/products/ie/home?ocid=ie6_countdown_bannercode" class="button_type_4 r_corners bg_scheme_color color_light d_inline_b t_align_c" target="_blank" style="margin-bottom:2px;">Update Now!</a></div></div></div></div>
    <![endif]-->

    <!--markup header-->
    <?php
    if(isset($_GET['header'])){
        $header_option = $_GET['header'];
    } elseif($is_page_header) {
        $header_option = $header_option_page;
    } else {
        $header_option = theme_get_setting('header_option');
    }
    switch($header_option):
        case 'header_1':
            require_once("includes/header_1.inc");
            break;
        case 'header_2':
            require_once("includes/header_2.inc");
            break;
        case 'header_3':
            require_once("includes/header_3.inc");
            break;
        case 'header_4':
            require_once("includes/header_4.inc");
            break;
        case 'header_5':
            require_once("includes/header_5.inc");
            break;
        default;
            break;
    endswitch;

    ?>

    <!--breadcrumbs-->
    <?php if (theme_get_setting('breadcrumbs') == 1): ?>
        <?php if ($breadcrumb): ?>
            <div class="breadcrumbs">
                <div class="container">
                    <?php print $breadcrumb; ?>
                </div>
            </div>
        <?php endif; ?>
    <?php endif; ?>
    
    <!-- Message -->
    <div class="message">
        <div class="container">
            <?php print $messages;  ?>
        </div>
    </div>

    <!--content-->
    <div class="page_content_offset">
        <div class="container">
            <div class="row clearfix">
                <!--left content column-->
                <section class="col-lg-9 col-md-9 col-sm-9">
                    <?php if (isset($page['features_blog'])): ?>
                        <?php print render($page['features_blog']); ?>
                    <?php endif; ?>
					<?php if ($tabs = render($tabs)): ?>
                        <div class="main-tabs">
                            <?php print render($tabs); ?>
                        </div>
                    <?php endif; ?>
                    <?php print render($title_prefix); ?>

                    <?php if($page['content']):?>
						<?php print render($page['content']);?>
					<?php endif;?>
                    <?php print render($title_suffix); ?>
                </section>
                <!--right column-->
                <aside class="col-lg-3 col-md-3 col-sm-3">
                    <?php if ($page['right_sidebar']) : ?>
                        <?php print render($page['right_sidebar']); ?>
                    <?php endif; ?>
                </aside>
            </div>
        </div>
    </div>

    <!--markup footer-->
    <?php
    if(isset($_GET['footer'])){
        $footer_option = $_GET['footer'];
    } elseif($is_page_footer) {
        $footer_option = $footer_option_page;
    } else {
        $footer_option = theme_get_setting('footer_option');
    }
    switch($footer_option):
        case 'footer_1':
            require_once("includes/footer_1.inc");
            break;
        case 'footer_2':
            require_once("includes/footer_2.inc");
            break;
        case 'footer_3':
            require_once("includes/footer_3.inc");
            break;
        case 'footer_4':
            require_once("includes/footer_4.inc");
            break;
        case 'footer_5':
            require_once("includes/footer_5.inc");
            break;
        case 'footer_6':
            require_once("includes/footer_6.inc");
            break;
        default;
            break;
    endswitch;
    ?>
</div>
<?php
if (theme_get_setting('social_widget') == 1):
    if ($page['social_widget']) :
        print render($page['social_widget']);
    endif;
endif;
?>
