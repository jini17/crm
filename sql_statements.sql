
/*** Add a block in vtiger_settings_block HR_Matters with id 14*/

/** Add the sub tabs *****************/

INSERT INTO ss_foundation.vtiger_settings_field (fieldid, blockid, name, iconpath, description, linkto, sequence, active, pinned) VALUES (48, 14, 'LBL_LEAVE_TYPE', null, 'Leave type', 'index.php?module=Vtiger&parent=Settings&view=LeaveTypeListView', 1, 0, 0);
INSERT INTO ss_foundation.vtiger_settings_field (fieldid, blockid, name, iconpath, description, linkto, sequence, active, pinned) VALUES (49, 14, 'LBL_CLAIM_TYPE', null, 'Claim Type', 'index.php?module=Vtiger&parent=Settings&view=ClaimTypeListView', 2, 0, 0);
INSERT INTO ss_foundation.vtiger_settings_field (fieldid, blockid, name, iconpath, description, linkto, sequence, active, pinned) VALUES (50, 14, 'LBL_BENEFIT_TYPE', null, 'Benifit Type', 'index.php?module=Vtiger&parent=Settings&view=BenefitTypeListView', 3, 0, 0);
INSERT INTO ss_foundation.vtiger_settings_field (fieldid, blockid, name, iconpath, description, linkto, sequence, active, pinned) VALUES (51, 14, 'LBL_ALLOCATION', null, 'Allocation', 'index.php?module=Vtiger&parent=Settings&view=AllocationListView', 4, 0, 0);