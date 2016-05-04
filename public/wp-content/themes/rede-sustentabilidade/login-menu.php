<?php
//$wp_session = WP_Session::get_instance();

global $usuario;

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
			WP_PASSPORT_PATH . '/user',
			$accessToken
		);
		$client = new \GuzzleHttp\Client(['base_uri' => WP_PASSPORT_PATH]);
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
?>

<script>API_USER_STATUS = 0;</script>
<?php if ((is_array($filiado)) && ($filiado['httpCode'] == 404)) { ?>
	<div class="filie">
		<a href="<?php echo site_url(); ?>/entenda-a-filiacao/" class="label">filie-se</a>
	</div>
	<div class="fazer-conexao">
    <a href="javascript:void(0);" class="welcome-message label"><?php echo $usuario->username; ?></a>
		<div class="dropdown">
			<!--<div class="seta"></div>-->
			<div class="item">
				<p class="title">Meu perfil</p>
				<p> Ainda estamos em construção! Logo menos, por este link você irá poder editar seus dados pessoais. </p>
				<a href="<?php echo site_url(); ?>/meu-perfil/">editar</a>
			</div>
			<div class="item">
				<p class="title">Status: Apoiador</p>
				<p>Aqui mostra seu status dentro da Rede. Há duas possibilidades APOIADOR ou FILIADO.</p><a href="<?php echo site_url(); ?>/entenda-a-filiacao/">filie-se</a>
			</div>
			<div class="item">
				<a href="<?php echo site_url(); ?>/?logout=1">sair</a>
			</div>
		</div>
	</div>
<?php } else { ?>
	<div class="filie">
		<a href="<?php echo site_url(); ?>/entenda-abono-e-impugnacao/" class="label">ajuda</a>
	</div>
	<div class="fazer-conexao">
		<a href="javascript:void(0);" class="welcome-message label"><?php echo $filiado->fullname; ?></a>
		<div class="dropdown">
			<!--<div class="seta"></div>-->
			<div class="item">
				<p class="title">Meu perfil</p>
				<p> Ainda estamos em construção! Logo menos, por este link você irá poder editar seus dados pessoais. </p>
				<a href="<?php echo site_url(); ?>/meu-perfil/">editar</a>
			</div>
<?php if ($filiado->status == 99) { ?>
			<div class="item">
				<p class="title">Status: Super Admin</p>
			</div>
			<div class="item">
				<p class="title">Arquivos úteis aos filiados</p>
				<p>Neste link você poderá acessar os principais documentos internos da REDE.</p>
				<a href="/arquivos-uteis/">baixar</a>
			</div>
			<div class="item">
				<p class="title"><a class="link-master" href="/listas/#/impugnacoes/1/50/nome/asc">Pré-Filiados em fase de Impugnação</a></p>
				<p>Toda pré-filiação deve estar disponível para contestação por qualquer filiado. A pré-filiação fica nesta lista por 15 dias.</p>
			</div>
			<div class="item">
				<p class="title"><a class="link-master" href="/listas/#/confirmacao/1/50/nome/asc">Pré-filiados à confirmar</a></p>
				<p>Lista dos pré-filiados que ainda precisam passar pela formação política para terem sua filiação confirmada.</p>
			</div>
			<div class="item">
				<p class="title"><a class="link-master" href="/listas/#/filiados/1/50/nome/asc">Filiados</a></p>
				<p>Esta é a lista de todos os filiados da REDE. Todas as pessoas que estão nessa lista também estão registradas pelo partido no FiliaWeb do TSE.</p>
			</div>
			<div class="item">
				<p class="title"><a class="link-master" href="/listas/#/admin/1/50/nome/asc">Filiados para admin</a></p>
			</div>
<?php } ?>
		<script>API_USER_STATUS = '<?php echo $filiado->status ?>';</script>
		<?php if ($filiado->status == 1) { ?>
			<div class="item">
				<p class="title">Status: Pré-filiado</p>
				<a href="<?php echo site_url(); ?>/entenda-a-filiacao/">entenda</a>
			</div>
			<div class="item">
				<p class="title"><a class="link-master" href="/listas/#/filiados/1/50/nome/asc">Filiados</a></p>
				<p>Esta é a lista de todos os filiados da REDE. Todas as pessoas que estão nessa lista também estão registradas pelo partido no FiliaWeb do TSE.</p>
			</div>
		<?php } elseif ($filiado->status == 2) { ?>
			<div class="item">
				<p class="title">Status: Abonado</p>
				<a href="<?php echo site_url(); ?>/entenda-a-filiacao/">entenda</a>
			</div>
			<div class="item">
				<p class="title"><a class="link-master" href="/listas/#/filiados/1/50/nome/asc">Filiados</a></p>
				<p>Esta é a lista de todos os filiados da REDE. Todas as pessoas que estão nessa lista também estão registradas pelo partido no FiliaWeb do TSE.</p>
			</div>
		<?php } elseif ($filiado->status == 3) { ?>
			<div class="item">
				<p class="title">Status: Filiado</p>
				<p>Aqui mostra seu status dentro da Rede. Há duas possibilidades APOIADOR ou FILIADO. </p><a href="<?php echo site_url(); ?>/entenda-abono-e-impugnacao/">ajuda</a>
			</div>
			<div class="item">
				<p class="title">Arquivos úteis aos filiados</p>
				<p>Neste link você poderá acessar os principais documentos internos da REDE.</p>
				<a href="/arquivos-uteis/">baixar</a>
			</div>
			<div class="item">
				<p class="title"><a class="link-master" href="/listas/#/impugnacoes/1/50/nome/asc">Pré-Filiados em fase de Impugnação</a></p>
				<p>Toda pré-filiação deve estar disponível para contestação por qualquer filiado. A pré-filiação fica nesta lista por 15 dias.</p>
			</div>
			<div class="item">
				<p class="title"><a class="link-master" href="/listas/#/confirmacao/1/50/nome/asc">Pré-filiados à confirmar</a></p>
				<p>Lista dos pré-filiados que ainda precisam passar pela formação política para terem sua filiação confirmada.</p>
			</div>
			<div class="item">
				<p class="title"><a class="link-master" href="/listas/#/filiados/1/50/nome/asc">Filiados</a></p>
				<p>Esta é a lista de todos os filiados da REDE. Todas as pessoas que estão nessa lista também estão registradas pelo partido no FiliaWeb do TSE.</p>
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
		echo '<meta http-equiv="Location" content="'.$authorizationUrl.'">';
		exit;

// Check given state against previously stored one to mitigate CSRF attack
/* } elseif (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) { */

/*     unset($_SESSION['oauth2state']); */
/*     exit('Invalid state'); */

/* } */
} else { ?>
    <script>API_USER_STATUS = 0;</script>
    <div class="fazer-conexao">
		<a href="<?php echo WP_PASSPORT_PATH . '/registration' ?>" class="label borderd">registre-se</a>
		<a href="<?php echo site_url() . '/?login=1'; ?>" class="label"><strong>login</strong></a>
    </div>
<?php } ?>
