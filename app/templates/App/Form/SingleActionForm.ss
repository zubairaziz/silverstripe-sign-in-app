<form $AttributesHTML autocomplete="off" novalidate>
  <% loop HiddenFields %>
  $FieldHolder
  <% end_loop %>

  <% if $Actions %>
    <% loop $Actions %>
    $Field
    <% end_loop %>
  <% end_if %>
</form>
