#!/bin/bash

USRP=~/quelle/users

# Empty the generated file
> $USRP/generated/admins.cfg

# Contact all the files into a single file
cat $USRP/admins.txt $USRP/moderators.txt $USRP/donators.txt >> $USRP/generated/admins.cfg

# Add Starting syntax
sed -i "1iAdmins\n{\n" $USRP/generated/admins.cfg
# Add Ending syntax
sed -i -e "$a\}" $USRP/generated/admins.cfg