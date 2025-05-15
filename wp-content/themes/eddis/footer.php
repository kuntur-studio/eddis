<footer class="page-footer">
        <div class="container prefooter">
            <div class="row">
                <div class="col-md-12 col-xs-12">
                    <a href="<?php bloginfo('url');?>">
                        <img width="140" class="logo img-fluid" src="<?php bloginfo('template_directory');?>/assets/img/logo_eddis_invertido.svg">
                    </a>
                </div>
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 text-lg-left text-md-center text-sm-center text-center menufooter">
                            <h3>Menú</h3>
                            <ul class="menu ">
                            <?php
                            $footer_menu_items = carbon_get_theme_option('footer_menu_items');
                            if (!empty($footer_menu_items)) :
                                foreach ($footer_menu_items as $item) :
                                    $link = '';
                                    if ($item['is_internal']) {
                                        $link = get_permalink($item['page']);
                                    } else {
                                        $link = esc_url($item['external_url']);
                                    }
                                    ?>
                                    <li><a href="<?php echo $link; ?>"><?php echo esc_html($item['title']); ?></a></li>
                                <?php endforeach;
                            endif;
                            ?>
                            </ul>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 text-lg-left text-md-center text-sm-center text-center">
                            <h3>Redes</h3>
                            <?php
                            $social_networks = carbon_get_theme_option('social_networks');
                            if (!empty($social_networks)) :
                                foreach ($social_networks as $network) :
                                    ?>
                                    <a class="social-icon transition-280"  target="_blank" href="<?php echo esc_url($network['link']); ?>" class="m-1"><?php echo $network['icon']; ?></a>
                                <?php endforeach;
                            endif;
                            ?>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 text-lg-left text-md-center text-sm-center text-center">
                            <h3>Contacto</h3>
                            <h2>
                                <?php
                                $contact_phone_active = carbon_get_theme_option('contact_phone_active');
                                $contact_phone = carbon_get_theme_option('contact_phone');
                                if ($contact_phone_active && !empty($contact_phone)) :
                                    ?>
                                    <a class="tel-footer" href="tel:+<?php echo preg_replace('/[^0-9]/', '', $contact_phone); ?>"><i class="fas fa-phone"></i> <?php echo esc_html($contact_phone); ?></a>
                                    <?php
                                endif;
                                ?>
                            </h2>
                            <ul class="menu ">
                                <?php
                                $contact_email_active = carbon_get_theme_option('contact_email_active');
                                $contact_email = carbon_get_theme_option('contact_email');
                                if ($contact_email_active && !empty($contact_email)) :
                                    ?>
                                    <li><a href="mailto:<?php echo esc_html($contact_email); ?>"><?php echo esc_html($contact_email); ?></a></li>
                                    <?php
                                endif;
                                ?>
                                <li><a href="/contacto/">Contacto</a></li>
                            </ul>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-lg-left text-md-center text-sm-center text-center mt-2 mb-2 sedecentralfooter">
                            <h3>Sede Central</h3>
                            <p><?php /*echo carbon_get_theme_option('sede_central');*/ ?></p>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-lg-left text-md-center text-sm-center text-center mt-2 mb-2">
                        <p class="woocommerce-mini-cart__buttons buttons boton-de-arrepentimiento"><a href="/arrepentimiento-de-compra/" class="btn btn-primary d-inline-block">Botón de arrepentimiento</a></p>
                        </div>
                    </div>
                    <!-- Acá iba el formulario del footer -->
                </div>
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