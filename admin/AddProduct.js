let newProductForm = document.getElementById('newProduct');
let addProductButton = document.getElementById('AddButton');
///errortype
let idTypeError=0;
let productNameTypeError=0;
let productPriceTypeError=0;
///

//Back button funtionality
document.getElementById("back-button").addEventListener('click',(e)=>{
    Back("/administration.php");
});
function Back(url){
    window.location.href = document.URL.substr(0,document.URL.lastIndexOf('/'))+url;
};
//


addProductButton.addEventListener('click', function(){
    CheckForm();
});

let inputs ={
    productId: document.getElementById('productId'),
    productName: document.getElementById('productName'),
    isActivated: document.getElementById('isActived'),
    schedule: document.getElementById('schedule'),
    productPrice: document.getElementById('productPrice'),
}


function CheckForm()
{
    let idHasErrors = CheckId();
    let productNameHasErrors = CheckProductName();
    let priceHasErrors = CheckProductPrice();

    if(idHasErrors)
    {
        switch (idTypeError) {
            case 101:
                PaintError("El id no puede estar vacio");
                break;
            case 102:
                PaintError("El id tiene que ser numerico (No puede contener caracteres/letras)");
                break;
            default:
                PaintError("Error Desconocido En el nombre");
                break;
        }
    }
    else if(productNameHasErrors)
    {
        switch (productNameTypeError) {
            case 201:
                PaintError("El nombre no puede estar vacio");
                break;
            default:
                PaintError("Error Desconocido");
                break;
        }
    }
    else if(priceHasErrors)
    {
        switch (productPriceTypeError) {
            case 301:
                PaintError("El precio introducido no es un valor numerico");
                break;
            case 302:
                PaintError("El precio no puede ser negativo");
                break;
            default:
                PaintError("Error Desconocido");
                break;
        }
        
    }
    else
    {
        
        Swal.fire({
            title: 'Creat',
            icon: 'succes',
            confirmButtonText: 'Acceptar',
        }).then((result) => {
            if(result.isConfirmed)
            {
                newProductForm.submit(); 
            }
        })
        
    }
}

function CheckId()
{
    if(inputs.productId.value == "")
    {
        idTypeError = 101;
        return true;
    }
    else if(isNaN(inputs.productId.value))
    {
        idTypeError = 102;
        return true;
    }
    return false;
}
function CheckProductName()
{
    if(inputs.productName.value == "")
    {
        productNameTypeError = 201;
        return true;
    }
    return false;
}

function CheckProductPrice()
{
    if(isNaN(inputs.productPrice.value))
    {
        productPriceTypeError = 301;
        return true;
    }
    else if(parseFloat(inputs.productPrice.value) < 0)
    {
        productPriceTypeError = 302;
        return true;
    }
    return false;
}

function PaintError(message)
{
    Swal.fire({
        title: 'Error!',
        text: message,
        icon: 'error',
        confirmButtonText: 'Entendido'
    })
}