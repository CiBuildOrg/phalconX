FROM centos:centos6.8

MAINTAINER Nguyen Duc Duy <nguyenducduy.it@gmail.com>

ARG OPENRESTY_VERSION="1.7.10.1"
ARG PHP_VERSION="7.1.1"

RUN rpm -Uvh http://ftp.iij.ad.jp/pub/linux/fedora/epel/6/x86_64/epel-release-6-8.noarch.rpm
RUN yum -y update
RUN yum -y install ntp wget gcc gcc-c++ make git zlib-devel readline-devel \
    libxml2-devel libcurl-devel bzip2-devel libmcrypt-devel libxslt-devel \
    ImageMagick libwebp-devel libjpeg-devel libpng-devel libXpm-devel freetype-devel pcre-devel openssl-devel

RUN echo "/usr/sbin/ntpdate 0.id.pool.ntp.org" >> /etc/rc.local

# Install OpenResty
WORKDIR /opt
RUN wget http://openresty.org/download/ngx_openresty-${OPENRESTY_VERSION}.tar.gz
RUN tar -xvf /opt/ngx_openresty-${OPENRESTY_VERSION}.tar.gz
RUN cd ngx_openresty-${OPENRESTY_VERSION} \
    && ./configure --prefix=/opt/openresty --with-luajit -j2 \
    && make -j2 && make install
RUN export PATH=/usr/local/openresty/bin:$PATH

# Install PHP 7
WORKDIR /opt
RUN wget -O php-${PHP_VERSION}.tar.gz http://am1.php.net/get/php-${PHP_VERSION}.tar.gz/from/this/mirror
RUN tar -xvf /opt/php-${PHP_VERSION}.tar.gz
RUN cd php-${PHP_VERSION} && ./configure --prefix=/opt/php7 \
    --enable-fpm --enable-pdo --with-pdo-mysql \
    --with-config-file-path=/opt/php7/lib/php.ini \
    --with-config-file-scan-dir=/opt/php7/conf.d \
    --with-zlib-dir \
    --with-freetype-dir \
    --enable-mbstring --with-mcrypt --with-zlib --with-curl --with-bz2\
    --with-libxml-dir=/usr \
    --disable-rpath \
    --enable-inline-optimization --enable-sockets --enable-sysvsem --enable-sysvshm --enable-pcntl \
    --enable-mbregex --enable-exif --enable-bcmath --with-mhash --enable-zip \
    --with-pcre-regex --with-pdo-mysql --with-openssl \
    --with-fpm-user=www-data --with-fpm-group=www-data  \
    --with-gettext --with-xmlrpc --with-xsl --enable-fpm --with-gd --with-jpeg-dir=/usr \
    && make && make install

# Install Phalcon Extension
WORKDIR /opt
RUN git clone git://github.com/phalcon/cphalcon.git
RUN cd cphalcon/build/php7/64bits && /opt/php7/bin/phpize \
    && ./configure --with-php-config=/opt/php7/bin/php-config \
    && make && make install
RUN mkdir /opt/php7/conf.d
RUN echo "extension=phalcon.so" > /opt/php7/conf.d/phalcon.ini

# Setup nginx web
ADD service /opt/service
ADD python /opt/python
RUN mkdir /var/www
RUN mkdir /var/www/logs
RUN mkdir /var/log/nginx
RUN mkdir /var/log/supervisor
ADD nginx.conf /opt/openresty/nginx/conf/nginx.conf
ADD localhost.conf /opt/openresty/nginx/conf/servers/localhost.conf

# Adding the default php file
ADD index.php /var/www/index.php

# Add php.ini
ADD php.ini /opt/php7/etc/php.ini
RUN mv /opt/php7/etc/php-fpm.conf.default /opt/php7/etc/php-fpm.conf
RUN mv /opt/php7/etc/php-fpm.d/www.conf.default /opt/php7/etc/php-fpm.d/www.conf

# Run supervisor
RUN echo "/opt/service/supervisord" >> /etc/rc.local

# Set the port to 80
EXPOSE 22 80 9000

RUN useradd -ms /bin/bash www-data
ENTRYPOINT /opt/service/supervisord && /bin/bash
