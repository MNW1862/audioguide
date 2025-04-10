#!/usr/bin/bash
#
HOST=$(hostname)
# copy php files

if [[ $HOST == "ojs" ]]; then
    WWWDIR="/var/www/html/guide/"
else
    WWWDIR="/var/www/html/"
fi

cp -vf *.php $WWWDIR
# copy data file
cp -vf *.csv $WWWDIR
# copy assets (aux files, graphics?, css)
cp -vRf assets/*.css assets/*.ico $WWWDIR/assets/
