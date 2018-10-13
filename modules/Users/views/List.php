<?php
/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.1
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/

class Users_List_View extends Settings_Vtiger_List_View {
        private $_limit;
        private $_page;
        private $_query;
        private $_total;
        
        function checkPermission(Vtiger_Request $request) {
                $currentUserModel = Users_Record_Model::getCurrentUserModel();
                global $current_user;

                //echo  $current_user->get('hradmin');
                if(!$currentUserModel->isAdminUser() && $current_user->roleid !='H12' && $current_user->roleid !='H13') {
                        throw new AppException(vtranslate('LBL_PERMISSION_DENIED', 'Vtiger'));
                }
        }

        public function process(Vtiger_Request $request) {
                 //global $adb;

                 global $site_URL;
                $alphabet = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');


                $URL = $site_URL.'/index.php?module=Users&parent=Settings&view=List&block=1&fieldid=1';
                $defaultview = $request->get('empview');	
                $Alphabet = $request->get('Alphabet');
                $currentUserModel = Users_Record_Model::getCurrentUserModel();
                //defaultTab : EmployeeDirectory
                $tabType = $request->get('tabtype');

                if($tabType == 'MD'){
                        $request->set('search_params', array("department","c", $currentUserModel->get('department')));	
                }
//
                $defaultview = $request->get('empview');	

                if(!$request->get('empview')){
                     $defaultview = 'grid';	
                }
                

                $viewer = $this->getViewer($request);
                $this->initializeListViewContents($request, $viewer);

                $viewer->assign('TAB_TYPE', $tabType);
                $viewer->assign('ALPHABETS', $alphabet);
                $viewer->assign('EMP_VIEW', $defaultview);
                $viewer->assign('PAGE_URL',$URL);
                $viewer->assign('TEXT_FILTER',$Alphabet);
                $viewer->assign('DEPT',$currentUserModel->get('department'));
                $viewer->assign("SEVEN_DAYS_AGO", date('Y-m-d', strtotime("-7 day")));
                 $viewer->assign("SEVEN_DAYS_AFTER", date('Y-m-d', strtotime("+7 day")));

                //$viewer->view('GridViewContents.tpl', $request->getModule(false));
                if( $tabType  ==  'WAI'){
                  
                        $viewer->view('EmployeeTree.tpl',  $request->getModule(false));
                } else {
                    if($defaultview =='grid'){
                            $viewer->view('GridViewContents.tpl', $request->getModule(false));
                    }
                    else {
                            $viewer->view('ListViewContents.tpl', $request->getModule(false));
                    }
                 }      
        }

