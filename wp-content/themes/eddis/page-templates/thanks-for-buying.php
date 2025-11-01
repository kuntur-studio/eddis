<?php
/*
Template Name: Página de Agradecimiento
*/


get_header();

// Obtengo parámetros extra del widget
$widget_options = edd_widget_options('branches_widget');

$normalized_options = [
    'banner_lg'   => $widget_options['thanks_banner_lg'],
    'banner_md'   => $widget_options['thanks_banner_md'],
    'banner_sm'   => $widget_options['thanks_banner_sm'],
];

if (!empty($widget_options)) {
    get_template_part('template-parts/responsive-banner', null, [
        'options' => $normalized_options,
        'classes' => ['mb-5']
    ]);
}

?>
<?php get_footer(); ?>