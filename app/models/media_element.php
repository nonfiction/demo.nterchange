<?php
require_once 'n_model.php';

class MediaElement extends NModel {
	function __construct() {
		$this->__table = 'media_element';
		// set up form
		$this->form_required_fields[] = 'media_file';
		$this->form_required_fields[] = 'link_title';
		$this->form_elements['media_file'] = array('cms_file', 'media_file', 'Media File');
		$this->_order_by = 'cms_headline';
		parent::__construct();
	}
}
?>