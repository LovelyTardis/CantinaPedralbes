let productButtons = document.getElementById('product-box');
let ticketNode = document.getElementById('ticket');

menu = JSON.parse(document.getElementById('JsonProducts').value);
console.log(menu);

productButtons.addEventListener('click', e => {
    if(e.target.classList.contains('Increase')){
        Increase(e.target.parentNode);
    }
    else if(e.target.classList.contains('Decrease')){ 
        Decrease(e.target,e.target.parentNode);
    }
  });


function Increase(parent)
{
    let quantity = parent.querySelector("p > span");

    if(parseInt(quantity.innerHTML) == 0)
    {
        let decreaseButton = parent.querySelector("p>button.Decrease");
        decreaseButton.removeAttribute("disabled");
    }
    quantity.innerHTML = parseInt(quantity.innerHTML)+1;
    console.log("Increase");
    AddToTicket(quantity.id, parseInt(quantity.innerHTML), quantity.getAttribute("price"));
}
function Decrease(button, parent)
{
    let quantity = parent.querySelector("p > span");
    quantity.innerHTML =  parseInt(quantity.innerHTML)-1;
    console.log("Decrease");
    if(parseInt(quantity.innerHTML) <= 0)
    {
        button.setAttribute("disabled","");
        // Por si acaso
        quantity.innerHTML = "0";
    } 
    RemoveFromTicket(quantity.id, parseInt(quantity.innerHTML), quantity.getAttribute("price"))
}


function AddToTicket(id, quantity, price)
{
    productNode = document.getElementById("Ticket-"+id);
    if(productNode == null)
    {
        let newProduct = document.createElement('div');
        newProduct.setAttribute("id", ("Ticket-"+id));
        newProduct.innerHTML = `${id} | ${price} | ${quantity}€`;
        ticketNode.appendChild(newProduct);
    }
    else
    {
        productNode.innerHTML = `${id} | ${parseFloat(price)*quantity}€ | ${quantity}`;
    }
}

function RemoveFromTicket(id, quantity, price)
{
    productNode = document.getElementById("Ticket-"+id);
    if(quantity == 0)
    {
        productNode.remove();
    }
    else
    {
        productNode.innerHTML = `${id} | ${parseFloat(price)*quantity} | ${quantity}€`;
    }
}