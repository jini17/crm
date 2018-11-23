<table class="table detailview-table">
  <thead>
      <tr>
          <th class="medium"><strong>{vtranslate('LBL_INSTITUTION_NAME', $MODULE)}</strong></th>
          <th class="medium"><strong>{vtranslate('LBL_LOCATION', $MODULE)}</strong></th>
          <th class="medium"><strong>{vtranslate('LBL_EDUCATION_TYPE', $MODULE)}</strong></th>
          <th style='width:15%' class="medium"><strong>{vtranslate('LBL_DURATION', $MODULE)}</strong></th>
          <th class="medium"><strong>{vtranslate('LBL_EDUCATION_LEVEL', $MODULE)}</strong></th>
          <th class="medium"><strong>{vtranslate('LBL_AREA_OF_STUDY', $MODULE)}</strong></th>
          <th class="medium"><strong>{vtranslate('LBL_DESCRIPTION', $MODULE)}</strong></th>
          <th colspan="2" class="medium"><strong>{vtranslate('LBL_EDUCATION_ISVIEW', $MODULE)}</strong></th>
      </tr>
  </thead>
  <tbody>
    <tr>
      <td class="listTableRow medium" valign="top">{$USER_EDUCATION['institution_name']}</td>
      <td class="listTableRow medium" valign="top">{$USER_EDUCATION['education_location']}</td>
      <td class="listTableRow medium" valign="top">{$USER_EDUCATION['education_type']}</td>
      <td class="listTableRow medium" valign="top">{$USER_EDUCATION['start_date']} - {if $USER_EDUCATION['is_studying'] eq 1}{vtranslate('LBL_TILL_NOW', $MODULE)}{else}{$USER_EDUCATION['end_date']}{/if}</td>
      <td class="listTableRow medium" valign="top">{$USER_EDUCATION['education_level']}</td>
      <td class="listTableRow medium" valign="top">{$USER_EDUCATION['area_of_study']}</td>
      <td class="listTableRow medium" valign="top">{$USER_EDUCATION['description']}</td>
      <td class="listTableRow medium" valign="top">{vtranslate($PERMISSION,$MODULE)}</td>
      <td class="listTableRow medium" width="5%" valign="top">
          <div class="pull-right actions">
              <span class="actionImages">
                  <a class="editEducation editAction ti-pencil" title="Edit" onclick="Users_Education_Js.editEducation('index.php?module=Users&amp;view=EditEducation&amp;record={$USER_EDUCATION['educationid']}&amp;userId={$USERID}');"></a>
                  &nbsp;&nbsp;
                  <a class="cursorPointer" onclick="Users_Education_Js.deleteEducation('index.php?module=Education&amp;action=Delete&amp;record={$USER_EDUCATION['educationid']}');"><i class="fa fa-trash-o" title="Delete"></i></a>
              </span>
          </div>
      </td>    
    </tr>
  </tbody>
</table>