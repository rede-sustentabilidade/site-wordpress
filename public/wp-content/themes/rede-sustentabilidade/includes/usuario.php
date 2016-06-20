<?php
global $usuario;

function is_logged_in()
{
    global $usuario;

    if (!empty($usuario)) {
        return $usuario;
    }

    return false;
}

function force_logged_in()
{
    $usuario = is_logged_in();

    if ($usuario) {
        return $usuario;
    }
    wp_redirect(site_url().'/?login=1');

    return false;
}

function is_filiado()
{
    $usuario = is_logged_in();
    $ApiRede = ApiRede::getInstance();
    $filiado = $ApiRede->getProfile($usuario->id); // trocar para e-mail

    if ((is_array($filiado)) && ($filiado['httpCode'] == 404)) {
        return false;
    } elseif (
        ($filiado) && (
            ($filiado->status == 3) ||
            ($filiado->status > 10)
        )) {
        return true;
    }

    return false;
}

if (isset($_GET['logout'])) {
	unset($_COOKIE['access_token']);
	setcookie('access_token', null, -1);
	setcookie('usuario', null, -1);
} else if (isset($_GET['code'])) {
    try {
        $provider = new RsProvider([
            'clientId' => OAUTH_CLIENT_ID,
            'clientSecret' => OAUTH_CLIENT_SECRET,
            'redirectUri' => OAUTH_REDIRECT_URI,
            'urlAuthorize' => OAUTH_URL_AUTHORIZE,
            'urlAccessToken' => OAUTH_URL_ACCESS_TOKEN,
            'urlResourceOwnerDetails' => OAUTH_URL_RESOURCE,
        ], ['httpClient' => new \GuzzleHttp\Client(array('verify' => false))]);
         // Try to get an access token using the authorization code grant.
         $accessToken = $provider->getAccessToken('authorization_code', [
             'code' => $_GET['code'],
         ]);

        setcookie('access_token', $accessToken);
        header('Location: /');
        exit;
    } catch (\League\OAuth2\Client\Provider\Exception\IdentityProviderException $e) {
        // Failed to get the access token or user details.
        /* var_dump($e); */
         exit($e->getMessage());
    }
} elseif (isset($_GET['login'])) {
    $provider = new RsProvider([
        'clientId' => OAUTH_CLIENT_ID,
        'clientSecret' => OAUTH_CLIENT_SECRET,
        'redirectUri' => OAUTH_REDIRECT_URI,
        'urlAuthorize' => OAUTH_URL_AUTHORIZE,
        'urlAccessToken' => OAUTH_URL_ACCESS_TOKEN,
        'urlResourceOwnerDetails' => OAUTH_URL_RESOURCE,
    ], ['httpClient' => new \GuzzleHttp\Client(array('verify' => false))]);

     // Fetch the authorization URL from the provider; this returns the
     // urlAuthorize option and generates and applies any necessary parameters
     // (e.g. state).
     $authorizationUrl = $provider->getAuthorizationUrl();

     // Get the state generated for you and store it to the session.
     $_SESSION['oauth2state'] = $provider->getState();

    // Redirect the user to the authorization URL.
        header('Location:'.$authorizationUrl);
    exit;

 // Check given state against previously stored one to mitigate CSRF attack
 /* elseif (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) { */

 /*     unset($_SESSION['oauth2state']); */
 /*     exit('Invalid state'); */

 /* } */
} else if (isset($_COOKIE['access_token'])) {
	try {
		$provider = new RsProvider([
			'clientId'                => OAUTH_CLIENT_ID,
			'clientSecret'            => OAUTH_CLIENT_SECRET,
			'redirectUri'             => OAUTH_REDIRECT_URI,
			'urlAuthorize'            => OAUTH_URL_AUTHORIZE,
			'urlAccessToken'          => OAUTH_URL_ACCESS_TOKEN,
			'urlResourceOwnerDetails' => OAUTH_URL_RESOURCE
		], ['httpClient' => new \GuzzleHttp\Client(array('verify'=>false))]);
		$accessToken = $_COOKIE['access_token'];
		$request = $provider->getAuthenticatedRequest(
			'GET',
			WP_PASSPORT_PATH . '/api/userinfo',
			$accessToken
		);
		$client = new \GuzzleHttp\Client(['base_uri' => WP_PASSPORT_PATH, 'verify'=>false]);
		$response = $client->send($request);
		$usuario = $response->getBody()->getContents();

		if (!isset($_COOKIE['usuario'])) {
			setcookie('usuario', $usuario);
		}
		$usuario = json_decode($usuario);
		$ApiRede = ApiRede::getInstance();
		$filiado = $ApiRede->getProfile($usuario->id); // trocar para e-mail
	} catch (\GuzzleHttp\Exception\ClientException $e) {
		unset($_COOKIE['access_token']);
		setcookie('access_token', null, -1);
		setcookie('usuario', null, -1);
		header('Location: /?login=1');
	} catch (\GuzzleHttp\Exception\ServerException $e) {
		// Evita que o wordpress fique fora do ar se o passaporte (oauth2 service) estiver fora do ar
	}
}
