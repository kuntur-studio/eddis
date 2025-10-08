<?php
/*
Template Name: Página de Contacto
*/

// El "Nombre de Identificación" que se definio en el gestor de formularios
$form_name = 'form-contact';
$form      = edd_get_eddis_form_data($form_name);

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

    <?php if (!empty($form['active']) && !empty($form['code'])): ?>
    <section class="contacto">
        <div class="container">
            <div class="row">
                <div class="col-xl-8 col-lg-8 col-sm-6 col-md-6 col-xs-12 col-12">
                    <h2 class="global-title"><strong>Formulario</strong></h2>
                    <p class="global-subtitle">Completá el siguiente formulario para obtener más información.</p>
					<?php echo $form['code']; // Renderiza el código del formulario externo ?>
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

    <?php get_template_part('template-parts/branches', null, [
            'classes' => ['bottom_spacer_120']
          ]); ?>

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
<?php get_footer(); ?>

