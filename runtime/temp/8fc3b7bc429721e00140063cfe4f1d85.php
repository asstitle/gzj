<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:69:"D:\PHPTutorial\WWW\gzj\public/../application/api\view\test\index.html";i:1565086772;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
<form method="post" action="<?php echo url('test/pt'); ?>" enctype="multipart/form-data">
    <input type="text" name="id" value="1"/>
    <input type="text" name="name" value="dkd"/>
    <input type="text" name="age" value="19"/>
    <input type="text" name="address" value="1202222"/>
    <input type="text" name="tel" value="18382426150"/>
    <input type="submit"/>
</form>
</body>
</html>