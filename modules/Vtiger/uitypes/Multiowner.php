<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

class Vtiger_Multiowner_UIType extends Vtiger_Base_UIType {

	/**
	 * Function to get the Template name for the current UI Type object
	 * @return <String> - Template Name
	 */
	public function getTemplateName() {
		return 'uitypes/MultiOwner.tpl';
	}

	/**
	 * Function to get the Display Value, for the current field type with given DB Insert Value
	 * @param <Object> $value
	 * @return <Object>
	 */
	public function getDisplayValue($ids) {
		
		if(!is_array($ids)){
			$values = explode('|##|', $ids);	
		} else {
			$values = $ids;
		}
		
        if($values == NULL && !is_array($values)) return;
        $k = 0;
        foreach($values as $value){
            if (self::getOwnerType($value) === 'User') {
                $userModel = Users_Record_Model::getCleanInstance('Users');
                $userModel->set('id', $value);
                $detailViewUrl = $userModel->getDetailViewUrl();
                $currentUser = Users_Record_Model::getCurrentUserModel();
                /*if(!$currentUser->isAdminUser()){
                    return getOwnerName($value);
                }*/
            } else {
                $currentUser = Users_Record_Model::getCurrentUserModel();
                /*if(!$currentUser->isAdminUser()){
                    return getOwnerName($value);
                }*/
                $recordModel = new Settings_Groups_Record_Model();
                $recordModel->set('groupid',$value);
                $detailViewUrl = $recordModel->getDetailViewUrl();
            }
            if($k%2==0 && $k !=0){
            	$displayvalue[] = "&nbsp;<a href=" .$detailViewUrl. ">" .getOwnerName($value). "</a>"."<br />";	
             } else {
            	$displayvalue[] = "&nbsp;<a href=" .$detailViewUrl. ">" .getOwnerName($value). "</a>";
            }	
            $k++;
        }
        $displayvalue = implode(',',$displayvalue);
        return $displayvalue;
	}
    
	/**
	 * Function to know owner is either User or Group
	 * @param <Integer> userId/GroupId
	 * @return <String> User/Group
	 */
	public static function getOwnerType($id) {
		$db = PearDatabase::getInstance();

		$result = $db->pquery('SELECT 1 FROM vtiger_users WHERE id = ?', array($id));
		if ($db->num_rows($result) > 0) {
			return 'User';
		}
		return 'Group';
	}
}