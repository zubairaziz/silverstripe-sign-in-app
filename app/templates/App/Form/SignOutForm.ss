<form $AttributesHTML autocomplete="off" novalidate>
  <div class="form-messages text-center py-4"></div>
  <div class="form-error-message"></div>

  <% loop HiddenFields %>
  $FieldHolder
  <% end_loop %>

  <% if $Actions %>
  <div class="button-toolbar" data-reveal>
    <% loop $Actions %>
    $Field
    <% end_loop %>
  </div>
  <% end_if %>
</form>
