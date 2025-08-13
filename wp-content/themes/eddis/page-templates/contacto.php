<?php
/*
Template Name: Página de Contacto
*/

// --- Lógica para obtener el formulario de CPT 'eddis_form' ---
$form_name = 'form-contacto'; // El Nombre de Identificación que se definio en el gestor de formularios

$form_query_args = array(
    'post_type'      => 'eddis_form',
    'posts_per_page' => 1,
    'post_status'    => 'publish',
    'fields'         => 'ids',
    'meta_query'     => array(
        array(
            'key'     => 'eddis_form_name', // Busca por la meta key 'eddis_form_name'
            'value'   => $form_name, // Con este valor
            'compare' => '=',
        ),
    ),
);

$form_posts = get_posts( $form_query_args );
$form_id = ! empty( $form_posts ) ? $form_posts[0] : 0;

$is_form_active = false;
$form_code = '';

if ( $form_id ) {
    $is_form_active_value = carbon_get_post_meta( $form_id, 'eddis_form_active' );
    $is_form_active = carbon_get_post_meta( $form_id, 'eddis_form_active' );
    $form_code = carbon_get_post_meta( $form_id, 'eddis_form_code' );
}
// -------------------------------------------------------------

get_header();
?>
    <section class="portada" style="background-image: url(<?php bloginfo('template_directory');?>/assets/images/bg-portada-contacto.jpg)">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <!--BEGIN SECTION BREADCRUMBS -->
                    <?php if ( function_exists('yoast_breadcrumb') ) : ?>
                        <div class="custom-breadcrumbs">
                            <div class="container">
                                <div class="row">
                                    <?php yoast_breadcrumb( '<nav class="text-nowrap bd-highlight" id="breadcrumbs">','</nav>' );?>
                                </div>
                            </div>
                        </div>
                    <?php endif ?>
                    <!--END SECTION BREADCRUMBS -->
                    <h1 class="global-title">
                        <strong>Contacto</strong>
                    </h1>
                </div>
            </div>
        </div>
    </section>

    <?php if ($is_form_active && !empty($form_code)): ?>
    <section class="contacto">
        <div class="container">
            <div class="row">
                <div class="col-xl-8 col-lg-8 col-sm-6 col-md-6 col-xs-12 col-12">
                    <h2 class="global-title"><strong>Formulario</strong></h2>
                    <p class="global-subtitle">Completá el siguiente formulario para obtener más información.</p>
					<?php echo $form_code; // Renderiza el código del formulario externo ?>
                </div>
                <div class="col-xl-4 col-lg-4 col-sm-6 col-md-6 col-xs-12 col-12">
                    <h2 class="global-title mb-5"><strong>Contacto</strong></h2>
                    <?php /*if( have_rows('datos_de_contacto') ):?>
                        <?php while ( have_rows('datos_de_contacto') ) : the_row();?>
                            <?php if(get_sub_field('link')):?>
                                <a target="_blank" href="<?php the_sub_field('link');?>" class="global-subtitle d-block mb-3"><?php the_sub_field('icono');?> <?php the_sub_field('descripcion');?></a>
                            <?php else:?>
                                <p class="global-subtitle"><?php the_sub_field('icono');?> <?php the_sub_field('descripcion');?></p>
                            <?php endif;?>
                        <?php endwhile;?>
                    <?php endif;*/?>
                </div>
                
            </div>
        </div>
    </section>
    <?php endif; // Fin del bloque condicional para el formulario ?>

    <section class="banner">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="banner-content" style="background-image: url(<?php bloginfo('template_directory');?>/assets/images/bg-banner.jpg)">
                        <div class="row">
                            <div class="col-5">
                                <h2 class="global-title text-white"><strong>Seguinos!</strong></h2>
                                <?php /*if( have_rows('redes_sociales', 'option') ):?>
                                    <?php while ( have_rows('redes_sociales', 'option') ) : the_row();?>
                                        <a class="social-icon transition-280"  target="_blank" href="<?php the_sub_field('link', 'option');?>" class="m-1"><?php the_sub_field('icon', 'option');?></a>
                                    <?php endwhile;?>
                                <?php endif;*/?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php get_template_part('template-parts/sedes'); ?>

    <section class="banner">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="banner-content" style="background-image: url(<?php bloginfo('template_directory');?>/assets/images/bg-banner.jpg)">
                        <div class="row">
                            <div class="col-5">
                                <h2 class="global-title text-white"><strong>Seguinos!</strong></h2>
                                <?php if( have_rows('redes_sociales', 'option') ):?>
                                    <?php while ( have_rows('redes_sociales', 'option') ) : the_row();?>
                                        <a class="social-icon transition-280"  target="_blank" href="<?php the_sub_field('link', 'option');?>" class="m-1"><?php the_sub_field('icon', 'option');?></a>
                                    <?php endwhile;?>
                                <?php endif;?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php get_footer(); ?>

