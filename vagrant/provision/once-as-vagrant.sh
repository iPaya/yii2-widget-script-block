#!/usr/bin/env bash

#== Bash helpers ==
function info {
  echo " "
  echo "--> $1"
  echo " "
}

GITHUB_TOKEN=$1

info "Provision-script user: `whoami`"

info "Config composer packagist"
composer config -g repo.packagist composer https://packagist.phpcomposer.com

if [ $GITHUB_TOKEN ]; then
    info "Config github token"
    composer config -g github-oauth.github.com $GITHUB_TOKEN
    info "Done!"
fi

info "Install composer packages"
composer global require "fxp/composer-asset-plugin:~1.2.0" && \
cd /vagrant && composer install --prefer-dist
echo "Done!"