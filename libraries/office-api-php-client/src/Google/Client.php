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

require_once realpath(dirname(__FILE__) . '/../../autoload.php');


class Google_Client
{

  /**
   * @var Google_Auth_Abstract $auth
   */
  private $auth;



  /**
   * @var Google_Config $config
   */
  private $config;





  /**
   * Construct the Google Client.
   *
   * @param $config Google_Config or string for the ini file to load
   */
  public function __construct($config = null)
  {
    if (is_string($config) && strlen($config)) {
      $config = new Google_Config($config);
    } else if ( !($config instanceof Google_Config)) {
      $config = new Google_Config();
    }

    $this->config = $config;
  }

  /**
   * Attempt to exchange a code for an valid authentication token.
   * Helper wrapped around the OAuth 2.0 implementation.
   *
   * @param $code string code from accounts.google.com
   * @return string token
   */
  public function authenticate($code)
  {
    $this->authenticated = true;
    return $this->getAuth()->authenticate($code);
  }

  /**
   * Set the auth config from the JSON string provided.
   * This structure should match the file downloaded from
   * the "Download JSON" button on in the Google Developer
   * Console.
   * @param string $json the configuration json
   * @throws Google_Exception
   */
  public function setAuthConfig($json)
  {
    $data = json_decode($json);
    $key = isset($data->installed) ? 'installed' : 'web';
    if (!isset($data->$key)) {
      throw new Google_Exception("Invalid client secret JSON file.");
    }
    $this->setClientId($data->$key->client_id);
    $this->setClientSecret($data->$key->client_secret);
    if (isset($data->$key->redirect_uris)) {
      $this->setRedirectUri($data->$key->redirect_uris[0]);
    }
  }

  /**
   * Set the auth config from the JSON file in the path
   * provided. This should match the file downloaded from
   * the "Download JSON" button on in the Google Developer
   * Console.
   * @param string $file the file location of the client json
   */
  public function setAuthConfigFile($file)
  {
    $this->setAuthConfig(file_get_contents($file));
  }

  /**
   * @throws Google_Auth_Exception
   * @return array
   * @visible For Testing
   */
  public function prepareScopes()
  {
    if (empty($this->requestedScopes)) {
      throw new Google_Auth_Exception("No scopes specified");
    }
    $scopes = implode(' ', $this->requestedScopes);
    return $scopes;
  }

  /**
   * Set the OAuth 2.0 access token using the string that resulted from calling createAuthUrl()
   * or Google_Client#getAccessToken().
   * @param string $accessToken JSON encoded string containing in the following format:
   * {"access_token":"TOKEN", "refresh_token":"TOKEN", "token_type":"Bearer",
   *  "expires_in":3600, "id_token":"TOKEN", "created":1320790426}
   */
  public function setAccessToken($accessToken)
  {
    if ($accessToken == 'null') {
      $accessToken = null;
    }
    $this->getAuth()->setAccessToken($accessToken);
  }



  /**
   * Set the authenticator object
   * @param Google_Auth_Abstract $auth
   */
  public function setAuth(Google_Auth_Abstract $auth)
  {
    $this->config->setAuthClass(get_class($auth));
    $this->auth = $auth;
  }

  /**
   * Construct the OAuth 2.0 authorization request URI.
   * @return string
   */
  public function createAuthUrl()
  {
    $scopes = $this->prepareScopes();
    return $this->getAuth()->createAuthUrl($scopes);
  }

  /**
   * Get the OAuth 2.0 access token.
   * @return string $accessToken JSON encoded string in the following format:
   * {"access_token":"TOKEN", "refresh_token":"TOKEN", "token_type":"Bearer",
   *  "expires_in":3600,"id_token":"TOKEN", "created":1320790426}
   */
  public function getAccessToken()
  {
    $token = $this->getAuth()->getAccessToken();
    // The response is json encoded, so could be the string null.
    // It is arguable whether this check should be here or lower
    // in the library.
    return (null == $token || 'null' == $token || '[]' == $token) ? null : $token;
  }

  /**
   * Get the OAuth 2.0 refresh token.
   * @return string $refreshToken refresh token or null if not available
   */
  public function getRefreshToken()
  {
    return $this->getAuth()->getRefreshToken();
  }

  /**
   * Returns if the access_token is expired.
   * @return bool Returns True if the access_token is expired.
   */
  public function isAccessTokenExpired()
  {
    return $this->getAuth()->isAccessTokenExpired();
  }



  /**
   * Set the application name, this is included in the User-Agent HTTP header.
   * @param string $applicationName
   */
  public function setApplicationName($applicationName)
  {
    $this->config->setApplicationName($applicationName);
  }

  /**
   * Set the OAuth 2.0 Client ID.
   * @param string $clientId
   */
  public function setClientId($clientId)
  {
    $this->config->setClientId($clientId);
  }


