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
        
        <h1>Статистика</h1>
        <p>
            <form name="form_date" enctype="multipart/form-data" method="get" action="?">
                <input type="hidden" name="controller" value="statistic">
                <input type="hidden" name="action" value="index">
                Дата: <input type="text" name="date" value="<?=date('d/m/Y')?>"> <input type="submit" name="submit" value="Применить">
            </form>
        </p>
        
        <h2>Среднее время ответа на сообщение</h2>
        <p>
            <?php
            if( empty($site['avg_response_time']) ):?>
                нету данных на указанную дату
            <?php
            else:?>
                <?=$site['avg_response_time']?> сек
            <?php
            endif;?>
        </p>

        <h2>Список диалогов, где время ответа превышает 15 минут</h2>
        <p>
            <?php
            if( empty($site['dialogs']) ):?>
                нету диалогов на указанную дату
            <?php
            else:?>
                <?php
                foreach ($site['dialogs'] as $key => $dialog):?>
                    <a href="" target="_blank">https://vk.com/gim<?=$site['vk_group_id']?>?sel=<?=$dialog['peer_id']?></a> <br>
                <?php
                endforeach;
                ?>
            <?php
            endif;?>
        </p>



        <h2>Список наиболее часто встречаемых времени ответа</h2>
        <p>
            <?php
            if( empty($site['stat_response']) ):?>
                нету данных на указанную дату
            <?php
            else:?>
                <table width="300" border="1">
                    <tr>
                        <td>Количество</td>
                        <td>Время ответа</td>
                    </tr>
                <?php
                foreach ($site['stat_response'] as $key => $stat):?>
                    <tr>
                        <td><?=$stat['count']?></td>
                        <td><?=$stat['response_time']?></td>
                    </tr>
                <?php
                endforeach;
                ?>
                </table>
            <?php
            endif;?>
        </p>
        
        
    </div>
</body>
</html>
