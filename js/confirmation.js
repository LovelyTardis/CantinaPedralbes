let purchaseButton = document.getElementById("btn-purchase");
let nameInput = document.getElementById("name");
let emailInput = document.getElementById("email");
let phoneInput = document.getElementById("phone");
let form = document.getElementById("credentialsForm");

//ERRORS
const error100 = "El nom no pot estar buit."
const error101 = "La direcció de correu no és correcta. El domini ha de ser '@inspedralbes.cat'.";
const error102 = "El format de número de telèfon introduït no és correcte. Ha de tenir 9 dígits.";
//

//Back button funtionality
document.getElementById("back-button").addEventListener('click',()=>{
    Back("/pickup.php");
});
function Back(url){
    window.location.href = document.URL.substr(0,document.URL.lastIndexOf('/'))+url;
};
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