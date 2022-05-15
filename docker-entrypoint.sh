#!/usr/bin/env bash

SCRIPTPATH="$( cd -- "$(dirname "$0")" >/dev/null 2>&1 ; pwd -P )"
DEST_FOLDER=$1
echo "Current scriptpath: ${SCRIPTPATH}"
echo "DEST folder: ${DEST_FOLDER}"

echo "Symlinking wp-config\n";
rm -fr $DEST_FOLDER/wp-config.php && ln -s $SCRIPTPATH/wordpress/wp-config.php $DEST_FOLDER
echo "Symlinking .htaccess\n";
rm -fr $DEST_FOLDER/.htaccess && ln -s $SCRIPTPATH/wordpress/.htaccess $DEST_FOLDER

cd $DEST_FOLDER

/usr/local/bin/docker-entrypoint.sh apache2-foreground
