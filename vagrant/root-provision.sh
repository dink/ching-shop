#!/usr/bin/env bash

sudo apt-get update --fix-missing
sudo apt-get dist-upgrade -y
sudo apt-get install htop -y

function installPHPUnit
{
    if [ ! $(type -P phpunit) ]; then
        ln -s /home/vagrant/ching-shop/vendor/phpunit/phpunit/phpunit /usr/local/bin/phpunit
    fi
}
installPHPUnit

function removeHHVM
{
    if [ $(type -P hhvm) ]; then
        sudo /usr/share/hhvm/uninstall_fastcgi.sh
        sudo apt-get remove hhvm -y
    fi
}
removeHHVM

function installXdebug
{
    if [ -z "$(php -i | grep xdebug)" ]; then
        mkdir -p ~/installs
        cd ~/installs/
        wget https://xdebug.org/files/xdebug-2.4.0rc4.tgz
        tar -xvzf xdebug-2.4.0rc4.tgz
        cd xdebug-2.4.0RC4
        phpize
        ./configure
        make
        cp modules/xdebug.so /usr/lib/php/20151012
        echo 'zend_extension = /usr/lib/php/20151012/xdebug.so' >> /etc/php/7.0/fpm/php.ini
        echo 'zend_extension = /usr/lib/php/20151012/xdebug.so' >> /etc/php/7.0/cli/php.ini
        read -r -d '' XDEBUG_INI << INI
xdebug.remote_enable=on
xdebug.remote_log="/tmp/xdebug.log"
xdebug.remote_port=9001
xdebug.remote_connect_back=1
INI
        echo ${XDEBUG_INI} > /etc/php/7.0/fpm/conf.d/20-xdebug.ini
        echo ${XDEBUG_INI} > /etc/php/7.0/cli/conf.d/20-xdebug.ini
    fi
}
installXdebug

service php7.0-fpm restart
service nginx restart