  public function setToken($token)
    {
        $this->config->setToken($token);
    }

  /**
   * Set the OAuth 2.0 Client Secret.
   * @param string $clientSecret
   */
  public function setClientSecret($clientSecret)
  {
    $this->config->setClientSecret($clientSecret);
  }

  /**
   * Set the OAuth 2.0 Redirect URI.
   * @param string $redirectUri
   */
  public function setRedirectUri($redirectUri)
  {
    $this->config->setRedirectUri($redirectUri);
  }

  /**
   * Fetches a fresh OAuth 2.0 access token with the given refresh token.
   * @param string $refreshToken
   */
  public function refreshToken($refreshToken)
  {
    $this->getAuth()->refreshToken($refreshToken);
  }

  /**
   * Revoke an OAuth2 access token or refresh token. This method will revoke the current access
   * token, if a token isn't provided.
   * @throws Google_Auth_Exception
   * @param string|null $token The token (access token or a refresh token) that should be revoked.
   * @return boolean Returns True if the revocation was successful, otherwise False.
   */
  public function revokeToken($token = null)
  {
    return $this->getAuth()->revokeToken($token);
  }

  /**
   * Verify an id_token. This method will verify the current id_token, if one
   * isn't provided.
   * @throws Google_Auth_Exception
   * @param string|null $token The token (id_token) that should be verified.
   * @return Google_Auth_LoginTicket Returns an apiLoginTicket if the verification was
   * successful.
   */
  public function verifyIdToken($token = null)
  {
    return $this->getAuth()->verifyIdToken($token);
  }

  /**
   * Set the scopes to be requested. Must be called before createAuthUrl().
   * Will remove any previously configured scopes.
   * @param array $scopes, ie: array('https://www.googleapis.com/auth/plus.login',
   * 'https://www.googleapis.com/auth/moderator')
   */
  public function setScopes($scopes)
  {
    $this->requestedScopes = array();
    $this->addScope($scopes);
  }

  /**
   * This functions adds a scope to be requested as part of the OAuth2.0 flow.
   * Will append any scopes not previously requested to the scope parameter.
   * A single string will be treated as a scope to request. An array of strings
   * will each be appended.
   * @param $scope_or_scopes string|array e.g. "profile"
   */
  public function addScope($scope_or_scopes)
  {
    if (is_string($scope_or_scopes) && !in_array($scope_or_scopes, $this->requestedScopes)) {
      $this->requestedScopes[] = $scope_or_scopes;
    } else if (is_array($scope_or_scopes)) {
      foreach ($scope_or_scopes as $scope) {
        $this->addScope($scope);
      }
    }
  }

  /**
   * Returns the list of scopes requested by the client
   * @return array the list of scopes
   *
   */
  public function getScopes()
  {
     return $this->requestedScopes;
  }
  /**
   * Helper method to execute deferred HTTP requests.
   *
   * @param $request Google_Http_Request|Google_Http_Batch
   * @throws Google_Exception
   * @return object of the type of the expected class or array.
   */
  public function execute($client,$request)
  {
      $request->maybeMoveParametersToBody();
      return Google_Http_REST::execute($client,$request);

  }

  /**
   * Whether or not to return raw requests
   * @return boolean
   */
  public function shouldDefer()
  {
    return $this->deferExecution;
  }

  /**
   * @return Google_Auth_Abstract Authentication implementation
   */
  public function getAuth()
  {
    if (!isset($this->auth)) {
      $class = $this->config->getAuthClass();
      $this->auth =$class;
    }
    return $this->auth;
  }

  /**
   * Retrieve custom configuration for a specific class.
   * @param $class string|object - class or instance of class to retrieve
   * @param $key string optional - key to retrieve
   * @return array
   */
  public function getClassConfig($class, $key = null)
  {
    if (!is_string($class)) {
      $class = get_class($class);
    }
    return $this->config->getClassConfig($class, $key);
  }

  /**
   * Set configuration specific to a given class.
   * $config->setClassConfig('Google_Cache_File',
   *   array('directory' => '/tmp/cache'));
   * @param $class string|object - The class name for the configuration
   * @param $config string key or an array of configuration values
   * @param $value string optional - if $config is a key, the value
   *
   */
  public function setClassConfig($class, $config, $value = null)
  {
    if (!is_string($class)) {
      $class = get_class($class);
    }
    $this->config->setClassConfig($class, $config, $value);

  }

  /**
   * @return string the base URL to use for calls to the APIs
   */
  public function getBasePath()
  {
    return $this->config->getBasePath();
  }

  public function getToken()
    {
        return $this->config->getToken();
    }

  /**
   * @return string the name of the application
   */
  public function getApplicationName()
  {
    return $this->config->getApplicationName();
  }

}
