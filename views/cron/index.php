<?php
use Models\User;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Список CRON</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="public/css/style.css" type="text/css">
</head>

<body>
    <div class="wr">
        <?php
        include 'views/site/header.php';?>
        
        <p>
        1.    <a href="index.php?controller=cron&action=conversations">Cron - получение списка бесед</a>.
        </p>
        <p>
        2.    <a href="index.php?controller=cron&action=messages">Cron - получение списка сообщений беседы</a>.
        </p>
                
    </div>
</body>
</html>
