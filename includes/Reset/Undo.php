<?php
  require_once '/var/www/html/ag_dev/config.inc.php';
  global $dbconfig;
  extract($dbconfig);
 
 $port = str_replace(":","", $db_port);
  $sql = "mysql -h $db_server -P $port -u $db_username -p'$db_password' $db_name < /var/www/html/agiliux_cp/golden60/agiliuxsql/DataReset.sql";
    $result = liveExecuteCommand($sql);

if($result['exit_status'] === 0){
   // do something if command execution succeeds
} else {
    // do something on failure
}
  function liveExecuteCommand($cmd)
{

    while (@ ob_end_flush()); // end all output buffers if any

    $proc = popen("$cmd 2>&1 ", 'r');

    $live_output     = "";
    $complete_output = "";

    while (!feof($proc))
    {
        $live_output     = fread($proc, 4096);
        $complete_output = $complete_output . $live_output;
        echo "$live_output";
        @ flush();
    }

    pclose($proc);

    // get exit status
    preg_match('/[0-9]+$/', $complete_output, $matches);

    // return exit status and intended output
    return array (
                    'exit_status'  => intval($matches[0]),
                    'output'       => str_replace("Exit status : " . $matches[0], '', $complete_output)
                 );
}
//echo	$res = exec($sql,$output);
//        echo $sql;