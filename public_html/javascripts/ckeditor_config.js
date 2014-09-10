// http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.config.html#.toolbar
CKEDITOR.editorConfig = function( config ) {
  config.toolbar = [
    ['Cut', 'Copy', 'PasteText', 'Undo', 'Redo'],
    ['Link', 'Unlink', 'Image'],
    ['Bold', 'Italic', 'NumberedList', 'BulletedList'],
    ['HorizontalRule', 'Table', 'Outdent', 'Indent', 'RemoveFormat'],
    ['Format', 'Styles', 'Source']
  ];
  config.stylesSet = [];
  config.allowedContent = true;
  config.extraPlugins = 'stylesheetparser';
  config.contentsCss = '/stylesheets/editor';
  config.filebrowserWindowWidth    = 700;
  config.filebrowserWindowHeight   = 500;
  config.filebrowserBrowseUrl      = '/nterchange/ck_upload/media_browse';
  config.filebrowserUploadUrl      = '/nterchange/ck_upload/media_upload';
  config.filebrowserImageBrowseUrl = '/nterchange/ck_upload/image_browse';
  config.filebrowserImageUploadUrl = '/nterchange/ck_upload/image_upload';
};
