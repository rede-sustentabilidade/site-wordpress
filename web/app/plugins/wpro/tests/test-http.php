<?php

class HttpTest extends WP_UnitTestCase {

	function testUrlExists() {
		$this->assertTrue(wpro()->http->url_exists('http://www.sunet.se/'));
		$this->assertFalse(wpro()->http->url_exists('http://www.google.com/fuckingshit')); // Yakees would never dare to have such an url. It would be http://www.google.com/beeeeepbeep in their world.
	}

}

