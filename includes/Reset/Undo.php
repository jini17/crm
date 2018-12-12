<?php
  require_once '/var/www/html/ag_dev/config.inc.php';
  global $dbconfig;
  extract($dbconfig);
 
 $port = str_replace(":","", $db_port);
echo  $sql = "mysql -h $db_server -P $port -u $db_username -p '$db_password' $db_name < /var/www/html/agiliux_cp/golden60/agiliuxsql/DataReset.sql";
echo	$res = exec($sql,$output);
//        echo $sql;