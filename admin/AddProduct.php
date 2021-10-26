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
        <div><span><label for="productId"></label></span><span><input type="text" name="productId" id="productId" value=""></span></div>
        <div><span><label for="productName"></label></span><span><input type="text" name="productName" id="productName" value=""></span></div>
        <div><span><label for="ImageName"></label></span><span><input type="file" accept=".png, .jpg, .jpeg" name="ImageName" value=""></span></div>
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
            <span><label for="schedule"></label></span>
            <span>        
                <select name="schedule" id="schedule">
                    <option value="0">Mañana</option>
                    <option value="1">Tarde</option>
                    <option value="2">Siempre</option>
                </select>
            </span>
        </div>
        <div>
            <span><label for="productPrice"></label></span>
            <span><input type="text" name="productPrice" id="productPrice" value=""></span>
        </div>
        <button type="button" id="AddButton" class="button-confirm">Crear</button>
    </form>
    <script src="./AddProduct.js"></script>
    <?php
        if($_SERVER["REQUEST_METHOD"] == "POST")
        {
            //
            $target_dir = "../assets/images/";
            $target_file = $target_dir . basename($_FILES["ImageName"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            
            // Check if image file is a actual image or fake image
            if(isset($_POST["submit"])) {
              $check = getimagesize($_FILES["ImageName"]["tmp_name"]);
              if($check !== false) {
                echo "File is an image - " . $check["mime"] . ".";
                $uploadOk = 1;
              } else {
                echo "File is not an image.";
                $uploadOk = 0;
              }
            }
            
            // Check if file already exists
            if (file_exists($target_file)) {
              echo "Sorry, file already exists.";
              $uploadOk = 0;
            }       
            
            // Allow certain file formats
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" ) {
              echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
              $uploadOk = 0;
            }
            
            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
              echo "Sorry, your file was not uploaded.";
            // if everything is ok, try to upload file
            } else {
              if (move_uploaded_file($_FILES["ImageName"]["tmp_name"], $target_file)) {
                echo "The file ". htmlspecialchars( basename( $_FILES["ImageName"]["name"])). " has been uploaded.";
              } else {
                echo "Sorry, there was an error uploading your file.";
              }
            }
            //

            $newProduct = array("id"=>null, "allowed"=>null, "activated" => null, "productName"=> null, "imageId" => null,"price"=>null);
            print_r($newProduct);
            $str = "";
            $str .= "<h1>New Product</h1>";
            $str .= "<div>".$_POST['productId']."</div>";
            $str .= "<div>".$_POST['productName']."</div>";
            //$str = "<div>".$_POST['productId']."</div>";
            $str .= "<div>".$_POST['isActived']."</div>";
            $str .= "<div>".$_POST['schedule']."</div>";
            $str .= "<div>".$_POST['productPrice']."</div>";
            echo $str;
        }
    ?>
   
</body>
</html>