#!/usr/bin/bash
#
HOST=$(hostname)
# copy php files

if [[ $HOST == "ojs" ]]; then
	cp -vf *.php /var/www/html/guide
	# copy data file
	cp -vf *.csv /var/www/html/guide
	# copy assets (aux files, graphics?, css)
	cp -vRf assets/*.css assets/*.ico /var/www/html/guide/assets/
fi
