# VK-API-MESSAGES

=== Настройка ===

1. composer install
2. В файле конфигурации config\config.php проставляем настройки подключения к базе данных, ACCESS_TOKEN VK, ID группы VK
3. Настраиваем CRON на 
  GET DOMAIN/index.php?controller=cron&action=conversations каждую минуту
  GET DOMAIN/index.php?controller=cron&action=messages каждую минуту

=== Описание структуры проекта ===

controllers\Cron.php - контролер задач для CRON. Задачи: 1. Получение списка бесед. 2. Получение списка сообщений беседы
controllers\Statistic.php - Контроллер Статистики

models\vk.php - Модель работы с VK.com

models\Conversations.php - Модель работы с беседами в БД
