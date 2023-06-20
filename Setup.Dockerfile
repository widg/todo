FROM composer

WORKDIR /laravel-setup

RUN composer global require "laravel/installer"

ENTRYPOINT [ "bash" ]