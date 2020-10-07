<form $AttributesHTML autocomplete="off" novalidate>
  <% loop HiddenFields %>
  $FieldHolder
  <% end_loop %>

  <button type="submit" name="action_submit" value="Cancel" class="action">
    <svg xmlns="http://www.w3.org/2000/svg" class="transform rotate-180 w-12 h-12" viewBox="0 0 24 24" stroke-width="1"
      stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
      <path stroke="none" d="M0 0h24v24H0z" fill="none" />
      <path d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2" />
      <path d="M7 12h14l-3 -3m0 6l3 -3" />
    </svg>
    <span class="sr-only">Sign Out</span>
  </button>
</form>
