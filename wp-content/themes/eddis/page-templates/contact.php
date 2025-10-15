<?php
/*
Template Name: Página de Contacto
*/

// El "Nombre de Identificación" que se definio en el gestor de formularios
$form_name = 'form-contact';
$form      = edd_get_eddis_form_data($form_name);

get_header();
?>
    <section class="portada" style="background-image: url(<?php bloginfo('template_directory');?>/assets/img/bg-portada-contacto.jpg)">
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
                    <?php
                    // DATOS DE CONTACTO
                    $phone_active  = carbon_get_theme_option('contact_phone_active');
                    $phone_number  = carbon_get_theme_option('contact_phone');
                    $wsapp_active  = carbon_get_theme_option('contact_whatsapp_active');
                    $wsapp_number  = carbon_get_theme_option('contact_whatsapp');
                    $email_active  = carbon_get_theme_option('contact_email_active');
                    $email_address = carbon_get_theme_option('contact_email');

                    if (!empty($phone_active) && !empty($phone_number)) : ?>
                        <a target="_blank" href="tel:+549<?php echo $phone_number;?>" class="global-subtitle d-block mb-3"><i class="fas fa-phone"></i> <?php echo $phone_number;?></a>
                    <?php endif;

                    if (!empty($wsapp_active) && !empty($wsapp_number)) : ?>
                        <a target="_blank" href="https://wa.me/549<?php echo $wsapp_number;?>" class="global-subtitle d-block mb-3"><i class="fab fa-whatsapp"></i> <?php echo $wsapp_number;?></a>
                    <?php endif;

                    if (!empty($email_active) && !empty($email_address)) : ?>
                        <a target="_blank" href="mailto:<?php echo $email_address;?>" class="global-subtitle d-block mb-3"><i class="far fa-envelope"></i> <?php echo $email_address;?></a>
                    <?php endif;?>
                </div>
                
            </div>
        </div>
    </section>
    <?php endif; // Fin del bloque condicional para el formulario ?>

    <section class="banner">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="banner-content" style="background-image: url(<?php bloginfo('template_directory');?>/assets/img/bg-banner.jpg)">
                        <div class="row">
                            <div class="col-5">
                                <h2 class="global-title text-white"><strong>Seguinos!</strong></h2>
                                <?php 
                                // REDES SOCIALES
                                $social_networks = carbon_get_theme_option('social_networks');
                                if (!empty($social_networks)) : ?>
                                    <?php foreach ($social_networks as $network) : ?>
                                        <a class="social-icon transition-280"  target="_blank" href="<?php echo esc_url($network['link']); ?>" class="m-1">
                                            <i class="<?php echo esc_attr($network['icon']); ?>"></i>
                                        </a>
                                    <?php endforeach; ?>
                                <?php endif;?>
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

<?php get_footer(); ?>

