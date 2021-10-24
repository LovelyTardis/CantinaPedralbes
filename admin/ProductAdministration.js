let productButtons = document.getElementById('product-list');
let senderJson = document.getElementById('senderJson');
console.log(senderJson);
const question100 = "Estas seguro de querer eliminar este producto: ";
const question101 = "Estas seguro de querer activar este producto: ";
const question102 = "Estas seguro de querer desactivar este producto: ";
const confirmation100 = "El producto ha sido eliminado correctamente";
const confirmation101 = "El producto se ha activado correctamente";
const confirmation102 = "El producto se ha desactivado correctamente";
let serverProducts = JSON.parse(senderJson.value);
console.log(serverProducts);
productButtons.addEventListener('click', e => {
    if(e.target.classList.contains('remove')){
        RemoveObject(e.target);
    }
    else if(e.target.classList.contains('activate-product')){
        ActivateProduct(e.target);
    }
    else if(e.target.classList.contains('deactivate-product')){
        DeactivateProduct(e.target);
    }
});

function RemoveObject(button)
{
    let nodeBox = button.closest(".cell-product");
    let productObj = getProductById(nodeBox.id);

    let index = serverProducts.findIndex(product => product.id == productObj['id']);
    if(index > -1)
    {
        Swal.fire({
            title: 'Are you sure?',
            text: question100 + serverProducts[index].productName,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Confirmar'
          }).then((result) => {
            if (result.isConfirmed) {
              Swal.fire(
                'Deleted!',
                confirmation100,
                'success'
              )
              nodeBox.remove();
              serverProducts.splice(index, 1);
              BuildJson()
            }
          })
    }
}


function ActivateProduct(button)
{
    let nodeBox = button.closest(".cell-product");
    let productObj = getProductById(nodeBox.id);

    let index = serverProducts.findIndex(product => product.id == productObj['id']);
    if(index > -1)
    {
        Swal.fire({
            title: 'Are you sure?',
            text: question101 + serverProducts[index].productName,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Confirmar'
          }).then((result) => {
            if (result.isConfirmed) {
              Swal.fire(
                'Deleted!',
                confirmation101,
                'success'
              )
              serverProducts[index].activated = 1;
              BuildJson();
            }
          })
    }
}
function DeactivateProduct(button)
{
    let nodeBox = button.closest(".cell-product");
    let productObj = getProductById(nodeBox.id);

    let index = serverProducts.findIndex(product => product.id == productObj['id']);
    if(index > -1)
    {
        Swal.fire({
            title: 'Are you sure?',
            text: question102 + serverProducts[index].productName,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Confirmar'
          }).then((result) => {
            if (result.isConfirmed) {
              Swal.fire(
                'Deleted!',
                confirmation102,
                'success'
              )
              serverProducts[index].activated = 0;
              BuildJson();
            }
          })
    }
}

function BuildJson()
{
    senderJson.value = JSON.stringify(serverProducts, true);
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