        /*
         * Function to initialize the required data in smarty to display the List View Contents
         */
    public function initializeListViewContents(Vtiger_Request $request, Vtiger_Viewer $viewer) {
            global $adb;
           //$adb->setDebug(true);
            $moduleName = $request->getModule();
            $cvId = $request->get('viewname');
            $pageNumber = $request->get('page');
            $orderBy = $request->get('orderby');
            $sortOrder = $request->get('sortorder');
            $currentUserModel = Users_Record_Model::getCurrentUserModel();
            
               if(!$request->get('empview')){
                     $defaultview = 'grid';	
                }
                else{
                        $defaultview = 'list';	
                }
                if(!$request->get('tabtype')){
                     $tabType = 'ED';	
                }else{
                    $tabType = $request->get('tabtype');
                }  
                    $searchType = $request->get('searchType');
                    if($tabType == 'MD'){
                        $request->set('search_key','department');
                        $request->set('search_value',$currentUserModel->get('department'));
                         $request->set('operator','e');
                    }
                    
                    if($searchType == 'alphabet'){
                        $request->set('search_key','first_name');
                        $request->set('search_value',$currentUserModel->get('first_name'));
                         $request->set('operator','s');
                         
                    }

         
           //  $request->set('search_params', array("department","e", $currentUserModel->get('department')));	
            $searchParams = $request->get('search_params');
    
            if($sortOrder == "ASC"){
                    $nextSortOrder = "DESC";
                    $sortImage = "icon-chevron-down";
                    $faSortImage = "fa-sort-desc";
            }else{
                    $nextSortOrder = "ASC";
                    $sortImage = "icon-chevron-up";
                    $faSortImage = "fa-sort-asc";
            }

            if(empty ($pageNumber)){
                    $pageNumber = '1';
            }

            $status = $request->get('status');
            if(empty($status))
                    $status = 'Active';



            $listViewModel = Vtiger_ListView_Model::getInstance($moduleName, $cvId);

            $linkParams = array('MODULE'=>$moduleName, 'ACTION'=>$request->get('view'), 'CVID'=>$cvId);
            $linkModels = $listViewModel->getListViewMassActions($linkParams);
                            $listViewModel->set('status', $status);

            $pagingModel = new Vtiger_Paging_Model();
            $pagingModel->set('page', $pageNumber);
        

            if(!empty($orderBy)) {
                    $listViewModel->set('orderby', $orderBy);
                    $listViewModel->set('sortorder',$sortOrder);
            }

            $searchKey = $request->get('search_key');
            $searchValue = $request->get('search_value');
            $operator = $request->get('operator');

            if($request->get('mode') == 'removeAlphabetSearch') {
                    Vtiger_ListView_Model::deleteParamsSession($moduleName.'_'.$cvId, array('search_key', 'search_value', 'operator'));
                    $searchKey = '';
                    $searchValue = '';
                    $operator = '';
            }
            if($request->get('mode') == 'removeSorting') {
                    Vtiger_ListView_Model::deleteParamsSession($listViewSessionKey, array('orderby', 'sortorder'));
                    $orderBy = '';
                    $sortOrder = '';
            }
            if(!empty($operator)) {
                    $listViewModel->set('operator', $operator);
                    $viewer->assign('OPERATOR',$operator);
                    $viewer->assign('ALPHABET_VALUE',$searchValue);
            }
            if(!empty($searchKey) && !empty($searchValue)) {
                    $listViewModel->set('search_key', $searchKey);
                    $listViewModel->set('search_value', $searchValue);
            }

            if(empty($searchParams)) {
                    $searchParams = array();
            }

            $transformedSearchParams = $this->transferListSearchParamsToFilterCondition($searchParams, $listViewModel->getModule());
            $listViewModel->set('search_params',$transformedSearchParams);

            //To make smarty to get the details easily accesible
            foreach($searchParams as $fieldListGroup){
                    foreach($fieldListGroup as $fieldSearchInfo){
                            $fieldSearchInfo['searchValue'] = $fieldSearchInfo[2];
                            $fieldSearchInfo['fieldName'] = $fieldName = $fieldSearchInfo[0];
                            $fieldSearchInfo['comparator'] = $fieldSearchInfo[1];
                            $searchParams[$fieldName] = $fieldSearchInfo;
                    }
            }

            if(!$this->listViewHeaders){
                    $this->listViewHeaders = $listViewModel->getListViewHeaders();
            }
            if(!$this->listViewEntries){
                    $this->listViewEntries = $listViewModel->getListViewEntries($pagingModel); 
            }
            $noOfEntries = count($this->listViewEntries);

            $viewer->assign('MODULE', $moduleName);

            if(!$this->listViewLinks){
                    $this->listViewLinks = $listViewModel->getListViewLinks($linkParams);
            }
            $viewer->assign('LISTVIEW_LINKS', $this->listViewLinks);

            $viewer->assign('LISTVIEW_MASSACTIONS', $linkModels['LISTVIEWMASSACTION']);

            $viewer->assign('PAGING_MODEL', $pagingModel);
            $viewer->assign('PAGE_NUMBER',$pageNumber);

            $viewer->assign('ORDER_BY',$orderBy);
            $viewer->assign('SORT_ORDER',$sortOrder);
            $viewer->assign('NEXT_SORT_ORDER',$nextSortOrder);
            $viewer->assign('SORT_IMAGE',$sortImage);
            $viewer->assign('COLUMN_NAME',$orderBy);
            $viewer->assign('QUALIFIED_MODULE', $moduleName);
            $viewer->assign('FASORT_IMAGE',$faSortImage);
            $viewer->assign('EMP_VIEW', $defaultview);
            $viewer->assign('LISTVIEW_ENTRIES_COUNT',$noOfEntries);
            $viewer->assign('LISTVIEW_HEADERS', $this->listViewHeaders);
            $viewer->assign('LISTVIEW_ENTRIES', $this->listViewEntries);
            $viewer->assign('TAB_TYPE', $tabType);
            if (PerformancePrefs::getBoolean('LISTVIEW_COMPUTE_PAGE_COUNT', true)) {
                    if(!$this->listViewCount){
                            $this->listViewCount = $listViewModel->getListViewCount();
                    }
                     $totalCount = $this->listViewCount;
                    $pageLimit = $pagingModel->getPageLimit();
                    $pageCount = ceil((int) $totalCount / (int) $pageLimit);

                    if($pageCount == 0){
                            $pageCount = 1;
                    }
                    $viewer->assign('PAGE_COUNT', $pageCount);
                    $viewer->assign('LISTVIEW_COUNT', $totalCount);
            }
            $viewer->assign('MODULE_MODEL', $listViewModel->getModule());
            $viewer->assign('IS_MODULE_EDITABLE', $listViewModel->getModule()->isPermitted('EditView'));
            $viewer->assign('IS_MODULE_DELETABLE', $listViewModel->getModule()->isPermitted('Delete'));
            $viewer->assign('USER_MODEL', Users_Record_Model::getCurrentUserModel());
            $viewer->assign('SEARCH_VALUE', $searchValue);
            $viewer->assign('SEARCH_DETAILS', $searchParams);
    }

