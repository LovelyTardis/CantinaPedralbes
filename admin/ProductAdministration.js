let productButtons = document.getElementById('product-list');
let senderJson = document.getElementById('senderJson');
console.log(senderJson);
let serverProducts = JSON.parse(senderJson.value);
productButtons.addEventListener('click', e => {
    if(e.target.classList.contains('remove')){
        RemoveObject(e.target);
    }
});

function RemoveObject(button)
{
    console.log(senderJson.value);
    let nodeBox = buttonNode.closest(".cell-product");
    let productObj = getProductById(nodeBox.id);

    let index = basket.findIndex(product => product.productId == productObj['id']);
}

function BuildJson()
{
    
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