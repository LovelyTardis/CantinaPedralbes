let productButtons = document.getElementById('products');
let ticketNode = document.getElementById('ticket');
console.log(productButtons);

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
    let quantity = parent.querySelector("td > span");

    if(parseInt(quantity.innerHTML) == 0)
    {
        let decreaseButton = parent.querySelector("td>button.Decrease");
        decreaseButton.removeAttribute("disabled");
    }
    quantity.innerHTML = parseInt(quantity.innerHTML)+1;
    console.log("Increase");
    AddToTicket(quantity.id, parseInt(quantity.innerHTML), quantity.getAttribute("price"));
}
function Decrease(button, parent)
{
    let quantity = parent.querySelector("td > span");
    quantity.innerHTML =  parseInt(quantity.innerHTML)-1;
    console.log("Decrease");
    if(parseInt(presio.innerHTML) <= 0)
    {
        button.setAttribute("disabled","");
        // Por si acaso
        quantity.innerHTML = "0";
    } 
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

function RemoveFromTicket()
{

}