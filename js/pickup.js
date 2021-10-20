let productButtons = document.getElementById('product-box');
let ticketNode = document.getElementById('ticket');
let buyButton = document.getElementById("purchase-button");
let basketEmpty = true;
let totalPrice = 0;
let basket = [];
var coinType= "€";

var basketProductObject = {
    productId: 0,
    quantity: 0
};
let menuList = JSON.parse(document.getElementById('JsonProducts').value);

document.getElementById('purchase-button').addEventListener('click', e => {
        ThingsToBuy();
});

productButtons.addEventListener('click', e => {
    if(e.target.classList.contains('increase')){
        Increase(e.target);
    }
    else if(e.target.classList.contains('decrease')){ 
        Decrease(e.target);
    }

});


function Increase(buttonNode)
{
    let nodeBox = buttonNode.closest(".cell-product");
    let quantityNode = nodeBox.querySelector(".quantity-value"); //quantitat de producte
    let productObj = getProductById(nodeBox.id);

    if(parseInt(quantityNode.innerHTML) == 0)
    {
        let decreaseButton = nodeBox.querySelector("button.decrease");
        decreaseButton.removeAttribute("disabled");
    }
    quantityNode.innerHTML = parseInt(quantityNode.innerHTML)+1; // añadimos +1 a la cantidad

    UpdateTicket(productObj, parseInt(quantityNode.innerHTML), 0);
}

function Decrease(buttonNode)
{
    let nodeBox = buttonNode.closest(".cell-product");
    let quantityNode = nodeBox.querySelector(".quantity-value");
    let productObj = getProductById(quantityNode.closest(".cell-product").id);

    quantityNode.innerHTML =  parseInt(quantityNode.innerHTML)-1;  // restamos -1 a la cantidad
    
    if(parseInt(quantityNode.innerHTML) <= 0)
    {
        buttonNode.setAttribute("disabled","");
    } 
    UpdateTicket(productObj,parseInt(quantityNode.innerHTML), 1);
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
            totalPrice +=  parseFloat(product['price']);
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
                CheckBasketEmpty();
            }
            else {
                UpdateProductOfTicket(product, quantity, productNode);
            }
            break;
        case 1:
            totalPrice -= parseFloat(product['price']);
            if(quantity == 0){
                productNode.remove();
                CheckBasketEmpty();
            }
            else{
                UpdateProductOfTicket(product, quantity, productNode);
            }    
            break;
        default:
            break;
    }
    UpdateTotalPrice(productNode,product, quantity);
}
function CheckBasketEmpty()
{
    if(document.querySelectorAll(".product-in-ticket").length == 0)
    {
        basketEmpty = true;
    }
    else if(basketEmpty == true)
    {
        basketEmpty = false;
    }
}

function UpdateProductOfTicket(product, quantity, productNode)
{
    let thisProductName = productNode.querySelector(".ticket-product-name");
    let thisProductTotalPrice = productNode.querySelector(".ticket-product-price");
    let thisProductQuantity = productNode.querySelector(".ticket-product-quantity");
    
    thisProductName.innerHTML = product['productName'];
    thisProductTotalPrice.innerHTML = (product['price']*quantity)+coinType;
    thisProductQuantity.innerHTML = quantity;
}

///se tiene que editar
function ThingsToBuy()
{
    if(!basketEmpty)
    {
        let ticketProducts = ticketNode.querySelectorAll(".product-in-ticket");

        for (let x = 0; x < ticketProducts.length; x++) {
            console.log(ticketProducts[x]);
            let bpo = Object.create(basketProductObject);
            bpo.productId = parseInt(ticketProducts[x].id.substr(7));
            bpo.quantity = parseInt(ticketProducts[x].querySelector(".ticket-product-quantity").innerHTML);
            basket.push(bpo);
        }
        console.log(ticketProducts);
        console.log(basket);
    
        document.getElementById("basket-product-php").value=JSON.stringify(basket);
    }
    else
    {
        alert("No es pot comprar res si la cesta esta buida");
    }
}
/// 

function UpdateTotalPrice()
{
    document.getElementById("total-price").innerHTML = totalPrice+coinType;
}

function getProductById(id) {
    return menuList.find(
        function(menuList){ return menuList.id == id }
    );
}
  
