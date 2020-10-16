<div class="absolute top-0 left-0">
  <a href="/" class="block w-20 h-20 text-white rounded-br-full bg-primary-500 hover:opacity-50">
    <span class="block pt-5 pl-3 text-lg">
      Back
    </span>
  </a>
</div>
<h1 class="text-4xl font-bold text-center text-gray-800">Dashboard</h1>
<div class="container w-full pt-10 mx-auto">
  <div class="w-full px-4 mb-16 leading-normal text-gray-800 md:px-0 md:mt-4">
    <!--Console Content-->
    <div class="flex flex-wrap">
      <% include DashboardEmployees %>
      <% include DashboardBirthdays %>
      <% include DashboardAnniversaries %>
      <% include DashboardLateSignIns %>
    </div>
  </div>
</div>
