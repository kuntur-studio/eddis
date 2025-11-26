<?php
/**
 * The template for displaying Search Results pages
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */
get_header(); ?>

<section class="portada" style="background-image: url(<?php bloginfo('template_directory');?>/assets/img/portada-generica.jpg)">
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
                    <h1 class="global-title"><?php printf('Resultados de búsqueda para: %s', get_search_query()); ?></h1>
                </div>
            </div>
        </div>
    </section>

<section class="search-page">
    <div class="container">
        <div class="row">
            <div class="col-12">

                <?php if ( have_posts() ) : ?>
                    <div class="row">
                        <?php while (have_posts()): the_post();?>
                            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <?php get_template_part('template-parts/content-card-search');?>
                            </div>
                        <?php endwhile;?>
                    </div>
                    <?php else :?>
                        <h1 class="global-title">Ningún resultado</h1>
                            <p>Parece que no hemos encontrado lo que buscas. Intenta con otra palabra.</p>
                    <?php endif; ?>
            </div>
        </div>
    </div>
</section>
<?php get_footer();?>