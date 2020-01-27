#!/usr/bin/env bash
#With root permission
apt-get install php -y
apt-get install php-{bcmath,bz2,intl,gd,mbstring,mysql,zip,fpm} -y
apt update
apt install apt-transport-https ca-certificates curl software-properties-common
curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo apt-key add -
add-apt-repository "deb [arch=amd64] https://download.docker.com/linux/ubuntu bionic stable"
apt update
apt install docker-ce
usermod -aG docker ${USER}
su - ${USER}
docker info
curl -L https://github.com/docker/compose/releases/download/1.21.2/docker-compose-`uname -s`-`uname -m` -o /usr/local/bin/docker-compose
chmod +x /usr/local/bin/docker-compose
docker-compose --version