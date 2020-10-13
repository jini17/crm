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
	'LBL_IMPORT_STEP_1' => 'Bước 1',
	'LBL_IMPORT_STEP_1_DESCRIPTION' => 'Chọn tập tin',
	'LBL_IMPORT_SUPPORTED_FILE_TYPES' => 'Loại tệp được hỗ trợ: .CSV, .VCF',
	'LBL_IMPORT_STEP_2' => 'Bước 2',
	'LBL_IMPORT_STEP_2_DESCRIPTION' => 'Chỉ định Định dạng',
	'LBL_FILE_TYPE' => 'Loại tệp',
	'LBL_CHARACTER_ENCODING' => 'Mã hóa ký tự',
	'LBL_DELIMITER' => 'Dấu phân cách',
	'LBL_HAS_HEADER' => 'Có tiêu đề',
	'LBL_IMPORT_STEP_3' => 'Bước 3',
	'LBL_IMPORT_STEP_3_DESCRIPTION' => 'Xử lý hồ sơ trùng lặp',
	'LBL_IMPORT_STEP_3_DESCRIPTION_DETAILED' => 'Chọn tùy chọn này để bật và đặt tiêu chí hợp nhất trùng lặp',
	'LBL_SPECIFY_MERGE_TYPE' => 'Chọn cách xử lý bản ghi trùng lặp',
	'LBL_SELECT_MERGE_FIELDS' => 'Chọn các trường phù hợp để tìm bản ghi trùng lặp',
	'LBL_AVAILABLE_FIELDS' => 'Các trường khả dụng',
	'LBL_SELECTED_FIELDS' => 'Các trường sẽ được kết hợp trên',
	'LBL_NEXT_BUTTON_LABEL' => 'Kế tiếp',
	'LBL_IMPORT_STEP_4' => 'Bước 4',
	'LBL_IMPORT_STEP_4_DESCRIPTION' => 'Lập bản đồ Các Cột để Các Trường Mô đun',
	'LBL_FILE_COLUMN_HEADER' => 'Tiêu đề',
	'LBL_ROW_1' => 'Hàng 1',
	'LBL_CRM_FIELDS' => 'Các lĩnh vực CRM',
	'LBL_DEFAULT_VALUE' => 'Giá trị mặc định',
	'LBL_SAVE_AS_CUSTOM_MAPPING' => 'Lưu dưới dạng Bản đồ Tuỳ chỉnh',
	'LBL_IMPORT_BUTTON_LABEL' => 'Nhập khẩu',
	'LBL_RESULT' => 'Kết quả',
	'LBL_TOTAL_RECORDS_IMPORTED' => 'Hồ sơ đã nhập thành công',
	'LBL_NUMBER_OF_RECORDS_CREATED' => 'Đã tạo hồ sơ',
	'LBL_NUMBER_OF_RECORDS_UPDATED' => 'Ghi đè lên',
	'LBL_NUMBER_OF_RECORDS_SKIPPED' => 'Hồ sơ đã bỏ qua',
	'LBL_NUMBER_OF_RECORDS_MERGED' => 'Bản ghi hợp nhất', 
	'LBL_TOTAL_RECORDS_FAILED' => 'Hồ sơ không thành công nhập',
	'LBL_IMPORT_MORE' => 'Nhập thêm',
	'LBL_VIEW_LAST_IMPORTED_RECORDS' => 'Hồ sơ Nhập Lần cuối',
	'LBL_UNDO_LAST_IMPORT' => 'Hoàn tác Nhập khẩu Lần cuối',
	'LBL_FINISH_BUTTON_LABEL' => 'Hoàn thành',
	'LBL_UNDO_RESULT' => 'Hoàn tác Kết quả Nhập',
	'LBL_TOTAL_RECORDS' => 'Tổng Số Hồ Sơ',
	'LBL_NUMBER_OF_RECORDS_DELETED' => 'Số hồ sơ bị xóa',
	'LBL_OK_BUTTON_LABEL' => 'Được',
	'LBL_IMPORT_SCHEDULED' => 'Nhập theo lịch',
	'LBL_RUNNING' => 'Đang chạy',
	'LBL_CANCEL_IMPORT' => 'Hủy nhập khẩu',
	'LBL_ERROR' => 'lỗi',
	'LBL_CLEAR_DATA' => 'Xóa dữ liệu',
	'ERR_LOCAL_INFILE_NOT_ON' => 'biến local_infile bị tắt trên máy chủ cơ sở dữ liệu.',
	'ERR_UNIMPORTED_RECORDS_EXIST' => 'Không thể nhập thêm dữ liệu trong đợt này. Hãy bắt đầu nhập mới.',
	'ERR_IMPORT_INTERRUPTED' => 'Nhập khẩu hiện tại đã bị gián đoạn. Vui lòng thử lại sau',
	'ERR_FAILED_TO_LOCK_MODULE' => 'Không thể khóa mô-đun để nhập. Thử lại sau',
	'LBL_SELECT_SAVED_MAPPING' => 'Chọn Bản đồ đã lưu',
	'LBL_IMPORT_ERROR_LARGE_FILE' => 'Lỗi nhập Lớn tệp',
	'LBL_FILE_UPLOAD_FAILED' => 'Tải tệp lên không thành công',
	'LBL_IMPORT_CHANGE_UPLOAD_SIZE' => 'Kích thước Tải lên Thay đổi Đổi',
	'LBL_IMPORT_DIRECTORY_NOT_WRITABLE' => 'Thư mục Nhập không thể ghi được',
	'LBL_IMPORT_FILE_COPY_FAILED' => 'Nhập tệp sao chép không thành công',
	'LBL_INVALID_FILE' => 'Tập tin không hợp lệ',
	'LBL_NO_ROWS_FOUND' => 'Không tìm thấy hàng',
	'LBL_SCHEDULED_IMPORT_DETAILS' => 'Nhập khẩu của bạn đã được lên lịch và sẽ bắt đầu trong vòng 15 phút. Bạn sẽ nhận được một email sau khi nhập xong.  <br> <br>
										Vui lòng đảm bảo rằng máy chủ gửi đi và địa chỉ email của bạn được định cấu hình để nhận thông báo qua email',
	'LBL_DETAILS' => 'Chi tiết',
	'skipped' => 'Bỏ qua Bản ghi',
	'failed' => 'Hồ sơ Không thành công',
	
        'LBL_IMPORT_LINEITEMS_CURRENCY'=> 'Đơn vị tiền tệ (Đối với trường mục hàng)',
        'LBL_USE_SAVED_MAPS'=>'Sử dụng Bản đồ đã Lưu',
        'LBL_IMPORT_MAP_FIELDS'=>'Lập bản đồ các cột cho các lĩnh vực CRM',
        'LBL_UPLOAD_CSV'=>'Tải lên tệp CSV', 
        'LBL_UPLOAD_VCF'=>'Tải lên tệp VCF',
        'LBL_DUPLICATE_HANDLING'=>'Xử lý trùng lặp',
        'LBL_FIELD_MAPPING'=>'Lập bản đồ hiện trường',
        'LBL_IMPORT_FROM_CSV_FILE'=>'Nhập từ tệp CSV',
        'LBL_SELECT_IMPORT_FILE_FORMAT'=>'Bạn muốn nhập từ đâu?',
        'LBL_CSV_FILE'=>'Tệp CSV',
        'LBL_VCF_FILE'=>'Tệp VCF',
        'LBL_GOOGLE'=>'Google',
        'LBL_IMPORT_COMPLETED'=>'Nhập đã hoàn thành',
        'LBL_IMPORT_SUMMARY'=>'Nhập tóm tắt',
        'LBL_DELETION_COMPLETED'=>'Xóa đã hoàn thành',
        'LBL_TOTAL_RECORDS_SCANNED'=>'Tổng số hồ sơ được quét',
        'LBL_SKIP_BUTTON'=>'Bỏ qua',
    'LBL_DUPLICATE_RECORD_HANDLING' => 'Xử lý hồ sơ trùng lặp',
    'LBL_IMPORT_FROM_VCF_FILE' => 'Nhập từ tệp VCF',
    'LBL_SELECT_VCF_FILE' => 'Chọn tệp VCF',
    'LBL_DONE_BUTTON' => 'Làm xong',
    'LBL_DELETION_SUMMARY' => 'Xóa bản tóm tắt',

	'LBL_SKIP_THIS_STEP' => 'Bỏ qua bước này',
	'LBL_ICS_FILE'=>'Tệp ICS',
	'LBL_UPLOAD_ICS'=>'Tải lên tệp ICS',
	'LBL_IMPORT_FROM_ICS_FILE'=>'Nhập từ tệp ICS',
	'LBL_SELECT_ICS_FILE' => 'Chọn tệp ICS',
);