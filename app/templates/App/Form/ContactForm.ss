<form $AttributesHTML autocomplete="off" novalidate>
  <fieldset>
    <legend data-reveal>(*) indicates required field</legend>
    <div class="flex flex-col md:flex-row md:flex-wrap">
      <div class="relative w-full px-2 my-3 md:my-4 lg:my-5 md:w-1/2">
        $Fields.fieldByName(FirstName).FieldHolder
      </div>
      <div class="relative w-full px-2 my-3 md:my-4 lg:my-5 md:w-1/2">
        $Fields.fieldByName(LastName).FieldHolder
      </div>
    </div>
  </fieldset>

  <div class="form-messages text-center py-4"></div>
  <div class="form-error-message"></div>

  <% loop HiddenFields %>
  $FieldHolder
  <% end_loop %>

  <% if $Actions %>
  <div class="btn-toolbar" data-reveal>
    <% loop $Actions %>
    $Field
    <% end_loop %>
  </div>
  <% end_if %>
</form>
