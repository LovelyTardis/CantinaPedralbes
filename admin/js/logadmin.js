//Back button funtionality
document.getElementById("back-button").addEventListener('click',()=>{
    Back("/index.php");
});
function Back(url){
    window.location.href = document.URL.substr(0,document.URL.lastIndexOf('/admin/'))+url;
};
//