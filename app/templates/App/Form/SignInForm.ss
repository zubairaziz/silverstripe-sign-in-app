<form $AttributesHTML autocomplete="off" novalidate>
  <fieldset>
    <legend data-reveal>Sign In</legend>
    <div class="flex flex-col md:flex-row md:flex-wrap" data-reveal>
      <div class="relative w-full px-2 my-3 md:my-4 lg:my-5">
        $Fields.fieldByName(PIN).FieldHolder
      </div>
    </div>
  </fieldset>

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
