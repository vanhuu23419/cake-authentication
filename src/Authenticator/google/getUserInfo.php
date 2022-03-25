<?php 
use Cake\Routing\Router;
use App\Libs\ConfigUtil;

// Avoid unwanted warning logs from Google source code 
if(version_compare(PHP_VERSION, '7.2.0', '>=')) {
    error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
}

/**
 * Set authorization parameters
 */
$authData = $session->read('google_auth');
$clientId = ConfigUtil::getValueList('common.google_auth')['client_id'];
$secret = ConfigUtil::getValueList('common.google_auth')['secret'];
$revokeUri = 'https://oauth2.googleapis.com/token';
$profileUri = 'https://www.googleapis.com/oauth2/v1/userinfo?alt=json&access_token=';

// Authenticated, fetch user profile data
if (!empty($authData)) {
    $client = new Google_Client();
    $content = file_get_contents($profileUri . $authData['access_token']);
    if ($content) {
        $user = json_decode($content, true);
    }
    // failed to fetch with ```access_token```
    // try again with ```refresh_token```
    else {
        // revoke ```access_token``` using ```refresh_token```
        $context  = stream_context_create(array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded",
                'method'  => 'POST',
                'content' => http_build_query([
                    'client_id' => $clientId,
                    'client_secret' => $secret,
                    'refresh_token' => $authData['refresh_token'],
                    'grant_type' => 'refresh_token',
                ])
            )
        ));

        $result = json_decode(
            file_get_contents($revokeUri, false, $context),
            true
        );
        if ($result) {
            $content = file_get_contents($profileUri . $result['access_token']);
            if ($content) {
                $user = json_decode($content, true);
            } 

            $_SESSION['google_auth'] = $result;
        }
    }
}
