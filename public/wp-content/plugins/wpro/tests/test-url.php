<?php

class UrlTest extends WP_UnitTestCase {

	function testUploadDirFilterShouldDoNothingIfThereIsNoBackend() {

		$result = wpro()->url->upload_dir(array(
			'path' => 'a',
			'url' => 'b',
			'subdir' => 'c',
			'basedir' => 'd',
			'baseurl' => 'e',
			'error' => 'f'
		));
		$reqTmpDir = wpro()->tmpdir->reqTmpDir();
		$this->assertEquals($result['path'], 'a');
		$this->assertEquals($result['url'], 'b');
		$this->assertEquals($result['subdir'], 'c');
		$this->assertEquals($result['basedir'], 'd');
		$this->assertEquals($result['baseurl'], 'e');
		$this->assertEquals($result['error'], 'f');
	}

	function testUploadDirFilterShouldReturnProperDataIfThereIsABackend() {

		wpro()->backends->activate_backend('Amazon S3');

		// Only subdir and baseurl needed:
		$result = wpro()->url->upload_dir(array(
			'subdir' => '/1973/09',
			'baseurl' => 'http://example.org/wp-content/uploads'
		));

		$this->assertStringStartsWith($result['basedir'], $result['path']);
		$this->assertStringStartsWith($result['baseurl'], $result['url']);
		$this->assertStringEndsWith($result['subdir'], $result['path']);
		$this->assertStringEndsWith($result['subdir'], $result['url']);

		wpro()->backends->deactivate_backend();

	}

}

