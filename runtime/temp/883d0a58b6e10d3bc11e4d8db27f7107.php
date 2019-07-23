<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:61:"D:\wamp\www\gzj\public/../application/api\view\info\test.html";i:1563850206;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
 <form method="post" action="<?php echo url('info/pt'); ?>" enctype="multipart/form-data">
     <input type="radio" /><input type="file" name="img1"/>
     <input type="radio" /><input type="file" name="img2"/>
     <input type="radio" /><input type="file" name="img3"/>
     <input type="submit"/>
 </form>
</body>
</html>