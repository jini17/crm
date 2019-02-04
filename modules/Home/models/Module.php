<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

class Home_Module_Model extends Vtiger_Module_Model {

	/**
	 * Function returns the default view for the Home module
	 * @return <String>
	 */
	public function getDefaultViewName() {
		return 'DashBoard';
	}

	/**
	 * Function returns latest comments across CRM
	 * @param <Vtiger_Paging_Model> $pagingModel
	 * @return <Array>
	 */
	public function getComments($pagingModel, $user, $dateFilter='') {
		$db = PearDatabase::getInstance();

		$sql = 'SELECT vtiger_modcomments.*,vtiger_crmentity.setype AS setype,vtiger_crmentity.createdtime AS createdtime, vtiger_crmentity.smownerid AS smownerid,
				crmentity2.crmid AS parentId, crmentity2.setype AS parentModule FROM vtiger_modcomments
				INNER JOIN vtiger_crmentity ON vtiger_modcomments.modcommentsid = vtiger_crmentity.crmid
				AND vtiger_crmentity.deleted = 0
				INNER JOIN vtiger_crmentity crmentity2 ON vtiger_modcomments.related_to = crmentity2.crmid
				AND crmentity2.deleted = 0 
				INNER JOIN vtiger_modtracker_basic ON vtiger_modtracker_basic.crmid = vtiger_crmentity.crmid';

		$currentUser = Users_Record_Model::getCurrentUserModel();
		$params = array();

		if($user === 'all') {
			if(!$currentUser->isAdminUser()){
				$accessibleUsers = array_keys($currentUser->getAccessibleUsers());
				$nonAdminAccessQuery = Users_Privileges_Model::getNonAdminAccessControlQuery('ModComments');
				$sql .= $nonAdminAccessQuery;
				$sql .= ' AND userid IN('.  generateQuestionMarks($accessibleUsers).')';
				$params = array_merge($params,$accessibleUsers);
			}
		}else{
			$sql .= ' AND userid = ?';
			$params[] = $user;
		}
		//handling date filter for history widget in home page
		if(!empty($dateFilter)) {
			$sql .= ' AND vtiger_modtracker_basic.changedon BETWEEN ? AND ? ';
			$params[] = $dateFilter['start'];
			$params[] = $dateFilter['end'];
		}

		$sql .= ' ORDER BY vtiger_crmentity.crmid DESC LIMIT ?, ?';
		$params[] = $pagingModel->getStartIndex();
		$params[] = $pagingModel->getPageLimit();
		$result = $db->pquery($sql,$params);
		
		$noOfRows = $db->num_rows($result);
		//setting up the count of records before checking permissions in history
		$pagingModel->set('historycount', $noOfRows);
		$comments = array();
		for($i=0; $i<$noOfRows; $i++) {
			$row = $db->query_result_rowdata($result, $i);
			if(Users_Privileges_Model::isPermitted($row['setype'], 'DetailView', $row['related_to'])){
				$commentModel = Vtiger_Record_Model::getCleanInstance('ModComments');
				$commentModel->setData($row);
                $commentModel->set('commentcontent', $commentModel->getParsedContent());
				$comments[] = $commentModel;
			}
		}

		return $comments;
	}

