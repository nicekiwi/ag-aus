#!/bin/bash

GLOBALPATH=~/quelle/maps
GLOBALLIST=$GLOBALPATH/all-maps.txt
VERIFYPATH=http://4c8fa4c.ngrok.com/maps/verify-remote-removal

# check the filename is present
if [ -n "$1" ] && [ -n "$2" ]; then

	# check if filetype is bz2
	if [ $2 == "bz2" ]; then
		FILE=${1%????}
	else
		FILE=$1
	fi

	# remove the file if it exists
	if [ -f $GLOBALPATH/$FILE ]; then

		# remove the file
		rm $GLOBALPATH/$FILE

		# Re-generate the global-maps.txt file
		ls $GLOBALPATH | grep .bsp$ > $GLOBALLIST

		# send confirmation the file was removed with the file key
		#curl -silent --request POST $VERIFYPATH --data "filename=$1"

	fi

	echo "0";

fi