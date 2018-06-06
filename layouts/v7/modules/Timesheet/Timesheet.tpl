

<div class="container-fluid">
   <div class="contentHeader row">
      <h3 class="col-lg-8 textOverflowEllipsis" style="height: 30px;">
         <strong>Janice Brown:</strong> May 16, 2018 - May 31, 2018
      </h3>
   </div>
   <hr>
   <div class="clearfix"></div>
   <div class="listViewContentDiv row" id="listViewContents">
      <div class="marginBottom10px">
         <h5 class="col-lg-12">
            Billable
            <strong>
            16:00
            </strong> |                                                                    Sick
            <strong>
            09:00
            </strong> |                                                                    Regular
            <strong>
            02:00
            </strong>                                                         
         </h5>
      </div>
      <form method="post" action="index.php" id="EditView" name="edit">
         <input name="__vtrftk" value="sid:e95419f21f5e638f7dd67687b4b5fa0c20325871,1527151007" type="hidden">
         <input name="txtDayStartTime" id="txtDayStartTime" value="07:00 AM" type="hidden">
         <input name="txtDayEndTime" id="txtDayEndTime" value="06:00 PM" type="hidden">
         <input name="txtLockTimesheet" id="txtLockTimesheet" value="1" type="hidden">
         <input name="txtIsAdminUser" id="txtIsAdminUser" value="1" type="hidden">
         <div class="col-lg-12 vteTimeSheetsRecords">
            <table class="table table-border-black listViewEntriesTable vte-listview-color">
               <thead>
                  <tr class="listViewHeaders">
                     <th class="medium" style="width: 10%;">DAY</th>
                     <th class="medium" style="width: 8%;">IN</th>
                     <th class="medium" style="width: 8%;">OUT</th>
                     <th class="medium" style="width: 8%;">Total</th>
                     <th class="medium" style="width: 12%;">Type</th>
                     <th class="medium">Detail</th>
                     <th class="medium" style="width: 6%;">Action</th>
                     <th class="medium" style="width: 8%;">Worked</th>
                  </tr>
               </thead>
               <tbody>
                  <tr class="rowClone VTETimesheetsRecordsClone hide">
                     <td class="fieldValue" field_label="Day">
                        <div class="vtereference">
                           <div class="input-group inputElement" style="margin-bottom: 3px"><input id="VTETimesheets_editView_fieldName_timesheetdate" class="dateField form-control " data-fieldname="timesheetdate" data-fieldtype="date" name="timesheetdate" data-date-format="yyyy-mm-dd" value="" data-rule-date="true" type="text"><span class="input-group-addon"><i class="fa fa-calendar "></i></span></div>
                        </div>
                     </td>
                     <td class="fieldValue" field_label="In">
                        <div class="vtereference">
                           <div class="input-group inputElement time"><input id="VTETimesheets_editView_fieldName_time_in" data-format="12" class="timepicker-default form-control ui-timepicker-input" value="" name="time_in" data-rule-required="true" data-rule-time="true" autocomplete="off" type="text"><span class="input-group-addon" style="width: 30px;"><i class="fa fa-clock-o"></i></span></div>
                        </div>
                     </td>
                     <td class="fieldValue" field_label="Out">
                        <div class="vtereference">
                           <div class="input-group inputElement time"><input id="VTETimesheets_editView_fieldName_time_out" data-format="12" class="timepicker-default form-control ui-timepicker-input" value="" name="time_out" data-rule-required="true" data-rule-time="true" autocomplete="off" type="text"><span class="input-group-addon" style="width: 30px;"><i class="fa fa-clock-o"></i></span></div>
                        </div>
                     </td>
                     <td class="fieldValue" field_label="Total">
                        <div class="vtereference">
                           <input id="VTETimesheets_editView_fieldName_total" class="inputElement" name="total" value="" type="text">
                        </div>
                     </td>
                     <td class="fieldValue" field_label="Type">
                        <div class="vtereference">
                           <div class="select2-container inputElement select2" id="s2id_autogen1">
                              <a href="javascript:void(0)" class="select2-choice" tabindex="-1">   <span class="select2-chosen" id="select2-chosen-2">Select an Option</span><abbr class="select2-search-choice-close"></abbr>   <span class="select2-arrow" role="presentation"><b role="presentation"></b></span></a><label for="s2id_autogen2" class="select2-offscreen"></label><input class="select2-focusser select2-offscreen" aria-haspopup="true" role="button" aria-labelledby="select2-chosen-2" id="s2id_autogen2" type="text">
                              <div class="select2-drop select2-display-none select2-with-searchbox">
                                 <div class="select2-search">       <label for="s2id_autogen2_search" class="select2-offscreen"></label>       <input autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" class="select2-input ignore-validation" role="combobox" aria-expanded="true" aria-autocomplete="list" aria-owns="select2-results-2" id="s2id_autogen2_search" placeholder="" type="text">   </div>
                                 <ul class="select2-results" role="listbox" id="select2-results-2">   </ul>
                              </div>
                           </div>
                           <select data-fieldname="timesheet_type" data-fieldtype="picklist" class="inputElement select2  select2-offscreen" type="picklist" name="timesheet_type" data-selected-value="" data-rule-required="true" tabindex="-1" title="">
                              <option value="">Select an Option</option>
                              <option value="Regular" class="picklistColor_timesheet_type_Regular">Regular</option>
                              <option value="Billable" class="picklistColor_timesheet_type_Billable">Billable</option>
                              <option value="Non-Billable" class="picklistColor_timesheet_type_Non-Billable">Non-Billable</option>
                              <option value="Overtime" class="picklistColor_timesheet_type_Overtime">Overtime</option>
                              <option value="Sick" class="picklistColor_timesheet_type_Sick">Sick</option>
                           </select>
                        </div>
                     </td>
                     <td class="fieldValue" field_label="Description">
                        <div class="vtereference">
                           <textarea rows="3" id="VTETimesheets_editView_fieldName_description" class="inputElement textAreaElement col-lg-12 " name="description"></textarea>
                        </div>
                     </td>
                     <td class="fieldValue">
                        <div class="actions" style="text-align: center;">
                           &nbsp;<a class="saveVTETimeSheetsButton"><i title="Save" class="glyphicon glyphicon-ok alignMiddle"></i></a>
                           &nbsp;<a class="deleteVTETimeSheetsButton"><i title="Delete" class="glyphicon glyphicon-trash alignMiddle"></i></a>
                        </div>
                     </td>
                     <td>
                     </td>
                  </tr>
                  <tr class="vteTimeSheetsRecords ">
                     <td class="listViewEntryValue" rowspan="1" width="17%">
                        <b>Wed</b>, May 16, 2018
                        <span style="float:right;">
                        <i class="glyphicon glyphicon-plus-sign btnAddMore" title="Add Timesheet" data-record="" data-date="2018-05-16"></i>
                        </span>
                     </td>
                     <td class="fieldValue">
                        <span class="dplvalue value" data-field-type="time">
                        07:30 AM
                        </span>
                        <span class="hide edit" field_label="In">
                           <div class="input-group inputElement time"><input id="VTETimesheets_editView_fieldName_time_in" data-format="12" class="timepicker-default form-control ui-timepicker-input" value="07:30 AM" name="time_in" data-rule-required="true" data-rule-time="true" autocomplete="off" type="text"><span class="input-group-addon" style="width: 30px;"><i class="fa fa-clock-o"></i></span></div>
                        </span>
                     </td>
                     <td class="fieldValue">
                        <span class="dplvalue value" data-field-type="time">
                        08:30 AM
                        </span>
                        <span class="hide edit" field_label="Out">
                           <div class="input-group inputElement time"><input id="VTETimesheets_editView_fieldName_time_out" data-format="12" class="timepicker-default form-control ui-timepicker-input" value="08:30 AM" name="time_out" data-rule-required="true" data-rule-time="true" autocomplete="off" type="text"><span class="input-group-addon" style="width: 30px;"><i class="fa fa-clock-o"></i></span></div>
                        </span>
                     </td>
                     <td class="fieldValue">
                        <span class="dplvalue value" data-field-type="double">
                        01:00
                        </span>
                        <span class="hide edit" field_label="Total">
                        <input id="VTETimesheets_editView_fieldName_total" class="inputElement" name="total" value="60.00" type="text">
                        </span>
                     </td>
                     <td class="fieldValue">
                        <span class="dplvalue value" data-field-type="picklist">
                        <span class="picklist-color" style="background-color: #a8ffdf; line-height:15px; color: black;">
                        Regular
                        </span>
                        </span>
                        <span class="hide edit" field_label="Type">
                           <div class="select2-container inputElement select2" id="s2id_autogen3">
                              <a href="javascript:void(0)" class="select2-choice" tabindex="-1">   <span class="select2-chosen" id="select2-chosen-4">Regular</span><abbr class="select2-search-choice-close"></abbr>   <span class="select2-arrow" role="presentation"><b role="presentation"></b></span></a><label for="s2id_autogen4" class="select2-offscreen"></label><input class="select2-focusser select2-offscreen" aria-haspopup="true" role="button" aria-labelledby="select2-chosen-4" id="s2id_autogen4" type="text">
                              <div class="select2-drop select2-display-none select2-with-searchbox">
                                 <div class="select2-search">       <label for="s2id_autogen4_search" class="select2-offscreen"></label>       <input autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" class="select2-input" role="combobox" aria-expanded="true" aria-autocomplete="list" aria-owns="select2-results-4" id="s2id_autogen4_search" placeholder="" type="text">   </div>
                                 <ul class="select2-results" role="listbox" id="select2-results-4">   </ul>
                              </div>
                           </div>
                           <select data-fieldname="timesheet_type" data-fieldtype="picklist" class="inputElement select2  select2-offscreen" type="picklist" name="timesheet_type" data-selected-value="Regular" data-rule-required="true" tabindex="-1" title="">
                              <option value="">Select an Option</option>
                              <option value="Regular" class="picklistColor_timesheet_type_Regular" selected="">Regular</option>
                              <option value="Billable" class="picklistColor_timesheet_type_Billable">Billable</option>
                              <option value="Non-Billable" class="picklistColor_timesheet_type_Non-Billable">Non-Billable</option>
                              <option value="Overtime" class="picklistColor_timesheet_type_Overtime">Overtime</option>
                              <option value="Sick" class="picklistColor_timesheet_type_Sick">Sick</option>
                           </select>
                           
                        </span>
                     </td>
                     <td class="fieldValue">
                        <span class="dplvalue value" data-field-type="text" style="white-space:normal;">
                        lll
                        </span>
                        <span class="hide edit" field_label="Description">
                        <textarea rows="3" id="VTETimesheets_editView_fieldName_description" class="inputElement textAreaElement col-lg-12 " name="description">lll</textarea>
                        </span>
                     </td>
                     <td class="fieldValue">
                        <div class="actions " style="text-align: center;">
                           <span class="hide edit">
                           &nbsp;<a class="saveVTETimeSheetsButton" data-record-date="2018-05-16" data-record-id="203"><i title="Save" class="glyphicon glyphicon-ok alignMiddle"></i></a>
                           <a class="hoverEditCancel"><i class="glyphicon glyphicon-remove alignMiddle"></i></a>
                           </span>
                           <span class="actionImages">
                           <span class="dplvalue">
                           <a class="editVTETimeSheetsButton" data-record-id="203">
                           <i class="glyphicon glyphicon-pencil alignMiddle" title="Edit Timesheet"></i>
                           </a>
                           <a class="deleteVTETimeSheetsButton" data-record-id="203">
                           <i class="glyphicon glyphicon-trash alignMiddle" title="Delete Timesheet"></i>
                           </a>
                           </span>
                           </span>
                        </div>
                     </td>
                     <td rowspan="1" class="worked">
                        01:00
                     </td>
                  </tr>
                  <tr class="vteTimeSheetsRecords ">
                     <td class="listViewEntryValue" width="17%">
                        <b>Thu</b>, May 17, 2018
                        <span style="float:right;">
                        <i class="glyphicon glyphicon-plus-sign btnAddMore" title="Add Timesheet" data-record="" data-date="2018-05-17"></i>
                        </span>
                     </td>
                     <td></td>
                     <td></td>
                     <td></td>
                     <td></td>
                     <td></td>
                     <td></td>
                     <td></td>
                  </tr>
                  <tr class="vteTimeSheetsRecords ">
                     <td class="listViewEntryValue" width="17%">
                        <b>Fri</b>, May 18, 2018
                        <span style="float:right;">
                        <i class="glyphicon glyphicon-plus-sign btnAddMore" title="Add Timesheet" data-record="" data-date="2018-05-18"></i>
                        </span>
                     </td>
                     <td></td>
                     <td></td>
                     <td></td>
                     <td></td>
                     <td></td>
                     <td></td>
                     <td></td>
                  </tr>
                  <tr class="vteTimeSheetsRecords ">
                     <td class="listViewEntryValue" rowspan="2" width="17%">
                        <b>Sat</b>, May 19, 2018
                        <span style="float:right;">
                        <i class="glyphicon glyphicon-plus-sign btnAddMore" title="Add Timesheet" data-record="" data-date="2018-05-19"></i>
                        </span>
                     </td>
                     <td class="fieldValue">
                        <span class="dplvalue value" data-field-type="time">
                        8:00 AM
                        </span>
                        <span class="hide edit" field_label="In">
                           <div class="input-group inputElement time"><input id="VTETimesheets_editView_fieldName_time_in" data-format="12" class="timepicker-default form-control ui-timepicker-input" value="8:00 AM" name="time_in" data-rule-required="true" data-rule-time="true" autocomplete="off" type="text"><span class="input-group-addon" style="width: 30px;"><i class="fa fa-clock-o"></i></span></div>
                        </span>
                     </td>
                     <td class="fieldValue">
                        <span class="dplvalue value" data-field-type="time">
                        9:00 AM
                        </span>
                        <span class="hide edit" field_label="Out">
                           <div class="input-group inputElement time"><input id="VTETimesheets_editView_fieldName_time_out" data-format="12" class="timepicker-default form-control ui-timepicker-input" value="9:00 AM" name="time_out" data-rule-required="true" data-rule-time="true" autocomplete="off" type="text"><span class="input-group-addon" style="width: 30px;"><i class="fa fa-clock-o"></i></span></div>
                        </span>
                     </td>
                     <td class="fieldValue">
                        <span class="dplvalue value" data-field-type="double">
                        01:00
                        </span>
                        <span class="hide edit" field_label="Total">
                        <input id="VTETimesheets_editView_fieldName_total" class="inputElement" name="total" value="60.00" type="text">
                        </span>
                     </td>
                     <td class="fieldValue">
                        <span class="dplvalue value" data-field-type="picklist">
                        <span class="picklist-color" style="background-color: #a8ffdf; line-height:15px; color: black;">
                        Regular
                        </span>
                        </span>
                        <span class="hide edit" field_label="Type">
                           <div class="select2-container inputElement select2" id="s2id_autogen5">
                              <a href="javascript:void(0)" class="select2-choice" tabindex="-1">   <span class="select2-chosen" id="select2-chosen-6">Regular</span><abbr class="select2-search-choice-close"></abbr>   <span class="select2-arrow" role="presentation"><b role="presentation"></b></span></a><label for="s2id_autogen6" class="select2-offscreen"></label><input class="select2-focusser select2-offscreen" aria-haspopup="true" role="button" aria-labelledby="select2-chosen-6" id="s2id_autogen6" type="text">
                              <div class="select2-drop select2-display-none select2-with-searchbox">
                                 <div class="select2-search">       <label for="s2id_autogen6_search" class="select2-offscreen"></label>       <input autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" class="select2-input" role="combobox" aria-expanded="true" aria-autocomplete="list" aria-owns="select2-results-6" id="s2id_autogen6_search" placeholder="" type="text">   </div>
                                 <ul class="select2-results" role="listbox" id="select2-results-6">   </ul>
                              </div>
                           </div>
                           <select data-fieldname="timesheet_type" data-fieldtype="picklist" class="inputElement select2  select2-offscreen" type="picklist" name="timesheet_type" data-selected-value="Regular" data-rule-required="true" tabindex="-1" title="">
                              <option value="">Select an Option</option>
                              <option value="Regular" class="picklistColor_timesheet_type_Regular" selected="">Regular</option>
                              <option value="Billable" class="picklistColor_timesheet_type_Billable">Billable</option>
                              <option value="Non-Billable" class="picklistColor_timesheet_type_Non-Billable">Non-Billable</option>
                              <option value="Overtime" class="picklistColor_timesheet_type_Overtime">Overtime</option>
                              <option value="Sick" class="picklistColor_timesheet_type_Sick">Sick</option>
                           </select>
                           
                        </span>
                     </td>
                     <td class="fieldValue">
                        <span class="dplvalue value" data-field-type="text" style="white-space:normal;">
                        </span>
                        <span class="hide edit" field_label="Description">
                        <textarea rows="3" id="VTETimesheets_editView_fieldName_description" class="inputElement textAreaElement col-lg-12 " name="description"></textarea>
                        </span>
                     </td>
                     <td class="fieldValue">
                        <div class="actions " style="text-align: center;">
                           <span class="hide edit">
                           &nbsp;<a class="saveVTETimeSheetsButton" data-record-date="2018-05-19" data-record-id="126"><i title="Save" class="glyphicon glyphicon-ok alignMiddle"></i></a>
                           <a class="hoverEditCancel"><i class="glyphicon glyphicon-remove alignMiddle"></i></a>
                           </span>
                           <span class="actionImages">
                           <span class="dplvalue">
                           <a class="editVTETimeSheetsButton" data-record-id="126">
                           <i class="glyphicon glyphicon-pencil alignMiddle" title="Edit Timesheet"></i>
                           </a>
                           <a class="deleteVTETimeSheetsButton" data-record-id="126">
                           <i class="glyphicon glyphicon-trash alignMiddle" title="Delete Timesheet"></i>
                           </a>
                           </span>
                           </span>
                        </div>
                     </td>
                     <td rowspan="2" class="worked">
                        03:00
                     </td>
                  </tr>
                  <tr>
                     <td class="fieldValue">
                        <span class="dplvalue value" data-field-type="time">
                        9:00 AM
                        </span>
                        <span class="hide edit" field_label="In">
                           <div class="input-group inputElement time"><input id="VTETimesheets_editView_fieldName_time_in" data-format="12" class="timepicker-default form-control ui-timepicker-input" value="9:00 AM" name="time_in" data-rule-required="true" data-rule-time="true" autocomplete="off" type="text"><span class="input-group-addon" style="width: 30px;"><i class="fa fa-clock-o"></i></span></div>
                        </span>
                     </td>
                     <td class="fieldValue">
                        <span class="dplvalue value" data-field-type="time">
                        11:00 AM
                        </span>
                        <span class="hide edit" field_label="Out">
                           <div class="input-group inputElement time"><input id="VTETimesheets_editView_fieldName_time_out" data-format="12" class="timepicker-default form-control ui-timepicker-input" value="11:00 AM" name="time_out" data-rule-required="true" data-rule-time="true" autocomplete="off" type="text"><span class="input-group-addon" style="width: 30px;"><i class="fa fa-clock-o"></i></span></div>
                        </span>
                     </td>
                     <td class="fieldValue">
                        <span class="dplvalue value" data-field-type="double">
                        02:00
                        </span>
                        <span class="hide edit" field_label="Total">
                        <input id="VTETimesheets_editView_fieldName_total" class="inputElement" name="total" value="120.00" type="text">
                        </span>
                     </td>
                     <td class="fieldValue">
                        <span class="dplvalue value" data-field-type="picklist">
                        <span class="picklist-color" style="background-color: #d7f5a9; line-height:15px; color: black;">
                        Billable
                        </span>
                        </span>
                        <span class="hide edit" field_label="Type">
                           <div class="select2-container inputElement select2" id="s2id_autogen7">
                              <a href="javascript:void(0)" class="select2-choice" tabindex="-1">   <span class="select2-chosen" id="select2-chosen-8">Billable</span><abbr class="select2-search-choice-close"></abbr>   <span class="select2-arrow" role="presentation"><b role="presentation"></b></span></a><label for="s2id_autogen8" class="select2-offscreen"></label><input class="select2-focusser select2-offscreen" aria-haspopup="true" role="button" aria-labelledby="select2-chosen-8" id="s2id_autogen8" type="text">
                              <div class="select2-drop select2-display-none select2-with-searchbox">
                                 <div class="select2-search">       <label for="s2id_autogen8_search" class="select2-offscreen"></label>       <input autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" class="select2-input" role="combobox" aria-expanded="true" aria-autocomplete="list" aria-owns="select2-results-8" id="s2id_autogen8_search" placeholder="" type="text">   </div>
                                 <ul class="select2-results" role="listbox" id="select2-results-8">   </ul>
                              </div>
                           </div>
                           <select data-fieldname="timesheet_type" data-fieldtype="picklist" class="inputElement select2  select2-offscreen" type="picklist" name="timesheet_type" data-selected-value="Billable" data-rule-required="true" tabindex="-1" title="">
                              <option value="">Select an Option</option>
                              <option value="Regular" class="picklistColor_timesheet_type_Regular">Regular</option>
                              <option value="Billable" class="picklistColor_timesheet_type_Billable" selected="">Billable</option>
                              <option value="Non-Billable" class="picklistColor_timesheet_type_Non-Billable">Non-Billable</option>
                              <option value="Overtime" class="picklistColor_timesheet_type_Overtime">Overtime</option>
                              <option value="Sick" class="picklistColor_timesheet_type_Sick">Sick</option>
                           </select>
                           
                        </span>
                     </td>
                     <td class="fieldValue">
                        <span class="dplvalue value" data-field-type="text" style="white-space:normal;">
                        </span>
                        <span class="hide edit" field_label="Description">
                        <textarea rows="3" id="VTETimesheets_editView_fieldName_description" class="inputElement textAreaElement col-lg-12 " name="description"></textarea>
                        </span>
                     </td>
                     <td class="fieldValue">
                        <div class="actions " style="text-align: center;">
                           <span class="hide edit">
                           &nbsp;<a class="saveVTETimeSheetsButton" data-record-date="2018-05-19" data-record-id="104"><i title="Save" class="glyphicon glyphicon-ok alignMiddle"></i></a>
                           <a class="hoverEditCancel"><i class="glyphicon glyphicon-remove alignMiddle"></i></a>
                           </span>
                           <span class="actionImages">
                           <span class="dplvalue">
                           <a class="editVTETimeSheetsButton" data-record-id="104">
                           <i class="glyphicon glyphicon-pencil alignMiddle" title="Edit Timesheet"></i>
                           </a>
                           <a class="deleteVTETimeSheetsButton" data-record-id="104">
                           <i class="glyphicon glyphicon-trash alignMiddle" title="Delete Timesheet"></i>
                           </a>
                           </span>
                           </span>
                        </div>
                     </td>
                  </tr>
                  <tr class="vteTimeSheetsRecords ">
                     <td class="listViewEntryValue" width="17%">
                        <b>Sun</b>, May 20, 2018
                        <span style="float:right;">
                        <i class="glyphicon glyphicon-plus-sign btnAddMore" title="Add Timesheet" data-record="" data-date="2018-05-20"></i>
                        </span>
                     </td>
                     <td></td>
                     <td></td>
                     <td></td>
                     <td></td>
                     <td></td>
                     <td></td>
                     <td></td>
                  </tr>
                  <tr class="vteTimeSheetsRecords ">
                     <td class="listViewEntryValue" width="17%">
                        <b>Mon</b>, May 21, 2018
                        <span style="float:right;">
                        <i class="glyphicon glyphicon-plus-sign btnAddMore" title="Add Timesheet" data-record="" data-date="2018-05-21"></i>
                        </span>
                     </td>
                     <td></td>
                     <td></td>
                     <td></td>
                     <td></td>
                     <td></td>
                     <td></td>
                     <td></td>
                  </tr>
                  <tr class="vteTimeSheetsRecords ">
                     <td class="listViewEntryValue" width="17%">
                        <b>Tue</b>, May 22, 2018
                        <span style="float:right;">
                        <i class="glyphicon glyphicon-plus-sign btnAddMore" title="Add Timesheet" data-record="" data-date="2018-05-22"></i>
                        </span>
                     </td>
                     <td></td>
                     <td></td>
                     <td></td>
                     <td></td>
                     <td></td>
                     <td></td>
                     <td></td>
                  </tr>
                  <tr class="vteTimeSheetsRecords ">
                     <td class="listViewEntryValue" rowspan="1" width="17%">
                        <b>Wed</b>, May 23, 2018
                        <span style="float:right;">
                        <i class="glyphicon glyphicon-plus-sign btnAddMore" title="Add Timesheet" data-record="" data-date="2018-05-23"></i>
                        </span>
                     </td>
                     <td class="fieldValue">
                        <span class="dplvalue value" data-field-type="time">
                        8:00 AM
                        </span>
                        <span class="hide edit" field_label="In">
                           <div class="input-group inputElement time"><input id="VTETimesheets_editView_fieldName_time_in" data-format="12" class="timepicker-default form-control ui-timepicker-input" value="8:00 AM" name="time_in" data-rule-required="true" data-rule-time="true" autocomplete="off" type="text"><span class="input-group-addon" style="width: 30px;"><i class="fa fa-clock-o"></i></span></div>
                        </span>
                     </td>
                     <td class="fieldValue">
                        <span class="dplvalue value" data-field-type="time">
                        5:00 PM
                        </span>
                        <span class="hide edit" field_label="Out">
                           <div class="input-group inputElement time"><input id="VTETimesheets_editView_fieldName_time_out" data-format="12" class="timepicker-default form-control ui-timepicker-input" value="5:00 PM" name="time_out" data-rule-required="true" data-rule-time="true" autocomplete="off" type="text"><span class="input-group-addon" style="width: 30px;"><i class="fa fa-clock-o"></i></span></div>
                        </span>
                     </td>
                     <td class="fieldValue">
                        <span class="dplvalue value" data-field-type="double">
                        09:00
                        </span>
                        <span class="hide edit" field_label="Total">
                        <input id="VTETimesheets_editView_fieldName_total" class="inputElement" name="total" value="540.00" type="text">
                        </span>
                     </td>
                     <td class="fieldValue">
                        <span class="dplvalue value" data-field-type="picklist">
                        <span class="picklist-color" style="background-color: #d7f5a9; line-height:15px; color: black;">
                        Billable
                        </span>
                        </span>
                        <span class="hide edit" field_label="Type">
                           <div class="select2-container inputElement select2" id="s2id_autogen9">
                              <a href="javascript:void(0)" class="select2-choice" tabindex="-1">   <span class="select2-chosen" id="select2-chosen-10">Billable</span><abbr class="select2-search-choice-close"></abbr>   <span class="select2-arrow" role="presentation"><b role="presentation"></b></span></a><label for="s2id_autogen10" class="select2-offscreen"></label><input class="select2-focusser select2-offscreen" aria-haspopup="true" role="button" aria-labelledby="select2-chosen-10" id="s2id_autogen10" type="text">
                              <div class="select2-drop select2-display-none select2-with-searchbox">
                                 <div class="select2-search">       <label for="s2id_autogen10_search" class="select2-offscreen"></label>       <input autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" class="select2-input" role="combobox" aria-expanded="true" aria-autocomplete="list" aria-owns="select2-results-10" id="s2id_autogen10_search" placeholder="" type="text">   </div>
                                 <ul class="select2-results" role="listbox" id="select2-results-10">   </ul>
                              </div>
                           </div>
                           <select data-fieldname="timesheet_type" data-fieldtype="picklist" class="inputElement select2  select2-offscreen" type="picklist" name="timesheet_type" data-selected-value="Billable" data-rule-required="true" tabindex="-1" title="">
                              <option value="">Select an Option</option>
                              <option value="Regular" class="picklistColor_timesheet_type_Regular">Regular</option>
                              <option value="Billable" class="picklistColor_timesheet_type_Billable" selected="">Billable</option>
                              <option value="Non-Billable" class="picklistColor_timesheet_type_Non-Billable">Non-Billable</option>
                              <option value="Overtime" class="picklistColor_timesheet_type_Overtime">Overtime</option>
                              <option value="Sick" class="picklistColor_timesheet_type_Sick">Sick</option>
                           </select>
                           
                        </span>
                     </td>
                     <td class="fieldValue">
                        <span class="dplvalue value" data-field-type="text" style="white-space:normal;">
                        Onsite install
                        </span>
                        <span class="hide edit" field_label="Description">
                        <textarea rows="3" id="VTETimesheets_editView_fieldName_description" class="inputElement textAreaElement col-lg-12 " name="description">Onsite install</textarea>
                        </span>
                     </td>
                     <td class="fieldValue">
                        <div class="actions " style="text-align: center;">
                           <span class="hide edit">
                           &nbsp;<a class="saveVTETimeSheetsButton" data-record-date="2018-05-23" data-record-id="107"><i title="Save" class="glyphicon glyphicon-ok alignMiddle"></i></a>
                           <a class="hoverEditCancel"><i class="glyphicon glyphicon-remove alignMiddle"></i></a>
                           </span>
                           <span class="actionImages">
                           <span class="dplvalue">
                           <a class="editVTETimeSheetsButton" data-record-id="107">
                           <i class="glyphicon glyphicon-pencil alignMiddle" title="Edit Timesheet"></i>
                           </a>
                           <a class="deleteVTETimeSheetsButton" data-record-id="107">
                           <i class="glyphicon glyphicon-trash alignMiddle" title="Delete Timesheet"></i>
                           </a>
                           </span>
                           </span>
                        </div>
                     </td>
                     <td rowspan="1" class="worked">
                        09:00
                     </td>
                  </tr>
                  <tr class="vteTimeSheetsRecords ">
                     <td class="listViewEntryValue" rowspan="1" width="17%">
                        <b>Thu</b>, May 24, 2018
                        <span style="float:right;">
                        <i class="glyphicon glyphicon-plus-sign btnAddMore" title="Add Timesheet" data-record="" data-date="2018-05-24"></i>
                        </span>
                     </td>
                     <td class="fieldValue">
                        <span class="dplvalue value" data-field-type="time">
                        8:00 AM
                        </span>
                        <span class="hide edit" field_label="In">
                           <div class="input-group inputElement time"><input id="VTETimesheets_editView_fieldName_time_in" data-format="12" class="timepicker-default form-control ui-timepicker-input" value="8:00 AM" name="time_in" data-rule-required="true" data-rule-time="true" autocomplete="off" type="text"><span class="input-group-addon" style="width: 30px;"><i class="fa fa-clock-o"></i></span></div>
                        </span>
                     </td>
                     <td class="fieldValue">
                        <span class="dplvalue value" data-field-type="time">
                        1:00 PM
                        </span>
                        <span class="hide edit" field_label="Out">
                           <div class="input-group inputElement time"><input id="VTETimesheets_editView_fieldName_time_out" data-format="12" class="timepicker-default form-control ui-timepicker-input" value="1:00 PM" name="time_out" data-rule-required="true" data-rule-time="true" autocomplete="off" type="text"><span class="input-group-addon" style="width: 30px;"><i class="fa fa-clock-o"></i></span></div>
                        </span>
                     </td>
                     <td class="fieldValue">
                        <span class="dplvalue value" data-field-type="double">
                        05:00
                        </span>
                        <span class="hide edit" field_label="Total">
                        <input id="VTETimesheets_editView_fieldName_total" class="inputElement" name="total" value="300.00" type="text">
                        </span>
                     </td>
                     <td class="fieldValue">
                        <span class="dplvalue value" data-field-type="picklist">
                        <span class="picklist-color" style="background-color: #d7f5a9; line-height:15px; color: black;">
                        Billable
                        </span>
                        </span>
                        <span class="hide edit" field_label="Type">
                           <div class="select2-container inputElement select2" id="s2id_autogen11">
                              <a href="javascript:void(0)" class="select2-choice" tabindex="-1">   <span class="select2-chosen" id="select2-chosen-12">Billable</span><abbr class="select2-search-choice-close"></abbr>   <span class="select2-arrow" role="presentation"><b role="presentation"></b></span></a><label for="s2id_autogen12" class="select2-offscreen"></label><input class="select2-focusser select2-offscreen" aria-haspopup="true" role="button" aria-labelledby="select2-chosen-12" id="s2id_autogen12" type="text">
                              <div class="select2-drop select2-display-none select2-with-searchbox">
                                 <div class="select2-search">       <label for="s2id_autogen12_search" class="select2-offscreen"></label>       <input autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" class="select2-input" role="combobox" aria-expanded="true" aria-autocomplete="list" aria-owns="select2-results-12" id="s2id_autogen12_search" placeholder="" type="text">   </div>
                                 <ul class="select2-results" role="listbox" id="select2-results-12">   </ul>
                              </div>
                           </div>
                           <select data-fieldname="timesheet_type" data-fieldtype="picklist" class="inputElement select2  select2-offscreen" type="picklist" name="timesheet_type" data-selected-value="Billable" data-rule-required="true" tabindex="-1" title="">
                              <option value="">Select an Option</option>
                              <option value="Regular" class="picklistColor_timesheet_type_Regular">Regular</option>
                              <option value="Billable" class="picklistColor_timesheet_type_Billable" selected="">Billable</option>
                              <option value="Non-Billable" class="picklistColor_timesheet_type_Non-Billable">Non-Billable</option>
                              <option value="Overtime" class="picklistColor_timesheet_type_Overtime">Overtime</option>
                              <option value="Sick" class="picklistColor_timesheet_type_Sick">Sick</option>
                           </select>
                           
                        </span>
                     </td>
                     <td class="fieldValue">
                        <span class="dplvalue value" data-field-type="text" style="white-space:normal;">
                        Follow up visit
                        </span>
                        <span class="hide edit" field_label="Description">
                        <textarea rows="3" id="VTETimesheets_editView_fieldName_description" class="inputElement textAreaElement col-lg-12 " name="description">Follow up visit</textarea>
                        </span>
                     </td>
                     <td class="fieldValue">
                        <div class="actions " style="text-align: center;">
                           <span class="hide edit">
                           &nbsp;<a class="saveVTETimeSheetsButton" data-record-date="2018-05-24" data-record-id="108"><i title="Save" class="glyphicon glyphicon-ok alignMiddle"></i></a>
                           <a class="hoverEditCancel"><i class="glyphicon glyphicon-remove alignMiddle"></i></a>
                           </span>
                           <span class="actionImages">
                           <span class="dplvalue">
                           <a class="editVTETimeSheetsButton" data-record-id="108">
                           <i class="glyphicon glyphicon-pencil alignMiddle" title="Edit Timesheet"></i>
                           </a>
                           <a class="deleteVTETimeSheetsButton" data-record-id="108">
                           <i class="glyphicon glyphicon-trash alignMiddle" title="Delete Timesheet"></i>
                           </a>
                           </span>
                           </span>
                        </div>
                     </td>
                     <td rowspan="1" class="worked">
                        05:00
                     </td>
                  </tr>
                  <tr class="vteTimeSheetsRecords ">
                     <td class="listViewEntryValue" rowspan="1" width="17%">
                        <b>Fri</b>, May 25, 2018
                        <span style="float:right;">
                        <i class="glyphicon glyphicon-plus-sign btnAddMore" title="Add Timesheet" data-record="" data-date="2018-05-25"></i>
                        </span>
                     </td>
                     <td class="fieldValue">
                        <span class="dplvalue value" data-field-type="time">
                        8:00 AM
                        </span>
                        <span class="hide edit" field_label="In">
                           <div class="input-group inputElement time"><input id="VTETimesheets_editView_fieldName_time_in" data-format="12" class="timepicker-default form-control ui-timepicker-input" value="8:00 AM" name="time_in" data-rule-required="true" data-rule-time="true" autocomplete="off" type="text"><span class="input-group-addon" style="width: 30px;"><i class="fa fa-clock-o"></i></span></div>
                        </span>
                     </td>
                     <td class="fieldValue">
                        <span class="dplvalue value" data-field-type="time">
                        5:00 PM
                        </span>
                        <span class="hide edit" field_label="Out">
                           <div class="input-group inputElement time"><input id="VTETimesheets_editView_fieldName_time_out" data-format="12" class="timepicker-default form-control ui-timepicker-input" value="5:00 PM" name="time_out" data-rule-required="true" data-rule-time="true" autocomplete="off" type="text"><span class="input-group-addon" style="width: 30px;"><i class="fa fa-clock-o"></i></span></div>
                        </span>
                     </td>
                     <td class="fieldValue">
                        <span class="dplvalue value" data-field-type="double">
                        09:00
                        </span>
                        <span class="hide edit" field_label="Total">
                        <input id="VTETimesheets_editView_fieldName_total" class="inputElement" name="total" value="540.00" type="text">
                        </span>
                     </td>
                     <td class="fieldValue">
                        <span class="dplvalue value" data-field-type="picklist">
                        <span class="picklist-color" style="background-color: #ffdca8; line-height:15px; color: black;">
                        Sick
                        </span>
                        </span>
                        <span class="hide edit" field_label="Type">
                           <div class="select2-container inputElement select2" id="s2id_autogen13">
                              <a href="javascript:void(0)" class="select2-choice" tabindex="-1">   <span class="select2-chosen" id="select2-chosen-14">Sick</span><abbr class="select2-search-choice-close"></abbr>   <span class="select2-arrow" role="presentation"><b role="presentation"></b></span></a><label for="s2id_autogen14" class="select2-offscreen"></label><input class="select2-focusser select2-offscreen" aria-haspopup="true" role="button" aria-labelledby="select2-chosen-14" id="s2id_autogen14" type="text">
                              <div class="select2-drop select2-display-none select2-with-searchbox">
                                 <div class="select2-search">       <label for="s2id_autogen14_search" class="select2-offscreen"></label>       <input autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" class="select2-input" role="combobox" aria-expanded="true" aria-autocomplete="list" aria-owns="select2-results-14" id="s2id_autogen14_search" placeholder="" type="text">   </div>
                                 <ul class="select2-results" role="listbox" id="select2-results-14">   </ul>
                              </div>
                           </div>
                           <select data-fieldname="timesheet_type" data-fieldtype="picklist" class="inputElement select2  select2-offscreen" type="picklist" name="timesheet_type" data-selected-value="Sick" data-rule-required="true" tabindex="-1" title="">
                              <option value="">Select an Option</option>
                              <option value="Regular" class="picklistColor_timesheet_type_Regular">Regular</option>
                              <option value="Billable" class="picklistColor_timesheet_type_Billable">Billable</option>
                              <option value="Non-Billable" class="picklistColor_timesheet_type_Non-Billable">Non-Billable</option>
                              <option value="Overtime" class="picklistColor_timesheet_type_Overtime">Overtime</option>
                              <option value="Sick" class="picklistColor_timesheet_type_Sick" selected="">Sick</option>
                           </select>
                           
                        </span>
                     </td>
                     <td class="fieldValue">
                        <span class="dplvalue value" data-field-type="text" style="white-space:normal;">
                        out sick
                        </span>
                        <span class="hide edit" field_label="Description">
                        <textarea rows="3" id="VTETimesheets_editView_fieldName_description" class="inputElement textAreaElement col-lg-12 " name="description">out sick</textarea>
                        </span>
                     </td>
                     <td class="fieldValue">
                        <div class="actions " style="text-align: center;">
                           <span class="hide edit">
                           &nbsp;<a class="saveVTETimeSheetsButton" data-record-date="2018-05-25" data-record-id="109"><i title="Save" class="glyphicon glyphicon-ok alignMiddle"></i></a>
                           <a class="hoverEditCancel"><i class="glyphicon glyphicon-remove alignMiddle"></i></a>
                           </span>
                           <span class="actionImages">
                           <span class="dplvalue">
                           <a class="editVTETimeSheetsButton" data-record-id="109">
                           <i class="glyphicon glyphicon-pencil alignMiddle" title="Edit Timesheet"></i>
                           </a>
                           <a class="deleteVTETimeSheetsButton" data-record-id="109">
                           <i class="glyphicon glyphicon-trash alignMiddle" title="Delete Timesheet"></i>
                           </a>
                           </span>
                           </span>
                        </div>
                     </td>
                     <td rowspan="1" class="worked">
                        09:00
                     </td>
                  </tr>
                  <tr class="vteTimeSheetsRecords ">
                     <td class="listViewEntryValue" width="17%">
                        <b>Sat</b>, May 26, 2018
                        <span style="float:right;">
                        <i class="glyphicon glyphicon-plus-sign btnAddMore" title="Add Timesheet" data-record="" data-date="2018-05-26"></i>
                        </span>
                     </td>
                     <td></td>
                     <td></td>
                     <td></td>
                     <td></td>
                     <td></td>
                     <td></td>
                     <td></td>
                  </tr>
                  <tr class="vteTimeSheetsRecords ">
                     <td class="listViewEntryValue" width="17%">
                        <b>Sun</b>, May 27, 2018
                        <span style="float:right;">
                        <i class="glyphicon glyphicon-plus-sign btnAddMore" title="Add Timesheet" data-record="" data-date="2018-05-27"></i>
                        </span>
                     </td>
                     <td></td>
                     <td></td>
                     <td></td>
                     <td></td>
                     <td></td>
                     <td></td>
                     <td></td>
                  </tr>
                  <tr class="vteTimeSheetsRecords ">
                     <td class="listViewEntryValue" width="17%">
                        <b>Mon</b>, May 28, 2018
                        <span style="float:right;">
                        <i class="glyphicon glyphicon-plus-sign btnAddMore" title="Add Timesheet" data-record="" data-date="2018-05-28"></i>
                        </span>
                     </td>
                     <td></td>
                     <td></td>
                     <td></td>
                     <td></td>
                     <td></td>
                     <td></td>
                     <td></td>
                  </tr>
                  <tr class="vteTimeSheetsRecords ">
                     <td class="listViewEntryValue" width="17%">
                        <b>Tue</b>, May 29, 2018
                        <span style="float:right;">
                        <i class="glyphicon glyphicon-plus-sign btnAddMore" title="Add Timesheet" data-record="" data-date="2018-05-29"></i>
                        </span>
                     </td>
                     <td></td>
                     <td></td>
                     <td></td>
                     <td></td>
                     <td></td>
                     <td></td>
                     <td></td>
                  </tr>
                  <tr class="vteTimeSheetsRecords ">
                     <td class="listViewEntryValue" width="17%">
                        <b>Wed</b>, May 30, 2018
                        <span style="float:right;">
                        <i class="glyphicon glyphicon-plus-sign btnAddMore" title="Add Timesheet" data-record="" data-date="2018-05-30"></i>
                        </span>
                     </td>
                     <td></td>
                     <td></td>
                     <td></td>
                     <td></td>
                     <td></td>
                     <td></td>
                     <td></td>
                  </tr>
                  <tr class="vteTimeSheetsRecords ">
                     <td class="listViewEntryValue" width="17%">
                        <b>Thu</b>, May 31, 2018
                        <span style="float:right;">
                        <i class="glyphicon glyphicon-plus-sign btnAddMore" title="Add Timesheet" data-record="" data-date="2018-05-31"></i>
                        </span>
                     </td>
                     <td></td>
                     <td></td>
                     <td></td>
                     <td></td>
                     <td></td>
                     <td></td>
                     <td></td>
                  </tr>
                  <tr class="vteTimeSheetsRecords hide">
                     <td colspan="8"></td>
                  </tr>
               </tbody>
               <tfoot>
                  <tr class="listViewFooters">
                     <th class="medium" colspan="7"></th>
                     <th class="medium" style="width: 8%;">
                        <strong>
                        27:00
                        </strong>
                     </th>
                  </tr>
               </tfoot>
            </table>
         </div>
      </form>
   </div>
</div>