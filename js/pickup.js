let productButtons = document.getElementById('product-box');
let ticketNode = document.getElementById('ticket');
let buyButton = document.getElementById("purchase-button");

let menuList = JSON.parse(document.getElementById('JsonProducts').value);
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
/**
 * This function add the functionality decrease of the product box
 * @param {*} buttonNode 
 */
function Decrease(buttonNode)
{
    let nodeBox = buttonNode.closest(".cell-product");
    let quantityNode = nodeBox.querySelector(".quantity-value");
    let productObj = getProductById(nodeBox.id);

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
                if(basketEmpty){ basketEmpty = false; }  // llamamos a la function para que ponga en true bas
            }
            else {
                UpdateProductsOfTicket(product, quantity, productNode);
            }
            break;
        case 1:
            totalPrice -= parseFloat(product['price']);
            if(quantity == 0){
                productNode.remove();
                if(CheckBasketEmpty())
                {
                    //desactivamos el boton de comprar
                }
            }
            else{
                UpdateProductsOfTicket(product, quantity, productNode);
            }    
            break;
        default:
            return false;
    }
    UpdateTotalPrice(productNode,product, quantity);
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

///se tiene que editar
function GenerateJsonWithProducts()
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
    document.getElementById("total-price").innerHTML = totalPrice+coinType;
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
  
