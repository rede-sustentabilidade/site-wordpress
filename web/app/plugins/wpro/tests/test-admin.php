<?php

class AdminTest extends WP_UnitTestCase {

	function testAllAdminMethodsExist() {
		$this->assertTrue(method_exists(wpro()->admin, 'admin_form'));
		$this->assertTrue(method_exists(wpro()->admin, 'admin_init'));
		$this->assertTrue(method_exists(wpro()->admin, 'admin_menu'));
		$this->assertTrue(method_exists(wpro()->admin, 'admin_post'));
		$this->assertTrue(method_exists(wpro()->admin, 'is_trusted'));
		$this->assertTrue(method_exists(wpro()->admin, 'network_admin_menu'));
	}

}

