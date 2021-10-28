let productButtons = document.getElementById('product-list');
let senderJson = document.getElementById('senderJson');
console.log(senderJson);

//Back button funtionality
document.getElementById("back-button").addEventListener('click',()=>{
  Back("/administration.php");
});
function Back(url){
  window.location.href = document.URL.substr(0,document.URL.lastIndexOf('/'))+url;
};
//

let popUpRemove = {
  questionTitle: 'Esborrar?',
  questionMessage:  'Estas segur de voler <b>ELIMINAR</b> aquest producte?<hr>',
  confirmationTitle: 'Esborrat!',
  confirmationMessage: 'El producte ha estat esborrat correctament'
};

let popUpActivate = {
  questionTitle: 'Activar?',
  questionMessage:  'Estas segur de voler <b>ACTIVAR</b> aquest producte?<hr>',
  confirmationTitle: 'Activat!',
  confirmationMessage: 'El producte ha estat activat correctament'
};

let popUpDeactivate = {
  questionTitle: 'Desactivar?',
  questionMessage:  'Estas segur de voler <b>DESACTIVAR</b> aquest producte?<hr>',
  confirmationTitle: 'Desactivat!',
  confirmationMessage: 'El producte ha estat desactivat correctament'
};

let serverProducts = JSON.parse(senderJson.value);
console.log(serverProducts);
productButtons.addEventListener('click', e => {
    let nodeBox = e.target.closest(".cell-product");
    let productObj = getProductById(nodeBox.id);
    let index = serverProducts.findIndex(product => product.id == productObj['id']);
    if(e.target.classList.contains('remove')){
        RemoveObject(nodeBox, productObj, index);
    }
    else if(e.target.classList.contains('activate-product')){
        ActivateProduct(productObj, index);
    }
    else if(e.target.classList.contains('deactivate-product')){
        DeactivateProduct(productObj, index);
    }
});

function RemoveObject(nodeBox, productObj, index){
    if(index > -1)
    {
      ConfirmationPopUp(popUpRemove, productObj);
      serverProducts.splice(index, 1);
      nodeBox.remove();
    }
}

function ActivateProduct(productObj , index){
  ConfirmationPopUp(popUpActivate, productObj);
  serverProducts[index].activated = 1;   
}

function DeactivateProduct(productObj, index){
  ConfirmationPopUp(popUpDeactivate, productObj);
  serverProducts[index].activated = 0; 
}

/**
 * 
 * @param {*} id - Identifier of the product you want to get.
 * @returns The product on the menuList
 */
 function getProductById(id) {
    return serverProducts.find(
        function(serverProducts){ return serverProducts.id == id }
    );
}

/**
 * 
 * @param {*} questionPopUp Message of the popup
 * @param {*} productName Product name to show in the message 
 */
function ConfirmationPopUp(questionPopUp, productObj)
{
  Swal.fire({
    title: questionPopUp.questionTitle,  
    html: questionPopUp.questionMessage + productObj.productName,
    imageUrl: productObj.imageId,
    icon: 'warning',
    imageWidth: 400,
    imageHeight: 400,
    imageAlt: 'Custom image',
    showCancelButton: true,
    cancelButtonText: 'Cancel·lar',
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Confirmar'
  }).then((result) => {
    if (result.isConfirmed) {
      Swal.fire(
        questionPopUp.confirmationTitle,
        questionPopUp.confirmationMessage,
        'success'
      ) 
      UpdateProducJson();
    }
  })
}

function UpdateProducJson()
{
    senderJson.value = JSON.stringify(serverProducts, true);
}