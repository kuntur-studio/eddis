<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Sitio Web</title>
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
                    <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12 col-12">
                        <div class="text-lg-left text-md-center text-sm-center text-center seguinos-header">
                            Seguinos:
                            <?php if( have_rows('redes_sociales', 'option') ):?>
                                <?php while ( have_rows('redes_sociales', 'option') ) : the_row();?>
                                    <a class="social-icon" target="_blank" href="<?php the_sub_field('link', 'option');?>" class="m-1"><?php the_sub_field('icon', 'option');?></a>
                                <?php endwhile;?>
                            <?php endif;?>
                        </div>		
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 col-12">
                        <a href="tel:+<?php the_field('telefono', 'option');?>" class="phone-number"><i class="fas fa-phone mr-1"></i> <b><?php the_field('telefono', 'option');?></b></a>
                    </div>
                    <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 col-12">
                        <p class="text-lg-right text-md-right text-sm-center text-center">
                        <a href="javascript:mostrar();" class="m-3"><i class="fas fa-search"></i> Buscar</a>
                        <a target="_blank" href="https://eddis.educativa.org/acceso.cgi?id_curso=" class="text-white btn-header-top">Campus virtual <i class="fas fa-chevron-right ml-2"></i></a>
                        </p>		
                    </div>
                </div>
            </div>

            <div class="row d-lg-none d-xl-none d-sm-none d-md-none d-flex flex-direction-row align-items-center justify-content-center">
                    <a href="tel:+<?php the_field('telefono', 'option');?>"><i class="fas fa-phone mr-1"></i> !Hablemos!</a>
                    <a href="javascript:mostrar();" class="m-3"><i class="fas fa-search"></i> Buscar</a>
                    <a target="_blank" href="https://eddis.educativa.org/acceso.cgi?id_curso=" class="text-white">Campus virtual <i class="fas fa-chevron-right ml-2"></i></a>
            </div>

        </div>
    </div>

    <nav class="navbar navbar-expand-lg navbar-light navbarlogo">
        <div class="container">
            <a href="<?php bloginfo('url');?>">
                <img width="140" class="img-fluid" src="<?php bloginfo('template_directory');?>/assets/images/logo_eddis_normal.svg">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbarprincipal navbar-nav ml-auto">
                    <?php include 'navigation-menu.php'; ?>
                </ul>
            </div>
        </div>
    </nav>



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