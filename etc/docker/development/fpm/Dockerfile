FROM randock/docker-ubuntu-php:7.2-dev

RUN sed -i "s|plugins=(git)|plugins=(git symfony2 composer)|g" /root/.zshrc
RUN echo "alias devsuperload='dev d:d:d --force;dev d:d:c; dev d:m:m --no-interaction   ; fixtures;'" >> ~/.bash_aliases
RUN echo "alias fixtures='bin/console doctrine:fixtures:load --no-interaction'" >> ~/.bash_aliases

COPY php-fpm7.2.conf /etc/php/7.2/fpm/php-fpm.conf