    <footer class="page-footer">
        <div class="container prefooter">
            <div class="row">
                <div class="col-md-12 col-xs-12">
                    <a href="<?php bloginfo('url');?>">
                        <img width="140" class="logo img-fluid" src="<?php bloginfo('template_directory');?>/assets/images/logo_eddis_invertido.svg">
                    </a>
                </div>
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 text-lg-left text-md-center text-sm-center text-center menufooter">
                            <h3>Menú</h3>
                            <ul class="menu ">
                            <?php /*if( have_rows('menu_footer','option') ):?>
                                <?php while ( have_rows('menu_footer','option') ) : the_row();?>
                                    <li><a href="<?php the_sub_field('link','option');?>"><?php the_sub_field('titulo');?></a></li>
                                <?php endwhile;?>
                            <?php endif;*/?>
                            </ul>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 text-lg-left text-md-center text-sm-center text-center">
                            <h3>Redes</h3>
                            <?php /*if( have_rows('redes_sociales', 'option') ):?>
                                <?php while ( have_rows('redes_sociales', 'option') ) : the_row();?>
                                    <a class="social-icon transition-280"  target="_blank" href="<?php the_sub_field('link', 'option');?>" class="m-1"><?php the_sub_field('icon', 'option');?></a>
                                <?php endwhile;?>
                            <?php endif;*/?>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 text-lg-left text-md-center text-sm-center text-center">
                            <h3>Contacto</h3>
                            <h2><a class="tel-footer" href="tel:+<?php /*the_field('telefono', 'option');*/?>"><i class="fas fa-phone"></i> <?php /*the_field('telefono', 'option');*/?></a></h2>
                            <ul class="menu ">
                            <?php /*if( have_rows('menu_footer_contacto','option') ):?>
                                <?php while ( have_rows('menu_footer_contacto','option') ) : the_row();?>
                                    <li><a href="<?php the_sub_field('link','option');?>"><?php the_sub_field('titulo');?></a></li>
                                <?php endwhile;?>
                            <?php endif;*/?>
                            </ul>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-lg-left text-md-center text-sm-center text-center mt-2 mb-2 sedecentralfooter">
                            <h3>Sede Central</h3>
                            <p><?php /*the_field('sede_central', 'option');*/?></p>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-lg-left text-md-center text-sm-center text-center mt-2 mb-2">
                        <p class="woocommerce-mini-cart__buttons buttons boton-de-arrepentimiento"><a href="https://www.eddis.edu.ar/arrepentimiento-de-compra/" class="btn btn-primary d-inline-block">Botón de arrepentimiento</a></p>
                        </div>
                    </div>
                </div>
                <!-- Acá iba el formulario del footer -->
            </div>
        </div>
    <div class="bar-copyright p-4 mt-5 copyright-footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <p class="text-lg-left text-sm-center text-center">© Copyright <?php echo date("Y");?> | <?php bloginfo('name');?> | Todos los derechos reservados</p>	
                </div>
            </div>
        </div>
    </div>
    </footer>
	<?php wp_footer(); ?>
</body>
</html>