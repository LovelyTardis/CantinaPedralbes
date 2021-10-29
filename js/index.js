//ERRORS
const error100 = "Ja has fet una comanda avui!";
const url = window.url;

let continueButton = document.getElementById("continue-button");
continueButton.addEventListener("click", () => {
    CheckCookie();
});

function CheckCookie()
{
    if(document.cookie.includes("022729"))
    {
        Swal.fire({
        title: 'Error!',
        text: error100,
        icon: 'error',
        confirmButtonText: 'Entendido'
    });
    return false;
    }
    else
    {
        window.location.href = "/pickup.php";
    }
}