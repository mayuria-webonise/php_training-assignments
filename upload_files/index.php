
<html>
<head>
    <script type = "text/javascript" src = "http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
    <script type = "text/javascript" >

        function validateEmail(){
            var emailField = document.getElementById('email');
            var reg = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

            if (reg.test(emailField.value) == false)
            {
                alert('Invalid Email Address');
                return false;
            }
            else{
                window.location.href = "curl.php";
            }
            return true;

        }
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
<form id = "uploadform" action="curl.php" method="post" enctype="multipart/form-data" onsubmit="return validateEmail();">

    <div class="userinfo">
        uploaded By:    <input type="text" name="name" id="name"><br>
        email:       <input type="text" value="email" id="email" name="email">
    </div><br>

    <div id="imageGroup">
    <div id="imageDiv1">Upload Image:<input type="file" name="image1" id="imagefile"></div>
    </div>
    <input type='button' value='more images' id='addButton'><br>
    <div id="excel">Upload excel file:<input type="file" name="excel" id="excelfile"></div><br>
    <div id="csv">Upload CSV file:<input type="file" name="csv" id="csvfile"></div><br>
    <input type="submit" value="submit" name="submit" >
</form>

</body>
</html>