<div class="absolute top-0 left-0">
  <div class="w-24 h-24 bg-primary block rounded-full absolute z-0 transform -translate-x-8 -translate-y-10"></div>
  <a href="/" class="absolute top-0 left-0 p-2 text-gray-100 hover:text-gray-200">Back</a>
</div>
<h1 class="text-4xl text-gray-800 text-center font-bold">Dashboard</h1>
<div class="container w-full mx-auto pt-10">
  <div class="w-full px-4 md:px-0 md:mt-4 mb-16 text-gray-800 leading-normal">
    <!--Console Content-->
    <div class="flex flex-wrap">
      <!--Metric Card-->
      <div class="dashboard-card relative z-0 w-full md:w-1/2 xl:w-1/3 p-3">
        <div class="relative bg-white border rounded shadow p-2">
          <button class="dashboard-toggle cursor-pointer z-1 bg-transparent w-full h-full absolute inset-0 -m-2 transform translate-x-2 translate-y-2">
            <div class="sr-only">Toggle</div>
          </button>
          <div class="flex flex-row items-center">
            <div class="flex-shrink pr-4">
              <div class="rounded p-3 text-orange-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="transform w-12 h-12" viewBox="0 0 24 24" stroke-width="1"
                  stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                  <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                  <circle cx="9" cy="7" r="4" />
                  <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                  <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                  <path d="M21 21v-2a4 4 0 0 0 -3 -3.85" />
                </svg>
              </div>
            </div>
            <div class="flex-1 text-right md:text-center">
              <h5 class="font-bold uppercase text-gray-500">Total Employees</h5>
              <h3 class="font-bold text-3xl">
                $AllEmployees.Count
              </h3>
            </div>
          </div>
        </div>
        <div
          class="dashboard-content hidden border rounded shadow transition-transform ease-out overflow-hidden origin-top transform">
          <ul class="w-full">
            <% loop AllEmployees %>
            <li class="w-full p-1 group hover:bg-gray-400 <% if Even %>bg-gray-200<% end_if %>">
              <a class="flex items-center" href="$Link">
                <% if Image %>
                <img src="$Image.FocusFill(100, 100).AbsoluteURL" alt=""
                  class="h-16 w-16 block mr-5 rounded-full p-2" />
                <% else %>
                <figure class="h-16 w-16 block mr-5 p-2">
                  <img src="$Asset('images/default-image.svg')" alt="" class="rounded-full bg-white" />
                </figure>
                <% end_if %>
                <p>$FullName</p>
              </a>
            </li>
            <% end_loop %>
          </ul>
        </div>
      </div>
      <!--/Metric Card-->
      <!--Metric Card-->
      <div class="w-full md:w-1/2 xl:w-1/3 p-3">
        <div class="bg-white border rounded shadow p-2">
          <div class="flex flex-row items-center">
            <div class="flex-shrink pr-4">
              <div class="rounded p-3 text-green-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="transform w-12 h-12" viewBox="0 0 24 24" stroke-width="1"
                  stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                  <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                  <rect x="3" y="8" width="18" height="4" rx="1" />
                  <line x1="12" y1="8" x2="12" y2="21" />
                  <path d="M19 12v7a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-7" />
                  <path d="M7.5 8a2.5 2.5 0 0 1 0 -5a4.8 8 0 0 1 4.5 5a4.8 8 0 0 1 4.5 -5a2.5 2.5 0 0 1 0 5" />
                </svg>
              </div>
            </div>
            <div class="flex-1 text-right md:text-center">
              <h5 class="font-bold uppercase text-gray-500">Birthdays This Month</h5>
              <h3 class="font-bold text-3xl">
                0
              </h3>
            </div>
          </div>
        </div>
      </div>
      <!--/Metric Card-->
      <!--Metric Card-->
      <div class="w-full md:w-1/2 xl:w-1/3 p-3">
        <div class="bg-white border rounded shadow p-2">
          <div class="flex flex-row items-center">
            <div class="flex-shrink pr-4">
              <div class="rounded p-3 text-red-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="transform w-12 h-12" viewBox="0 0 24 24" stroke-width="1"
                  stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                  <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                  <circle cx="12" cy="12" r="9" />
                  <line x1="12" y1="8" x2="12" y2="12" />
                  <line x1="12" y1="16" x2="12.01" y2="16" />
                </svg>
              </div>
            </div>
            <div class="flex-1 text-right md:text-center">
              <h5 class="font-bold uppercase text-gray-500">Late Sign-Ins</h5>
              <h3 class="font-bold text-3xl">
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