    /**
     * Function returns the number of records for the current filter
     * @param Vtiger_Request $request
     */
    function getRecordsCount(Vtiger_Request $request) {
            $moduleName = $request->getModule();
            $cvId = $request->get('viewname');
            $count = $this->getListViewCount($request);

            $result = array();
            $result['module'] = $moduleName;
            $result['viewname'] = $cvId;
            $result['count'] = $count;

            $response = new Vtiger_Response();
            $response->setEmitType(Vtiger_Response::$EMIT_JSON);
            $response->setResult($result);
            $response->emit();
    }

    /**
     * Function to get listView count
     * @param Vtiger_Request $request
     */
    function getListViewCount(Vtiger_Request $request){
            $moduleName = $request->getModule();
            $cvId = $request->get('viewname');
            if(empty($cvId)) {
                    $cvId = '0';
            }

            $searchKey = $request->get('search_key');
            $searchValue = $request->get('search_value');

            $listViewModel = Vtiger_ListView_Model::getInstance($moduleName, $cvId);
            if(empty($tagParams)){
                    $tagParams = array();
            }

            $searchParams = $request->get('search_params');
            $searchAndTagParams = array_merge($searchParams, $tagParams);

            $listViewModel->set('search_params',$this->transferListSearchParamsToFilterCondition($searchAndTagParams, $listViewModel->getModule()));

            $listViewModel->set('search_key', $searchKey);
            $listViewModel->set('search_value', $searchValue);
            $listViewModel->set('operator', $request->get('operator'));

            $count = $listViewModel->getListViewCount();

            return $count;
    }



        /**
         * Function to get the page count for list
         * @return total number of pages
         */
        function getPageCount(Vtiger_Request $request){
                $listViewCount   = $this->getListViewCount($request);
                $pagingModel    = new Vtiger_Paging_Model();
                $pageLimit          = $pagingModel->getPageLimit();
                $pageCount        = ceil((int) $listViewCount / (int) $pageLimit);

                if($pageCount == 0){
                        $pageCount = 1;
                }
                $result = array();
                $result['page'] = $pageCount;
                $this->_total = $listViewCount;
                $result['numberOfRecords'] = $listViewCount;
                $response = new Vtiger_Response();
                $response->setResult($result);
                $response->emit();
        }

