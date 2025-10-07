<?php
/*
Template Name: Página de Sedes
*/
get_header();
?>

<div class="container my-5">
    <h1>Nuestras Sedes</h1>
    <?php get_template_part('template-parts/branches', null, [
            'classes' => ['bottom_spacer_120']
        ]); ?>
</div>

<!-- Contenido de la página -->
<?php get_footer(); ?>

