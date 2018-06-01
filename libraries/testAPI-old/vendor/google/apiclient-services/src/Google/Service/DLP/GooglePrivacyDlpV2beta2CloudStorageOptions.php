<?php
/*
 * Copyright 2014 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may not
 * use this file except in compliance with the License. You may obtain a copy of
 * the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations under
 * the License.
 */

class Google_Service_DLP_GooglePrivacyDlpV2beta2CloudStorageOptions extends Google_Model
{
  public $bytesLimitPerFile;
  protected $fileSetType = 'Google_Service_DLP_GooglePrivacyDlpV2beta2FileSet';
  protected $fileSetDataType = '';

  public function setBytesLimitPerFile($bytesLimitPerFile)
  {
    $this->bytesLimitPerFile = $bytesLimitPerFile;
  }
  public function getBytesLimitPerFile()
  {
    return $this->bytesLimitPerFile;
  }
  /**
   * @param Google_Service_DLP_GooglePrivacyDlpV2beta2FileSet
   */
  public function setFileSet(Google_Service_DLP_GooglePrivacyDlpV2beta2FileSet $fileSet)
  {
    $this->fileSet = $fileSet;
  }
  /**
   * @return Google_Service_DLP_GooglePrivacyDlpV2beta2FileSet
   */
  public function getFileSet()
  {
    return $this->fileSet;
  }
}
