#!/bin/bash
### Defino Funciones
function setQuery {
echo "set @@sql_mode = '';"
echo "$1"
}
#### Defino los parametros de conexión a la BD MySQL
host=$1
user=$2
password=$3
database=$4
data=$5
### Comprobar entradas
if [ -z "$host" ] || [ -z "$user" ] || [ -z "$password" ] || [ -z "$database" ] || [ -z "$data" ]; then
echo "ERROR: Faltan algunos parametros."
exit
fi
### Se monta los parámetros de conexión
conexion="-h $host -u $user -p$password -D $database"
#echo $conexion
query=$(setQuery "$data")
### Mi sentencia Sql para que la muestre
mysql $conexion <<EOF
 
 $query
 
EOF
