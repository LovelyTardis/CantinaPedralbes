<?php
  $imageErrorMessage = "";
  if($_SERVER["REQUEST_METHOD"] == "POST")
  {
    $newProduct = array("id"=>null, "allowed"=>null, "activated" => null, "productName"=> null, "imageId" => null,"price"=>null);
    CheckProductId();
    CheckProductName();
    CheckProductPrice();
    CheckActivation();
    CheckSchedule();
    if($_FILES["ImageName"]["error"] == 0) //significa que se ha subido una imagen si o si
    {
      $target_dir = "../assets/images/";
      $target_file = $target_dir . basename($_FILES["ImageName"]["name"]);
      if(CheckImage($target_file))
      {
        UploadImage($target_file);
      }
      /*else
      {
        $GLOBALS['imageErrorMessage'] = "Sorry, your file was not uploaded.";
      }*/
    }
    TryUpload();
    print_r($newProduct);
    $str = "";
    $str .= "<h1>New Product</h1>";
    $str .= "<div>".$_POST['productId']."</div>";
    $str .= "<div>".$_POST['productName']."</div>";
    print_r($_FILES["ImageName"]);
    $str .= "<div></div>";
    $str .= "<div>".$_POST['isActived']."</div>";
    $str .= "<div>".$_POST['schedule']."</div>";
    $str .= "<div>".$_POST['productPrice']."</div>";
    echo $str;
  }

  function CheckProductId()
  {
    if($_POST['productId'] == '')
    {
      echo 'La id no puede estar vacia';
    }
    else if(!is_numeric($_POST['productId']))
    {
      echo 'La id no puede tener letras/caracteres';
    }
    else
    {
      $GLOBALS['newProduct']['id'] = $_POST['productId'];
    }
  }
  function CheckProductName()
  {
    if($_POST['productName'] == '')
    {
      echo 'El nombre del producto no puede estar vacio';
    }
    else if(!is_numeric($_POST['productName']))
    {
      echo 'El precio tiene que ser un numero';
    }
    else
    {
      $GLOBALS['newProduct']['productName'] = $_POST['productName'];
    }
  }
  function CheckActivation()
  {
    if(!is_numeric($_POST['isActived']))
    {
      echo 'El Horario introducido no es correcto';
    }
    else
    {
      $GLOBALS['newProduct']['activated'] = $_POST['isActived'];
    }
  }
  function CheckSchedule()
  {
    if(!is_numeric($_POST['schedule']))
    {
      echo 'El Horario introducido no es correcto';
    }
    else
    {
      $GLOBALS['newProduct']['allowed'] = $_POST['schedule'];
    }
  }
  function CheckProductPrice()
  {
    if($_POST['productPrice'] == '')
    {
      echo 'El precio del producto no puede estar vacio';
    }
    else if(is_numeric($_POST['productPrice']) == false)
    {
      echo 'El precio del producto tiene que ser numerico';
      echo $_POST['productPrice'];
    }
    else
    {
      $GLOBALS['newProduct']['price'] = $_POST['productPrice'];
    }
  }
  function CheckImage($target_file)
  {
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    
    // Check if image file is a actual image or fake image
    if(isset($_POST["submit"])) {
      $check = getimagesize($_FILES["ImageName"]["tmp_name"]);
      if($check !== false) {
        $GLOBALS['imageErrorMessage'] = "File is an image - " . $check["mime"] . ".";
      } else {
        $GLOBALS['imageErrorMessage'] = "File is not an image.";
        return false;
      }
    }
    
    // Check if file already exists
    if (file_exists($target_file)) {
      $GLOBALS['imageErrorMessage'] = "Sorry, file already exists.";
      return false;
    }       
    
    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
      $GLOBALS['imageErrorMessage'] = "Sorry, only JPG, JPEG, PNG files are allowed.";
      return false;
    }
    // if everything is ok, try to upload file

      if (move_uploaded_file($_FILES["ImageName"]["tmp_name"], $target_file)) {
        $GLOBALS['imageErrorMessage'] = "The file ". htmlspecialchars( basename( $_FILES["ImageName"]["name"])). " has been uploaded.";
        $GLOBALS['newProduct']['imageId'] = $target_file;
      } else {
        $GLOBALS['imageErrorMessage'] = "Sorry, there was an error uploading your file.";
      }
  }
  function UploadImage($target_file)
  {
    if (move_uploaded_file($_FILES["ImageName"]["tmp_name"], $target_file)) {
      $newProduct['imageId'] = htmlspecialchars($target_file);
    } else {
      $GLOBALS['imageErrorMessage'] = "Sorry, there was an error uploading your file.";
    }
  }

  function TryUpload()
  {
    $allOk = true;
    foreach($GLOBALS['newProduct'] as $key => $value){
      if(is_null($value))
      {
        $allOk = false;
      }
    }
    
    if($allOk)
    {
      $fileName = "../products.json";
      $jsonProducts = file_get_contents($fileName);
      $productsObject = json_decode($jsonProducts,true);
      array_push($productsObject, $GLOBALS['newProduct']);
      file_put_contents($fileName, json_encode($productsObject, JSON_PRETTY_PRINT));
    }
  }
?>

<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="/SweetAlert2/dist/sweetalert2.all.min.js"></script>
    <title>Document</title>
</head>
<body>
    <form id="newProduct" method="POST" action="./AddProduct.php" enctype="multipart/form-data">
        <div><span><label for="productId">Id del producto:</label></span><span><input type="text" name="productId" id="productId" value=""></span></div>
        <div><span><label for="productName">Nombre del producto</label></span><span><input type="text" name="productName" id="productName" value=""></span></div>
        <div><span><label for="ImageName">Imagen del producto</label></span><span><input type="file" accept=".png, .jpg, .jpeg" name="ImageName" value=""></span><span><?php  echo $GLOBALS['imageErrorMessage'] ?></span></div>
        <div>
            <span><label for="isActived"></label></span>
            <span>        
                <select name="isActived" id="isActived">
                    <option value="1">Activado</option>
                    <option value="0">Desactivado</option>
                </select>
            </span>
        </div>
        <div>
            <span><label for="schedule">Horario:</label></span>
            <span>        
                <select name="schedule" id="schedule">
                    <option value="0">Mañana</option>
                    <option value="1">Tarde</option>
                    <option value="2">Siempre</option>
                </select>
            </span>
        </div>
        <div>
            <span><label for="productPrice">Precio del producto:</label></span>
            <span><input type="text" name="productPrice" id="productPrice" value=""></span>
        </div>
        <button type="button" id="AddButton" class="button-confirm">Crear</button>
    </form>
    <script src="./AddProduct.js"></script>

</body>
</html>