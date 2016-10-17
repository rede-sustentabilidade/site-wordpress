<?php

class EditTest extends WP_UnitTestCase {

	function testSaveImageEditorFileShouldReturnNullWhenNoBackend() {

		$this->assertNull(wpro()->edit->save_image_editor_file('', 'filename', 'image', 'some/mime', 1));

	}


}
