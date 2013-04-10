#!/bin/bash
clear
echo "RUNNING";
PACKAGE_NAME=$1;
PACKAGE_REPO=$2;
PACKAGE_TIME=$(date +%s);
PACKAGE_DIR="/var/www/mlc/packages/$PACKAGE_NAME";
echo "App Repos: $PACKAGE_REPO";
if [ -d $PACKAGE_DIR ]
then
        PACKAGE_ROLLBACK_DIR="$PACKAGE_DIR-$PACKAGE_TIME";
        mv $PACKAGE_DIR $PACKAGE_ROLLBACK_DIR;
fi

echo "Package Repos: $PACKAGE_REPO";
git clone $PACKAGE_REPO /var/www/mlc/packages/$PACKAGE_NAME
