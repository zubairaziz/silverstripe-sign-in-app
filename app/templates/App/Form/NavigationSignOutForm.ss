<form $AttributesHTML autocomplete="off" novalidate>
  <% loop HiddenFields %>
  $FieldHolder
  <% end_loop %>

  <button type="submit" name="action_submit" value="Cancel" class="action">
    <svg class="transform rotate-180 w-12 h-12" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
      stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
    </svg>
    <span class="sr-only">Sign Out</span>
  </button>
</form>
