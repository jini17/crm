<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

  require_once '/var/www/html/ag_dev/config.inc.php';
  global $dbconfig;
  extract($dbconfig);
 
 $port = str_replace(":","", $db_port);
echo  $sql = "sudo mysql -h $db_server -P $port -u $db_username -p '$db_password' $db_name < /var/www/html/agiliux_cp/golden60/agiliuxsql/ReloadData.sql";
echo	$res = exec($sql,$output);
//        echo $sql;