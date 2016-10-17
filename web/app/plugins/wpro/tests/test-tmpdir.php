<?php

class TmpDirTest extends WP_UnitTestCase {

	function testSystemTemporaryDirectoryShouldBeSomething() {
		$this->assertNotEmpty(wpro()->tmpdir->sysTmpDir());
	}

	function testSystemTemporaryDirectoryShouldNotHaveTailingSlash() {
		$this->assertStringEndsNotWith(wpro()->tmpdir->sysTmpDir(), '/');
	}

	function testRequestTmpDirToBeSubdirToTheSystemTmpDir() {
		$this->assertStringStartsWith(wpro()->tmpdir->sysTmpDir() . '/wpro', wpro()->tmpdir->reqTmpDir());
	}

	function testRequestTemporaryDirectoryShouldNotHaveTailingSlash() {
		$this->assertStringEndsNotWith(wpro()->tmpdir->reqTmpDir(), '/');
	}

	function testRequestTemporaryDirectoryShouldBeSameEachTimeWithinTheSameRequest() {
		$this->assertEquals(wpro()->tmpdir->reqTmpDir(), wpro()->tmpdir->reqTmpDir());
		$this->assertEquals(wpro()->tmpdir->reqTmpDir(), wpro()->tmpdir->reqTmpDir());
		$this->assertEquals(wpro()->tmpdir->reqTmpDir(), wpro()->tmpdir->reqTmpDir());
	}

	function testCleanUpShouldRemoveTemporaryDirectoryRecursively() {
		mkdir(wpro()->tmpdir->reqTmpDir() . '/alfred/was', 0777, true);
		touch(wpro()->tmpdir->reqTmpDir() . '/alfred/was/here');
		$this->assertTrue(file_exists(wpro()->tmpdir->reqTmpDir()));
		wpro()->tmpdir->cleanUp();
		$this->assertFalse(file_exists(wpro()->tmpdir->reqTmpDir()));
	}

	function testToOverrideSystemTemporaryDirectoryWithOption() {
		$noOptSysTmpDir = wpro()->tmpdir->sysTmpDir();
		wpro()->options->set('wpro-tempdir', '/alfred/was/here');
		$this->assertEquals(wpro()->tmpdir->sysTmpDir(), '/alfred/was/here');
		wpro()->options->set('wpro-tempdir', '');
		$this->assertEquals($noOptSysTmpDir, wpro()->tmpdir->sysTmpDir());
	}

	function testCleanUpTempDirectories() {
		$tmpfname = tempnam('/tmp', 'FOO');
		unlink($tmpfname);
		mkdir($tmpfname);
		$this->assertTrue(is_dir($tmpfname));
		wpro()->tmpdir->cleanUpDirs[] = $tmpfname;
		wpro()->tmpdir->cleanUp();
		$this->assertFalse(is_dir($tmpfname));
	}

}

