<div class="absolute top-0 left-0">
  <div class="absolute z-0 block w-24 h-24 transform -translate-x-8 -translate-y-10 rounded-full bg-primary"></div>
  <a href="/" class="absolute top-0 left-0 p-2 text-gray-100 hover:text-gray-200">Back</a>
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
