<?php
/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/
$languageStrings = array(
	'LBL_IMPORT_STEP_1'            => 'Langkah 1'                      , 
	'LBL_IMPORT_STEP_1_DESCRIPTION' => 'Pilih Fail'                 , 
	'LBL_IMPORT_SUPPORTED_FILE_TYPES' => 'Supported File Type(s): .CSV, .VCF, .XML,.XLS,.XLSX',  ## Modified By Jitendra Gupta on 25-04-2015 
	'LBL_IMPORT_STEP_2'            => 'Langkah 2'                      , 
	'LBL_IMPORT_STEP_2_DESCRIPTION' => 'Nyatakan Format'              , 
	'LBL_FILE_TYPE'                => 'Jenis Fail'                   , 
	'LBL_CHARACTER_ENCODING'       => 'Pengekodan Aksara'          , 
	'LBL_DELIMITER'                => 'Penyahhad:'                  , 
	'LBL_HAS_HEADER'               => 'Mempunyai tajuk'                  , 
	'LBL_IMPORT_STEP_3'            => 'Langkah 3'                      , 
	'LBL_IMPORT_STEP_3_DESCRIPTION' => 'Pengendalian Rekod Duplikasi '   , 
	'LBL_IMPORT_STEP_3_DESCRIPTION_DETAILED' => 'Pilih pilihan ini untuk mengaktifkan dan tetapkan  kriteria penggabungan duplikasi', //Select this option to enable and set duplicate merge criteria FIZA
	'LBL_SPECIFY_MERGE_TYPE'       => 'Pilih Bagaimana Rekod Pendua Perlu Dikendalikan', 
	'LBL_SELECT_MERGE_FIELDS'      => 'Pilih Medan Sepadan untuk cari Rekod Pendua', //Select the matching fields to find duplicate records FIZA
	'LBL_AVAILABLE_FIELDS'         => 'Medan Tersedia'            , 
	'LBL_SELECTED_FIELDS'          => 'Medan yang akan dipadankan pada '     , 
	'LBL_NEXT_BUTTON_LABEL'        => 'Seterusnya'                        , 
	'LBL_IMPORT_STEP_4'            => 'Langkah 4'                      , 
	'LBL_IMPORT_STEP_4_DESCRIPTION' => 'Memetakan Lajur untuk Medan Modul', 
	'LBL_FILE_COLUMN_HEADER'       => 'Tajuk'                      , 
	'LBL_ROW_1'                    => 'Baris 1'                       , 
	'LBL_CRM_FIELDS'               => 'Medan CRM'                  , 
	'LBL_DEFAULT_VALUE'            => 'Nilai Lalai'               , 
	'LBL_SAVE_AS_CUSTOM_MAPPING'   => 'Simpan Sebagai Pemetaan Tersuai '      , 
	'LBL_IMPORT_BUTTON_LABEL'      => 'Import'                      , 
	'LBL_RESULT'                   => 'Hasil'                      , 
	'LBL_TOTAL_RECORDS_IMPORTED'   => 'Jumlah rekod yang diimport', 
	'LBL_NUMBER_OF_RECORDS_CREATED' => 'Jumlah rekod yang dibuat'   , 
	'LBL_NUMBER_OF_RECORDS_UPDATED' => 'Jumlah rekod yang ditulis ganti', 
	'LBL_NUMBER_OF_RECORDS_SKIPPED' => 'Jumlah Rekod yang Dilangkau'   , 
	'LBL_NUMBER_OF_RECORDS_MERGED' => 'Jumlah Rekod yang Digabung'    , 
	'LBL_TOTAL_RECORDS_FAILED'     => 'Jumlah Rekod yang Gagal', 
	'LBL_IMPORT_MORE'              => 'Import Lagi'                 , 
	'LBL_VIEW_LAST_IMPORTED_RECORDS' => 'Rekod Terakhir diimport'       , 
	'LBL_UNDO_LAST_IMPORT'         => 'Batalkan Import Lepas'            , 
	'LBL_FINISH_BUTTON_LABEL'      => 'Selesai'                      , 
	'LBL_UNDO_RESULT'              => 'Batalkan Hasil Import'          , 
	'LBL_TOTAL_RECORDS'            => 'Jumlah Rekod'     , 
	'LBL_NUMBER_OF_RECORDS_DELETED' => 'Jumlah Rekod yang Dipadam'   , 
	'LBL_OK_BUTTON_LABEL'          => 'OK'                          ,
	'LBL_SELECT_IMPORT_FILE_FORMAT'=> 'Daripada manakah anda ingin mengimport?'                          , 
	'LBL_IMPORT_SCHEDULED'         => 'Import Berjadual '            , 
	'LBL_RUNNING'                  => 'Running'                     , 
	'LBL_CANCEL_IMPORT'            => 'Batalkan Import'               , 
	'LBL_ERROR'                    => 'Ralat:'                      , 
	'LBL_CLEAR_DATA'               => 'Kosongkan Data'                  ,
	'LBL_DUPLICATE_HANDLING'       => 'Pengendalian Salinan',
	'LBL_IMPORT_FROM_CSV_FILE'     => 'Import daripada fail CSV',
	'LBL_DUPLICATE_RECORD_HANDLING'     => 'Pengendalian Salinan rekod',
	'LBL_SKIP_THIS_STEP'     => 'Langkau langkah ini',
	'LBL_USE_SAVED_MAPS'     => 'Gunakan Pemetaan Tersimpan',
	'LBL_IMPORT_MAP_FIELDS'     => 'Memetakan lajur ke medan CRM',
	'LBL_UPLOAD_CSV'     => 'Muat naik fail CSV',
	'Select from My Computer'     => 'Pilih daripada \'My Computer\'',
	
	
	

	'ERR_UNIMPORTED_RECORDS_EXIST' => '
Masih ada beberapa rekod tidak dapat diimport dalam barisan import anda, ia menyekat anda daripada mengimport lebih banyak data. Bersihkan dengan kosongkan data dan mulakan dengan import yg baru.', 
	'ERR_IMPORT_INTERRUPTED'       => 'Import semasa telah terganggu. Sila cuba sekali lagi.', 
	'ERR_FAILED_TO_LOCK_MODULE'    => 'Gagal untuk mengunci modul untuk import. Sila cuba lagi kemudian.', 
	'LBL_SELECT_SAVED_MAPPING'     => 'Pilih Pemetaan Tersimpan'        , 
	'LBL_IMPORT_ERROR_LARGE_FILE'  => 'Ralat Import Fail Besar '    , // TODO: Review
	'LBL_FILE_UPLOAD_FAILED'       => 'Muat Naik Fail Gagal'          , // TODO: Review
	'LBL_IMPORT_CHANGE_UPLOAD_SIZE' => 'Import Perubahan Saiz Muat Naik '   , // TODO: Review
	'LBL_IMPORT_DIRECTORY_NOT_WRITABLE' => 'Direktori Import Tidak Boleh Ditulis ', // TODO: Review
	'LBL_IMPORT_FILE_COPY_FAILED'  => 'Import Salinan Fail Gagal'     , // TODO: Review
	'LBL_INVALID_FILE'             => 'Fail tidak sah'                , // TODO: Review
	'LBL_NO_ROWS_FOUND'            => 'Tiada Baris Ditemui'               , // TODO: Review
	'LBL_SCHEDULED_IMPORT_DETAILS' => 'Import anda telah dijadualkan dan akan bermula dalam masa 15 minit. Anda akan menerima e-mel selepas import selesai.  <br> <br>
										Sila pastikan bahawa pelayan keluar dan alamat e-mel anda dikonfigurasi untuk menerima pemberitahuan e-mel', // TODO: Review
	'LBL_DETAILS'                  => 'Terperinci'                     , // TODO: Review
	'skipped'                      => 'Langkau Rekod'             , // TODO: Review
	'failed'                       => 'Rekod Gagal'              , // TODO: Review
        'Skip'=>'Langkau', 
        'Overwrite'=>'Tulis Semula', 
        'Merge'=>'Gabung', 
);
