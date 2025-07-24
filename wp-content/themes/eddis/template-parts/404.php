<?php
// Incluye el encabezado de tu tema.
get_header();
?>

<section class="portada" style="background-image: url(<?php echo get_template_directory_uri(); ?>/assets/images/portada-generica.jpg)">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <?php if ( function_exists('yoast_breadcrumb') ) : ?>
                    <div class="custom-breadcrumbs">
                        <div class="container">
                            <div class="row">
                                <?php yoast_breadcrumb( '<nav class="text-nowrap bd-highlight" id="breadcrumbs">','</nav>' );?>
                            </div>
                        </div>
                    </div>
                <?php endif ?>
                <h1 class="global-title">
                    404 Página <strong>no encontrada</strong>
                </h1>
            </div>
        </div>
    </div>
</section>

<section class="search-page">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="error-code">404</h2>
                <h1 class="global-title">Página no encontrada</h1>
                <p>Parece que no hemos encontrado lo que buscas.</p>
                <a href="<?php echo home_url(); ?>" class="btn btn-primary">Regresar al inicio</a>
            </div>
        </div>
    </div>
</section>

<?php
// Incluye el pie de página de tu tema.
get_footer();
?>