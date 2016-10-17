<?php

class BackendFSTest extends WP_UnitTestCase {

	function testFSOptions() {
		wpro()->backends->activate_backend('Custom Filesystem Path');
		$this->assertTrue(wpro()->options->is_an_option('wpro-fs-baseurl'));
		$this->assertTrue(wpro()->options->is_an_option('wpro-fs-path'));
		wpro()->backends->deactivate_backend();
		$this->assertFalse(wpro()->options->is_an_option('wpro-fs-baseurl'));
		$this->assertFalse(wpro()->options->is_an_option('wpro-fs-path'));
	}

	function testDirsFilterFunctionRemovesTrailingSlashFromBaseurl() {

		wpro()->backends->activate_backend('Custom Filesystem Path');
		wpro()->options->set('wpro-fs-baseurl', 'http://example.org/');
		wpro()->options->set('wpro-fs-path', '/tmp');

		$dirs = wp_upload_dir();
		$this->assertEquals($dirs['baseurl'], 'http://example.org');

		wpro()->backends->deactivate_backend();

	}

	function testUploadHandleFunction() {
		// Create a 1x1 pixel transparent PNG:
		$tmpfname = tempnam('/tmp', 'WPROTEST');
		wpro()->tmpdir->cleanUpDirs[] = $tmpfname;
		$fh = fopen($tmpfname, 'w');
		$transparentpng = 'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABAQMAAAAl21bKAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAAApJREFUCNdjYAAAAAIAAeIhvDMAAAAASUVORK5CYII=';
		fwrite($fh, base64_decode($transparentpng));
		fclose($fh);

		$tmpdir = tempnam('/tmp', 'WPROTESTFSPATH');
		unlink($tmpdir);
		mkdir($tmpdir);
		//wpro()->tmpdir->cleanUpDirs[] = $tmpdir;

		wpro()->backends->activate_backend('Custom Filesystem Path');
		wpro()->options->set('wpro-fs-baseurl', 'http://example.org/');
		wpro()->options->set('wpro-fs-path', $tmpdir);
		do_action('wpro_backend_store_file', array(
			'file' => $tmpfname,
			'url' => 'http://www.example.org/wp-content/uploads/2014/05/test.png',
			'type' => 'image/png'
		));

		wpro()->backends->deactivate_backend();

		$this->assertEquals(base64_encode(file_get_contents($tmpdir . '/2014/05/test.png')), $transparentpng);

	}

}

