#!/usr/bin/env bash

cd "`dirname \"$0\"`"
#Run docker with file docker-composer.yml
docker-compose up -d || exit
#composer install in docker
docker-compose exec -T "php-fpm" sh -c "cd /app && composer install"
#echo 'y' | ./composer-install.sh
#echo -n "do you want to use a dump for the database? (y/n): "
#read use_dump
#case "$use_dump" in
#    y|Y) ./dump.sh
#         echo -en '\n'
#         echo -n "Дамп успешно закачался! ${green}${toend}[OK]"
#         echo -en '\n'
#    ;;
#    *) echo "$name, хорошо, обойдемся без дампа! =)"
#    ;;
#esac
#echo 'Теперь нам надо провести миграции!'
#./migrations-migrate.sh
echo 'Rm files on folders: var/cache/{env}/*'
./php-fpm-command.sh rm -rf var/cache/*
echo 'Set permissions on folders: var/cache/{env}/*'
./php-fpm-command.sh chmod 777 var/ -R
echo 'Clear project cache .....'
docker-compose exec -T "php-fpm" sh -c "cd /app && php bin/console cache:clear"
docker-compose exec -T "php-fpm" sh -c "cd /app && php bin/console doctrine:migrations:migrate"
#echo 'Теперь скопируем настройки для локалки!'
#./env.sh
#echo "./env.sh                                    |Скопировать настройки для локалки"
#echo "./migrations-migrate.sh                     |Провести миграции"
#echo "./php-fpm-command.sh [command(ex. php -m)]  |Выполнить команду в php-fpm контейнере"
#echo "./up.sh                                  |Запуск локалки (этот скрипт)"
#echo "./stop.sh                                   |Gracefull shutdown локалки"
#echo -en '\n'
#echo "ДЛЯ УДОБНОГО ПОЛЬЗОВАНИЯ В ДАМПЕ БЫЛИ СОЗДАНЫ СЛЕДУЮЩИЕ ПОЛЬЗОВАТЕЛИ:"
#echo "client@c.cc    | QWEasd123"
#echo "admin@a.aa     | QWEasd123"
#echo "moderator@m.mm | QWEasd123"
#echo -en '\n'
#echo "------------------------------------------------------------------------------"
#echo -en '\n'
#echo -en '\n'