<?php
require_once '/var/www/html/ss_mabruk/include/asdadw/vendor/autoload.php';


define('APPLICATION_NAME', 'DD');
define('CREDENTIALS_PATH', __DIR__ . '/drive-php-quickstart.json');
define('CLIENT_SECRET_PATH', __DIR__ . '/client_secret.json');
// If modifying these scopes, delete your previously saved credentials
// at ~/.credentials/drive-php-quickstart.json
define('SCOPES', implode(' ', array(
  Google_Service_Drive::DRIVE)
));

/*if (php_sapi_name() != 'cli') {
  throw new Exception('This application must be run on the command line.');
}*/

/**
 * Returns an authorized API client.
 * @return Google_Client the authorized client object
 */
function getClient() {
  $client = new Google_Client();
  $client->setApplicationName(APPLICATION_NAME);
  $client->setScopes(SCOPES);
  $client->setAuthConfig(CLIENT_SECRET_PATH);
  $client->setAccessType('offline');

  // Load previously authorized credentials from a file.
  $credentialsPath = expandHomeDirectory(CREDENTIALS_PATH);
  $accessToken = json_decode(file_get_contents($credentialsPath), true);
 /* if (file_exists($credentialsPath)) {
    $accessToken = json_decode(file_get_contents($credentialsPath), true);
    echo '<pre>'; print_r ($accessToken);die;
  } else {
    // Request authorization from the user.
    $authUrl = $client->createAuthUrl();
    printf("Open the following link in your browser:\n%s\n", $authUrl);
    print 'Enter verification code: ';
    $authCode = trim(fgets(STDIN));

    // Exchange authorization code for an access token.
    $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);

    // Store the credentials to disk.
    if(!file_exists(dirname($credentialsPath))) {
      mkdir(dirname($credentialsPath), 0700, true);
    }
    file_put_contents($credentialsPath, json_encode($accessToken));
    printf("Credentials saved to %s\n", $credentialsPath);
  } */
  /*$accessToken = array(
    'access_token' => 'ya29.Glx6BQXrt7VmFcfUXZ8ETFPqTB13zJU0-oMyz8g4x9RVuZV3Di61jCMhZxSUnFTRcO3opcYJKlKrsaf8eiDl4iGf1DCc_LjaTGG4ooO0TukqYVW9wBLGwfCCnSTfRQ',
    'token_type' => 'Bearer',
    'expires_in' => '3600',
    'created' => '1520661561',
    'refresh_token' => '1/_Ado9zJW1hkbxXp0K-GwmmLHMg4iV92HOUPYtB7b2ks'
); */
  $client->setAccessToken($accessToken);

  // Refresh the token if it's expired.
  if ($client->isAccessTokenExpired()) {
    $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
    file_put_contents($credentialsPath, json_encode($client->getAccessToken()));
  }
  return $client;
}

/**
 * Expands the home directory alias '~' to the full path.
 * @param string $path the path to expand.
 * @return string the expanded path.
 */
function expandHomeDirectory($path) {
  $homeDirectory = getenv('HOME');
  if (empty($homeDirectory)) {
    $homeDirectory = getenv('HOMEDRIVE') . getenv('HOMEPATH');
  }
  return str_replace('~', realpath($homeDirectory), $path);
}

// Get the API client and construct the service object.
$client = getClient();
$service = new Google_Service_Drive($client);

// Print the names and IDs for up to 10 files.
$optParams = array(
	'q' => "name = 'dawdawdddw'",
  'fields' => 'nextPageToken, files(name), files(id)'
);
$results = $service->files->listFiles($optParams); //echo 'RESULT = ' . $result[0];

if (count($results->getFiles()) == 0) {
  print "No files found.\n";
} else {
  print "Files:\n";
  foreach ($results->getFiles() as $file) {
    printf("%s (%s)\n", $file->getName(), $file->getId()); //echo 'RESULT = ' .  $file->getId();
  }
}
die;
$fileId = '10HN1_ee-XxyXlQ-aQI5eRlSn8m5iMEmE';
$response = $service->files->get($fileId, array("alt" => "media")); 
$headers = $response->getHeaders();

foreach ($headers as $name => $values) {
  header($name . ': ' . implode(', ', $values));
}

$fileName = "Test";

//header('Content-Disposition: attachment; filename="' . $fileName . '"');
echo $response->getBody();
exit;

/*$fileMetadata = new Google_Service_Drive_DriveFile(array(
    'name' => 'APItest',
    'mimeType' => 'application/vnd.google-apps.folder'));
$file = $service->files->create($fileMetadata, array(
    'fields' => 'id'));
printf("Folder ID: %s\n", $file->id); */
/*$p = '14H7myJ0sKrPjlYYZyCfQ1abSN7l9dO4N';
$fileMetadata = new Google_Service_Drive_DriveFile(array(
    'parents'=>array($p),
    'name' => 'McD'));
$content = file_get_contents('crm.jpg');
 $file = $service->files->create($fileMetadata, array(
    'data' => $content,
    'mimeType' => 'image/jpeg',
    'uploadType' => 'multipart',
    'fields' => 'id'));
printf("File ID: %s\n", $file->id); */

function downloadFile($service, $file) {
  $downloadUrl = $file->getDownloadUrl();
  if ($downloadUrl) {
    $request = new Google_Http_Request($downloadUrl, 'GET', null, null);
    $httpRequest = $service->getClient()->getAuth()->authenticatedRequest($request);
    if ($httpRequest->getResponseHttpCode() == 200) {
      return $httpRequest->getResponseBody();
    } else {
      // An error occurred.
      return null;
    }
  } else {
    // The file doesn't have any content stored on Drive.
    return null;
  }
}


downloadFile($service,$content);
