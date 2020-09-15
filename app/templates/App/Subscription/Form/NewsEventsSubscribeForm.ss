<form $AttributesHTML autocomplete="off" novalidate>
  <div class="grid-x grid-margin-x">
    <div class="cell">
      $Fields.fieldByName(SubscribeType).FieldHolder
    </div>

    <div class="cell">
      $Fields.fieldByName(Email).FieldHolder
    </div>
  </div>

  <div class="form-error-message"></div>
  <div class="form-success-message"></div>

  <% if $Actions %>
    <% loop $Actions %>
      $Field
    <% end_loop %>
  <% end_if %>

  <% loop HiddenFields %>
    $FieldHolder
  <% end_loop %>
</form>
