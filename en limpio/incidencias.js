function ValidarLogin()
{
    //let entradas = [];
    let longitud,usuario,passwd;   
    let correctousu = 1;
    let correctopass = 1;
    let valores = /^[a-zA-z0-9]+$/;

    //Limpiamos los errores previos
    //document.getElementById("aviso").innerHTML = "";
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
        if (longitud<6)
        {
            document.getElementById("errorpasswd").innerHTML = "la contraseña ha de tener mínimo 6 caracteres";
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
    if(correctopass==1 && correctousu==1)
    {
        return true;
    }else
    {
        return false;
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