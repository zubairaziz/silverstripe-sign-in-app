<form $AttributesHTML autocomplete="off" novalidate>
  <fieldset>
    <legend class="text-center">(*) indicates required field</legend>
    <div class="flex flex-col">
      <div class="relative w-full px-2 my-3 md:my-4 lg:my-5">
        $Fields.fieldByName(Name).FieldHolder
      </div>
      <div class="relative w-full px-2 my-3 md:my-4 lg:my-5">
        $Fields.fieldByName(Resource).FieldHolder
      </div>
      <div class="relative w-full px-2 my-3 md:my-4 lg:my-5">
        $Fields.fieldByName(Description).FieldHolder
      </div>
    </div>
  </fieldset>

  <div class="form-messages text-center py-4"></div>
  <div class="form-error-message"></div>

  <% loop HiddenFields %>
  $FieldHolder
  <% end_loop %>

  <% if $Actions %>
  <div class="btn-toolbar">
    <% loop $Actions %>
    $Field
    <% end_loop %>
  </div>
  <% end_if %>
</form>
