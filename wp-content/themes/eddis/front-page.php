<?php
$front_page                = edd_widget_options('front_page');
$slider_hero_slides        = [];
$featured_carousel_options = [];

if ($front_page && !empty($front_page['home_widgets'])) {
    foreach ($front_page['home_widgets'] as $widget) {
        if ($widget['_type'] === 'slider_hero' && !empty($widget['enable_slider_hero'])) {
            $slider_hero_slides = $widget['slider_hero_slides'] ?? [];
        }

        if ($widget['_type'] === 'featured_carousel' && !empty($widget['enable_featured_carousel'])) {
            print_r($widget);
            $featured_carousel_options['title'] = $widget['featured_carousel_title'] ?? '';
            $featured_carousel_options['subtitle'] = $widget['featured_carousel_subtitle'] ?? '';
            $featured_carousel_options['button_text'] = $widget['featured_carousel_button_text'] ?? '';
            $featured_carousel_options['button_link'] = $widget['featured_carousel_button_link'] ?? '';
            $featured_carousel_options['category_id'] = $widget['featured_carousel_category_id'] ?? '';
        }
    }
}

get_header(); ?>
<main>
    <?php 
    if (!empty($slider_hero_slides)) {
        get_template_part('template-parts/slider-hero', null, [
            'slides' => $slider_hero_slides
        ]);
    }

    if (!empty($featured_carousel_options)) {
        get_template_part('template-parts/featured-carousel', null, [
            'options' => $featured_carousel_options
        ]);
    }
    get_template_part('template-parts/sedes'); ?>
</main>
<?php get_footer(); ?>

