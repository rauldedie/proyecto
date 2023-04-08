function ValidarFormulario()
{
    document.getElementById("resultado").innerHTML ="";
    //let entradas = document.getElementsByTagName("input");
    let entradas = [];    
    let correctopass = 1;
    let correcto = 1;
    let correctomail = 1;
    let correctocheck = document.getElementById("dato5").checked;
    let i,id,longitud;

    document.getElementById("usuario").innerHTML = " ";
    document.getElementById("resultado").innerHTML = " ";
    
    
    for (i=0;i<6; i++)
    {
        if (i<6)
        {
            document.getElementById("error"+i).innerHTML = " ";
                
        }
    }

    
    for (i=0; i<5; i++)
    {
    //cargo en el array todos los datos introducidos por el usuario
        entradas.push(document.getElementById("dato"+i).value);
    }

    longitud = entradas.length-1;
    
    for (i=0; i<longitud; i++)
    {
            
        if (entradas[i]== "")
        {
            id = "error"+i;
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
}*/