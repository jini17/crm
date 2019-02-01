<?php

$sql = "mysql -h 13.229.249.148 -P 3306 -u development -p'Dev123$%^)' testuser < /var/www/html/agiliux_cp/golden60/agiliuxsql/DataReset.sql";
$res = exec($sql,$output);

