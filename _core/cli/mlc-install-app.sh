#!/bin/bash
clear

echo "RUNNING";
APP_NAME=$1;
APP_REPO=$2;
if [ -n "$var" ]; then
    INSTALL_ROOT_DIR = '/var/www/mlc';
else

fi
APP_TIME=$(date +%s);
APP_DIR="$INSTALL_ROOT_DIR/apps/$APP_NAME";
echo "App Repos: $APP_REPO";
if [ -d $APP_DIR ]
then
        APP_ROLLBACK_DIR="$APP_DIR-$APP_TIME";
        mv $APP_DIR $APP_ROLLBACK_DIR;
fi
git clone $APP_REPO $APP_DIR;

