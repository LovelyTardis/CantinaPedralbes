window.onload = function() {
    LoadProducts();
};



let productButtons = document.getElementById('product-box'); //nodo donde se encuentran los productos cargados por php
let ticketNode = document.getElementById('ticket'); //nodo donde se encuentra la informacion del tiquet
let buyButton = document.getElementById("purchase-button"); //boton de comprar
let form = document.getElementById("form-basket"); //formulario con la cesta que utilizare para controlar el submit.

let basketJson = document.getElementById("basket-product-php").value; //input hidden donde mandaremos el json de productos para utilizar-lo en el siguiente php.

let menuList = JSON.parse(document.getElementById('JsonProducts').value);


//errors
const error200 = "La cesta esta vacia";


//cesta de productos en cliente
let basket = [];

//Carga los productos a la cesta, en caso de tener un pedido en $_SESSION
function LoadProducts()
{
    basket = JSON.parse(basketJson);
    console.log(basket);
}

//Plantilla para añadir productos a la cesta
var basketProductObject = {
    productId: null,
    quantity: 0
};


// constant variables
const coinType= "€";
const unitMessage = " ud/s"

document.getElementById('purchase-button').addEventListener('click', (e) => {
    GenerateJsonWithProducts();
});

/**
 * Se añade la funcionalidad a los botones increase i decrease.
 */
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
    if(index > -1)// si encuentra el producto, no lo crea, lo actualiza
    {
        UpdateBasket(productObj,(basket[index].quantity + 1));
    }
    else// en caso contrario crea 
    {
        //se envia con valor default 1 ya que si no existe, lo queremos añadir por primera vez, osea la cantidad va a ser 1 siempre, ademas de que se añadira al array basket
        UpdateBasket(productObj, 1);
        //como este producto no existia en el array basket, al crearlo, necessitamos coger su KEY sobre el array, para eso volvemos a buscarlo.
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
    let quantityOfProduct = (index == -1 ? 0 : basket[index].quantity); // busca si el producto existe en la cesta "basket" en caso de no existir pone un 0.
    quantityNode.innerHTML = quantityOfProduct + unitMessage;
    UpdateTicket(productObj,quantityOfProduct, 1);
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

                let thisProductQuantity = document.createElement('div');
                thisProductQuantity.setAttribute("class", "ticket-product-quantity");
                thisProductQuantity.innerHTML = (quantity+"x");
        
                let thisProductName = document.createElement('div');
                thisProductName.setAttribute("class", "ticket-product-name");
                thisProductName.innerHTML = product['productName'];
                
        
                let thisProductTotalPrice = document.createElement('div');
                thisProductTotalPrice.setAttribute("class", "ticket-product-price");
                thisProductTotalPrice.innerHTML = (product['price']*quantity).toFixed(2)+"€";

                newProduct.appendChild(thisProductQuantity);
                newProduct.appendChild(thisProductName);
                newProduct.appendChild(thisProductTotalPrice);
        
                ticketNode.appendChild(newProduct);  // llamamos a la function para que ponga en true bas
            }
            else {
                UpdateNodeFromTicket(product, quantity, productNode);
            }
            break;
        case 1:
            if(quantity == 0){ // si al hacer "decrease" la cantidad es de 0, queremos quitarlo del ticket
                productNode.remove();
            }
            else{// en caso de ser mayor a 0, actualizamos el producto del ticket
                UpdateNodeFromTicket(product, quantity, productNode);
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
function UpdateNodeFromTicket(product, quantity, productNode)
{ 
    let thisProductTotalPrice = productNode.querySelector(".ticket-product-price");
    let thisProductQuantity = productNode.querySelector(".ticket-product-quantity");
    
    thisProductTotalPrice.innerHTML = (product['price']*quantity).toFixed(2)+coinType;
    thisProductQuantity.innerHTML = (quantity+"x");
}

/**
 * 
 * @param {*} productObj - Product To add/remove.
 * @param {*} quantity - Quantity of the product.
 */
function UpdateBasket(productObj, quantity)
{
    basketItem = basket.find(item => item.productId == productObj['id']);
    if(basketItem == undefined) //si no existe en el array de la cesta, lo creamos
    {
        let bpo = Object.create(basketProductObject); //bpo => basketProductObject
        bpo.productId = parseInt(productObj['id']);
        bpo.quantity = parseInt(quantity);
        basket.push(bpo);
    }
    else if(quantity <= 0)// si existe pero se ha reducido a 0, lo eliminamos de la cesta
    {
        let index = basket.findIndex(product => product.productId == productObj['id']);
        if (index > -1) {
            basket.splice(index, 1);
        }
    }
    else //en caso de ninguno de las dos anteriores, actualizamos la con la nueva cantidad
    {
        basketItem.quantity = quantity;
    }
    console.log(basket);
}

/**
 * se llama cuando le damos al boton comprar, carga en JSON el input hidden con todos los productos que vamos a comprar
 */ 
function GenerateJsonWithProducts()
{
    console.log(basket);
    if(basket.length > 0)
    {
        document.getElementById("basket-product-php").value = JSON.stringify(basket);
        form.submit();
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

/**
 * Actualiza el precio total de la compra.
 */
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
    document.getElementById("total-price").innerHTML = total.toFixed(2)+coinType;
}

/**
 * 
 * @param {*} id - Identifier of the product you want to get.
 * @returns The product from the menuList
 */
function getProductById(id) {
    return menuList.find(
        function(menuList){ return menuList.id == id }
    );
}
  
