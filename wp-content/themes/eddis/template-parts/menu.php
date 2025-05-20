<?php 
$menu_items = carbon_get_theme_option('menu_items');
if (!empty($menu_items)): ?>
    <?php foreach ($menu_items as $item): ?>
        <?php if ($item['active']): ?>
            <?php if (!$item['dropdown_menu']): ?>
                <!-- Si es menu simple -->
                
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo esc_url($item['link']); ?>">
                            <?php if ($item['title'] === 'Ver Carrito') {?>
                                <!-- Si es elemento carrito -->
                            <?php
                                echo '<img class="cart-icon" src="wp-content/themes/eddis/assets/img/shopping-cart.png" />';
                            } else { 
                                echo esc_html($item['title']); 
                            } ?>
                        </a>
                    </li>
            <?php else: ?>
                <!-- Si es menu desplegable -->

                <?php if ($item['dropdown_type'] === 'one_column'): ?>
                <!-- Si es 1 columna -->
                <li class="nav-item dropdown single-column" style="position: relative!important;">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php echo esc_html($item['title']); ?>
                    </a>
                    <div class="dropdown-menu menu-collapse-utc line-gradient-utc">
                        <div class="container">
                            <div class="row">
                                <div class="text-lg-left text-md-center text-sm-center text-center">
                                    <nav class="links-card-menu-utc">
                                        <?php 
                                        $column1_items = carbon_get_theme_option('menu_items_column1_items');
                                        if (!empty($column1_items)): ?>
                                            <?php foreach ($column1_items as $col1_item): ?>
                                                <a href="<?php echo esc_url($col1_item['link']); ?>" class="transition-280 text-dark single-column-menu-item">
                                                    <?php echo esc_html($col1_item['title']); ?>
                                                </a>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                
                <?php elseif ($item['dropdown_type'] === 'one_column_banner'): ?>
                <!-- Si es 1 columna + banner -->
                <li class="nav-item dropdown" style="position: static!important;">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php echo esc_html($item['title']); ?>
                    </a>
                    <div class="dropdown-menu menu-collapse-utc line-gradient-utc">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12 text-lg-left text-md-center text-sm-center text-center">
                                    <h3 style="font-size: 1.3em!important;"><?php echo esc_html(carbon_get_theme_option('menu_items_column1_title')); ?></h3>
                                    <nav class="links-card-menu-utc">
                                        <?php 
                                        $column1_items = carbon_get_theme_option('menu_items_column1_items');
                                        if (!empty($column1_items)): ?>
                                            <?php foreach ($column1_items as $col1_item): ?>
                                                <a href="<?php echo esc_url($col1_item['link']); ?>" class="transition-280 text-dark">
                                                    <?php echo esc_html($col1_item['title']); ?>
                                                </a>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </nav>
                                </div>
                                <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12 text-lg-left text-md-center text-sm-center text-center">
                                    <div class="card-utc-menu">
                                        <div class="row">
                                            <div class="col-lg-4" style="padding: 5em 3em; background-color:<?php echo esc_attr(carbon_get_theme_option('menu_items_banner_bg_color')); ?>;">
                                                <h2><?php echo esc_html(carbon_get_theme_option('menu_items_banner_title')); ?></h2>
                                                <p><?php echo esc_html(carbon_get_theme_option('menu_items_banner_description')); ?></p>
                                                <a href="<?php echo esc_url(carbon_get_theme_option('menu_items_banner_link')); ?>" class="button-primary-white">SABER MÁS</a>
                                            </div>
                                            <div class="col-lg-8 bg-card-menu" style="background-image: url(<?php echo esc_url(carbon_get_theme_option('menu_items_banner_image')); ?>);">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>

                <?php elseif ($item['dropdown_type'] === 'two_columns_banner'): ?>
                <!-- Si es 2 columna + banner -->
                <li class="nav-item dropdown" style="position: static!important;">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php echo esc_html($item['title']); ?>
                    </a>
                    <div class="dropdown-menu menu-collapse-utc line-gradient-utc">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-2 col-md-6 col-sm-6 col-xs-12 text-lg-left text-md-center text-sm-center text-center">
                                    <h3 style="font-size: 1.3em!important;"><?php echo esc_html(carbon_get_theme_option('menu_items_column1_title')); ?></h3>
                                    <nav class="links-card-menu-utc">
                                        <?php 
                                        $column1_items = carbon_get_theme_option('menu_items_column1_items');
                                        if (!empty($column1_items)): ?>
                                            <?php foreach ($column1_items as $col1_item): ?>
                                                <a href="<?php echo esc_url($col1_item['link']); ?>" class="transition-280 text-dark">
                                                    <?php echo esc_html($col1_item['title']); ?>
                                                </a>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </nav>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 text-lg-left text-md-center text-sm-center text-center">
                                    <h3 style="font-size: 1.3em!important;"><?php echo esc_html(carbon_get_theme_option('menu_items_column2_title')); ?></h3>
                                    <nav class="links-card-menu-utc">
                                        <?php 
                                        $column2_items = carbon_get_theme_option('menu_items_column2_items');
                                        if (!empty($column2_items)): ?>
                                            <?php foreach ($column2_items as $col2_item): ?>
                                                <a href="<?php echo esc_url($col2_item['link']); ?>" class="transition-280 text-dark">
                                                    <?php echo esc_html($col2_item['title']); ?>
                                                </a>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </nav>
                                </div>
                                <div class="col-lg-7 col-md-12 col-sm-12 col-xs-12 text-lg-left text-md-center text-sm-center text-center">
                                    <div class="card-utc-menu">
                                        <div class="row">
                                            <div class="col-lg-4" style="padding: 5em 3em; background-color:<?php echo esc_attr(carbon_get_theme_option('menu_items_banner_bg_color')); ?>;">
                                                <h2><?php echo esc_html(carbon_get_theme_option('menu_items_banner_title')); ?></h2>
                                                <p><?php echo esc_html(carbon_get_theme_option('menu_items_banner_description')); ?></p>
                                                <a href="<?php echo esc_url(carbon_get_theme_option('menu_items_banner_link')); ?>" class="button-primary-white">SABER MÁS</a>
                                            </div>
                                            <div class="col-lg-8 bg-card-menu" style="background-image: url(<?php echo esc_url(carbon_get_theme_option('menu_items_banner_image')); ?>);">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>

                <?php elseif ($item['dropdown_type'] === 'two_columns_3_2'): ?>
                <!-- Si es 2 columna + desplegable -->
                <li class="nav-item dropdown" style="position: static!important;">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php echo esc_html($item['title']); ?>
                    </a>
                    <div class="dropdown-menu menu-collapse-utc line-gradient-utc">
                        <div class="container">
                            <div class="row">

                                <!-- Columna grande 1 -->
                                <div class="col-lx-6 col-lg-6 col-sm-12 col-md-12 col-xs-12 col-12">
                                    <h2><?php echo esc_html(carbon_get_theme_option('menu_items_large_column1_title')); ?></h2>
                                    <div class="row">
                                        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 text-lg-left text-md-center text-sm-center text-center">
                                            <h3><?php echo esc_html(carbon_get_theme_option('menu_items_column1_title')); ?></h3>
                                            <nav class="links-card-menu-utc">
                                                <?php 
                                                $column1_items = carbon_get_theme_option('menu_items_column1_items');
                                                if (!empty($column1_items)): ?>
                                                    <?php foreach ($column1_items as $col1_item): ?>
                                                        <a href="<?php echo esc_url($col1_item['link']); ?>" class="transition-280 text-dark">
                                                            <?php echo esc_html($col1_item['title']); ?>
                                                        </a>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </nav>
                                        </div>
                                        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 text-lg-left text-md-center text-sm-center text-center">
                                            <h3><?php echo esc_html(carbon_get_theme_option('menu_items_column2_title')); ?></h3>
                                            <nav class="links-card-menu-utc">
                                                <?php 
                                                $column2_items = carbon_get_theme_option('menu_items_column2_items');
                                                if (!empty($column2_items)): ?>
                                                    <?php foreach ($column2_items as $col2_item): ?>
                                                        <a href="<?php echo esc_url($col2_item['link']); ?>" class="transition-280 text-dark">
                                                            <?php echo esc_html($col2_item['title']); ?>
                                                        </a>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </nav>
                                        </div>
                                        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 text-lg-left text-md-center text-sm-center text-center">
                                            <h3><?php echo esc_html(carbon_get_theme_option('menu_items_column3_title')); ?></h3>
                                            <nav class="links-card-menu-utc">
                                                <?php 
                                                $column3_items = carbon_get_theme_option('menu_items_column3_items');
                                                if (!empty($column3_items)): ?>
                                                    <?php foreach ($column3_items as $col3_item): ?>
                                                        <a href="<?php echo esc_url($col3_item['link']); ?>" class="transition-280 text-dark">
                                                            <?php echo esc_html($col3_item['title']); ?>
                                                        </a>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </nav>
                                        </div>
                                    </div>
                                </div>

                                <!-- Columna grande 2 -->
                                <div class="col-lx-6 col-lg-6 col-sm-12 col-md-12 col-xs-12 col-12">
                                    <h2><?php echo esc_html(carbon_get_theme_option('menu_items_large_column2_title')); ?></h2>
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-lg-left text-md-center text-sm-center text-center">
                                            <h3><?php echo esc_html(carbon_get_theme_option('menu_items_column4_title')); ?></h3>
                                            <nav class="links-card-menu-utc">
                                                <?php 
                                                $column4_items = carbon_get_theme_option('menu_items_column4_items');
                                                if (!empty($column4_items)): ?>
                                                    <?php foreach ($column4_items as $col4_item): ?>
                                                        <a href="<?php echo esc_url($col4_item['link']); ?>" class="transition-280 text-dark">
                                                            <?php echo esc_html($col4_item['title']); ?>
                                                        </a>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </nav>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-lg-left text-md-center text-sm-center text-center">
                                            <h3><?php echo esc_html(carbon_get_theme_option('menu_items_column5_title')); ?></h3>
                                            <nav class="links-card-menu-utc">
                                                <?php 
                                                $column5_items = carbon_get_theme_option('menu_items_column5_items');
                                                if (!empty($column5_items)): ?>
                                                    <?php foreach ($column5_items as $col5_item): ?>
                                                        <a href="<?php echo esc_url($col5_item['link']); ?>" class="transition-280 text-dark">
                                                            <?php echo esc_html($col5_item['title']); ?>
                                                        </a>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </nav>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </li>

                <?php elseif ($item['dropdown_type'] === 'courses'): ?>
                <!-- Si es menú de cursos -->
                <li class="nav-item dropdown" style="position: static!important;">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php echo esc_html($item['title']); ?>
                    </a>
                    <div class="dropdown-menu menu-collapse-utc line-gradient-utc">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 text-lg-left text-md-center text-sm-center text-center menu-border-right">
                                    <?php 
                                    // Obtener categorías de producto padre (ajusta el término padre según tu estructura)
                                    $product_categories = get_terms([
                                        'taxonomy'   => 'product_cat',
                                        'hide_empty' => true,
                                        'parent'     => 0, // Cambia esto según tu estructura de categorías
                                    ]);
                                    
                                    if (!empty($product_categories) && !is_wp_error($product_categories)): ?>
                                        <ul class="nav tab-menu nav-pills tab-menu-cursos" id="tabCursos">
                                            <?php foreach ($product_categories as $category): ?>
                                                <li>
                                                    <a href="#<?php echo esc_attr($category->slug); ?>" data-toggle="tab">
                                                        <?php echo esc_html($category->name); ?>
                                                    </a>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php endif; ?>
                                </div>
                                <div class="col-lg-7 offset-lg-1 col-md-12 col-sm-12 col-xs-12 text-lg-left text-md-center text-sm-center text-center">
                                    <div class="tab-content">
                                        <?php 
                                        if (!empty($product_categories) && !is_wp_error($product_categories)):
                                            foreach ($product_categories as $category): ?>
                                                <div class="tab-pane well" id="<?php echo esc_attr($category->slug); ?>"> 
                                                    <div class="column-nav d-flex flex-row justify-content-between flex-wrap">
                                                        <?php
                                                        // Obtener productos de esta categoría
                                                        $args = [
                                                            'post_type'      => 'product',
                                                            'posts_per_page' => -1,
                                                            'tax_query'      => [
                                                                [
                                                                    'taxonomy' => 'product_cat',
                                                                    'field'    => 'term_id',
                                                                    'terms'    => $category->term_id,
                                                                ]
                                                            ]
                                                        ];
                                                        
                                                        $products = new WP_Query($args);
                                                        
                                                        if ($products->have_posts()):
                                                            while ($products->have_posts()): $products->the_post(); ?>
                                                                <a href="<?php the_permalink(); ?>" class="w-50 d-block">
                                                                    <?php the_title(); ?>
                                                                </a>
                                                            <?php endwhile;
                                                            wp_reset_postdata();
                                                        endif; ?>
                                                        <a class="btn btn-primary d-inline-block mt-4" href="<?php echo esc_url(get_term_link($category)); ?>">
                                                            Ver todos
                                                        </a>
                                                    </div>
                                                </div>
                                            <?php endforeach;
                                        endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <?php endif; // Verificación del tipo de despegable?>
            <?php endif; // Si el item es desplegable o no?>
        <?php endif;  // Si el item está activo ?>
    <?php endforeach; ?>
<?php endif; ?>
<?php wp_reset_postdata(); ?>