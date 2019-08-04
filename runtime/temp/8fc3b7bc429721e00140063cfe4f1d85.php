<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:69:"D:\PHPTutorial\WWW\gzj\public/../application/api\view\test\index.html";i:1564886881;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
<form method="post" action="<?php echo url('test/pt'); ?>" enctype="multipart/form-data">
    <input type="radio" /><input type="file" name="img1"/>
    <input type="radio" /><input type="file" name="img2"/>
    <input type="radio" /><input type="file" name="img3"/>
    <input type="submit"/>
</form>
</body>
</html>