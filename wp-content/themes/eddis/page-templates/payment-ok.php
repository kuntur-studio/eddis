<?php
/*
Template name: Pago Ok
*/
?>
<?php get_header();?>

<section class="progressbarsection">
<div class="container">
    <div class="row">
        <div class="col-xl-10 offset-xl-1 col-lg-10 offset-lg-1 col-md-12 col-sm-12 col-12">
            <ul class="progressbar">
                <li>Verifica los datos</li>
                <li>Pago con Mercadopago</li>
                <li class="active">Formulario Inscripción</li>
            </ul>
        </div>
    </div>
</div>
</section>


<section class="precio mb-5">
	<div class="container">
		<div class="row">
            <div class="col-12">
                <h2 class="global-title text-center">
                    <strong>Tu pago se realizó con éxito.</strong>
                </h2>
                <h3 class="global-subtitle text-center mb-5">
                    Completa el formulario para finalizar tu inscripción.
                </h3>
			</div>
			<div class="col-xl-10 col-lg-10 offset-xl-1 offset-lg-1 col-sm-12 col-md-12 col-xs-12 col-12">
				<form id="formInscripcion" class="needs-validation" novalidate>
                    <div class="row">
                        <div class="form-group col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                            <label for="apellido">Apellido</label>
                            <input type="text" class="form-control" id="apellido" required>
                        </div>
                        <div class="form-group col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                            <label for="nombre">Nombre</label>
                            <input type="text" class="form-control" id="nombre" required>
                        </div>
                        <div class="form-group col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                            <label for="dni">DNI</label>
                            <input type="number" class="form-control" id="dni" required>
                        </div>
                        <div class="form-group col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                            <label for="nacimiento">Fecha de nacimiento</label>
                            <input type="date" class="form-control" id="nacimiento" required>
                        </div>
                        <div class="form-group col-4">
                            <label for="ciudad">Ciudad</label>
                            <input type="text" class="form-control" id="ciudad" required>
                        </div>
                        <div class="form-group col-4">
                            <label for="direccion">Dirección</label>
                            <input type="text" class="form-control" id="direccion" required>
                        </div>
                        <div class="form-group col-4">
                            <label for="telefono">Teléfono</label>
                            <input type="number" class="form-control" id="telefono" required>
                        </div>
                        <div class="form-group col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" required>
                        </div>
                        
                        <div class="form-group col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                            <label for="genero">Género</label>
                            <select class="form-select" id="genero" required>
                                <option selected disabled value="">Selecciona...</option>
                                <option value="1">Hombre</option>
                                <option value="2">Mujer</option>
                                <option value="3">No Declara</option>
                            </select>
                        </div>
                        <div class="form-group col-12 d-flex justify-content-start align-self-center">
                            <input type="hidden" name="curso" value="">
                            <input type="hidden" id="pagox" value="">
                            <button id="sendForm" type="submit" class="btn btn-primary">Enviar</button>
                            <div class="loading"></div>
                            <div class="msg"></div>
                        </div>
                    </div>
                </form>
			</div>
		</div>
	</div>
</section>

<?php get_footer();?>

<script>
    $('.loading').hide();
    $(document).ready(function(){
			$("#sendForm").click(function(e) {
                
                e.preventDefault();

                $("#formInscripcion").addClass("was-validated");
				var nombre = $("#nombre").val();
				var apellido = $("#apellido").val();
				var dni = $("#dni").val();
                var nacimiento = $("#nacimiento").val();
                var ciudad = $("#ciudad").val();
                var direccion = $("#direccion").val();
                var telefono = $("#telefono").val();
				var	email = $("#email").val();
                var	validacion_email = /^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$/;
                var genero = $("#genero").val();
                var cursoId = parseInt(localStorage.getItem('cursoId'));
                var pagox = parseInt(localStorage.getItem('precioFinal'));
                var sede = localStorage.getItem('sede');
                var cursoNombre = localStorage.getItem('cursoNombre');

				if(apellido === ""){
                    $("#apellido").focus();
					return false;
				}
				else if (nombre == "") {
					$("#nombre").focus();
					return false;
                }
                else if (dni == "") {
					$("#dni").focus();
					return false;
                }
                else if (nacimiento == "") {
					$("#nacimiento").focus();
					return false;
                }
                else if (ciudad == "") {
					$("#ciudad").focus();
					return false;
                }
                else if (direccion == "") {
					$("#direccion").focus();
					return false;
                }
                else if (telefono == "") {
					$("#telefono").focus();
					return false;
				}
				else if(email == "" || !validacion_email.test(email)){
					$("#email").focus();	
					return false;			
                }
                else if (genero === null) {
                    $("#genero").focus();
					return false;
                }
                
				else{
					$.ajax({
                        url: window.location.origin + '/wp-admin/admin-ajax.php',
						method: 'post',
                        data: {
                            action: 'enrolarAlumno',
                            nombre,
                            apellido,
                            dni,
                            nacimiento,
                            ciudad,
                            direccion,
                            telefono,
                            email,
                            genero,
                            cursoId,
                            pagox,
                            sede,
                            cursoNombre
                        },
                        beforeSend:function(){
                            $("#sendForm").addClass('disabled');
                            $('.loading').show();
                        },
						success: function(data) {
                            $('.loading').hide();
							$("#formInscripcion").addClass("was-validated");
                            console.log(data);
							if(data === "200"){
                                localStorage.clear();
								location.href = BLOGURL+"/gracias/";
							} else{
                                $('.loading').hide();
							    $("#formInscripcion").addClass("was-validated");
							    $('.msg').text('Ocurrió un error, intenta luego').addClass('msg_error').animate({ 'right' : '0px' }, 300);
                            }
						},
						error: function() {
                            $('.loading').hide();
							$("#formInscripcion").addClass("was-validated");
							$('.msg').text('Ocurrió un error, intenta luego').addClass('msg_error').animate({ 'right' : '0px' }, 300);
						}
					});
					return false;	
				}
			});
		});
</script>