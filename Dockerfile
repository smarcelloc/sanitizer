FROM php:7.1-fpm-alpine

# Declare variable
ENV WORKDIR=/usr/app
ENV USER=docker
ENV UID=1000
ENV GROUP=${USER}
ENV GID=1000

# Install Composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"
RUN mv composer.phar /usr/local/bin/composer

# Create user in Docker
RUN addgroup -g ${GID} ${GROUP} && \
    adduser -u ${UID} -G ${GROUP} -h /home/${USER} -D ${USER}

# Set working directory and user
WORKDIR ${WORKDIR}
USER ${USER}