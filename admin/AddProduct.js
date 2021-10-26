
let newProductForm = document.getElementById('newProduct');
let addProductButton = document.getElementById('AddButton');
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

console.log(inputs);

function CheckForm()
{
    if(inputs.productId.value == "")
    {
        allOk = false;
        Swal.fire({
            title: 'Error!',
            text: 'haha1',
            icon: 'error',
            confirmButtonText: 'Entendido'
        })
    }
    else if(inputs.productName.value == "")
    {
        allOk = false;
        Swal.fire({
            title: 'Error!',
            text: 'haha2',
            icon: 'error',
            confirmButtonText: 'Entendido'
        })
    }
    else if(isNaN(inputs.productPrice.value))
    {
        allOk = false;
        Swal.fire({
            title: 'Error!',
            text: 'haha3',
            icon: 'error',
            confirmButtonText: 'Entendido'
        })
    }
    else
    {
       newProductForm.submit(); 
    }
}