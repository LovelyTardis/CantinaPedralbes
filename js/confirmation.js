let purchaseButton = document.getElementById("btn-purchase");
let nameInput = document.getElementById("name");
let emailInput = document.getElementById("email");
let phoneInput = document.getElementById("phone");
let form = document.getElementById("credentialsForm");

//ERRORS
const error100 = "El nombre de usuario no puede estar vacio."
const error101 = "La dirección de correo no es correcta. El dominio tiene que ser de '@inspedralbes.cat'.";
const error102 = "El numero de teléfono introducido no és correcto/compatible, Tiene que tener 9 digitos.";
//

purchaseButton.addEventListener("click", () => {
    CheckForm();
})

function CheckForm()
{
    if(!CheckUsername())
    {
        Swal.fire({
            title: 'Error!',
            text: error100,
            icon: 'error',
            confirmButtonText: 'Entendido'
        });
        return false;
    }
    if(!CheckEmail())
    {
        Swal.fire({
            title: 'Error!',
            text: error101,
            icon: 'error',
            confirmButtonText: 'Entendido'
        });
        return false;
    }
    if(!CheckPhone())
    {
        Swal.fire({
            title: 'Error!',
            text: error102,
            icon: 'error',
            confirmButtonText: 'Entendido'
        });
        return false;
    }
    form.submit();
}


////////////////////////////////////////////////
function CheckUsername()
{
    if(nameInput.value == '')
    {
        return false
    }
    return true;
}
function CheckEmail()
{
    if (emailInput.value.endsWith("@inspedralbes.cat")) {
        return true;
    }
    return false; 
}

function CheckPhone()
{
    return (phoneInput.value.replace(/\D/g,'').length == 9);
}