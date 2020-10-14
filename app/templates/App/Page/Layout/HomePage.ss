<article class="">
  <% if IsLoggedIn %>
  <% with LoggedInEmployee %>
  <div class="absolute inset-0 grid w-full w-screen h-full h-screen place-content-center z-1" style="background-color: rgba(0,0,0,0.5)">
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
