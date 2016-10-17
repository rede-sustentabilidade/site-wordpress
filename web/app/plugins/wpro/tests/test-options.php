<?php

class OptionsTest extends WP_UnitTestCase {

	function testAvailableOptions() {
		$this->assertTrue(wpro()->options->is_an_option('wpro-service'));
		$this->assertTrue(wpro()->options->is_an_option('wpro-folder'));
		$this->assertTrue(wpro()->options->is_an_option('wpro-tempdir'));

		$this->assertFalse(wpro()->options->is_an_option('wpro-some-bullshit'));
	}


	function testRegisterAndDeregisterOption() {
		$this->assertFalse(wpro()->options->is_an_option('unit-test-option'));
		wpro()->options->register('unit-test-option');
		$this->assertTrue(wpro()->options->is_an_option('unit-test-option'));

		wpro()->options->deregister('unit-test-option');
		$this->assertFalse(wpro()->options->is_an_option('unit-test-option'));
	}

	function testSetAndGetOption() {

		$option = 'wpro_testSetAndGetOption';
		$value = 'test value';

		wpro()->options->register($option);
		wpro()->options->set($option, $value);
		
		$this->assertEquals($value, wpro()->options->get($option));

		wpro()->options->deregister($option);

	}
}

