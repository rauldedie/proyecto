function Ayuda()
{
    $mensaje ="No dejes los campos vacios.\nEl usuario y contraseña no pueden contener tildes ni espacios.\nLa contraseña ha de tener mínimo 8 caracteres entre números y letras";
    alert($mensaje);
}

//VERIFICACION DEL LOGIN

/*function ValidarLogin()
{
    //let entradas = [];
    let longitud,usuario,passwd;   
    let correctousu = 1;
    let correctopass=1;
    let valores = /^[a-zA-z0-9]+$/;

    //Limpiamos los errores previos
    document.getElementById("aviso").innerHTML = "";
    document.getElementById("errorusuario").innerHTML = " ";
    document.getElementById("errorpasswd").innerHTML = " ";

    //obtenemos el usuario y contraseña introducido por el usuario
    usuario = document.getElementById("usuario").value;
    passwd = document.getElementById("password").value;
    //entradas.push(document.getElementById("usuario").value);
    //entradas.push(document.getElementById("password").value);

    //verificmaos que los campos no esten vacios
    if (usuario=="")
    {
        document.getElementById("errorusuario").innerHTML = "Este campo es obligatorio.";
        correctousu = 0;
    }
    if (passwd=="")
    {
        document.getElementById("errorpasswd").innerHTML = "Este campo es obligatorio.";
        correctopass = 0;
    }
    //si los campos no estan vacios controlamos que no tengan espacios,
    //tildes o que la contraseña tenga menos de 8 caracteres o contenga caracteres no permitidos.
    if (correctousu == 1 && correctopass == 1)
    {
        longitud = passwd.length;
        if (longitud<8)
        {
            document.getElementById("errorpasswd").innerHTML = "la contraseña ha de tener mínimo 8 caracteres";
            correctopass=0;

        }else if(!passwd.match(valores))
        {
            document.getElementById("errorpasswd").innerHTML = "solo números y letras";
            correctopass=0;
        } else
        {
            usuario = SinTildes(usuario);
            passwd = SinTildes(passwd);
            usuario = SinEspacios(usuario);
            passwd = SinEspacios(passwd);
        }
    }
}

function SinTildes (usuario)
{
    usuario = Array.from(usuario);
    let tamano = usuario.length;
    for(let i=0;i<tamano;i++)
    {
        if(usuario[i]=='á')
        {
            usuario[i] = 'a';
        }else if (usuario [i] == 'é')
            {
                usuario[i] = 'e';
            }else if (usuario[i] == 'í')
                {
                    usuario[i] = 'i';
                }else if (usuario[i] == 'ó')
                    {
                        usuario[i] = 'o';
                    }else if (usuario[i] == 'ú')
                        {
                            usuario[i] = 'u';
                        }
    }

    usuario = usuario.join("");

    return(usuario);
}

function SinEspacios (nombre)
{
    let i,j,long1;
    j = 0;
    let aux=[];
    long1=nombre.length;

    for (i=0;i<long1;i++)
    {
        if(nombre[i]!=" ")
        {
            aux[j] = nombre[i];
            j++;
        }
    }
    aux = aux.join("");
    return (aux);
}

//VERIFICAR REGISTRO

function ValidarRegistro()
{
    //document.getElementById("resultadoregistro").innerHTML ="";
    //let entradas = document.getElementsByTagName("input");
    let entradas = [];    
    let correctopass = 1;
    let correcto = 1;
    let correctomail = 1;
    let i,id,longitud;

    document.getElementById("avisoregistro").innerHTML = " ";    
    
    for (i=0;i<6; i++)
    {
        if (i<6)
        {
            document.getElementById("errorReg"+i).innerHTML = " ";
                
        }
    }

    
    for (i=0; i<5; i++)
    {
    //cargo en el array todos los datos introducidos por el usuario
        entradas.push(document.getElementById("datoreg"+i).value);
    }

    longitud = entradas.length-1;
    
    for (i=0; i<longitud; i++)
    {
            
        if (entradas[i]== "")
        {
            id = "errorReg"+i;
            document.getElementById(id).innerHTML = "Este campo es obligatorio";
            correcto = 0; 

        }else if (i==2)
        {
            correctomail = VerificarMail(entradas[i],i);

        } else if (i==3)
        {
            correctopass = VerificarPassword (entradas[i],entradas[i+1],i);
        }
        
    } 
}

function VerificarPassword (pass1,pass2,i)
{
        let correcto = 1;
        let valores = /^0-9]+$/;
        let tamano1 = pass1.length;
        let tamano2 = pass2.length;
        let item1 = "error"+i;
        let item2 = "error"+(i+1);

        document.getElementById(item1).innerHTML = "";
        document.getElementById(item2).innerHTML = "";

        if(pass1!=pass2)
        {
            document.getElementById(item1).innerHTML = "las contraseñas no son iguales";
            document.getElementById(item2).innerHTML = "las contraseñas no son iguales";
            correcto = 0;
            
        }else if (tamano1<8 || tamano2 <8)
        {
            document.getElementById(item1).innerHTML = "las contraseñas son de mínimo 8 caracteres";
            document.getElementById(item2).innerHTML = "las contraseñas son de mínimo 8 caracteres";
            correcto = 0;

        }else if(!pass1.match(valores) || !pass2.match(valores))
        {
            document.getElementById(item1).innerHTML = "solo números y letras";
            document.getElementById(item2).innerHTML = "solo números y letras";
            correcto = 0;
        }

        if(correcto)
        {
            if (pass1.length<8)
            {
                document.getElementById(item1).innerHTML = "La longitud mínima ha de ser 8 caracteres";
                correcto = 0;
            }
            if (pass2.length<8)
            {
                document.getElementById(item2).innerHTML = "La longitud mínima ha de ser 8 caracteres";
                correcto = 0;
            }
        }
        return (correcto);
}

function VerificarMail(entrada,i)
{
    let correo = /^[0-9a-zA-Z]+@+[a-zA-z]+[.]+[a-zA-Z]+$/;
    let correcto = 1;
    if (!correo.test(entrada))
    {
        correcto = 0;
        document.getElementById("error"+i).innerHTML = "El mail no es correcto" 
    }
    return (correcto);
}

/*function CalcularUsuario(entradas) 
{ 
    let usuario, nombre,apellido1,apellido2;
    nombre = SinEspacios(entradas[0].toLowerCase());
    apellidos = SinEspacios(entradas[1].toLowerCase());
    console.log(entradas[0],entradas[1],entradas[2]);
    usuario = nombre.substring(0,1) + apellidos.substring(0,3) + entradas[4].substr(5,3) ;
    usuario = SinTildes(usuario);
    return (usuario);
}*/