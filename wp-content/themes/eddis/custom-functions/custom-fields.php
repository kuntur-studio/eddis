<?php

use Carbon_Fields\Container;
use Carbon_Fields\Field;

// Campos personalizados para configuración general del tema
// Menues, redes sociales, elementos del footer, etc
add_action('carbon_fields_register_fields', 'edd_register_theme_options');
function edd_register_theme_options() {
	require_once('admin.php');

	$social_labels = array(
		'plural_name' => 'Redes Sociales',
		'singular_name' => 'Red Social',
	);
	
	Container::make( 'theme_options', 'Configuración General')
		->set_icon('dashicons-superhero')
		->add_tab('Gestión de Menú', [
			Field::make('complex', 'menu_items', 'Ítems del Menú')
				->set_layout('tabbed-horizontal')  // Ó 'tabbed-vertical'
				->add_fields([
					// Título del ítem
					Field::make('text', 'title', 'Título')
						->set_required(true),

					// Tipo de ítem: simple, dropdown o carrito
					Field::make('select', 'item_type', 'Tipo')
						->add_options([
							'simple' => 'Simple',
							'dropdown' => 'Desplegable',
							'cart' => 'Carrito',
						]),

					// Tipo de dropdown
					Field::make('select', 'dropdown_type', 'Modo de visualización')
						->add_options([
							'one_column' => '1 Columna',
							'one_column_banner' => '1 Columna + Banner',
							'two_columns_banner' => '2 Columnas + Banner',
							'five_columns_3_2' => '5 Columnas (3 + 2)',
							'courses' => 'Cursos',
						])
						->set_conditional_logic([
							[
								'field' => 'item_type',
								'value' => 'dropdown', // Solo se muestra si el item es desplegable
							]
						]),

					// Link (solo si es simple o carrito)
					Field::make('text', 'link', 'Enlace')
						->set_conditional_logic([
							[
									'field' => 'item_type',
									'value' => ['simple', 'cart'],
								]
						]),

					// Activo
					Field::make('checkbox', 'active', 'Activo'),

					// Títulos para agrupadores (solo five_columns_3_2)
					Field::make('text', 'wrapper1_title', 'Título grupo 3 columnas')
						->set_conditional_logic([
							[
								'field' => 'dropdown_type',
								'value' => 'five_columns_3_2',
							]
						]),

					Field::make('text', 'wrapper2_title', 'Título grupo 2 columnas')
						->set_conditional_logic([
							[
								'field' => 'dropdown_type',
								'value' => 'five_columns_3_2',
							]
						]),

					// Columna 1
					Field::make('text', 'column1_title', 'Título de la Columna 1')
						->set_conditional_logic([
							[
								'field' => 'dropdown_type',
								'value' => [
									'one_column',
									'one_column_banner',
									'two_columns_banner',
									'five_columns_3_2',
								],
								'compare' => 'IN'
							]
						]),

					Field::make('complex', 'column1_items', 'Ítems Columna 1')
						->add_fields([
							Field::make('text', 'title', 'Título'),
							Field::make('text', 'link', 'Enlace'),
						])
						->set_layout('tabbed-horizontal')
						->set_conditional_logic([
							[
								'field' => 'dropdown_type',
								'value' => [
									'one_column',
									'one_column_banner',
									'two_columns_banner',
									'five_columns_3_2',
								],
								'compare' => 'IN'
							]
						]),

					// Columna 2
					Field::make('text', 'column2_title', 'Título de la Columna 2')
						->set_conditional_logic([
							[
								'field'   => 'dropdown_type',
								'value'   => ['two_columns_banner', 'five_columns_3_2'],
								'compare' => 'IN'
							]
						]),

					Field::make('complex', 'column2_items', 'Ítems Columna 2')
						->add_fields([
							Field::make('text', 'title', 'Título'),
							Field::make('text', 'link', 'Enlace'),
						])
						->set_layout('tabbed-horizontal')
						->set_conditional_logic([
							[
								'field'   => 'dropdown_type',
								'value'   => ['two_columns_banner', 'five_columns_3_2'],
								'compare' => 'IN'
							]
						]),

					// Columna 3
					Field::make('text', 'column3_title', 'Título de la Columna 3')
						->set_conditional_logic([
							[
								'field' => 'dropdown_type',
								'value' => 'five_columns_3_2',
							]
						]),

					Field::make('complex', 'column3_items', 'Ítems Columna 3')
						->add_fields([
							Field::make('text', 'title', 'Título'),
							Field::make('text', 'link', 'Enlace'),
						])
						->set_layout('tabbed-horizontal')
						->set_conditional_logic([
							[
								'field' => 'dropdown_type',
								'value' => 'five_columns_3_2',
							]
						]),

					// Columna 4
					Field::make('text', 'column4_title', 'Título de la Columna 4')
						->set_conditional_logic([
							[
								'field' => 'dropdown_type',
								'value' => 'five_columns_3_2',
							]
						]),

					Field::make('complex', 'column4_items', 'Ítems Columna 4')
						->add_fields([
							Field::make('text', 'title', 'Título'),
							Field::make('text', 'link', 'Enlace'),
						])
						->set_layout('tabbed-horizontal')
						->set_conditional_logic([
							[
								'field' => 'dropdown_type',
								'value' => 'five_columns_3_2',
							]
						]),

					// Columna 5
					Field::make('text', 'column5_title', 'Título de la Columna 5')
						->set_conditional_logic([
							[
								'field' => 'dropdown_type',
								'value' => 'five_columns_3_2',
							]
						]),

					Field::make('complex', 'column5_items', 'Ítems Columna 5')
						->add_fields([
							Field::make('text', 'title', 'Título'),
							Field::make('text', 'link', 'Enlace'),
						])
						->set_layout('tabbed-horizontal')
						->set_conditional_logic([
							[
								'field' => 'dropdown_type',
								'value' => 'five_columns_3_2',
							]
						]),

					// Banner para los dropdowns con banner (one_column_banner, two_columns_banner)
					Field::make('text', 'banner_title', 'Título del banner')
						->set_conditional_logic([
							[
								'field'   => 'dropdown_type',
								'value'   => ['one_column_banner', 'two_columns_banner'],
								'compare' => 'IN'
							]
						]),

					Field::make('textarea', 'banner_description', 'Descripción del banner')
						->set_conditional_logic([
							[
								'field'   => 'dropdown_type',
								'value'   => ['one_column_banner', 'two_columns_banner'],
								'compare' => 'IN'
							]
						]),

					Field::make('color', 'banner_bg_color', 'Color de fondo del banner')
						->set_conditional_logic([
							[
								'field'   => 'dropdown_type',
								'value'   => ['one_column_banner', 'two_columns_banner'],
								'compare' => 'IN'
							]
						]),

					Field::make('image', 'banner_image', 'Imagen del banner')
						->set_value_type('url')
						->set_conditional_logic([
							[
								'field'   => 'dropdown_type',
								'value'   => ['one_column_banner', 'two_columns_banner'],
								'compare' => 'IN'
							]
						]),

					Field::make('text', 'banner_link', 'Enlace del banner')
						->set_conditional_logic([
							[
								'field'   => 'dropdown_type',
								'value'   => ['one_column_banner', 'two_columns_banner'],
								'compare' => 'IN'
							]
						]),
				])
				->set_header_template('Columna <%- $_index + 1 %>') // Esto va al final porque sino no funciona
				// Aparentemente add_fields elimina la configuración establecida por set_header_template
		])

		->add_tab('Footer', [
            Field::make('complex', 'footer_menu_items', 'Ítems del Menú')
				->add_fields([
					Field::make('text', 'title', 'Título')
						->set_required(true),
					Field::make('checkbox', 'is_internal', 'Interno')
						->set_default_value(true), 
					Field::make('select', 'page', 'Página')
						->set_options(edd_get_pages_list())
						->set_conditional_logic([
							[
								'field' => 'is_internal',
								'value' => true,
							]
						]),
					Field::make('text', 'external_url', 'URL externa')
						->set_conditional_logic([
							[
								'field' => 'is_internal',
								'value' => false,
							]
						])
					->set_required(true),
				])
				->set_header_template('
					<% if (title) { %>
						<%- title %>
					<% } else { %>
						Nuevo Ítem
					<% } %>
				')
				->set_collapsed(true),
		])

		->add_tab('Redes Sociales', [
        Field::make('complex', 'social_networks', 'Redes Sociales')
			->setup_labels($social_labels)
            ->add_fields([
                Field::make('icon_select', 'icon', 'Icono')
					->set_options(edd_get_social_icons()), // Ver admin.php
                Field::make('text', 'link', 'Enlace')->set_attribute('type', 'url'),
            ]),
    	])

		->add_tab('Datos de Contacto', [
			// Teléfono
			Field::make('text', 'contact_phone', 'Teléfono')
				->set_attribute('placeholder', 'Ingresa el número de teléfono'),

			Field::make('checkbox', 'contact_phone_active', 'Activo'),

			Field::make('separator', 'separator_1', ' '),

			// WhatsApp
			Field::make('text', 'contact_whatsapp', 'WhatsApp')
				->set_attribute('placeholder', 'Ingresa el número de WhatsApp'),

			Field::make('checkbox', 'contact_whatsapp_active', 'Activo'),

			Field::make('separator', 'separator_2', ' '),

			// Correo Electrónico
			Field::make('text', 'contact_email', 'Correo Electrónico')
				->set_attribute('placeholder', 'Ingresa la dirección de correo electrónico'),

			Field::make('checkbox', 'contact_email_active', 'Activo'),
		])

		->add_tab('Marketing', [
			Field::make('html', 'gtm_label')
				->set_html('<h3>Google Tag Manager</h3>'),

			Field::make('text', 'gtm_service_tag', 'Service Tag')
				->set_attribute('placeholder', 'Ingresa el ID del Service Tag'),

			Field::make('checkbox', 'gtm_active', 'Activo')
		])

		->add_tab('Gestión de Assets', [
        	Field::make('complex', 'assets', 'Assets JS/CSS')
				->add_fields([
					Field::make('select', 'asset_type', 'Tipo de Asset')
						->set_options([
							'js' => 'JavaScript',
							'css' => 'CSS',
						])
						->set_required(true),

					Field::make('text', 'asset_name', 'Nombre del Asset')
						->set_required(true),

					Field::make('text', 'asset_url', 'URL o ruta del archivo')
						->set_attribute('placeholder', 'https://... o /ruta/al/archivo.js o .css dentro de assets')
						->set_required(true),

					Field::make('select', 'load_location', 'Ubicación de carga')
						->set_options([
							'header' => 'Header',
							'footer' => 'Footer',
						])
						->set_default_value('footer'),

					Field::make('multiselect', 'load_pages', 'Páginas donde cargar')
						->set_options(['all' => 'Todas las páginas'] + edd_get_pages_list()),

					Field::make('checkbox', 'load_in_admin', 'Cargar en Admin'),
				])
				->set_header_template('
					<% if (asset_name) { %>
						<%- asset_name %> (<%- asset_type.toUpperCase() %>)
					<% } else { %>
						Nuevo Asset
					<% } %>
				')
				->set_collapsed(true),
				//->set_layout('tabbed-horizontal'),
    	])
		
		->add_tab('Widgets', [
			Field::make('complex', 'widgets_tabs', 'Configuración de Widgets')
				->setup_labels(['singular_name' => 'Pestaña'])
				->set_layout('tabbed-vertical') // Tabs verticales
				->add_fields('branches_widget', 'Sedes', [
					Field::make('checkbox', 'enable_branches_widget', 'Activar Widget de Sedes')
						->set_option_value('yes')
						->set_default_value(true),
					Field::make('multiselect', 'branches_widget_pages', 'Páginas donde cargar')
						->set_options(['all' => 'Todas las páginas'] + edd_get_pages_list())
						->set_default_value(['home', '764', '770'])
				])
				->add_fields('product_banner', 'Página de Producto', [
					Field::make('checkbox', 'enable_product_banner_widget', 'Activar Banner Inferior')
						->set_option_value('yes')
						->set_default_value(false),
					
					// Imágenes para diferentes breakpoints
					Field::make('image', 'product_banner_lg', 'Banner LG (≥1200px)')
						->set_value_type('url')
						->help_text('Tamaño recomendado: 1200px de ancho'),
					Field::make('image', 'product_banner_md', 'Banner MD (≥768px)')
						->set_value_type('url')
						->help_text('Tamaño recomendado: 768px de ancho'),
					Field::make('image', 'product_banner_sm', 'Banner SM (<768px)')
						->set_value_type('url')
						->help_text('Tamaño recomendado: 576px de ancho'),
					
					// Configuración de enlace
					Field::make('checkbox', 'product_banner_enable_link', 'Habilitar enlace')
						->set_option_value('yes')
						->set_default_value(false),
					Field::make('text', 'product_banner_link', 'Enlace del Banner')
						->set_attribute('type', 'url')
						->set_conditional_logic([
							[
								'field' => 'product_banner_enable_link',
								'value' => true,
							]
						])
				])
				->add_fields('front_page', 'Front Page', [
					Field::make('html', 'home_notice')
						->set_html('<p>Configuración para widgets en la página de inicio</p>')
					
				])
		]);
}

// Este hook intercepta el guardado de los datos
add_filter('carbon_fields_save_value', function($value, $field, $container) {
	// Borra el valor si dropdown_menu es falso
    if ($field->get_name() === 'dropdown_type') {
        $dropdown_menu = carbon_get_theme_option('dropdown_menu');
        if (!$dropdown_menu) {
            return null;
        }
    }
    return $value;
}, 10, 3);





// Campos personalizados para el custom type sedes
add_action('carbon_fields_register_fields', 'edd_register_sedes_custom_fields');
function edd_register_sedes_custom_fields() {
	Container::make('post_meta', 'Datos de la Sede')
		->where('post_type', '=', 'sedes')
		->add_fields([
			Field::make('text', 'eddis_system_id', 'ID sistema Eddis'),
			Field::make('rich_text', 'description', 'Descripción'),
			Field::make('text', 'address', 'Dirección'),
			Field::make('rich_text', 'map_iframe', 'Mapa Iframe'),
			Field::make('text', 'email', 'Correo electrónico'),
			Field::make('text', 'phone', 'Teléfono'),
			Field::make('text', 'facebook_link', 'Facebook Sede'),
			Field::make('text', 'instagram_link', 'Instagram Sede'),
		]);
}




// Campos personalizados para el custom type formularios
add_action( 'carbon_fields_register_fields', 'edd_register_eddis_form_fields' );
function edd_register_eddis_form_fields() {
    Container::make( 'post_meta', 'Configuración del Formulario' )
        ->where( 'post_type', '=', 'eddis_form' )
        ->add_fields( array(
            Field::make( 'checkbox', 'eddis_form_active', 'Activo' )
                ->set_option_value( 'yes' )
                ->set_default_value( 'yes' )
                ->set_help_text( 'Marca esta casilla para activar o desactivar el formulario en el sitio.' ),

            Field::make( 'text', 'eddis_form_name', 'Nombre de Identificación (Slug)' )
                ->set_attribute( 'placeholder', 'ej: contacto-principal' )
                ->set_help_text( 'Un nombre único y legible por máquinas para identificar este formulario (ej: contacto-principal). Se usará para generar el ID HTML: eddis-form-{name}.' )
                ->set_required( true )
                ->set_width( 50 ),

            Field::make( 'textarea', 'eddis_form_code', 'Pegar Código del Formulario' )
                ->set_rows( 15 )
                ->set_help_text( 'Pega acá el código HTML/JavaScript/CSS que el CRM genera para el formulario. Podes incluir estilos o scripts para personalizar la apariencia y el comportamiento del formulario.' )
                ->set_attribute( 'placeholder', '<form>...</form><script>...</script><style>...</style>' ),
        ) );
}




// Campos personalizados para productos de la tienda
add_action('carbon_fields_register_fields', 'edd_register_product_custom_fields');
function edd_register_product_custom_fields() {
	require_once('admin.php');
	
	Container::make('post_meta', 'Detalles del Curso')
		->where('post_type', '=', 'product') // Solo en productos (cursos)
		->add_fields([
			Field::make('text', 'plan_id', 'Plan ID')->set_attribute('type', 'number'),
			Field::make('checkbox', 'enable_payment', 'Habilitar Pago de Matrícula con Mercado Pago?'),
			Field::make('checkbox', 'show_inscription_fields', 'Mostrar campos de inscripción'),
			Field::make('text', 'list_price', 'Precio de lista')->set_attribute('type', 'number'),
			Field::make('image', 'featured_image', 'Imagen destacada'),
			Field::make('image', 'cover_image', 'Imagen de portada'),
			Field::make('text', 'duration', 'Duración'),
			Field::make('text', 'certification', 'Certificación'),
			Field::make('text', 'mode', 'Modalidad'),
			Field::make('textarea', 'short_description', 'Descripción corta'),

			Field::make('complex', 'content_blocks', 'Contenido')
				->add_fields([
					Field::make('text', 'title', 'Título'),
					Field::make('rich_text', 'content', 'Contenido'),
				]),

			/*Field::make('complex', 'highlight_bullets', 'Bullets Destacados')
				->add_fields([
					Field::make('icon_select', 'highlight_icon', 'Ícono Destacado')
						->set_options(edd_get_product_bullet_icons()) // Ver admin.php
						->set_default_value('graduation-cap'),
				
				Field::make('text', 'title', 'Título'),
				Field::make('text', 'description', 'Descripción'),
			]),

			Field::make('file', 'study_plan_file', 'Plan de estudios Descargable'),

			Field::make('complex', 'study_plan', 'Plan de Estudios')
				->add_fields([
					Field::make('text', 'title', 'Título'),
					Field::make('rich_text', 'content', 'Contenido'),
				]),

			Field::make('complex', 'testimonials', 'Testimonios')
				->add_fields([
					Field::make('image', 'image', 'Imagen'),
					Field::make('textarea', 'content', 'Contenido'),
					Field::make('text', 'name', 'Nombre'),
					Field::make('text', 'course', 'Curso'),
				]),

			Field::make('association', 'related_programs', 'Programas relacionados')
				->set_types([
					['type' => 'post', 'post_type' => 'product']
				]),

			Field::make('checkbox', 'reserve_spot', 'Reserva tu lugar')*/
		]);
}
