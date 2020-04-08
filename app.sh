#!/usr/bin/env bash

# вспомогательный функции
log() {
    RED='\e[31m'
    GREEN='\e[32m'

    case $2 in
        info)
            printf "${GREEN}${1}\e[0m\n"
        ;;
        error)
            printf "${RED}${1}\e[0m\n"
        ;;
        *)
            printf "${1}"
        ;;
    esac
}

# команды для фронта
if [[ $1 == "front" ]]; then
    case $2 in
        install)
            docker-compose exec front yarn install
        ;;
        watch)
            docker-compose exec front yarn run watch
        ;;
        build)
            docker-compose exec front yarn run build
        ;;
        esac

    exit
fi

# команды для работы с бэкапами
if [[ $1 == "backup" ]]; then
    if [[ $2 == "create" ]]; then
        docker-compose exec -T db mysqldump -uroot -proot wwf > docker/db/$3.sql
        log "Бэкап успешно создан!" "info"
        exit
    fi
    docker-compose exec db mysql -uroot -proot -e 'drop database if exists wwf'
    docker-compose exec db mysql -uroot -proot -e 'create database wwf'
    docker-compose exec -T db mysql -uroot -proot wwf < docker/db/$2.sql
    log "Бэкап успешно установлен!" "info"
    exit
fi

# команды для работы с композером
if [[ $1 == "composer" ]]; then
    docker-compose exec php $@
    exit
fi

# команды для работы с консолью
if [[ $1 == "console" ]]; then
    docker-compose exec php bin/console ${@:2}
    exit
fi

# команда для php cs fixer
if [[ $1 == "php-fixer" ]]; then
    docker-compose exec php vendor/bin/php-cs-fixer fix --config=.php_cs
    exit
fi

case $1 in
    down)
        docker-compose down
        exit
    ;;
    build)
        if [[ $2 == "x" ]]; then
            args="--build-arg INSTALL_XDEBUG=1"
        fi
        docker-compose build ${args}
        exit
    ;;
    up)
        docker-compose up -d
        exit
    ;;
esac
