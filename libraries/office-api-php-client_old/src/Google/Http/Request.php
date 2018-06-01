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
 * HTTP Request to be executed by IO classes. Upon execution, the
 * responseHttpCode, responseHeaders and responseBody will be filled in.
 *
 * @author Chris Chabot <chabotc@google.com>
 * @author Chirag Shah <chirags@google.com>
 *
 */
class Google_Http_Request
{


  private $batchHeaders = array(
    'Content-Type' => 'application/json',
  );

  protected $queryParams;
  protected $requestMethod;

  protected $baseComponent;
  protected $Auth;
  protected $path;


  protected $responseHttpCode;
  protected $responseHeaders;
  protected $responseBody;
  protected $postBody;
  




  public function __construct(
      $url,
      $method = 'GET',
      $headers = array(),
      $postBody = null
  ) {
    $this->setUrl($url);
    $this->setRequestMethod($method);
    $this->setRequestHeaders($headers);
    $this->setPostBody($postBody);


  }

  /**
   * Misc function that returns the base url component of the $url
   * used by the OAuth signing class to calculate the base string
   * @return string The base url component of the $url.
   */
  public function getBaseComponent()
  {
    return $this->baseComponent;
  }
  
  /**
   * Set the base URL that path and query parameters will be added to.
   * @param $baseComponent string
   */
  public function setBaseComponent($baseComponent)
  {
    $this->baseComponent = $baseComponent;
  }

  public function setAuth($auth)
  {
        $this->Auth = $auth;
  }



  /**
   * Misc function that returns an array of the query parameters of the current
   * url used by the OAuth signing class to calculate the signature
   * @return array Query parameters in the query string.
   */
  public function getQueryParams()
  {
    return $this->queryParams;
  }

  /** 
   * Set a new query parameter.
   * @param $key - string to set, does not need to be URL encoded
   * @param $value - string to set, does not need to be URL encoded
   */
  public function setQueryParam($key, $value)
  {
    $this->queryParams[$key] = $value;
  }

  /**
   * @return string HTTP Response Code.
   */
  public function getResponseHttpCode()
  {
    return (int) $this->responseHttpCode;
  }

  /**
   * @param int $responseHttpCode HTTP Response Code.
   */
  public function setResponseHttpCode($responseHttpCode)
  {
    $this->responseHttpCode = $responseHttpCode;
  }

  /**
   * @return $responseHeaders (array) HTTP Response Headers.
   */
  public function getResponseHeaders()
  {
    return $this->responseHeaders;
  }

  /**
   * @return string HTTP Response Body
   */
  public function getResponseBody()
  {
    return $this->responseBody;
  }
  



  /**
   * @param string $responseBody The HTTP response body.
   */
  public function setResponseBody($responseBody)
  {
    $this->responseBody = $responseBody;
  }

  /**
   * @return string $url The request URL.
   */
  public function getUrl()
  {
    return $this->baseComponent . $this->path .
        (count($this->queryParams) ?
            "?" . $this->buildQuery($this->queryParams) :
            '');
  }

  /**
   * @return string $method HTTP Request Method.
   */
  public function getRequestMethod()
  {
    return $this->requestMethod;
  }

  /**
   * @return array $headers HTTP Request Headers.
   */
  public function getRequestHeaders()
  {
    return $this->requestHeaders;
  }

  /**
   * @param string $key
   * @return array|boolean Returns the requested HTTP header or
   * false if unavailable.
   */
  public function getRequestHeader($key)
  {
    return isset($this->requestHeaders[$key])
        ? $this->requestHeaders[$key]
        : false;
  }

  /**
   * @return string $postBody HTTP Request Body.
   */
  public function getPostBody()
  {
    return $this->postBody;
  }

  /**
   * @param string $url the url to set
   */
  public function setUrl($url)
  {
    if (substr($url, 0, 4) != 'http') {
      // Force the path become relative.
      if (substr($url, 0, 1) !== '/') {
        $url = '/' . $url;
      }
    }
    $parts = parse_url($url);
    if (isset($parts['host'])) {
      $this->baseComponent = sprintf(
          "%s%s%s",
          isset($parts['scheme']) ? $parts['scheme'] . "://" : '',
          isset($parts['host']) ? $parts['host'] : '',
          isset($parts['port']) ? ":" . $parts['port'] : ''
      );
    }
    $this->path = isset($parts['path']) ? $parts['path'] : '';
    $this->queryParams = array();
    if (isset($parts['query'])) {
      $this->queryParams = $this->parseQuery($parts['query']);
    }
  }

  /**
   * @param string $method Set he HTTP Method and normalize
   * it to upper-case, as required by HTTP.
   *
   */
  public function setRequestMethod($method)
  {
    $this->requestMethod = strtoupper($method);
  }

  /**
   * @param array $headers The HTTP request headers
   * to be set and normalized.
   */
  public function setRequestHeaders($headers)
  {
    $headers = Google_Utils::normalize($headers);
    if ($this->requestHeaders) {
      $headers = array_merge($this->requestHeaders, $headers);
    }
    $this->requestHeaders = $headers;
  }

  /**
   * @param string $postBody the postBody to set
   */
  public function setPostBody($postBody)
  {
    $this->postBody = $postBody;
  }



  /**
   * @param string $id
   * @return string A string representation of the HTTP Request.
   */
  public function toBatchString($id)
  {
    $str = '';
    $path = parse_url($this->getUrl(), PHP_URL_PATH) . "?" .
        http_build_query($this->queryParams);
    $str .= $this->getRequestMethod() . ' ' . $path . " HTTP/1.1\n";

    foreach ($this->getRequestHeaders() as $key => $val) {
      $str .= $key . ': ' . $val . "\n";
    }

    if ($this->getPostBody()) {
      $str .= "\n";
      $str .= $this->getPostBody();
    }
    
    $headers = '';
    foreach ($this->batchHeaders as $key => $val) {
      $headers .= $key . ': ' . $val . "\n";
    }

    $headers .= "Content-ID: $id\n";
    $str = $headers . "\n" . $str;

    return $str;
  }
  
  /**
   * Our own version of parse_str that allows for multiple variables
   * with the same name. 
   * @param $string - the query string to parse
   */
  private function parseQuery($string)
  {
    $return = array();
    $parts = explode("&", $string);
    foreach ($parts as $part) {
      list($key, $value) = explode('=', $part, 2);
      $value = urldecode($value);
      if (isset($return[$key])) {
        if (!is_array($return[$key])) {
          $return[$key] = array($return[$key]);
        }
        $return[$key][] = $value;
      } else {
        $return[$key] = $value;
      }
    }
    return $return;
  }
  
  /**z
   * A version of build query that allows for multiple
   * duplicate keys. 
   * @param $parts array of key value pairs
   */
  private function buildQuery($parts)
  {
    $return = array();
    foreach ($parts as $key => $value) {
      if (is_array($value)) {
        foreach ($value as $v) {
          $return[] = urlencode($key) . "=" . urlencode($v);
        }
      } else {
        $return[] = urlencode($key) . "=" . urlencode($value);
      }
    }
    return implode('&', $return);
  }
  
  /** 
   * If we're POSTing and have no body to send, we can send the query
   * parameters in there, which avoids length issues with longer query
   * params.
   */
  public function maybeMoveParametersToBody()
  {
    if ($this->getRequestMethod() == "POST" && empty($this->postBody)) {
      $this->setRequestHeaders(
          array(
            "content-type" =>
                "application/json; charset=UTF-8"
          )
      );
      $this->setPostBody($this->buildQuery($this->queryParams));
      $this->queryParams = array();
    }
  }
}
