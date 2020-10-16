<nav class="absolute top-0 right-0 z-50 flex p-4">
  <% if IsLoggedIn %>
  $LogOutForm($IsLoggedIn)
  <% else %>
  <button role="button" class="z-50 ml-4 sign-in-trigger" @click="showModal = true">
    <svg class="w-12 h-12 transform rotate-180" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="1"
      stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
      <path stroke="none" d="M0 0h24v24H0z" fill="none" />
      <path d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2" />
      <path d="M20 12h-13l3 -3m0 6l-3 -3" />
    </svg>
    <span class="sr-only">
      Sign In
    </span>
  </button>
  <% end_if %>
  <a href="#" data-tab="#tab-1" role="button" class="z-50 ml-4">
    <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 transform" viewBox="0 0 24 24" stroke-width="1"
      stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
      <path stroke="none" d="M0 0h24v24H0z" fill="none" />
      <circle cx="9" cy="7" r="4" />
      <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
      <path d="M16 3.13a4 4 0 0 1 0 7.75" />
      <path d="M21 21v-2a4 4 0 0 0 -3 -3.85" />
    </svg>
    <span class="sr-only">
      Employees
    </span>
  </a>
  <a href="#" data-tab="#tab-2" role="button" class="z-50 ml-4">
    <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 transform" viewBox="0 0 24 24" stroke-width="1"
      stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
      <path stroke="none" d="M0 0h24v24H0z" fill="none" />
      <rect x="4" y="5" width="16" height="16" rx="2" />
      <line x1="16" y1="3" x2="16" y2="7" />
      <line x1="8" y1="3" x2="8" y2="7" />
      <line x1="4" y1="11" x2="20" y2="11" />
      <rect x="8" y="15" width="2" height="2" />
    </svg>
    <span class="sr-only">
      Calendar
    </span>
  </a>
  <a href="#" data-tab="#tab-3" role="button" class="z-50 ml-4 mouse-only">
    <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 transform" viewBox="0 0 24 24" stroke-width="1"
      stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
      <path stroke="none" d="M0 0h24v24H0z" fill="none" />
      <path d="M7 18a4.6 4.4 0 0 1 0 -9a5 4.5 0 0 1 11 2h1a3.5 3.5 0 0 1 0 7h-1" />
      <polyline points="9 15 12 12 15 15" />
      <line x1="12" y1="12" x2="12" y2="21" />
    </svg>
    <span class="sr-only">
      Upload
    </span>
  </a>
</nav>
