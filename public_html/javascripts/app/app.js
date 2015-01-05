$(function(){
    var $contact_form_containers = $(":contains('{{contact_form}}')")
    ,   $contact_form
    ;
    if ($contact_form_containers.length) {
      $contact_form = $($contact_form_containers[$contact_form_containers.length - 1])
      $contact_form.replaceWith(contact_form);
    }
});

var contact_form = $('<form data-async="true" action="/contact.php" method="POST">')
  .append(
    $('<div class="form-group">')
      .append($('<label for="name">Name</label>'))
      .append($('<input name="name" id="name">'))
  ).append(
    $('<div class="form-group">')
      .append($('<label for="email">Email Address</label>'))
      .append($('<input name="email" id="email">'))
  )
  .append($('<button type="submit">Submit</button>'))
  .append($('<p><small><strong>Note:</strong> your contact details will not be used for any purposes other than direct promotional and informational communications.</small></p>'))
  .submit(function(){
    $(this).replaceWith($('<h3>Thank you!</h3>'));
    return false;
  })
  ;