	/**
	 * Function returns comments and recent activities across CRM
	 * @param <Vtiger_Paging_Model> $pagingModel
	 * @param <String> $type - comments, updates or all
	 * @return <Array>
	 */
	public function getHistory($pagingModel, $type='', $userId='', $dateFilter='') {
		if(!$userId)	$userId	= 'all';
		if(!$type)		$type	= 'all';
		//TODO: need to handle security
		$comments = array();
		if($type == 'all' || $type == 'comments') {
			$modCommentsModel = Vtiger_Module_Model::getInstance('ModComments'); 
			if($modCommentsModel->isPermitted('DetailView')){
				$comments = $this->getComments($pagingModel, $userId, $dateFilter);
			}
			if($type == 'comments') {
				return $comments;
			}
		}
		$db = PearDatabase::getInstance();
		$params = array();
		$sql = 'SELECT vtiger_modtracker_basic.*
				FROM vtiger_modtracker_basic
				INNER JOIN vtiger_crmentity ON vtiger_modtracker_basic.crmid = vtiger_crmentity.crmid
				AND module NOT IN ("ModComments","Users") ';

		$currentUser = Users_Record_Model::getCurrentUserModel();
		if($userId === 'all') {
			if(!$currentUser->isAdminUser()) {
				$accessibleUsers = array_keys($currentUser->getAccessibleUsers());
				$sql .= ' AND whodid IN ('.  generateQuestionMarks($accessibleUsers).')';
				$params = array_merge($params, $accessibleUsers);
			}
		}else{
			$sql .= ' AND whodid = ?';
			$params[] = $userId;
		}
		//handling date filter for history widget in home page
		if(!empty($dateFilter)) {
			$sql .= ' AND vtiger_modtracker_basic.changedon BETWEEN ? AND ? ';
			$params[] = $dateFilter['start'];
			$params[] = $dateFilter['end'];
		}
		$sql .= ' ORDER BY vtiger_modtracker_basic.id DESC LIMIT ?, ?';
		$params[] = $pagingModel->getStartIndex();
		$params[] = $pagingModel->getPageLimit();
                
		//As getComments api is used to get comment infomation,no need of getting
		//comment information again,so avoiding from modtracker
		$result = $db->pquery($sql,$params);
                
		$activites = array();
		$noOfRows = $db->num_rows($result);
		//set the records count before checking permissions and unsetting it
		//If updates count more than comments count, this count should consider
		if($pagingModel->get('historycount') < $noOfRows) {
			$pagingModel->set('historycount', $noOfRows);
		}
		for($i=0; $i<$noOfRows; $i++) {
			$row = $db->query_result_rowdata($result, $i);
			$moduleName = $row['module'];
			$recordId = $row['crmid'];
			if(Users_Privileges_Model::isPermitted($moduleName, 'DetailView', $recordId)){
				$modTrackerRecorModel = new ModTracker_Record_Model();
				$modTrackerRecorModel->setData($row)->setParent($recordId, $moduleName);
				$activites[] = $modTrackerRecorModel;
			}
		}

		$history = array_merge($activites, $comments);
		
		$dateTime = array();
		foreach($history as $model) {
			if(get_class($model) == 'ModComments_Record_Model') {
				$time = $model->get('createdtime');
			} else {
				$time = $model->get('changedon');
			}
			$dateTime[] = $time;
		}

		if(!empty($history)) {
			array_multisort($dateTime,SORT_DESC,SORT_STRING,$history);
			return $history;
		}
		return false;
	}

