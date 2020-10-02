<article class="">
  <% if IsLoggedIn %>
  <% with LoggedInEmployee %>
  <div class="h-full w-full grid place-content-center absolute z-1 h-screen w-screen inset-0">
    <% include EmployeeCard %>
  </div>
  <% end_with %>
  <% else %>
  <div>
    <% include SignInModal %>
  </div>
  <% end_if %>
  <% include Tabset %>
</article>
