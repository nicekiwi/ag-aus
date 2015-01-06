#!/bin/bash

GLOBALPATH=~/quelle/maps
GLOBALLIST=$GLOBALPATH/all-maps.txt
GLOBALTMP=$GLOBALPATH/tmp
AWSPATH=https://s3-ap-southeast-2.amazonaws.com/alternative-gaming/games/team-fortress-2/maps
VERIFYPATH=http://4c8fa4c.ngrok.com/maps/verify-remote-download

# check the filename and type param is passed
if [ -n "$1" ] && [ -n "$2" ]; then


	# check if filetype is bz2
	if [ $2 == "bz2" ]; then

		MAP=$1

		# Download map
		curl -sS $AWSPATH/$MAP > $GLOBALTMP/$MAP

		# get filesize of downloaded file
		MAPSIZE=$(stat -c%s $GLOBALTMP/$MAP)

		# check if .bz2 file exists and is lager than 1Kb
		if [ -f $GLOBALTMP/$MAP ] && [ $MAPSIZE -ge 1024 ]; then

			# unzip and remove .bz2 file
			bzip2 -cdf $GLOBALTMP/$MAP > $GLOBALPATH/${MAP%????}

			# remove the .bz2 file after extraction
			rm $GLOBALTMP/$MAP

			# check the file was extracted
			if [ -f $GLOBALPATH/${MAP%????} ]; then

				# Re-generate the global-maps.txt file
				ls $GLOBALPATH | grep .bsp$ > $GLOBALLIST

				# send confirmation the file was downloaded with the file key
				#curl -silent --request POST $VERIFYPATH --data "filename=$MAP"
				echo "1";

			fi

		else

			# remove the damaged file
			rm $GLOBALTMP/$MAP
			echo "0";

		fi

	# if the filetype is NOT bz2
	else

		FILE=$1

		# download file
		curl -sS $AWSPATH/$FILE > $GLOBALPATH/$FILE

		# get filesize of downloaded file
		FILESIZE=$(stat -c%s $GLOBALPATH/$FILE)

		# check if file exists and is lager than 1Kb
		if [ -f $GLOBALPATH/$FILE ] && [ $FILESIZE -ge 1024 ]; then

			# send confirmation the file was downloaded with the file key
			#curl -silent --request POST $VERIFYPATH --data "filename=$FILE"
			echo "1";

		else

			# remove damaged file
			rm $GLOBALPATH/$FILE
			echo "0";

		fi

	fi

fi