	/**
	 * Function returns the Calendar Events for the module
	 * @param <String> $mode - upcoming/overdue mode
	 * @param <Vtiger_Paging_Model> $pagingModel - $pagingModel
	 * @param <String> $user - all/userid
	 * @param <String> $recordId - record id
	 * @return <Array>
	 */
	function getCalendarActivities($mode, $pagingModel, $user) {
		$currentUser = Users_Record_Model::getCurrentUserModel();
		$db = PearDatabase::getInstance();

		if (!$user) {
			$user = $currentUser->getId();
		}

		$nowInUserFormat = Vtiger_Datetime_UIType::getDisplayDateTimeValue(date('Y-m-d H:i:s'));
		$nowInDBFormat = Vtiger_Datetime_UIType::getDBDateTimeValue($nowInUserFormat);
		list($currentDate, $currentTime) = explode(' ', $nowInDBFormat);

		$query = "SELECT vtiger_crmentity.crmid, vtiger_crmentity.smownerid, vtiger_crmentity.setype, vtiger_activity.* FROM vtiger_activity
					INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = vtiger_activity.activityid
					LEFT JOIN vtiger_groups ON vtiger_groups.groupid = vtiger_crmentity.smownerid";

		$query .= Users_Privileges_Model::getNonAdminAccessControlQuery('Calendar');

		$query .= " WHERE vtiger_crmentity.deleted=0
					AND (vtiger_activity.activitytype NOT IN ('Emails'))
					AND (vtiger_activity.status is NULL OR vtiger_activity.status NOT IN ('Completed', 'Deferred', 'Cancelled'))
					AND (vtiger_activity.eventstatus is NULL OR vtiger_activity.eventstatus NOT IN ('Held', 'Cancelled'))";

		if(!$currentUser->isAdminUser()) {
			$moduleFocus = CRMEntity::getInstance('Calendar');
			$condition = $moduleFocus->buildWhereClauseConditionForCalendar();
			if($condition) {
				$query .= ' AND '.$condition;
			}
		}

		if ($mode === 'upcoming') {
			$query .= " AND CASE WHEN vtiger_activity.activitytype='Task' THEN due_date >= '$currentDate' ELSE CONCAT(due_date,' ',time_end) >= '$nowInDBFormat' END";
		} elseif ($mode === 'overdue') {
			$query .= " AND CASE WHEN vtiger_activity.activitytype='Task' THEN due_date < '$currentDate' ELSE CONCAT(due_date,' ',time_end) < '$nowInDBFormat' END";
		}

		$params = array();
		if($user != 'all' && $user != '') {
			//if($user === $currentUser->id) {
				$query .= " AND vtiger_crmentity.smownerid = ?";
				$params[] = $user;
			//}
		}

		$query .= " ORDER BY date_start, time_start LIMIT ?, ?";
		$params[] = $pagingModel->getStartIndex();
		$params[] = $pagingModel->getPageLimit()+1;

		$result = $db->pquery($query, $params);
		$numOfRows = $db->num_rows($result);
		
		$groupsIds = Vtiger_Util_Helper::getGroupsIdsForUsers($currentUser->getId());
		$activities = array();
		$recordsToUnset = array();
		for($i=0; $i<$numOfRows; $i++) {
			$newRow = $db->query_result_rowdata($result, $i);
			$model = Vtiger_Record_Model::getCleanInstance('Calendar');
			$ownerId = $newRow['smownerid'];
			$currentUser = Users_Record_Model::getCurrentUserModel();
			$visibleFields = array('activitytype','date_start','time_start','due_date','time_end','assigned_user_id','visibility','smownerid','crmid');
			$visibility = true;
			if(in_array($ownerId, $groupsIds)) {
				$visibility = false;
			} else if($ownerId == $currentUser->getId()){
				$visibility = false;
			}
			if(!$currentUser->isAdminUser() && $newRow['activitytype'] != 'Task' && $newRow['visibility'] == 'Private' && $ownerId && $visibility) {
				foreach($newRow as $data => $value) {
					if(in_array($data, $visibleFields) != -1) {
						unset($newRow[$data]);
					}
				}
				$newRow['subject'] = vtranslate('Busy','Events').'*';
			}
			if($newRow['activitytype'] == 'Task') {
				unset($newRow['visibility']);
				
                $due_date = $newRow["due_date"];
                $dayEndTime = "23:59:59";
                $EndDateTime = Vtiger_Datetime_UIType::getDBDateTimeValue($due_date." ".$dayEndTime);
                $dueDateTimeInDbFormat = explode(' ',$EndDateTime);
                $dueTimeInDbFormat = $dueDateTimeInDbFormat[1];
                $newRow['time_end'] = $dueTimeInDbFormat;
            }
			$model->setData($newRow);
			$model->setId($newRow['crmid']);
			$activities[$newRow['crmid']] = $model;
			if(!$currentUser->isAdminUser() && $newRow['activitytype'] == 'Task' && isToDoPermittedBySharing($newRow['crmid']) == 'no') { 
				$recordsToUnset[] = $newRow['crmid'];
			}
		}
		
		$pagingModel->calculatePageRange($activities);
		if($numOfRows > $pagingModel->getPageLimit()){
			array_pop($activities);
			$pagingModel->set('nextPageExists', true);
		} else {
			$pagingModel->set('nextPageExists', false);
		}
		//after setting paging model, unsetting the records which has no permissions
		foreach($recordsToUnset as $record) {
			unset($activities[$record]);
		}
		return $activities;
	}
    
