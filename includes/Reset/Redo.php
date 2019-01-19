<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$sql = "mysql -h 13.229.249.148 -P 3306 -u development -p'Dev123$%^)' testuser < /var/www/html/agiliux_cp/golden60/agiliuxsql/ReloadData.sql";
$res = exec($sql,$output);

