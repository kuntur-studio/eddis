<section class="mb-5" id="logosCarousel">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="global-title text-center"><?php the_sub_field('titulo');?></h2>
                <h5 class="global-subtitle text-center"><?php the_sub_field('descripcion');?></h5>
                <?php if( have_rows('logos') ):?>
                    <div class="owl-carousel owl-theme" id="logosCarouselSlider">
                        <?php while ( have_rows('logos') ) : the_row();?>
                        <div class="item">
                            <?php if(get_sub_field('link_boton')):?>
                            <a target="_blank" href="<?php the_sub_field('link_boton');?>">
                                <img class="img-fluid" src="<?php the_sub_field('logo');?>" alt="">
                            </a>
                            <?php else : ?>
                                <img class="img-fluid" src="<?php the_sub_field('logo');?>" alt="">
                            <?php endif;?>
                        </div>
                        <?php endwhile;?>
                    </div>
                <?php endif;?>
                <?php if(get_sub_field('link_boton')):?>
                <div class="text-center mt-3">
                    <a class="btn btn-primary" href="<?php the_sub_field('link_boton')?>"><?php the_sub_field('texto_boton')?></a>
                </div>
                <?php endif;?>
            </div>
        </div>
    </div>
</section>