let productButtons = document.getElementById('product-box');
let ticketNode = document.getElementById('ticket');

menuList = JSON.parse(document.getElementById('JsonProducts').value);


productButtons.addEventListener('click', e => {
    if(e.target.classList.contains('Increase')){
        Increase(e.target);
    }
    else if(e.target.classList.contains('Decrease')){ 
        Decrease(e.target);
    }
  });


function Increase(button)
{
    let quantityNode = document.getElementById("quantity-"+button.value); //quantitat de producte
    let productObj = getProductById(button.value);
    if(parseInt(quantityNode.innerHTML) == 0)
    {
        let decreaseButton = document.getElementById("button-decrease-"+button.value);
        decreaseButton.removeAttribute("disabled");
    }
    quantityNode.innerHTML = parseInt(quantityNode.innerHTML)+1; // añadimos +1 a la cantidad

    AddToTicket(productObj, parseInt(quantityNode.innerHTML));
}
function Decrease(button)
{
    let quantityNode = document.getElementById("quantity-"+button.value);
    let productObj = getProductById(button.value);

    quantityNode.innerHTML =  parseInt(quantityNode.innerHTML)-1;  // restamos -1 a la cantidad
    
    if(parseInt(quantityNode.innerHTML) <= 0)
    {
        button.setAttribute("disabled","");
        // Por si acaso
        quantityNode.innerHTML = "0";
    } 
    RemoveFromTicket(productObj,parseInt(quantityNode.innerHTML));
}


function AddToTicket(product, quantity)
{
    console.log(product['id']);
    productNode = document.getElementById("Ticket-"+product['id']);
    if(productNode == null)
    {
        let newProduct = document.createElement('div');
        newProduct.setAttribute("id", ("Ticket-"+product['id']));
        newProduct.innerHTML = `${product['id']} | ${product['price']} | ${quantity}€`;
        ticketNode.appendChild(newProduct);
    }
    else
    {
        productNode.innerHTML = `${product['id']} | ${parseFloat(product['price'])*quantity}€ | ${quantity}`;
    }
}

function RemoveFromTicket(product, quantity)
{
    productNode = document.getElementById("Ticket-"+product['id']);
    if(quantity == 0)
    {
        productNode.remove();
    }
    else
    {
        productNode.innerHTML = `${product['id']} | ${parseFloat(product['price'])*quantity} | ${quantity}€`;
    }
}

function getProductById(id) {
    return menuList.find(
        function(menuList){ return menuList.id == id }
    );
  }
  