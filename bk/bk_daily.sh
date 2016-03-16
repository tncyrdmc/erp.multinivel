#!/bin/bash
#echo "creando dump";
dir=$DIRSTACK"/test/bk/";
hostname=$1;
username=$2;
password=$3;
database=$4;
crear=$(date +"%Y%m%d" --date='-1 day')"_"$database; 
eliminar=$(date +"%Y%m%d" --date='-15 day')"_"$database; 
#echo $archivo;
mysqldump -h $hostname -u $username -p$password $database > $dir$crear"_dump.sql";
rm $dir$eliminar"_dump.sql"