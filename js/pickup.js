let productButtons = document.getElementById('products');
console.log(productButtons);

productButtons.addEventListener('click', e => {
    if(e.target.classList.contains('Increase')){
      //document.getElementById("i"+e.target.parentNode.id).value = parseInt(document.getElementById("i"+e.target.parentNode.id).value) + 1;
        Increase(e.target.parentNode);
    }
    else if(e.target.classList.contains('Decrease')){
      //document.getElementById("i"+e.target.parentNode.id).value = parseInt(document.getElementById("i"+e.target.parentNode.id).value) < 1 ? 0 : (parseInt(document.getElementById("i"+e.target.parentNode.id).value) - 1);
        Decrease(e.target,e.target.parentNode);
    }
  });


function Increase(parent)
{
    let presio = parent.querySelector("td > span");
    if(parseInt(presio.innerHTML) == 0)
    {
        let decreaseButton = parent.querySelector("td>button.Decrease");
        decreaseButton.removeAttribute("disabled");
    }
    presio.innerHTML = parseInt(presio.innerHTML)+1;
    console.log("Increase");
}
function Decrease(button, parent)
{
    let presio = parent.querySelector("td > span");
    presio.innerHTML =  parseInt(presio.innerHTML)-1;
    console.log("Decrease");
    if(parseInt(presio.innerHTML) <= 0)
    {
        button.setAttribute("disabled","");
        // Por si acaso
        presio.innerHTML = "0";
    } 
}