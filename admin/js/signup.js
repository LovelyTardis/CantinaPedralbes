//Back button funtionality
document.getElementById("back-button").addEventListener('click',()=>{
    Back("/logAdmin.php");
});
function Back(url){
    window.location.href = document.URL.substr(0,document.URL.lastIndexOf('/'))+url;
};
//