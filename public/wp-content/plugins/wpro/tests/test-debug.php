<?php

class DebugTest extends WP_UnitTestCase {

	function testDebugCache() {
		wpro()->debug->log('This is a test.');
		$this->assertTrue(wpro()->debug->is_in_cache('This is a test.'));

		wpro()->debug->clean_debug_cache();
		$this->assertFalse(wpro()->debug->is_in_cache('This is a test.'));

		wpro()->debug->log('This is a test.');
		wpro()->debug->log('This is another test.');
		$this->assertTrue(wpro()->debug->is_in_cache('This is a test.'));
		$this->assertTrue(wpro()->debug->is_in_cache('This is another test.'));
		$this->assertFalse(wpro()->debug->is_in_cache('This is a third test.'));
	}

	function testClearingDebugCache() {
		$msg = 'testClearingDebugCache test log message.';
		wpro()->debug->log($msg);
		wpro()->debug->clean_debug_cache();
		$this->assertFalse(wpro()->debug->is_in_cache($msg));
	}

	function testIndentation() {
		$i = wpro()->debug->indentation;

		wpro()->debug->logblock('test');
		$this->assertEquals($i + 1, wpro()->debug->indentation);

		wpro()->debug->logblockend();
		$this->assertEquals($i, wpro()->debug->indentation);

		wpro()->debug->clean_debug_cache();
	}

	function testLogblock() {
		$msg = 'testLockblock test string';
		wpro()->debug->logblock($msg);
		$this->assertTrue(wpro()->debug->is_in_cache($msg));

		$msg .= ' 2';
		wpro()->debug->logblock($msg);
		$this->assertTrue(wpro()->debug->is_in_cache($msg));

		wpro()->debug->logblockend();
		wpro()->debug->logblockend();
		wpro()->debug->clean_debug_cache();
	}

	function testLogreturn() {
		wpro()->debug->logblock('dummy');
		$r = wpro()->debug->logreturn('test');
		$this->assertTrue(wpro()->debug->is_in_cache("return: 'test'"));
		wpro()->debug->clean_debug_cache();
	}

	function test_wp_handle_upload_error() {
		$this->assertTrue(function_exists('wp_handle_upload_error'));
	}

}

