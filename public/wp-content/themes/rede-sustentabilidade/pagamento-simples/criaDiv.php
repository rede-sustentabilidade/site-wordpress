<?php

	include_once "autoload.inc.php";

		$moip = new Moip();
		//$moip->setEnvironment('test');

		$ip_server = $_SERVER['SERVER_ADDR'];

		if ( $ip_server != '177.153.4.42') {
			// teste sistema@redesustentabilidade.org.br
			$moip->setEnvironment('test');
			$moip->setCredential(array(
				'key' => '5HEZBLHUY2NLSMBZ7C1RHULEKNXKTSMASGLIZQY7',
				'token' => 'BW2SLTOSNSZE8SYBGBQHWNIRKW3IWDJJ'
			));
		} else {
			// producao redesustentabilidade 1
			// $moip->setEnvironment();
			// $moip->setCredential(array(
			// 	'key' => 'NKHQEFARRUMTW7IWTA21YLDON09W86INITFTKBXW',
			// 	'token' => 'YXLEJLA6XKXVLHLSLNVIR7TIBKC8FZJX'
			// ));

			// producao redesustentabilidadeorgbr 2
			$moip->setEnvironment();
			$moip->setCredential(array(
				'key' => 'UQTXONUZDIXW6VTN2LH1UAAVYCXPFROOJOV5R8QA',
				'token' => '30YS5XAE9XHRFG82G91V6U1AJDK1YCQP'
			));
		}
		

		
		$moip->setUniqueID(false);
		$moip->setValue($_POST['ipt_contribuicao']);
		$moip->setReason('Doacao');

		$payerData = array();

		$billingAddress = array();
		foreach ($_POST as $key => $value) {
		 	if(strncmp($key, "ipt_bln_", 8)==0){
			 	if(strncmp($key, "ipt_bln_add_", 12) ==0){
			 		$billingAddress[substr($key,12)] = $value;		
			 	}
			 	else {
			 		$payerData[substr($key,8)] = $value;
			 	}
		 	}
		}

		$payerData['payerId'] = 'xid_usuario';
		$payerData['billingAddress'] = $billingAddress;


		$moip->setPayer($payerData);
		$moip->validate('Identification');

		$moip->addPaymentWay('creditCard');
		$moip->addPaymentWay('billet');
		$two_days_more  = date('Y-m-d',mktime(0, 0, 0, date("m")  , date("d")+1, date("Y")));
		$moip->setBilletConf($two_days_more, true, array("Rede Sustentabilidade", "Doacao", ""), "http://redesustentabilidade.org.br/content/themes/rede-sustentabilidade/assets/images/rede-logo-beta-old.png");

		$moip->send();

		if($moip->getAnswer()->response) {
			print_r('<div id="MoipWidget" data-token="'.$moip->getAnswer()->token.'" callback-method-success="funcaoSucesso" callback-method-error="funcaoFalha"></div>');

			$data = array (
				'quantia' => $_POST['ipt_contribuicao'], 
				'forma' => 1, 
				'nome' => $_POST['ipt_bln_name'], 
				'email' => $_POST['ipt_bln_email'], 
				'endereco' => $_POST['ipt_bln_add_address'], 
				'numero' => $_POST['ipt_bln_add_number'], 
				'complemento' => $_POST['ipt_bln_add_complement'], 
				'bairro' => $_POST['ipt_bln_add_neighborhood'], 
				'cidade' => $_POST['ipt_bln_add_city'], 
				'estado' => $_POST['ipt_bln_add_state'], 
				'cep' => $_POST['ipt_bln_add_zipCode'], 
				'pais' => $_POST['ipt_bln_add_country'], 
				'telefone' => $_POST['ipt_bln_add_phone'], 
				'transacao' => $moip->getAnswer()->token
				);


			// $cURL = curl_init('http://localhost:9999/conexao-rede-api/public/api/v1/doacao');

			$cURL = curl_init('http://api.redesustentabilidade.org.br/api/v1/doacao');
	    	curl_setopt($cURL, CURLOPT_POST, true);
	    	curl_setopt($cURL, CURLOPT_POSTFIELDS, json_encode($data));
	    	curl_setopt($cURL, CURLOPT_RETURNTRANSFER, false);

	    	curl_exec($cURL);	   	
		}
		else
			print_r( '<div>'.$moip->getAnswer()->error.'</div>' );
	?>
