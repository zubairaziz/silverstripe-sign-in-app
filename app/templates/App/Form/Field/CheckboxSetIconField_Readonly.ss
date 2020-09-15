<span class="readonly" id="$ID">
  <% loop AttrValues %>
    <div class="checkbox-icon">
      <div class="checkbox-icon__inner">
        <div class="icon" aria-hidden="true">
          $Icon
        </div>

        <span>$Title</span>
      </div>
    </div>
  <% end_loop %>
</span>

<input type="hidden" name="$Name" value="$InputValue" />
