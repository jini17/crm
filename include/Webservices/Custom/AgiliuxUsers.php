<?php 


//function to count lead,contacts,accounts
function vtws_agiliuxUsage()
{
	global $adb;	
		
	$sql = "SELECT count(su.userid) as 'created', sp.plantitle, sp.nousers as 'assigned' FROM secondcrm_plan sp 
					LEFT OUTER JOIN secondcrm_userplan su ON su.planid=sp.planid
					WHERE sp.isactive=1 GROUP BY su.planid ORDER BY sp.planid ASC";
	$result = $adb->pquery($sql, array());
	for($i=0;$i<$adb->num_rows($result);$i++){
		$data[$i] = $adb->query_result_rowdata($result, $i);
	}	
	$data['storage'] = folderSize('storage'); 
	return $data;
}

function folderSize ($dir)
{
    $size = 0;
    foreach (glob(rtrim($dir, '/').'/*', GLOB_NOSORT) as $each) {
        $size += is_file($each) ? filesize($each) : folderSize($each);
    }
    return $size;
}

?>