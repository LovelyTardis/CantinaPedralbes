console.log(document.getElementById("navigation"));
document.getElementById("navigation").addEventListener('click',(e)=>{
    if(e.target.getAttribute('id') == "product-admin"){
        Redirect("/AddProduct.php");
    }
    else if(e.target.getAttribute('id') == "product-manage"){
        Redirect("/ProductManagement.php");
    }
    else if(e.target.getAttribute('id') == "ticket-admin"){
        Redirect("/TicketList.php");
    }
});
function Redirect(url){
    window.location.href = document.URL.substr(0,document.URL.lastIndexOf('/'))+url;
};