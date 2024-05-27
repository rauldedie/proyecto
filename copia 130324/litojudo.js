/*// Ejemplo de JavaScript inicial para deshabilitar el envío de formularios si hay campos no válidos
(function () {
    'use strict'
  
    // Obtener todos los formularios a los que queremos aplicar estilos de validación de Bootstrap personalizados
    var forms = document.querySelectorAll('.needs-validation')
  
    // Bucle sobre ellos y evitar el envío
    Array.prototype.slice.call(forms)
      .forEach(function (form) {
        form.addEventListener('submit', function (event) {
          if (!form.checkValidity()) {
            event.preventDefault()
            event.stopPropagation()
          }
  
          form.classList.add('was-validated')
        }, false)
      })
  })()*/

/*document.addEventListener("DOMContentLoaded", function() 
{
  document.getElementById("formulario").addEventListener('submit', validarFormulario); 
});

function validarFormulario(evento) 
{
    evento.preventDefault();
    var usuario = document.getElementById('InputUsuario').value;
    if(usuario.length == 0) {
        alert('No has escrito nada en el usuario');
        return;
    }
    //puedo añadir patrones para comparar usuario y contraseña
    var clave = document.getElementById('InputPassword').value;
    if (clave.length < 8) {
        alert('La contraseña no es válida');
        return;
    }
    this.submit();
}*/

/*function ValidarLogin()
{
    let nombre = document.getElementById("InputUsuario").value;
    let pass = document.getElementById("InputPassword").value;
    let valores = /^[a-zA-z0-9]+$/;

    if(nombre.length == 0)
    {
        alert('No has escrito nada en el usuario');
        return;
    }
    else if (pass.length < 8)
    {
        alert('usuario y/o contraseña incorrectos');
        return;
    }else document.formulario.submit;
}*/

/*function MenorEdad() 
{
    let dateborn = document.getElementById('dateborn').value;
    let fecha,edad;
    edad = calcular_edad(dateborn);

    if (edad<18)
    {
        document.getElementById('menor').innerHTML="Alumno menor de edad, hay campos obligatorios";
        document.getElementById('padremenor').innerHTML = edad+" AÑOS";
    }
}

//calcular la edad de una persona
//recibe la fecha como un string en formato español
//devuelve un entero con la edad. Devuelve false en caso de que la fecha sea incorrecta o mayor que el dia actual
function calcular_edad(fecha){

    //calculo la fecha de hoy
    hoy=new Date()
    //alert(hoy)

    //calculo la fecha que recibo
    //La descompongo en un array
    var array_fecha = fecha.split("/")
    //si el array no tiene tres partes, la fecha es incorrecta
    if (array_fecha.length!=3)
       return false

    //compruebo que los ano, mes, dia son correctos
    var ano
    ano = parseInt(array_fecha[2]);
    if (isNaN(ano))
       return false

    var mes
    mes = parseInt(array_fecha[1]);
    if (isNaN(mes))
       return false

    var dia
    dia = parseInt(array_fecha[0]);
    if (isNaN(dia))
       return false


    //si el año de la fecha que recibo solo tiene 2 cifras hay que cambiarlo a 4
    if (ano<=99)
       ano +=1900

    //resto los años de las dos fechas
    edad=hoy.getYear()- ano - 1; //-1 porque no se si ha cumplido años ya este año

    //si resto los meses y me da menor que 0 entonces no ha cumplido años. Si da mayor si ha cumplido
    if (hoy.getMonth() + 1 - mes < 0) //+ 1 porque los meses empiezan en 0
       return edad
    if (hoy.getMonth() + 1 - mes > 0)
       return edad+1

    //entonces es que eran iguales. miro los dias
    //si resto los dias y me da menor que 0 entonces no ha cumplido años. Si da mayor o igual si ha cumplido
    if (hoy.getUTCDate() - dia >= 0)
       return edad + 1

    return edad
}

/*function cambiaf_a_espanol($fecha){
    preg_match( '/([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})/', $fecha, $mifecha);
    $lafecha=$mifecha[3]."/".$mifecha[2]."/".$mifecha[1];
    return $lafecha;
}

////////////////////////////////////////////////////
// Convierte fecha de español a mysql
////////////////////////////////////////////////////
function cambiarFormatoAMysql($fecha){
    preg_match( '/([0-9]{1,2})\/([0-9]{1,2})\/([0-9]{2,4})/', $fecha, $mifecha);
    $lafecha=$mifecha[3]."-".$mifecha[2]."-".$mifecha[1];
    return $lafecha;
}*/
