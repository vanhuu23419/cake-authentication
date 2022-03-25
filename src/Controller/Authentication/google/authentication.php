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

$clientId = ConfigUtil::getValueList('common.google_auth')['client_id'];
$secret = ConfigUtil::getValueList('common.google_auth')['secret'];

$client = new Google_Client();
$client->setClientId($clientId);
$client->setClientSecret($secret);
$client->setAccessType("offline");
$client->setPrompt("consent");
$client->addScope('https://www.googleapis.com/auth/userinfo.email');
$client->addScope('https://www.googleapis.com/auth/userinfo.profile');
$client->setRedirectUri(
    Router::url(['_name' => 'auth_google_authentication'], true) 
);

/**
 * Authenticating
 */
// redirected from Google's login uri (after init call)
// login successful, set ```access_token``` & redirect
if (isset($_GET['code'])) {
    $authenticate = $client->authenticate($_GET['code']);
    if ($authenticate['access_token']) {
        $session->write('google_auth', $authenticate);
    }
    else {
        // unexpected error
        $controller->Flash->error('Failed to login with Google. Please try again.');
    }

    // whether login successful or not, redirect to ```auth_login_index```
    // because we're only handle Google's auth here, not the app login logic
    return $this->redirect(
        Router::url(['_name' => 'auth_login_index'], true));
}
// redirected from Google's login uri (after init call)
// failed to login, redirect to ```auth_login_index```
elseif (isset($_GET['error'])) {
    $this->Flash->error('Failed to login with Google. Please try again.');
    return $this->redirect(
        Router::url(['_name' => 'auth_login_index'], true)
    );
}
// init call, redirect to Google's login uri
else {
    $googleAuthUri = $client->createAuthUrl(); 
    return $this->redirect($googleAuthUri);
}
