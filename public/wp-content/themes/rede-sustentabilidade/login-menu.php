<?php

if ($_GET['logout']) {
	unset($_COOKIE['access_token']);
	setcookie('access_token', null, -1);
	setcookie('usuario', null, -1);
}

if (isset($_COOKIE['access_token'])) {
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
			'http://rede.passaporte:3000/user',
			$accessToken
		);
		$client = new \GuzzleHttp\Client(['base_uri' => 'http://rede.passaporte:3000/']);
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
	}
?>

<script>API_USER_STATUS = 0;</script>
<?php if ($filiado['httpCode'] == 404) { ?>
	<div class="filie">
		<a href="<?php echo site_url(); ?>/entenda-a-filiacao/" class="label">filie-se</a>
	</div>
	<div class="fazer-conexao">
		<a class="welcome-message label"><?php echo $usuario->username; ?></a>
		<div class="dropdown">
			<!--<div class="seta"></div>-->
			<div class="item">
				<i class="icon-user 2x"></i>
				<p>Meu perfil</p>
				<a href="<?php echo site_url(); ?>/meu-perfil/">editar</a>
			</div>
			<div class="item">
				<i class="icon-tipo-perfil 2x"></i>
				<p>Status: Apoiador</p>
				<a href="<?php echo site_url(); ?>/entenda-a-filiacao/">filie-se</a>
			</div>
		</div>
	</div>
<?php } else { ?>
	<div class="filie">
		<a href="<?php echo site_url(); ?>/entenda-abono-e-impugnacao/" class="label">ajuda</a>
	</div>
	<div class="fazer-conexao">
		<a class="welcome-message label"><?php echo $filiado->fullname; ?></a>
		<div class="dropdown">
			<!--<div class="seta"></div>-->
			<div class="item">
				<i class="icon-user 2x"></i>
				<p>Meu perfil</p>
				<a href="<?php echo site_url(); ?>/meu-perfil/">editar</a>
			</div>
<?php if ($filiado->status == 99) { ?>
			<div class="item">
				<i class="icon-tipo-perfil"></i>
				<p>Status: Super Admin</p>
			</div>
			<div class="item">
				<i class="icon-download"></i>
				<p>Arquivos úteis aos filiados</p>
				<a href="/arquivos-uteis/">baixar</a>
			</div>
			<div class="item">
				<p><a class="link-master" href="/listas/#/filiados/1/50/nome/asc">Filiados</a></p>
			</div>
			<div class="item">
				<p><a class="link-master" href="/listas/#/admin/1/50/nome/asc">Filiados para admin</a></p>
			</div>
			<div class="item">
				<p><a class="link-master" href="/listas/#/abonos/1/50/nome/asc">Pré-filiados aguardando abono</a></p>
			</div>
			<div class="item">
				<p><a class="link-master" href="/listas/#/impugnacoes/1/50/nome/asc">Pré-filiados em fase de avaliação</a></p>
			</div>
<?php } ?>
<?php if ($filiado->status > 10) { ?>
			<script>var WP_USER_STATE = '<?php echo $filiado->uf ?>';</script>
			<div class="item">
				<p><a class="link-master" href="/listas/#/confirmacao/1/50/nome/asc">Pré-filiados à confirmar</a></p>
			</div>
<?php } ?>
		<script>API_USER_STATUS = '<?php echo $filiado->status ?>';</script>
		<?php if ($filiado->status == 1) { ?>
			<div class="item">
				<i class="icon-tipo-perfil"></i>
				<p>Status: Pré-filiado</p>
				<a href="<?php echo site_url(); ?>/entenda-a-filiacao/">entenda</a>
			</div>
			<div class="item">
				<p><a class="link-master" href="/listas/#/filiados/1/50/nome/asc">Filiados</a></p>
			</div>
		<?php } elseif ($filiado->status == 2) { ?>
			<div class="item">
				<i class="icon-tipo-perfil"></i>
				<p>Status: Abonado</p>
				<a href="<?php echo site_url(); ?>/entenda-a-filiacao/">entenda</a>
			</div>
			<div class="item">
				<p><a class="link-master" href="/listas/#/filiados/1/50/nome/asc">Filiados</a></p>
			</div>
		<?php } elseif ($filiado->status == 3) { ?>
			<div class="item">
				<i class="icon-tipo-perfil"></i>
				<p>Status: Filiado</p>
				<a href="<?php echo site_url(); ?>/entenda-abono-e-impugnacao/">ajuda</a>
			</div>
			<div class="item">
				<i class="icon-download"></i>
				<p>Arquivos úteis aos filiados</p>
				<a href="/arquivos-uteis/">baixar</a>
			</div>
			<div class="item">
				<p><a class="link-master" href="/listas/#/abonos/1/50/nome/asc">Pré-filiados aguardando abono</a></p>
			</div>
			<div class="item">
				<p><a class="link-master" href="/listas/#/impugnacoes/1/50/nome/asc">Pré-filiados em fase de avaliação</a></p>
			</div>
			<div class="item">
				<p><a class="link-master" href="/listas/#/filiados/1/50/nome/asc">Filiados</a></p>
			</div>
		<?php } ?>
			<div class="item">
				<a href="<?php echo site_url(); ?>/?logout=1">sair</a>
			</div>
		</div>
	</div>
<?php } ?>
<?php } else if (isset($_GET['code'])) {
	try {
		$provider = new RsProvider([
			'clientId'                => OAUTH_CLIENT_ID,
			'clientSecret'            => OAUTH_CLIENT_SECRET,
			'redirectUri'             => OAUTH_REDIRECT_URI,
			'urlAuthorize'            => OAUTH_URL_AUTHORIZE,
			'urlAccessToken'          => OAUTH_URL_ACCESS_TOKEN,
			'urlResourceOwnerDetails' => OAUTH_URL_RESOURCE
		], ['httpClient' => new \GuzzleHttp\Client(array('verify'=>false))]);
        // Try to get an access token using the authorization code grant.
        $accessToken = $provider->getAccessToken('authorization_code', [
            'code' => $_GET['code']
        ]);
		setcookie('access_token', $accessToken);
		header('Location: /');
    } catch (\League\OAuth2\Client\Provider\Exception\IdentityProviderException $e) {
		// Failed to get the access token or user details.
		/* var_dump($e); */
        exit($e->getMessage());

    }

} else if (isset($_GET['login'])) {
	$provider = new RsProvider([
		'clientId'                => OAUTH_CLIENT_ID,
		'clientSecret'            => OAUTH_CLIENT_SECRET,
		'redirectUri'             => OAUTH_REDIRECT_URI,
		'urlAuthorize'            => OAUTH_URL_AUTHORIZE,
		'urlAccessToken'          => OAUTH_URL_ACCESS_TOKEN,
		'urlResourceOwnerDetails' => OAUTH_URL_RESOURCE
	], ['httpClient' => new \GuzzleHttp\Client(array('verify'=>false))]);

    // Fetch the authorization URL from the provider; this returns the
    // urlAuthorize option and generates and applies any necessary parameters
    // (e.g. state).
    $authorizationUrl = $provider->getAuthorizationUrl();

    // Get the state generated for you and store it to the session.
    $_SESSION['oauth2state'] = $provider->getState();

	// Redirect the user to the authorization URL.
    header('Location: ' . $authorizationUrl);
    exit;

// Check given state against previously stored one to mitigate CSRF attack
/* } elseif (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) { */

/*     unset($_SESSION['oauth2state']); */
/*     exit('Invalid state'); */

/* } */
} else { ?>
    <script>API_USER_STATUS = 0;</script>
    <div class="filie">
      <a href="<?php echo site_url(); ?>/entenda-a-filiacao/" class="label">filie-se</a>
    </div>
    <div class="fazer-conexao">
		<a href="<?php echo WP_PASSPORT_PATH . '/registration' ?>" class="label borderd">registre-se</a>
		<a href="<?php echo site_url() . '/?login=1'; ?>" class="label"><strong>login</strong></a>
    </div>
<?php } ?>
