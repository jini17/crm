<?php
/*
 * Copyright 2010 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

require_once realpath(dirname(__FILE__) . '/../../../autoload.php');

/**
 * This class implements the RESTful transport of apiServiceRequest()'s
 *
 * @author Chris Chabot <chabotc@google.com>
 * @author Chirag Shah <chirags@google.com>
 */
class Google_Http_REST
{
  /**
   * Executes a Google_Http_Request
   *
   * @param Google_Client $client
   * @param Google_Http_Request $req
   * @return array decoded result
   * @throws Google_Service_Exception on server side error (ie: not authenticated,
   *  invalid or malformed post body, invalid url)
   */
  public static function execute($client, Google_Http_Request $req)
  {

    $req=self::CalendarFetch($client,$req);


   return $req;
  }


  public static function createBodyParameter($object){
      $query=array();

      $object['visibility'] == "public"?$visibility="Normal": $visibility="Private";


      $query=array(
          "Subject" =>$object["summary"],
          "Start" => array("DateTime" => $object['start']["dateTime"], "TimeZone" => "UTC"),
          "End" =>array("DateTime" => $object['end']["dateTime"], "TimeZone" => "UTC"),
          "Importance" => $visibility,
          "Location" =>array("DisplayName" => $object['location']),
          "BodyPreview" =>$object['description']

      );
        $query=json_encode($query);
      return $query;

  }


  /**
   * Parse/expand request parameters and create a fully qualified
   * request uri.
   * @static
   * @param string $servicePath
   * @param string $restPath
   * @param array $params
   * @return string $requestUrl
   */
  public static function createRequestUri($servicePath, $restPath, $params)
  {
    $requestUrl = $servicePath . $restPath;
    $uriTemplateVars = array();
    $queryVars = array();

    foreach ($params as $paramName => $paramSpec) {
      if ($paramSpec['type'] == 'boolean') {
        $paramSpec['value'] = ($paramSpec['value']) ? 'true' : 'false';
      }
      if ($paramSpec['type'] == 'datetimeoffset') {
          if($paramName == 'startDateTime') $paramSpec['value']=str_replace(' ','T',$paramSpec['value']);
         // if($paramName == 'endDateTime') $paramSpec['value']=='2018-10-30T07:53:21';
        }

      if ($paramSpec['location'] == 'path') {
        $uriTemplateVars[$paramName] = $paramSpec['value'];
      } else if ($paramSpec['location'] == 'query') {
        if (isset($paramSpec['repeated']) && is_array($paramSpec['value'])) {
          foreach ($paramSpec['value'] as $value) {
            $queryVars[] = $paramName . '=' . rawurlencode($value);
          }
        } else {
          $queryVars[] = $paramName . '=' . rawurlencode($paramSpec['value']);
        }
      }
    }

    if (count($uriTemplateVars) > 0) {
      $uriTemplateParser = new Google_Utils_URITemplate();

      $requestUrl = $uriTemplateParser->parse($requestUrl, $uriTemplateVars);

    }

    if (count($queryVars)) {
      $requestUrl .= '?' . implode($queryVars, '&');
    }

    return $requestUrl;
  }
  public static function fetchRequesturi($param,$https_request,$url){
      $query[] = array(
          'alt' => 'json',
          '\$top' => 1000,
      );

      if($url==null) $CalendarUri = $https_request->getUrl();
      else $CalendarUri=$url;
      $token=$param->getToken();

      $headers = array(
          "Authorization: Bearer ".$token['access_token']['access_token'],
      );
      if($https_request->getPostBody() != ''&& $https_request->getRequestMethod() =="PATCH") $query=self::changeformattoOffice365($https_request->getPostBody());
      if($https_request->getPostBody() != '' && $https_request->getRequestMethod() =="POST") $query=self::createBodyParameter($https_request->getPostBody());




      $response=self::fireRequest($CalendarUri,$headers,$query,$https_request->getRequestMethod());


      return $response;
  }

   public static function CalendarFetch($param,$query) {

      $response=self::fetchRequesturi($param,$query,null);
       $count=0;
       $value[$count]=json_decode($response, true);
            while (true){
                if(array_key_exists("@odata.nextLink",$value[$count])){
                    $response1=self::fetchRequesturi($param,$query,$value[$count++]["@odata.nextLink"]);
                    $value[$count]=json_decode($response1,true);
                }
                else break;

            }

        return $value;
    }

    public static function changeformattoOffice365($query){

        unset($query[0]['@odata.context']);
        unset($query[0]['@odata.id']);
        unset($query[0]['@odata.etag']);
        unset($query[0]['Calendar@odata.associationLink']);
        unset($query[0]['Calendar@odata.navigationLink']);
        unset($query[0]['WebLink']);
        unset($query[0]['Id']);
        unset($query[0]['iCalUId']);
        unset($query[0]['ChangeKey']);
        unset($query[0]['CreatedDateTime']);
        unset($query[0]['LastModifiedDateTime']);



      return json_encode((object)array_shift($query));
    }

    protected function fireRequest($url,$headers,$query,$method) {

        $ch = curl_init($url);

        switch ($method) {
            case 'POST':
                $headers[] = "Content-Type: application/json";
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_POSTFIELDS,$query);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                break;
            case 'GET':
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                break;
            case "PATCH":
                $headers[] = "Content-Type: application/json";
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                break;
            case "DELETE":
                $headers[] = "Content-Type: application/json";
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                break;
            default:
                error_log("INVALID METHOD: ".$method);
                exit;




        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $response=curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if($http_code >= 400) {
            echo "Error executing request to Office365 api with error code=$http_code<br/><br/>\n\n";
            echo "<pre>"; print_r($response);echo "methods :" .print_r($method); echo "</pre>";

        }
        return $response;

    }
}
