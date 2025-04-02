version: '3.9'

services:

    mytia_web:
        build: .
        image: mytia:latest
        restart: unless-stopped
        ports:
            - 80:80
        depends_on:
            - mytia_db
        networks:
            - mytia_net

    mytia_db:
        image: mysql:9.1
        restart: unless-stopped
        volumes:
            - mytia_db:/var/lib/mysql
        expose:
            - 3306
        environment:
            - MYSQL_ROOT_PASSWORD=MUDAR_SENHA
            - MYSQL_DATABASE=mytia_db
        networks:
            - mytia_net

volumes:
    mytia_db:

networks:
    mytia_net:
     