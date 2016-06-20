<?php

class BackendS3Test extends WP_UnitTestCase {

	function testFiltersAreRegistered() {
		/*
		$s3_backend = wpro()->backends->backend_by_name('Amazon S3');

		// 10 is the filter priority:
		$this->assertEquals(has_filter('wpro_backend_retrieval_baseurl', array($s3_backend, 'url')), 10);
		*/
	}

	function testFileExists() {
		// The S3 backend does not have a filter for file_exists functionality, so it depends on the general WPRO fallback.
		// This test just makes sure the filter returns null, which means it should do the fallback. However, the fallback is not tested here.
		wpro()->backends->activate_backend('Amazon S3');
		$exists = apply_filters('wpro_backend_file_exists', null, 'http://example.org/2015/01/test.png');
		$this->assertNull($exists);
		wpro()->backends->deactivate_backend();
	}

	function testS3Options() {
		wpro()->backends->activate_backend('Amazon S3');
		$this->assertTrue(wpro()->options->is_an_option('wpro-aws-key'));
		$this->assertTrue(wpro()->options->is_an_option('wpro-aws-secret'));
		$this->assertTrue(wpro()->options->is_an_option('wpro-aws-bucket'));
		//$this->assertTrue(wpro()->options->is_an_option('wpro-aws-cloudfront')); // Move feature into CDN functionality.
		$this->assertTrue(wpro()->options->is_an_option('wpro-aws-virthost'));
		$this->assertTrue(wpro()->options->is_an_option('wpro-aws-endpoint'));
		$this->assertTrue(wpro()->options->is_an_option('wpro-aws-ssl'));
		wpro()->backends->deactivate_backend();
		$this->assertFalse(wpro()->options->is_an_option('wpro-aws-key'));
		$this->assertFalse(wpro()->options->is_an_option('wpro-aws-secret'));
		$this->assertFalse(wpro()->options->is_an_option('wpro-aws-bucket'));
		//$this->assertFalse(wpro()->options->is_an_option('wpro-aws-cloudfront')); // Move feature into CDN functionality.
		$this->assertFalse(wpro()->options->is_an_option('wpro-aws-virthost'));
		$this->assertFalse(wpro()->options->is_an_option('wpro-aws-endpoint'));
		$this->assertFalse(wpro()->options->is_an_option('wpro-aws-ssl'));
	}

	function testStringToBeSignedAtUploads() {
		wpro()->backends->activate_backend('Amazon S3');
		wpro()->options->set('wpro-aws-bucket', 'mytestbucket');
		$shouldBe = "PUT\n\n";
		$shouldBe .= "image/jpeg\n";
		$shouldBe .= "Sat, 24 Jan 2015 14:22:35 +0000\n";
		$shouldBe .= "x-amz-acl:public-read\n";
		$shouldBe .= "/mytestbucket/2014/12/HR-77-682x1024.jpg";
		$this->assertEquals($shouldBe, wpro()->backends->active_backend->string_to_sign_at_upload("image/jpeg", "Sat, 24 Jan 2015 14:22:35 +0000", "http://mytestbucket.s3-eu-west-1.amazonaws.com/2014/12/HR-77-682x1024.jpg"));
		wpro()->backends->deactivate_backend();
	}

}

