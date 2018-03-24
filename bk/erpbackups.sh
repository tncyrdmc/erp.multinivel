#!/bin/bash
dir=("/vitale /etraveland /aguagana /globalsuperclub /sistemadelealtad /smart-owner");
#dir=("/erp.multinivel");
echo `date +"%Y-%m-%d"`"";
parenth="/www/erp.clientes";
for i in $dir; do
	#php $DIRSTACK$i"/bk/backup.php" > $DIRSTACK$i"/bk/backup.log";
	echo $HOME$parenth$i"/bk/backup.php 
	";
	php $HOME$parenth$i"/bk/backup.php" >> $HOME$parenth$i"/bk/backup.log";
file=$HOME$parenth$i"/bk/db_access.php"; 
	if [ -f "$file" ]
	then
		rm $file;
	fi
done
