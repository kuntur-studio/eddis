<?php
/*
Template Name: Página de Sedes
*/
get_header();
?>

<section class="portada" style="background-image: url(<?php bloginfo('template_directory');?>/assets/img/bg-sedes-portada.jpg)">
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
                    Nuestras <strong>Sedes</strong>
                </h1>
            </div>
        </div>
    </div>
</section>

<div class="container my-5">
    <?php get_template_part('template-parts/branches', null, [
            'classes' => ['bottom_spacer_120']
        ]); ?>
</div>

<!-- Contenido de la página -->
<?php get_footer(); ?>

