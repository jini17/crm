<?php
/**
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
 * Implements the actual methods/resources of the discovered Google API using magic function
 * calling overloading (__call()), which on call will see if the method name (plus.activities.list)
 * is available in this service, and if so construct an apiHttpRequest representing it.
 *
 * @author Chris Chabot <chabotc@google.com>
 * @author Chirag Shah <chirags@google.com>
 *
 */
class Google_Service_Resource
{


  /** @var Google_Service $service */
  private $service;

  /** @var Google_Client $client */
  private $client;

  /** @var string $serviceName */
  private $serviceName;

  /** @var string $resourceName */
  private $resourceName;

  /** @var array $methods */
  private $methods;

  public function __construct($service, $serviceName, $resourceName, $resource)
  {
    $this->service = $service;
    $this->client = $service->getClient();
    $this->serviceName = $serviceName;
    $this->resourceName = $resourceName;
    $this->methods = isset($resource['methods']) ?
        $resource['methods'] :
        array($resourceName => $resource);

  }

  /**
   * TODO(ianbarber): This function needs simplifying.
   * @param $name
   * @param $arguments
   * @param $expected_class - optional, the expected class name
   * @return Google_Http_Request|expected_class
   * @throws Google_Exception
   */
  public function call($name, $arguments, $expected_class = null)
  {
    if (! isset($this->methods[$name])) {
      throw new Google_Exception(
          "Unknown function: " .
          "{$this->serviceName}->{$this->resourceName}->{$name}()"
      );
    }

    $method = $this->methods[$name];

    $parameters = $method['parameters'];


    if (!isset($method['parameters'])) {
      $method['parameters'] = array();
    }



    foreach ($method['parameters'] as $paramName => $paramSpec) {

      if (isset($parameters[$paramName])) {
          if($paramSpec['type']=='datetimeoffset'){
              //date_default_timezone_set("UTC");
              $date=date("Y-m-d H:i:s", gmmktime());
              $parameters[$paramName]['value']=$date;
          }
          if($paramSpec['type'] == 'string'){
              if($paramName == 'calendar_id') $parameters[$paramName]['value']=$arguments[0]['calendarId'];
              if($paramName =='eventId') $parameters[$paramName]['value']=$arguments[0]['eventId'];
          }
          unset($parameters[$paramName]['required']);
      } else {
        // Ensure we don't pass nulls.
        unset($parameters[$paramName]);
      }
    }


    $servicePath = $this->service->servicePath;

    $url = Google_Http_REST::createRequestUri(
        $servicePath,
        $method['path'],
        $parameters
    );

    if ($parameters == '') $parameters=null;

    if ($arguments[0]['postBody'] =='')
        $postBody=null;
    else {
        $postBody=$arguments[0]['postBody'];
    }

    $httpRequest = new Google_Http_Request(
        $url,
        $method['httpMethod'],
        $parameters,
        $postBody
    );

    $httpRequest->setBaseComponent($this->client->getBasePath());

    $httpRequest->setAuth($this->client->getAuth());

  // $httpRequest->setExpectedClass($expected_class);


    return $this->client->execute($this->client,$httpRequest);
  }

  protected function convertToArrayAndStripNulls($o)
  {
    $o = (array) $o;
    foreach ($o as $k => $v) {
      if ($v === null) {
        unset($o[$k]);
      } elseif (is_object($v) || is_array($v)) {
        $o[$k] = $this->convertToArrayAndStripNulls($o[$k]);
      }
    }
    return $o;
  }
}
