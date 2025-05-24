FROM php:8.2-apache

# Étape 1 : ajouter le bon fichier et bon chemin
ADD --chmod=0755 https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/install-php-extensions

# Étape 2 : (chmod plus nécessaire grâce à --chmod)
# Étape 3 : exécuter le script d’installation d’extensions
RUN install-php-extensions pdo_mysql intl

# Installer Composer
RUN curl -sSk https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer

RUN apt-get update && \
      apt-get -y install sudo

COPY . /var/www/

RUN chown -R www-data:www-data /var/www
#
COPY ./docker/apache.conf /etc/apache2/sites-available/000-default.conf

RUN cd /var/www && \
    composer install

WORKDIR /var/www/

#ENTRYPOINT ["bash", "./docker/docker.sh"]

EXPOSE 80