<?php
require_once 'app/controllers/asset_controller.php';

class CkUploadController extends AssetController {
  function __construct() {
    $this->name = 'ck_upload';
    $this->base_view_dir = ROOT_DIR;
    $this->login_required = array('image_upload', 'image_browse', 'media_upload', 'media_browse');
    parent::__construct();
  }

  function imageUpload(){
    $model = &NModel::factory('body_image');
    $funcNum = $_GET['CKEditorFuncNum'];

    // Deal with the upload
    $i = 0;
    $rel_path = "/upload/body_image/attachments/$i/";
    while (file_exists(DOCUMENT_ROOT.$rel_path)){
      // searching for a new upload folder
      $i++;
      $rel_path = "/upload/body_image/attachments/$i/";
    }
    mkdir(DOCUMENT_ROOT.$rel_path, 0777, true);

    $rel_path .= $_FILES["upload"]["name"];

    $tmp_name = $_FILES["upload"]["tmp_name"];
    $target = DOCUMENT_ROOT."$rel_path";
    move_uploaded_file($tmp_name, $target);

    // Make a new body image
    $title = "Attachment:".strftime("%Y-%m-%d:%H%M%S").$_FILES['upload']['name'];
    $model->cms_headline = $title;
    $model->small_image = $rel_path;
    $model->align = 'default';
    $model->large_image = $rel_path;
    $model->insert();

    // Return the url
    $url = $rel_path;
    $message = "Uploaded: $rel_path";
    echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($funcNum, '$url', '$message');</script>";
  }

  function imageBrowse(){
    $this->set('ckeditorfuncnum', $_GET['CKEditorFuncNum']);
    require_once('n_quickform.php');
    $this->auto_render=false;
    $form = new NQuickform();
    $model = &NModel::factory('body_image');
    $modelIndex = array();
    $model->find();
    $imgs = $model->fetchAll(true);
    foreach ($imgs as $i){
      $modelIndex[$i['small_image']] = $i['cms_headline'];
    }
    $form->addElement('select', 'image', "Image", $modelIndex, array("id"=>"bodyimage"));
    $form->addElement('button', 'bodyimagesubmit', "Submit", array("onclick"=>"javascript: img_callback()"));
    $this->set('title', 'Choose Body Image');
    $this->set('form', $form->toHtml());
    $this->render(array('layout'=>'simple'));
  }

  function mediaUpload(){
    $model = &NModel::factory('media_element');
    $funcNum = $_GET['CKEditorFuncNum'];

    // Deal with the upload
    $i = 0;
    $rel_path = "/upload/media_element/attachments/$i/";
    while (file_exists(DOCUMENT_ROOT.$rel_path)){
      // searching for a new upload folder
      $i++;
      $rel_path = "/upload/media_element/attachments/$i/";
    }
    mkdir(DOCUMENT_ROOT.$rel_path, 0777, true);

    $rel_path .= $_FILES["upload"]["name"];

    $tmp_name = $_FILES["upload"]["tmp_name"];
    $target = DOCUMENT_ROOT."$rel_path";
    move_uploaded_file($tmp_name, $target);

    // Make a new media element
    $title = "Attachment:".strftime("%Y-%m-%d:%H%M%S").$_FILES['upload']['name'];
    $model->cms_headline = $title;
    $model->media_file = $rel_path;
    $model->insert();

    // Return the url
    $url = $rel_path;
    $message = "Uploaded: $rel_path";
    echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($funcNum, '$url', '$message');</script>";
  }

  function mediaBrowse(){
    $this->set('ckeditorfuncnum', $_GET['CKEditorFuncNum']);
    require_once('n_quickform.php');
    $this->auto_render=false;
    // Media Element Browser
    $form = new NQuickform();
    $model = &NModel::factory('media_element');
    $modelIndex = array();
    $model->find();
    $media_elements = $model->fetchAll(true);
    foreach ($media_elements as $i){
      $modelIndex[$i['media_file']] = $i['cms_headline'];
    }
    $form->addElement('select', 'mediaelement', "Media Element", $modelIndex, array("id"=>"mediaelement"));
    $form->addElement('button', 'mediaelementsubmit', "Submit", array("onclick"=>"javascript: me_callback()"));

    $page_controller = &NController::factory('page');
    $pageTree = $page_controller->getTreeAsSelect('pages', "Pages");
    $form->addElement($pageTree);
    $form->addElement('button', 'pagessubmit', "Submit", array("onclick"=>"javascript: pg_callback()"));

    $this->set('title', 'Choose file or page to link to:');
    $this->set('form', $form->toHtml());
    $this->render(array('layout'=>'simple'));
  }
}
