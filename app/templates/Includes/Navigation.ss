<div class="absolute top-0 right-0 p-4">
  <% if IsLoggedIn %>
  <form id="SignOutForm_SignOutForm" action="/_formsubmit/SignOutForm/" method="post"
    enctype="application/x-www-form-urlencoded" class="sign-out-form inline-block w-12 h-12">
    <input type="hidden" name="SecurityID" value="d6d194d7885c99172bc8f0a972ef28e003df5a9b" class="hidden"
      id="SignOutForm_SignOutForm_SecurityID">
    <button type="submit" name="action_submit" value="Sign Out" class="action"
      id="SignOutForm_SignOutForm_action_submit">
      <svg class="transform rotate-180 w-12 h-12" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
        stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
      </svg>
      <span class="sr-only">Sign Out</span>
    </button>
  </form>
  <% else %>
  <button role="button" class="ml-4" @click="showModal = true">
    <svg class="transform rotate-180 w-12 h-12" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
      stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
        d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
    </svg>
    <span class="sr-only">
      Sign In
    </span>
  </button>
  <% end_if %>
  <button role="button" class="ml-4">
    <svg class="transform w-12 h-12" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
      stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
    </svg>
    <span class="sr-only">
      Employees
    </span>
  </button>
</div>
