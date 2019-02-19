<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/
$languageStrings = array(
	// Basic Strings
	'HelpDesk' => 'ตั๋ว',
	'SINGLE_HelpDesk' => 'ตั๋ว',
	'LBL_ADD_RECORD' => 'เพิ่มตั๋ว',
	'LBL_RECORDS_LIST' => 'รายชื่อตั๋ว',

	// Blocks
	'LBL_TICKET_INFORMATION' => 'ข้อมูลบัตรโดยสาร',
	'LBL_TICKET_RESOLUTION' => 'ความละเอียดตั๋ว',

	//Field Labels
	'Ticket No' => 'เลขที่ตั๋ว',
	'Severity' => 'ความรุนแรง',
	'Update History' => 'ประวัติการอัปเดต',
	'Hours' => 'ชั่วโมง',
	'Days' => 'วัน',
	'Title' => 'หัวข้อ',
	'Solution' => 'วิธีการแก้',
	'From Portal' => 'จากพอร์ทัล',
	'Related To' => 'ชื่อองค์กร',
	'Contact Name' => 'ชื่อผู้ติดต่อ',
	//Added for existing picklist entries

	'Big Problem'=>'ปัญหาใหญ่',
	'Small Problem'=>'ปัญหาเล็ก ๆ',
	'Other Problem'=>'ปัญหาอื่น ๆ',

	'Normal'=>'ปกติ',
	'High'=>'สูง',
	'Urgent'=>'ด่วน',

	'Minor'=>'ย่อย',
	'Major'=>'สำคัญ',
	'Feature'=>'ลักษณะ',
	'Critical'=>'วิกฤติ',

	'Open'=>'เปิด',
	'Wait For Response'=>'รอการตอบสนอง',
	'Closed'=>'ปิด',
	'LBL_STATUS' => 'สภาพ',
	'LBL_SEVERITY' => 'ความรุนแรง',
	//DetailView Actions
	'LBL_CONVERT_FAQ' => 'แปลงเป็นคำถามที่พบบ่อย',
	'LBL_RELATED_TO' => 'เกี่ยวข้องกับ',

	//added to support i18n in ticket mails
	'Ticket ID'=>'ตั๋ว ID',
	'Hi' => 'สวัสดี',
	'Dear'=> 'ที่รัก',
	'LBL_PORTAL_BODY_MAILINFO'=> 'ตั๋วคือ',
	'LBL_DETAIL' => 'รายละเอียดมี :',
	'LBL_REGARDS'=> 'ความเคารพนับถือ',
	'LBL_TEAM'=> 'ทีมช่วยเหลือ',
	'LBL_TICKET_DETAILS' => 'รายละเอียดตั๋ว',
	'LBL_SUBJECT' => 'เรื่อง : ',
	'created' => 'สร้าง',
	'replied' => 'ตอบ',
	'reply'=>'มีการตอบกลับ',
	'customer_portal' => 'ใน "พอร์ทัลลูกค้า" ที่ VTiger.',
	'link' => 'คุณสามารถใช้ลิงก์ต่อไปนี้เพื่อดูการตอบกลับที่ทำ:',
	'Thanks' => 'ขอบคุณ',
	'Support_team' => 'ทีมสนับสนุน Vtiger',
	'The comments are' => 'ความคิดเห็นคือ',
	'Ticket Title' => 'ชื่อตั๋ว',
	'Re' => 'Re :',

	//This label for customerportal.
	'LBL_STATUS_CLOSED' =>'ปิด',//Do not convert this label. This is used to check the status. If the status 'Closed' is changed in vtigerCRM server side then you have to change in customerportal language file also.
	'LBL_STATUS_UPDATE' => 'สถานะตั๋วถูกอัพเดตเป็น',
	'LBL_COULDNOT_CLOSED' => 'ตั๋วไม่สามารถ',
	'LBL_CUSTOMER_COMMENTS' => 'ลูกค้าได้ให้ข้อมูลเพิ่มเติมต่อไปนี้ในการตอบกลับของคุณ:',
	'LBL_RESPOND'=> 'กรุณาตอบกลับด้านบนให้เร็วที่สุด.',
	'LBL_SUPPORT_ADMIN' => 'ผู้ดูแลระบบสนับสนุน',
	'LBL_RESPONDTO_TICKETID' =>'ตอบสนองต่อตั๋ว ID',
	'LBL_RESPONSE_TO_TICKET_NUMBER' =>'การตอบสนองต่อจำนวนตั๋ว',
	'LBL_TICKET_NUMBER' => 'เลขที่ตั๋ว',
	'LBL_CUSTOMER_PORTAL' => 'ในพอร์ทัลลูกค้า - ด่วน',
	'LBL_LOGIN_DETAILS' => 'รายละเอียดการเข้าสู่ระบบพอร์ทัลลูกค้าของคุณมีดังนี้ :',
	'LBL_MAIL_COULDNOT_SENT' =>'ไม่สามารถส่งจดหมาย',
	'LBL_USERNAME' => 'ชื่อผู้ใช้ :',
	'LBL_PASSWORD' => 'รหัสผ่าน:',
	'LBL_SUBJECT_PORTAL_LOGIN_DETAILS' => 'เกี่ยวกับรายละเอียดการล็อกอินของลูกค้าพอร์ทัล',
	'LBL_GIVE_MAILID' => 'โปรดระบุรหัสอีเมลของคุณ',
	'LBL_CHECK_MAILID' => 'โปรดตรวจสอบรหัสอีเมลของคุณสำหรับพอร์ทัลลูกค้า',
	'LBL_LOGIN_REVOKED' => 'การเข้าสู่ระบบของคุณถูกเพิกถอน. โปรดติดต่อผู้ดูแลระบบของคุณ.',
	'LBL_MAIL_SENT' => 'จดหมายถูกส่งไปยังรหัสไปรษณีย์ของคุณด้วยรายละเอียดการเข้าสู่ระบบพอร์ทัลลูกค้า',
	'LBL_ALTBODY' => 'นี่คือเนื้อหาในข้อความล้วนสำหรับไคลเอ็นต์อีเมลที่ไม่ใช่ HTML',
	'HelpDesk ID' => 'ตั๋ว ID',    
	//Portal shortcuts
	'LBL_ADD_DOCUMENT'=>"เพิ่มเอกสาร",
	'LBL_OPEN_TICKETS'=>"เปิดตั๋ว",
	'LBL_CREATE_TICKET'=>"สร้างบัตร",
);

$jsLanguageStrings=array(
	'LBL_ADD_DOCUMENT'=>'เพิ่มเอกสาร',
	'LBL_OPEN_TICKETS'=>'เปิดตั๋ว',
	'LBL_CREATE_TICKET'=>'สร้างบัตร'
);
