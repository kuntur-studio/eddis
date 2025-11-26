<?php
/**
 * Template Part: Tarjeta de Resultado de Búsqueda
 * * Propósito: Muestra un resultado individual (post, curso, sede) 
 * dentro de la página de resultados de búsqueda (search.php).
 * * Contiene el markup HTML básico para el enlace y el título.
 * Es llamado dentro del loop de WordPress en search.php.
 */
?>
<div class="card-search">
    <h3><?php the_title();?></h3>
    <a class="btn btn-primary" href="<?php the_permalink();?>">Ver más</a>
</div>