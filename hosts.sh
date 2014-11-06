#!/usr/bin/env bash -x

# Create file
touch etchosts

# Add entries from /etc/hosts file
while read line; do
	# Don't grab the RevMsg hosts records
	if [[ $line =~ Cluster$ ]]; then
			break
	else
    	echo $line >> etchosts
  fi
done < /etc/hosts

# Add entries from RevMsg hosts file
while read line; do
    echo $line >> etchosts
done < hosts

# Make backups and move new file over to /etc/hosts
mv /etc/hosts /etc/hosts.backup
cp etchosts etchosts.bak
mv etchosts /etc/hosts

# REMOTE - Vagrant hosts file - Create file
rm web/remoteetchosts
touch web/remoteetchosts

# Add entries from Vagrant hosts file
while read line; do
		echo $line >> web/remoteetchosts
done < remotehosts

# Add entries from RevMsg hosts file
while read line; do
    echo $line >> web/remoteetchosts
done < hosts

# Make backups and move new file over to /etc/hosts
cp web/remoteetchosts web/remoteetchosts.bak