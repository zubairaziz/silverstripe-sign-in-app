<div class="text-center form-messages"></div>
<form $AttributesHTML autocomplete="off" novalidate>
  <p class="text-3xl font-bold text-center">Sign In!</p>
  <div class="flex flex-row">
    <div class="relative w-1/4 px-2 my-3 md:my-4 lg:my-5">
      $Fields.fieldByName(PIN1).FieldHolder
    </div>
    <div class="relative w-1/4 px-2 my-3 md:my-4 lg:my-5">
      $Fields.fieldByName(PIN2).FieldHolder
    </div>
    <div class="relative w-1/4 px-2 my-3 md:my-4 lg:my-5">
      $Fields.fieldByName(PIN3).FieldHolder
    </div>
    <div class="relative w-1/4 px-2 my-3 md:my-4 lg:my-5">
      $Fields.fieldByName(PIN4).FieldHolder
    </div>
  </div>
  <%-- <div class="flex flex-col md:flex-row md:flex-wrap">
    <div class="relative w-full px-2 my-3 md:my-4 lg:my-5">
      $Fields.fieldByName(PIN).FieldHolder
    </div>
  </div> --%>

  <div class="form-error-message"></div>

  <% loop HiddenFields %>
  $FieldHolder
  <% end_loop %>

  <% if $Actions %>
  <div class="flex place-content-center">
    <% loop $Actions %>
    $Field
    <% end_loop %>
  </div>
  <% end_if %>
</form>
