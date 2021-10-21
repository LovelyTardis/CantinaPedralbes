let productButtons = document.getElementById('product-box');
let ticketNode = document.getElementById('ticket');
let buyButton = document.getElementById("purchase-button");
let unitMessage = " ud/s."
let menuList = JSON.parse(document.getElementById('JsonProducts').value);

let purchaseButton = document.getElementById('purchase');

//errors
const error200 = "La cesta esta vacia";
//
let basketEmpty = true;
let totalPrice = 0;
let basket = [];
var coinType= "€";

var basketProductObject = {
    productId: null,
    quantity: 0
};


document.getElementById('purchase-button').addEventListener('click', e => {
    GenerateJsonWithProducts();
});

productButtons.addEventListener('click', e => {
    if(e.target.classList.contains('increase')){
        Increase(e.target);
    }
    else if(e.target.classList.contains('decrease')){ 
        Decrease(e.target);
    }

});

/**
 * 
 * @param {*} buttonNode 
 */
function Increase(buttonNode)
{
    let nodeBox = buttonNode.closest(".cell-product");
    let productObj = getProductById(nodeBox.id);

    let index = basket.findIndex(product => product.productId == productObj['id']);
    if(index > -1)
    {
        UpdateBasket(productObj,(basket[index].quantity + 1));
    }
    else
    {
        UpdateBasket(productObj, 1);
        index = basket.findIndex(product => product.productId == productObj['id']);

        //Check if enable button needed
        let decreaseButton = nodeBox.querySelector("button.decrease");
        decreaseButton.removeAttribute("disabled");
        
    }
    let quantityNode = nodeBox.querySelector(".quantity-value"); //quantitat de producte
    quantityNode.innerHTML = basket[index].quantity + unitMessage; 

    UpdateTicket(productObj, basket[index].quantity, 0);
}
/**
 * This function add the functionality decrease of the product box
 * @param {*} buttonNode 
 */
function Decrease(buttonNode)
{
    let nodeBox = buttonNode.closest(".cell-product");
    let quantityNode = nodeBox.querySelector(".quantity-value");
    let productObj = getProductById(nodeBox.id);

    let index = basket.findIndex(product => product.productId == productObj['id']);
    if(index > -1)
    {
        UpdateBasket(productObj,(basket[index].quantity - 1));
        index = basket.findIndex(product => product.productId == productObj['id']);
    }
    //Check if disable button needed
    if(index == -1)
    {
        buttonNode.setAttribute("disabled","");
         quantityNode.innerHTML =  0 + unitMessage;
    } 
    let tempVar = (index == -1 ? 0 : basket[index].quantity);
    quantityNode.innerHTML = tempVar + unitMessage;
    UpdateTicket(productObj,tempVar, 1);
}

/**
 * 
 * @param {*} product - Product Object
 * @param {*} quantity - Quantity of the product
 * @param {*} option - 0 => AddToTicket | 1 => RemoveFromTicket
 */
function UpdateTicket(product, quantity, option)
{
    productNode = document.getElementById("Ticket-"+product['id']);
    switch (option) {
        case 0:
            if(productNode == null) {
                let newProduct = document.createElement('div');
                newProduct.setAttribute("id", ("Ticket-"+product['id']));
                newProduct.setAttribute("class", "product-in-ticket");
        
        
                let thisProductName = document.createElement('div');
                thisProductName.setAttribute("class", "ticket-product-name");
                thisProductName.innerHTML = product['productName'];
                newProduct.appendChild(thisProductName);
        
                let thisProductTotalPrice = document.createElement('div');
                thisProductTotalPrice.setAttribute("class", "ticket-product-price");
                thisProductTotalPrice.innerHTML = (product['price']*quantity);
                newProduct.appendChild(thisProductTotalPrice);
        
                let thisProductQuantity = document.createElement('div');
                thisProductQuantity.setAttribute("class", "ticket-product-quantity");
                thisProductQuantity.innerHTML = quantity;
                newProduct.appendChild(thisProductQuantity);
        
                ticketNode.appendChild(newProduct);
                if(basketEmpty){ basketEmpty = false; }  // llamamos a la function para que ponga en true bas
            }
            else {
                UpdateProductsOfTicket(product, quantity, productNode);
            }
            break;
        case 1:
            if(quantity == 0){
                productNode.remove();
                CheckBasketEmpty();
            }
            else{
                UpdateProductsOfTicket(product, quantity, productNode);
            }    
            break;
        default:
            return false;
    }
    UpdateTotalPrice(productNode, product, quantity);
}
/**
 * 
 * @param {*} product - Product object.
 * @param {*} quantity - Bew quantity of the product.
 * @param {*} productNode - HTML node in ticket.
 */
function UpdateProductsOfTicket(product, quantity, productNode)
{
    
    let thisProductName = productNode.querySelector(".ticket-product-name");
    let thisProductTotalPrice = productNode.querySelector(".ticket-product-price");
    let thisProductQuantity = productNode.querySelector(".ticket-product-quantity");
    
    thisProductName.innerHTML = product['productName'];
    thisProductTotalPrice.innerHTML = (product['price']*quantity)+coinType;
    thisProductQuantity.innerHTML = quantity;
}
/**
 * Looks if there is something to buy on the ticket, (if empty => set basketEmpty {true})
 */
function CheckBasketEmpty()
{
    if(document.querySelectorAll(".product-in-ticket").length == 0)
    {
        basketEmpty = true;
    }
}
function UpdateBasket(productObj, quantity)
{
    basketItem = basket.find(item => item.productId == productObj['id']);
    if(basketItem == undefined)
    {
        let bpo = Object.create(basketProductObject);
        bpo.productId = parseInt(productObj['id']);
        bpo.quantity = parseInt(quantity);
        basket.push(bpo);
    }
    else if(quantity <= 0)
    {
        let index = basket.findIndex(product => product.productId == productObj['id']);
        if (index > -1) {
            basket.splice(index, 1);
        }
    }
    else
    {
        basketItem.quantity = quantity;
    }
}
///se tiene que editar
function GenerateJsonWithProducts()
{
    if(!basketEmpty)
    {
        document.getElementById("basket-product-php").value=JSON.stringify(basket);
        purchaseButton.submit();
    }
    else
    {
        Swal.fire({
            title: 'Oh no!',
            text: error200,
            icon: 'error',
            confirmButtonText: 'Entendido'
        });
    }
}
/// 

function UpdateTotalPrice()
{
    let total = 0;
    if(basket.length > 0)
    {
        for (let x = 0; x < basket.length; x++) {
            let productObj = getProductById(basket[x].productId);
            total += productObj.price * basket[x].quantity;
        }    
    }
    document.getElementById("total-price").innerHTML = total+coinType;
}

/**
 * 
 * @param {*} id - Identifier of the product you want to get.
 * @returns The product on the menuList
 */
function getProductById(id) {
    return menuList.find(
        function(menuList){ return menuList.id == id }
    );
}
  