    /*
     * Function to get supported utility actions for a module
     */
    function getUtilityActionsNames() {
        return array();
    }

    function getSubscriptionDetail(){
    	$db = PearDatabase::getInstance();
    	$result = $db->pquery("SELECT * FROM secondcrm_plan WHERE isactive=1", array());
    	$numOfRows = $db->num_rows($result);
    	$plandetail = array();
    	for($i=0; $i<$numOfRows; $i++) {
    		$plan = $db->query_result($result, $i, 'plantitle');
    		$planid = $db->query_result($result, $i, 'planid');
    		$nousers = $db->query_result($result, $i, 'nousers');
    		$startdate = $db->query_result($result, $i, 'createdtime');
    		$enddate = $db->query_result($result, $i, 'expiredate');
    		$plandetail[$plan] = array($nousers, date('jS M Y', strtotime($startdate)), date('jS M Y', strtotime($enddate)));
    	}
        return $plandetail;
    }
    
    
    //#added by safuan@secondcrm for birthday widget
	function getBirthdays($group, $type){

		$db = PearDatabase::getInstance();			
		
		if(empty($group)) {
		$group = 'user';
		}		
		if(empty($type)) {
		$type = 'today';
		}
		//echo 'group '.$group.' XDXD type '.$type;
		if ($group == 'user'){
		$query = "(SELECT CONCAT(vtiger_users.first_name, ' ', vtiger_users.last_name) as fullname,department,
				birthday AS birthdate,vtiger_users.id AS 'id','Users' AS module,'email1' AS fieldname,
				TIMESTAMPDIFF( YEAR, birthday, CURDATE( ) ) AS age
				FROM vtiger_users ";

			if($type == 'today'){
			$query .= "WHERE DATE_FORMAT(birthday,'%m-%d') = DATE_FORMAT(NOW(),'%m-%d')
					     OR (
						    (
							DATE_FORMAT(NOW(),'%Y') % 4 <> 0
							OR (
								DATE_FORMAT(NOW(),'%Y') % 100 = 0
								AND DATE_FORMAT(NOW(),'%Y') % 400 <> 0
							    )
						    )
						    AND DATE_FORMAT(NOW(),'%m-%d') = '03-01'
						    AND DATE_FORMAT(birthday,'%m-%d') = '02-29'
						)
				)";
					
			}elseif($type == 'tomorrow'){
			$query .= "WHERE DATE_FORMAT(birthday,'%m-%d') = DATE_FORMAT(CURDATE() + INTERVAL 1 DAY,'%m-%d') )";			
			

			}elseif($type == 'thisweek'){
			$query .= "WHERE WEEKOFYEAR(CONCAT(YEAR(CURDATE()),'-', date_format(birthday,'%m-%d'))) = WEEKOFYEAR(CURDATE()))"; 
			/*$query .= "WHERE DATE_ADD( birthday, INTERVAL YEAR( CURDATE() ) - YEAR( birthday ) YEAR )
					BETWEEN CURDATE()
					AND DATE_ADD( CURDATE() , INTERVAL 7
					DAY ))";			
			*/

			}elseif($type == 'nextweek'){
			$query .= " WHERE WEEKOFYEAR(CONCAT(YEAR(CURDATE()),'-', date_format(birthday,'%m-%d'))) = WEEKOFYEAR(CURDATE())+1)";
		/*	$query .= "WHERE DATE_ADD( birthday, INTERVAL YEAR( CURDATE() + INTERVAL 7 DAY ) - YEAR( birthday ) YEAR )
					BETWEEN CURDATE() + INTERVAL 7 DAY
					AND DATE_ADD( CURDATE() + INTERVAL 7
					DAY , INTERVAL 7 DAY ))";
		*/	

			}elseif($type == 'thismonth'){
			$query .= "WHERE DATE_FORMAT(birthday,'%m') = DATE_FORMAT(CURDATE(),'%m') )";			
			

			}
		//echo $query;	
		}

		
		if ($group == 'customer'){
		
		$query = "(SELECT DISTINCT CONCAT(vtiger_contactdetails.firstname, ' ', vtiger_contactdetails.lastname) AS fullname,		
				vtiger_contactsubdetails.birthday AS birthdate,vtiger_contactdetails.contactid AS 'id',
				'Accounts' AS module,'email1' AS fieldname,
				TIMESTAMPDIFF( YEAR, vtiger_contactsubdetails.birthday, CURDATE( ) ) AS age, vtiger_contactdetails.company_name as department
				FROM vtiger_contactdetails
				INNER JOIN vtiger_contactsubdetails
				ON vtiger_contactdetails.contactid = vtiger_contactsubdetails.contactsubscriptionid
				WHERE 1	";

			if($type == 'today'){
			$query .= "AND DATE_FORMAT(birthday,'%m-%d') = DATE_FORMAT(NOW(),'%m-%d')
				     OR (
					    (
						DATE_FORMAT(NOW(),'%Y') % 4 <> 0
						OR (
							DATE_FORMAT(NOW(),'%Y') % 100 = 0
							AND DATE_FORMAT(NOW(),'%Y') % 400 <> 0
						    )
					    )
					    AND DATE_FORMAT(NOW(),'%m-%d') = '03-01'
					    AND DATE_FORMAT(birthday,'%m-%d') = '02-29'
					)
				)";
					
			}elseif($type == 'tomorrow'){
			$query .= "AND DATE_FORMAT(birthday,'%m-%d') = DATE_FORMAT(CURDATE() + INTERVAL 1 DAY,'%m-%d') )";			
			

			}elseif($type == 'thisweek'){
			$query .= "AND WEEKOFYEAR(CONCAT(YEAR(CURDATE()),'-', date_format(birthday,'%m-%d'))) = WEEKOFYEAR(CURDATE()))"; 

			}elseif($type == 'nextweek'){
				
			$query .= " AND WEEKOFYEAR(CONCAT(YEAR(CURDATE()),'-', date_format(birthday,'%m-%d'))) = WEEKOFYEAR(CURDATE())+1)";


			}elseif($type == 'thismonth'){
			$query .= "AND DATE_FORMAT(birthday,'%m') = DATE_FORMAT(CURDATE(),'%m') )";			
			

			}
                                                        
