<?php

class BackendsTest extends WP_UnitTestCase {

	function testActivationAndDeactivationOfBackend() {

		wpro()->backends->deactivate_backend();
		$this->assertNull(wpro()->backends->active_backend);

		$backendName = 'Custom Filesystem Path';
		wpro()->backends->activate_backend($backendName);
		$activeBackend = wpro()->backends->active_backend;
		$this->assertNotNull($activeBackend);
		$this->assertEquals($backendName, $activeBackend::NAME);

		wpro()->backends->deactivate_backend();
		$this->assertNull(wpro()->backends->active_backend);
	}

	function testBackendByNameShouldReturnNullIfNonexisting() {
		$this->assertNull(wpro()->backends->backend_by_name('this_shit_does_not_exist'));
	}

	function testBackendByNameShouldReturnsCorrectObject() {
		$backendName = 'Custom Filesystem Path';
		$backendObj = wpro()->backends->backend_by_name($backendName);
		$this->assertEquals($backendName, $backendObj::NAME);
	}

	function testStandardBackendsAreRegistered() {
		$this->assertTrue(wpro()->backends->has_backend('Amazon S3'));
		$this->assertTrue(wpro()->backends->has_backend('Custom Filesystem Path'));

		// There should be no other backends than the standard ones, at this point:
		$this->assertEquals(count(wpro()->backends->backend_names()), 2);
		
	}

	function testTheIsBackendActivatedFunction() {

		wpro()->backends->deactivate_backend();
		$this->assertFalse(wpro()->backends->is_backend_activated());

		$backendName = 'Custom Filesystem Path';
		wpro()->backends->activate_backend($backendName);
		$this->assertTrue(wpro()->backends->is_backend_activated());

		wpro()->backends->deactivate_backend();
		$this->assertFalse(wpro()->backends->is_backend_activated());
	}

}
