<?php
use League\OAuth2\Client\Provider\GenericProvider as GenericProvider;

class RsProvider extends GenericProvider {

	protected $verify;

    protected function getConfigurableOptions()
    {
		return array_merge(parent::getConfigurableOptions(), [
			'verify'
		]);
	}
}
