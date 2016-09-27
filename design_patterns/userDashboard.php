<?php
session_start();
echo "Hello  ".$_SESSION["user_name"];
?>
<html>
<body>
<form id = "userform" action="requestHandler.php" method="post" >
    Product_name<input type="text" name="product_name"><br>
        <input type="submit" value="search Product" name="search_product" ><br>
    <input type="checkbox" name="in_pound" value="Price in Pounds">Price in Pounds<br>
    <input type="checkbox" name="in_rupees" value="Price in Rupees" >Price in Rupees<br>
        <input type="submit" value="list Products" name="list_products" >
</form>
</body>
</html>