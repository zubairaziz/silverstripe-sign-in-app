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
      <!--Metric Card-->
      <div class="w-full p-3 md:w-1/2 xl:w-1/3">
        <div class="p-2 bg-white border rounded shadow">
          <div class="flex flex-row items-center">
            <div class="flex-shrink pr-4">
              <div class="p-3 text-red-600 rounded">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 transform" viewBox="0 0 24 24" stroke-width="1"
                  stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                  <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                  <circle cx="12" cy="12" r="9" />
                  <line x1="12" y1="8" x2="12" y2="12" />
                  <line x1="12" y1="16" x2="12.01" y2="16" />
                </svg>
              </div>
            </div>
            <div class="flex-1 text-right md:text-center">
              <h5 class="font-bold text-gray-500 uppercase">Late Sign-Ins</h5>
              <h3 class="text-3xl font-bold">
                0
              </h3>
            </div>
          </div>
        </div>
      </div>
      <!--/Metric Card-->
    </div>
  </div>
</div>
