<?php
/**
 * Obtengo los datos de todos los widgets usados en la página salvo el formulario y
 * el widget de sedes que utilizan otros mecanismos
 */
$front_page                = edd_widget_options('front_page');
$mode_banner               = edd_widget_options('mode_banner');

$slider_hero_slides        = [];
$featured_carousel_options = [];
$banner_one_options        = [];
$banner_two_options        = [];
$youtube_video_options     = [];

if ($front_page && !empty($front_page['home_widgets'])) {
    foreach ($front_page['home_widgets'] as $widget) {
        // Usa una condición genérica para verificar si el widget está habilitado
        if (!empty($widget['enable_' . $widget['_type']])) {
            switch ($widget['_type']) {
                case 'slider_hero':
                    $slider_hero_slides = $widget['slider_hero_slides'] ?? [];
                    break;
                case 'featured_carousel':
                    $featured_carousel_options = [
                        'title'       => $widget['featured_carousel_title'] ?? '',
                        'subtitle'    => $widget['featured_carousel_subtitle'] ?? '',
                        'button_text' => $widget['featured_carousel_button_text'] ?? '',
                        'button_link' => $widget['featured_carousel_button_link'] ?? '',
                        'category_id' => $widget['featured_carousel_category_id'] ?? '',
                    ];
                    break;
                case 'banner_one':
                case 'banner_two':
                    $type = $widget['_type'];
                    // Asigna a la variable dinámica correcta ($banner_one_options o $banner_two_options)
                    ${$type . '_options'} = [
                        'banner_lg'   => $widget[$type . '_lg'],
                        'banner_md'   => $widget[$type . '_md'],
                        'banner_sm'   => $widget[$type . '_sm'],
                        'enable_link' => $widget[$type . '_enable_link'],
                        'banner_link' => $widget[$type . '_link'],
                    ];
                    break;
                case 'youtube_video':
                    $youtube_video_options = [
                        'enable'      => $widget['enable_youtube_video'] ?? false,
                        'id'          => $widget['youtube_video_id'] ?? '',
                        'content'     => $widget['youtube_video_content'] ?? '',
                        'background_lg' => $widget['youtube_video_background_lg'] ?? '',
                        'background_md' => $widget['youtube_video_background_md'] ?? '',
                        'background_sm' => $widget['youtube_video_background_sm'] ?? '',
                    ];
                    break;
            }
        }
    }
}

// El "Nombre de Identificación" que se definio en el gestor de formularios
$form_name = 'form-home';
$form      = edd_get_eddis_form_data($form_name);

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

    if (!empty($form['active'])) { ?>
    <section class="container" id="formHomeContainer">
        <div class="row">
            <div class="col-12">
                <div class="external-form-content">
                    <?php echo $form['code']; // Renderiza el código del formulario externo ?>
                </div>
            </div>
        </div>
    </section>
<?php
    }

    if (!empty($banner_one_options)) {
        get_template_part('template-parts/responsive-banner', null, [
            'options' => $banner_one_options,
            'classes' => ['py-5']
        ]);
    }





    get_template_part('template-parts/sedes');






    if (!empty($banner_two_options)) {
        get_template_part('template-parts/responsive-banner', null, [
            'options' => $banner_two_options
        ]);
    }

    if (!empty($youtube_video_options['enable'])) {
        get_template_part('template-parts/youtube-video', null, [
            'options' => $youtube_video_options
        ]);
    }

    if ($mode_banner['enable_mode_banner_widget']) {
        get_template_part('template-parts/mode-banner', null, [
            'options' => $mode_banner
        ]);
    }

?>
</main>
<?php get_footer(); ?>