<?php
/**
 * The template for displaying all single pages.
 *
 * This is the template that displays all pages by default.
 *
 * @package EddisTheme
 */

// Incluye el encabezado de tu tema.
get_header();
?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">

        <?php
        // Comienza el bucle de WordPress para mostrar el contenido de la página.
        if ( have_posts() ) :
            while ( have_posts() ) : the_post();
        ?>

            <section id="productos" class="container-fluid bg-highlight-dark position-relative">
                <div class="row bg-light py-5">
                    <div class="container">
                        <div id="content" role="main">
                            <article role="article" id="post_<?php the_ID(); ?>" <?php post_class(); ?>>
                                <header class="mb-5 text-center">
                                    <h1 class="display-3 text-highlight">
                                        <?php the_title(); ?>
                                    </h1>
                                </header>
                                <section>
                                    <?php the_content(); // Muestra el contenido principal de la página. ?>
                                    <?php wp_link_pages(); // Paginar si la página tiene un paginado. ?>
                                </section>
                            </article>
                        </div>
                    </div>
                </div>
            </section>

        <?php
            endwhile; // Fin del bucle.
        else :
            // Si no se encuentra contenido (ej. página 404).
            get_template_part( '404' );
        endif;
        ?>

    </main>
</div>

<?php
// Incluye el pie de página de tu tema.
get_footer();
?>