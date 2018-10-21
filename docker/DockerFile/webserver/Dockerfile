FROM ubuntu:16.04

RUN apt-get update && apt-get install -y --no-install-recommends \
		apache2 \
		software-properties-common \
		supervisor \
	&& apt-get clean \
	&& rm -fr /var/lib/apt/lists/*

RUN LC_ALL=C.UTF-8 add-apt-repository ppa:ondrej/php

RUN apt-get update && apt-get install -y --no-install-recommends \
		libapache2-mod-php7.2 \
		php7.2 \
		php7.2-bcmath \
		php7.2-cli \
		php7.2-curl \
		php7.2-dev \
		php7.2-gd \
		php7.2-imap \
		php7.2-intl \
		php7.2-mbstring \
		php7.2-mysql \
		php7.2-pgsql \
		php7.2-pspell \
		php7.2-xml \
		php7.2-xmlrpc \
		php7.2-zip \
		php-apcu \
		php-memcached \
		php-pear \
		php-redis \
        php-xdebug \		
		net-tools \
		unzip \
		git \
	&& apt-get clean \
	&& rm -fr /var/lib/apt/lists/*

RUN a2enmod rewrite
COPY docker/conf/000-default.conf /etc/apache2/sites-available/000-default.conf

COPY docker/conf/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

COPY docker/run.sh /run.sh
RUN chmod 755 /run.sh

COPY docker/conf/config /config

COPY docker/conf/20-xdebug.ini /etc/php/7.2/apache2/conf.d
COPY docker/conf/20-xdebug.ini /etc/php/7.2/cli/conf.d

COPY docker/composer-exec.sh /
RUN chmod +x /composer-exec.sh

EXPOSE 80
EXPOSE 8080

CMD ["/run.sh"]