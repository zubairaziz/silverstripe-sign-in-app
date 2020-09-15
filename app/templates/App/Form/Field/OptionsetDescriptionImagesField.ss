<ul $AttributesHTML>
  <% loop $Options %>
    <li class="$Class">
      <input id="$ID" class="radio" name="$Name" type="radio" value="$Value"<% if $isChecked %> checked<% end_if %><% if $isDisabled %> disabled<% end_if %> <% if $Up.Required %>required<% end_if %> />
      <label for="$ID">$Title</label>
      <div class="description">$Description</div>

      <% if ImagesData %>
        <button type="button" class="view-images" data-images="$ImagesData">(View Images)</button>
      <% end_if %>
    </li>
  <% end_loop %>
</ul>
