<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	
    <!--Back To Top-->
    <a class="ir-arriba"  href="#" title="Volver arriba">
        <span class="fa-stack">
            <i class="fa fa-arrow-up fa-stack-1x"></i>
        </span>
    </a>
    <!-------------------------->
    <div class="bar-menu-utc">
        <div class="container">
            <div class="d-none d-lg-block d-lx-block d-sm-none d-md-none">
                <div class="row">
                <?php
                // SOCIAL NETWORKS
                $social_networks = carbon_get_theme_option('social_networks');
                if (!empty($social_networks)) : ?>
                    <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12 col-12">
                        <div class="text-lg-start text-md-center text-sm-center text-center seguinos-header">
                            Seguinos:
                                <?php foreach ($social_networks as $network) : ?>
                                    <a class="social-icon" target="_blank" href="<?php echo esc_url($network['link']); ?>" class="m-1">
                                        <?php echo $network['icon']; // Asume que el icono es HTML o una clase CSS ?>
                                    </a>
                                <?php endforeach; ?>
                        </div>		
                    </div>
                <?php endif; ?>
                <?php
                // PHONE NUMBER
                $phone_active = carbon_get_theme_option('contact_phone_active');
                $phone_number = carbon_get_theme_option('contact_phone');

                if ($phone_active && !empty($phone_number)) : ?>
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 col-12">
                        <a href="tel:+<?php echo esc_attr($phone_number); ?>" class="phone-number">
                            <i class="fas fa-phone mr-1"></i> 
                            <b><?php echo esc_html($phone_number); ?></b>
                        </a>
                    </div>
                <?php endif; ?>
                    <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 col-12">
                        <p class="text-lg-right text-md-end text-sm-center text-center">
                        <a href="javascript:mostrar();" class="m-3"><i class="fas fa-search"></i> Buscar</a>
                        <a target="_blank" href="https://eddis.educativa.org/acceso.cgi?id_curso=" class="text-white btn-header-top">Campus virtual <i class="fas fa-chevron-right ml-2"></i></a>
                        </p>		
                    </div>
                </div>
            </div>

            <div class="row d-lg-none d-xl-none d-sm-none d-md-none d-flex flex-direction-row align-items-center justify-content-center">
                <?php if ($phone_active && !empty($phone_number)) : ?>
                    <a href="tel:+<?php echo esc_attr($phone_number); ?>"><i class="fas fa-phone mr-1"></i> !Hablemos!</a>
                <?php endif; ?>
                    <a href="javascript:mostrar();" class="m-3"><i class="fas fa-search"></i> Buscar</a>
                    <a target="_blank" href="https://eddis.educativa.org/acceso.cgi?id_curso=" class="text-white">Campus virtual <i class="fas fa-chevron-right ml-2"></i></a>
            </div>

        </div>
    </div>
    
    <!-- BEGIN NAVIGATION MENU -->
    <nav class="navbar navbar-expand-lg navbar-light navbarlogo">
        <div class="container">
            <a href="<?php bloginfo('url');?>">
                <img width="140" class="img-fluid" src="<?php bloginfo('template_directory');?>/assets/img/logo_eddis_normal.svg">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbarprincipal navbar-nav ms-auto">
                    <?php get_template_part('template-parts/menu'); ?>
                </ul>
            </div>
        </div>
    </nav>
    <!-- END NAVIGATION MENU -->


    <!--BEGIN SEARCH HEADER-->
    <div id="flotante" style="visibility: hidden; opacity: 0">
        <div id="close"><a href="javascript:cerrar();"><i class="fa fa-times" aria-hidden="true"></i></a></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 col-md-8 offset-md-2 col-sm-12 col-xs-12 col-12">
                    <div class="box-search-home">					
                        <div class="search-form-nav valign-wrapper">
                            <form role="search" method="get" class="search-form" action="<?php echo home_url( '/' ); ?>">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-12 col-lg-8 col-md-8 col-sm-12 col-xs-12">
                                            <input type="search" class="search-field" placeholder="<?php echo esc_attr_x( 'Buscar…', 'placeholder' ) ?>" value="<?php echo get_search_query() ?>" name="busqueda" title="<?php echo esc_attr_x( 'Buscar...', 'label' ) ?>" />
                                            <input type="hidden" name="post_type" value="cursos, sedes" />
                                        </div>
                                        <div class="col-12 col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                            <input type="submit" class="btn btn-primary" value="<?php echo esc_attr_x( 'Buscar', 'submit button' ) ?>" />
                                        </div>
                                    </div>
                                </div>
                            </form>       
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--END SEARCH HEADER-->