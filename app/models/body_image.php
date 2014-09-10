<?php
require_once 'n_model.php';
require_once 'n_image.php';
require_once 'n_mirror.php';

class BodyImage extends NModel {
  function __construct() {
    $this->__table = 'body_image';
    $this->form_elements['small_image'] = array('cms_file', 'small_image', 'Small Image');
    $this->form_elements['large_image'] = array('cms_file', 'large_image', 'Large Image');
    $this->form_elements['align'] = array('select', 'align', 'Align', array('default'=>'Default', 'left'=>'Left', 'center'=>'Center', 'right'=>'Right'));
    $this->form_required_fields = array('small_image');
    $this->_order_by = 'cms_headline';
    $this->resize_to_width = 800;
    $this->resize_to_height = 0;
    parent::__construct();
  }

  function afterCreate() {
  }

  function afterUpdate() {
    /* These are just here as a demonstration of what's possible with the update hooks:
    $this->checkFormat();
    $this->resizeImages();
    $this->compressImages();
    $this->mirrorImage();
    */
  }

  function resizeImages() {
    // Requires Imagemagik PHP Module.
    $image = new NImage();
    $image->imageResize($this->large_image, $this->resize_to_width, $this->resize_to_height);
  }

  function checkFormat() {
    // Requires Imagemagik PHP Module.
    $image = new NImage();
    $image->checkImageFormat('JPG', $this->large_image, 'resize_image', 'large_image', $this->id);
  }

  function compressImages() {
    // Requires Imagemagik PHP Module.
    $image = new NImage();
    $image->compressJPEGImage($this->large_image, 75);
  }

  // Regular uploads are already handled in the form class if MIRROR_SITE is true.
  // This will take care of re-uploading the files after they've been manipulated if necessary.
  function mirrorImage() {
    if (defined('MIRROR_SITE') && MIRROR_SITE) {
      $mirror = NMirror::getInstance();
      $mirror->putFile($this->large_image);
    }
  }
}
