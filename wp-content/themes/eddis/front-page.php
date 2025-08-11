<?php
$front_page = edd_widget_options('front_page');
$slides = [];

if ($front_page && !empty($front_page['home_widgets'])) {
    foreach ($front_page['home_widgets'] as $widget) {
        if ($widget['_type'] === 'slider_hero' && !empty($widget['enable'])) {
            $slides = $widget['slides'] ?? [];
            break;
        }
    }
}

get_header(); ?>
<main>
    <?php 
    if (!empty($slides)) {
        get_template_part('template-parts/slider-hero', null, [
            'slides' => $slides
        ]);
    }   
    get_template_part('template-parts/sedes'); ?>
</main>
<?php get_footer(); ?>

