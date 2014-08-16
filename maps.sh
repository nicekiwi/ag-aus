#!/bin/bash

#global_maps = "quelle/global_maps"

if [ $1 = "download" ]; then

	# Create temp dir and enter it
	mkdir ./tmp && cd ./tmp

	# Download map
	curl -sS https://s3-ap-southeast-2.amazonaws.com/alternative-gaming/games/team-fortress-2/maps/$2 > $2
	bzip2 -d $2 && rm $2
fi

if [ $1 = "delete" ]; then

	# Create temp dir and enter it
	mkdir ./tmp && cd ./tmp

	# Download map
	curl -sS https://s3-ap-southeast-2.amazonaws.com/alternative-gaming/games/team-fortress-2/maps/$2 > $2
	bzip2 -d $2 && rm $2
fi

echo "$2 has been $1ed successfully."
echo "bye:-)"