		//echo $query;			
		}

		if ($group == 'vendor'){
		
		$query = "(SELECT DISTINCT CONCAT(vtiger_contactdetails.firstname, ' ', vtiger_contactdetails.lastname) AS fullname,		
				vtiger_contactsubdetails.birthday AS birthdate,vtiger_vendorcontactrel.vendorid AS 'id',
				'Vendors' AS module,'email' AS fieldname,
				TIMESTAMPDIFF( YEAR, vtiger_contactsubdetails.birthday, CURDATE( ) ) AS age
				FROM vtiger_contactdetails
				INNER JOIN vtiger_contactsubdetails
				ON vtiger_contactdetails.contactid = vtiger_contactsubdetails.contactsubscriptionid
				INNER JOIN vtiger_vendorcontactrel
				ON vtiger_vendorcontactrel.contactid = vtiger_contactdetails.contactid
				WHERE vtiger_contactdetails.contactid = vtiger_vendorcontactrel.contactid ";


			if($type == 'today'){
			$query .= "AND DATE_FORMAT(birthday,'%m-%d') = DATE_FORMAT(NOW(),'%m-%d')
				     OR (
					    (
						DATE_FORMAT(NOW(),'%Y') % 4 <> 0
						OR (
							DATE_FORMAT(NOW(),'%Y') % 100 = 0
							AND DATE_FORMAT(NOW(),'%Y') % 400 <> 0
						    )
					    )
					    AND DATE_FORMAT(NOW(),'%m-%d') = '03-01'
					    AND DATE_FORMAT(birthday,'%m-%d') = '02-29'
					)
				)";
					
			}elseif($type == 'tomorrow'){
			$query .= "AND DATE_FORMAT(birthday,'%m-%d') = DATE_FORMAT(CURDATE() + INTERVAL 1 DAY,'%m-%d') )";			
			

			}elseif($type == 'thisweek'){
			$query .= " AND WEEKOFYEAR(CONCAT(YEAR(CURDATE()),'-', date_format(birthday,'%m-%d'))) = WEEKOFYEAR(CURDATE()))";	
			/*$query .= "AND DATE_ADD( birthday, INTERVAL YEAR( CURDATE() ) - YEAR( birthday ) YEAR )
					BETWEEN CURDATE()
					AND DATE_ADD( CURDATE() , INTERVAL 7
					DAY ))";			
			*/

			}elseif($type == 'nextweek'){
			$query .= " AND WEEKOFYEAR(CONCAT(YEAR(CURDATE()),'-', date_format(birthday,'%m-%d'))) = WEEKOFYEAR(CURDATE())+1)";	
			/*$query .= "AND DATE_ADD( birthday, INTERVAL YEAR( CURDATE() + INTERVAL 7 DAY ) - YEAR( birthday ) YEAR )
					BETWEEN CURDATE() + INTERVAL 7 DAY
					AND DATE_ADD( CURDATE() + INTERVAL 7
					DAY , INTERVAL 7 DAY ))";
			*/

			}elseif($type == 'thismonth'){
			$query .= "AND DATE_FORMAT(birthday,'%m') = DATE_FORMAT(CURDATE(),'%m') )";			
			

			}
		//echo $query;
		}
		 $query .= "ORDER BY unix_timestamp(CONCAT(YEAR(CURDATE()),'-', date_format(birthday,'%m-%d'))) ASC ";
		$result = $db->pquery($query, array());
				$birthdays = array();
		if($db->num_rows($result) > 0) {
			for($i=0;$i<$db->num_rows($result);$i++) {
			  	$birthdays[$i]['fullname'] = $db->query_result($result, $i, 'fullname');
			  	$birthdays[$i]['birthday'] = date('dS M, Y', strtotime($db->query_result($result, $i, 'birthdate')));		$birthdays[$i]['id'] = $db->query_result($result, $i, 'id');		
				$birthdays[$i]['module'] = $db->query_result($result, $i, 'module');		
				$birthdays[$i]['fieldname'] = $db->query_result($result, $i, 'fieldname');		
				$birthdays[$i]['age'] = $db->query_result($result, $i, 'age');		
                $birthdays[$i]['department'] =$db->query_result($result, $i, 'department');		
			}
		}
		return $birthdays;

	}
	
	function getAllNotifications($pagingModel){

		$db = PearDatabase::getInstance();	
		
		$currentUser = Users_Record_Model::getCurrentUserModel();
		
		$params[] = $currentUser->id;
		$params[] = $pagingModel->getStartIndex();
		$params[] = $pagingModel->getPageLimit();
        
        $sql .= ' ORDER BY vtiger_crmentity.createdtime DESC LIMIT ?, ?';  

		$result = $db->pquery("SELECT *  FROM vtiger_notifications 
					INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid=vtiger_notifications.notificationsid
					LEFT JOIN `vtiger_crmentity_user_field` ON vtiger_crmentity_user_field.recordid=vtiger_crmentity.crmid 
					WHERE vtiger_crmentity.`deleted`=0  AND vtiger_crmentity_user_field.`userid`=? ".$sql, $params);

		$notifications = array();
		$unread = 0;
		$noOfRow = $db->num_rows($result);
		if($pagingModel->get('notificationcount') < $noOfRows) {
			$pagingModel->set('notificationcount', $noOfRows);
		}

		if($noOfRow> 0) {

			for($i=0;$i<$db->num_rows($result);$i++) {

			  	$notifyby	 	= $db->query_result($result, $i, 'notifyby');
			  	$relatedto 		= $db->query_result($result, $i, 'relatedto');
			  	$notifyto 		= $db->query_result($result, $i, 'notifyto');
			  	$timestamp 		= $db->query_result($result, $i, 'createdtime');
			  	$viewed 		= $db->query_result($result, $i, 'viewed');
			  	
			  	$nameResult = $db->pquery('SELECT first_name, last_name,  FROM vtiger_users WHERE id = ?', array($notifyto));
				if($db->num_rows($nameResult)) {
					$fullname =  $db->query_result($nameResult, 0, 'first_name').' '.$db->query_result($nameResult, 0, 'last_name');
				}
				
			  	$referenceModuleName = RecordSetype($relatedto);

			  	$action = $db->query_result($result, $i, 'actionperform');
			  	$entityNames = 	getEntityName($referenceModuleName, array($relatedto));
			  	$notifications['details'][$i]['linkurl'] = "index.php?module=$referenceModuleName&view=Detail&record=$relatedto";
			  	$notifications['details'][$i]['linklabel'] = $entityNames[$relatedto];
			  	

			  	if($action == 'Posted'){
			  		$message = 'New message is posted';
			  	} else if($action == 'Download'){
			  		$message = 'Download your payslip here';
			  	} else if($action == 'Approved' || $action == 'Rejected' || $action == "Applied"){
			  		$message =  $referenceModuleName. " is $action ";
			  	} else if($action == 'Assigned'){
			  		$message = "A task is assigned to ". $fullname;
			  	} else if($action == 'Completed'){
			  		$message = "Task completed by ". $fullname;
			  	} else if($action == 'Updated'){
			  		$message = "HR change the working hours";
			  	} else if($action == 'Commented'){
			  		
			  		$namebyResult = $db->pquery('SELECT first_name, last_name FROM vtiger_users WHERE id = ?', array($notifyby));
					if($db->num_rows($namebyResult)) {
						$notifybyfullname =  $db->query_result($namebyResult, 0, 'first_name').' '.$db->query_result($namebyResult, 0, 'last_name');
					}

			  		$message = " New Comment on ". $entityNames[$relatedto] ." by ".$notifybyfullname;
			  	} else {
			  		$message = "Your Subscription is getting expired";
			  	}

			  
		  		if($notifyby==0){
		  			$imagename = 'storage/2018/October/week3/2560_admin.jpg';
		  		} else {
		  			$recordModel = Users_Record_Model::getInstanceById($notifyby, 'Users');
		  			$imagesdetails = $recordModel->getImageDetails();
		  			$imagename = $imagesdetails[0]['path'].'_'.$imagesdetails[0]['name'];
		  		}
		  		$notifications['details'][$i]['message'] 		= $message;
		  		$notifications['details'][$i]['profilepic'] 	= $imagename;
		  		$notifications['details'][$i]['timestamp'] 	= Vtiger_Util_Helper::formatDateDiffInStrings($timestamp);
		  		$notifications['details'][$i]['unread'] 		= $viewed;

		  		if($viewed==0)
		  			$unread++;
			}

			$notifications['new'] = $unread;
		}
		return $notifications;
	}

	function getDepartments(){
 
 		$db = PearDatabase::getInstance();	
 		$result = $db->pquery("SELECT * from vtiger_department WHERE presence=1 ORDER BY ");
 	}
}
