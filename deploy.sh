#!/usr/bin/bash
#
HOST=$(hostname)
# copy php files

if [[ $HOST == "ojs" ]]; then
    WWWDIR="/var/www/html/guide/"
else
    WWWDIR="/var/www/html/"
fi

cp -vf --update=older *.php $WWWDIR
# copy data file
cp -vf --update=older *.csv $WWWDIR
# copy assets (aux files, jpegs, css, etc.)
cp -vRf --update=older assets/*.css assets/*.ico ${WWWDIR}assets/
cp -vRf --update=older assets/images/*.jpg ${WWWDIR}assets/images/
