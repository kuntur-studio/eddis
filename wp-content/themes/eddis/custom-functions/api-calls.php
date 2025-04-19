<?php

/**
 * Funcion que consulta el webservice de Eddis
 */
add_action('wp_ajax_consultaEddis', 'edd_query');
add_action('wp_ajax_nopriv_consultaEddis', 'edd_query');
function edd_query() {
	require_once(get_stylesheet_directory().'/common/xml.php');
	/*
        Consultas:
                obtener_planes
                obtener_centros
                obtener_cursos

        Post Alumno:
            Apellido
            Nombre
            DNi
            fecha de nacimiento
            Ciudad
            Dirección
            teléfono
            Email
            Género
            A que curso
        */

	$consulta = $_POST['consulta'];

	if(empty($_POST['param1'])) {
		$param1 = null;
	}
	else {
		$param1 = $_POST['param1'];
	};

	if(empty($_POST['param2'])) {
		$param2 = null;
	}
	else {
		$param2 = $_POST['param2'];
	};

	$client = new SoapClient(null, [
		'location' => "https://servidoreddis.com.ar/sistema/servereddis.php",
		'uri'      => "https://servidoreddis.com.ar/sistema/servereddis.php",
		'trace'    => 1 ]
							);

	try {
		$return = $client->__soapCall($consulta, array($param1, $param2));
	}
	catch (SOAPFault $e) {
		echo $e->getMessage().PHP_EOL;
	}

	print_r(json_encode(simplexml_load_string($return)));

	die();
};

/**
 * Guardar en Custom Post Type
 */
function edd_enroll_student_local($title, $data){

	$new_post  = [
		'post_title'    => $title,
		'post_status'   => 'publish', // Choose: publish, preview, future, draft, etc.
		'post_type'     => 'compras'  //'post',page' or use a custom post type if you want to
	];
	$pid       = wp_insert_post($new_post);

	// Save a basic text value.
	$field_key = 'nombre';
	update_field( $field_key, $data[$field_key], $pid );

	// Save a basic text value.
	$field_key = 'apellido';
	update_field( $field_key, $data[$field_key], $pid );

	// Save a basic text value.
	$field_key = 'email';
	update_field( $field_key, $data[$field_key], $pid );

	// Save a basic text value.
	$field_key = 'dni';
	update_field( $field_key, $data[$field_key], $pid );

	// Save a basic text value.
	$field_key = 'importe';
	update_field( $field_key, $data[$field_key], $pid );

	// Save a basic text value.
	$field_key = 'curso_id';
	update_field( $field_key, $data[$field_key], $pid );

	// Save a basic text value.
	$field_key = 'curso_nombre';
	update_field( $field_key, $data[$field_key], $pid );

	// Save a basic text value.
	$field_key = 'sede';
	update_field( $field_key, $data[$field_key], $pid );
}

/**
 * Funcion para enviar contacto Eddis
 */
add_action('wp_ajax_enroll_student', 'edd_enroll_student');
add_action('wp_ajax_nopriv_enroll_student', 'edd_enroll_student');
function edd_enroll_student(){
	require_once(get_stylesheet_directory().'/common/xml.php');

	// Enviar email
	$nombre      = $_POST["nombre"];
	$apellido    = $_POST["apellido"];
	$dni         = $_POST["dni"];
	$nacimiento  = $_POST["nacimiento"];
	$ciudad      = $_POST["ciudad"];
	$direccion   = $_POST["direccion"];
	$telefono    = $_POST["telefono"];
	$email       = $_POST["email"];
	$genero      = $_POST["genero"];
	$cursoId     = $_POST["cursoId"];
	$pagox       = $_POST['pagox'];
	$sede        = $_POST['sede'];
	$cursoNombre = $_POST['cursoNombre'];

	$title = "$nombre $apellido | $cursoNombre";
	$data = [
		'nombre'        => $nombre,
		'apellido'      => $apellido,
		'email'         => $email,
		'dni'           => $dni,
		'importe'       => $pagox,
		'curso_id'      => $cursoId,
		'curso_nombre'  => $cursoNombre,
		'sede'          => $sede
	];

	$lala   = edd_enroll_student_local($title, $data);

	$param  = ["$nombre|$apellido|$dni|$nacimiento|$ciudad|$direccion|$telefono|$email|$genero|$cursoId"];

	$client = new SoapClient(null, [
		'location' => "https://servidoreddis.com.ar/sistema/servereddis.php",
		'uri'      => "https://servidoreddis.com.ar/sistema/servereddis.php",
		'trace'    => 1]
							);

	try {
		$return = $client->__soapCall('nuevo_alumno', $param);

		die();

	}
	catch (SOAPFault $e) {
		echo $e->getMessage().PHP_EOL;
	}
}