    /**
     * Setting module related Information to $viewer (for Vtiger7)
     * @param type $request
     * @param type $moduleModel
     */
    public function setModuleInfo($request, $moduleModel){
            $fieldsInfo = array();
            $basicLinks = array();

            $moduleFields = $moduleModel->getFields();
            foreach($moduleFields as $fieldName => $fieldModel){
                    $fieldsInfo[$fieldName] = $fieldModel->getFieldInfo();
            }

            $moduleBasicLinks = $moduleModel->getModuleBasicLinks();
            foreach($moduleBasicLinks as $basicLink){
                    $basicLinks[] = Vtiger_Link_Model::getInstanceFromValues($basicLink);
            }

            $viewer = $this->getViewer($request);

            $listViewModel = Vtiger_ListView_Model::getInstance($moduleModel->getName()); 
            $linkParams = array('MODULE'=>$moduleModel->getName(), 'ACTION'=>$request->get('view')); 

            if(!$this->listViewLinks){ 
                    $this->listViewLinks = $listViewModel->getListViewLinks($linkParams); 
            }

            $viewer->assign('LISTVIEW_LINKS', $this->listViewLinks); 
            $viewer->assign('FIELDS_INFO', json_encode($fieldsInfo));
            $viewer->assign('MODULE_BASIC_ACTIONS', $basicLinks);
    }

    public function transferListSearchParamsToFilterCondition($listSearchParams, $moduleModel) {
            return Vtiger_Util_Helper::transferListSearchParamsToFilterCondition($listSearchParams, $moduleModel);
    }

    public function getHeaderCss(Vtiger_Request $request) {
            $headerCssInstances = parent::getHeaderCss($request);
            $cssFileNames = array(
                    "~layouts/".Vtiger_Viewer::getDefaultLayoutName()."/lib/jquery/perfect-scrollbar/css/perfect-scrollbar.css",
                     "//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css"
            );
            $cssInstances = $this->checkAndConvertCssStyles($cssFileNames);
            $headerCssInstances = array_merge($headerCssInstances, $cssInstances);
            return $headerCssInstances;
    }

     function getHeaderScripts(Vtiger_Request $request) {
                $headerScriptInstances = parent::getHeaderScripts($request);

                $jsFileNames = array(
                        'modules.Users.resources.List',
                        "modules.Emails.resources.MassEdit",
                        "~layouts/".Vtiger_Viewer::getDefaultLayoutName()."/lib/jquery/floatThead/jquery.floatThead.js",
                        "//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js",
                        "//code.jquery.com/jquery-1.11.1.min.js"
                );

                $jsScriptInstances = $this->checkAndConvertJsScripts($jsFileNames);
                $headerScriptInstances = array_merge($headerScriptInstances, $jsScriptInstances);
                return $headerScriptInstances;
        }
        
        public function createLinks( $links, $list_class ) {
            if ( $this->_limit == 'all' ) {
                return '';
            }

            $last       = ceil( $this->_total / $this->_limit );

            $start      = ( ( $this->_page - $links ) > 0 ) ? $this->_page - $links : 1;
            $end        = ( ( $this->_page + $links ) < $last ) ? $this->_page + $links : $last;

            $html       = '<ul class="' . $list_class . '">';

            $class      = ( $this->_page == 1 ) ? "disabled" : "";
            $html       .= '<li class="' . $class . '"><a href="?limit=' . $this->_limit . '&page=' . ( $this->_page - 1 ) . '">&laquo;</a></li>';

            if ( $start > 1 ) {
                $html   .= '<li><a href="?limit=' . $this->_limit . '&page=1">1</a></li>';
                $html   .= '<li class="disabled"><span>...</span></li>';
            }

            for ( $i = $start ; $i <= $end; $i++ ) {
                $class  = ( $this->_page == $i ) ? "active" : "";
                $html   .= '<li class="' . $class . '"><a href="?limit=' . $this->_limit . '&page=' . $i . '">' . $i . '</a></li>';
            }

            if ( $end < $last ) {
                $html   .= '<li class="disabled"><span>...</span></li>';
                $html   .= '<li><a href="?limit=' . $this->_limit . '&page=' . $last . '">' . $last . '</a></li>';
            }

            $class      = ( $this->_page == $last ) ? "disabled" : "";
            $html       .= '<li class="' . $class . '"><a href="?limit=' . $this->_limit . '&page=' . ( $this->_page + 1 ) . '">&raquo;</a></li>';

            $html       .= '</ul>';

            return $html;
        }

}
