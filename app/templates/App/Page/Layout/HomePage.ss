<div class="absolute top-0 left-0 z-50">
  <a href="/dashboard" class="z-50 block w-20 h-20 bg-gray-100 rounded-br-full opacity-25 text-primary-500 hover:opacity-100 dashboard-link">
    <span class="block pt-3 pl-2 text-lg">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10" viewBox="0 0 24 24" stroke-width="1.5"
        stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
        <line x1="4" y1="19" x2="20" y2="19" />
        <polyline points="4 15 8 9 12 11 16 6 20 10" />
      </svg>
    </span>
  </a>
</div>
<article>
  <% if IsLoggedIn %>
  <% with LoggedInEmployee %>
  <div class="absolute inset-0 grid w-full w-screen h-full h-screen place-content-center z-1"
    style="background-color: rgba(0,0,0,0.5)">
    <% include EmployeeCard %>
  </div>
  <% end_with %>
  <% else %>
  <% include SignInModal %>
  <div class="absolute inset-0 grid w-full w-screen h-full h-screen place-content-center">
    <p class="text-3xl text-center text-gray-100 welcome-text">
      $WelcomeMessage
    </p>
  </div>
  <% end_if %>
  <% include Tabset %>
</article>
