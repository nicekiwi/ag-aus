#!/bin/bash

GLOBALLIST=~/quelle/maps/configs/global-maps.txt
GLOBALPATH=~/quelle/maps/files
GLOBALTMP=$GLOBALPATH/tmp
AWSPATH=https://s3-ap-southeast-2.amazonaws.com/alternative-gaming/games/team-fortress-2/maps

# check the download param is passed and the filename also
if [ $1="dl" ] && [ -n "$2" ]; then

	# Download .nav file if present
	if [ $3="nav" ]; then
		echo "Started downloading $2.nav."
		curl -sS $AWSPATH/$2.nav > $GLOBALPATH/$2.nav

		# get filesize of downloaded file
		FILESIZE=$(stat -c%s $GLOBALPATH/$2.nav)

		# check if .nav file exists and is lager than 1Kb
		if [ -f $GLOBALPATH/$2.nav ] && [ $FILESIZE -ge 1024 ]; then
			echo "Finished downloading $2.nav."
		else
			echo "ERROR: $2.nav is missing or damaged."
			rm $GLOBALPATH/$2.nav
		fi
	fi

	# check if the file already exists
	#if [ ! -f $GLOBALPATH/$2.bsp ]; then
	# ive disabled chercking if file exists to allow overwriting

		echo "Started downloading $2.bsp.bz2."

		# Download map
		curl -sS $AWSPATH/$2.bsp.bz2 > $GLOBALTMP/$2.bsp.bz2
		echo "Finished downloading $2.bsp.bz2."

		# get filesize of downloaded file
		FILESIZE=$(stat -c%s $GLOBALTMP/$2.bsp.bz2)

		# check if .bz2 file exists and is lager than 1Kb
		if [ -f $GLOBALTMP/$2.bsp.bz2 ] && [ $FILESIZE -ge 1024 ]; then

			# unzip and remove .bz2 file
			bzip2 -cdf $GLOBALTMP/$2.bsp.bz2 > $GLOBALPATH/$2.bsp

			# remove the .bz2 file after extraction
			rm $GLOBALTMP/$2.bsp.bz2

			# check the file was extracted
			if [ -f $GLOBALPATH/$2.bsp ]; then

				echo "$2.bsp extracted."

				# Re-generate the global-maps.txt file
				ls $GLOBALPATH | grep .bsp$ > $GLOBALLIST
				echo "global-maps.txt generated."

			else

				echo "ERROR: $2.bsp could not be extracted,"

			fi

		else

			echo "ERROR: $2.bsp.bz2 is missing or damaged."
			
			# remove the damaged file if it exists
			if [ -f $GLOBALTMP/$2.bsp.bz2 ]; then
				rm $GLOBALTMP/$2.bsp.bz2
			fi

		fi

	#else

		#echo "ERROR: $2.bsp already exists."

	#fi

else

	echo "ERROR: missing file paramaters."

fi