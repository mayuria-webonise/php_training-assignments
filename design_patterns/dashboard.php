<?php
session_start();
echo "Hello  ".$_SESSION["user_name"];
?>
<html>
<head>
    <script type = "text/javascript" src = "http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
    <script type = "text/javascript" >
        $(document).ready(function()
        {
            var  counter = 2;
            $("#addButton").click(function()
            {
                if(counter>5)
                {
                    alert("only 5 images allowed");
                    return false;
                }
                var newImage = $(document.createElement("div")).attr('id','imageDiv'+counter);
                newImage.after().html('Upload Image: <input type="file" name = "image' + counter +'" id = "imagefile' + counter + '">');
                newImage.appendTo("#imageGroup");
                counter++;
            });
        });
    </script>
</head>
<body>
<h3>Welcome to Admin Page:</h3>
<form id = "uploadform" action="requestHandler.php" method="post" enctype="multipart/form-data">

    <div id="imageGroup">
        <div id="imageDiv1">Upload Product Images:<input type="file" name="image1" id="imagefile"></div>
    </div>
    <input type='button' value='more product images' id='addButton'><br>
    <div id="product">Product_name<input type="text" name="product_name"><br>
        Product_Price<input type="text" name="price"></div><br>
    <input type="submit" value="Add Product" name="add_product" ><br>
    <input type="submit" value="search Product" name="search_product" ><br>
    <input type="submit" value="list Products" name="list_products" >
</form>

</body>
</html>