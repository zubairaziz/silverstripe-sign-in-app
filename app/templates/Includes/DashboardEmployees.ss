<!--Metric Card-->
<div class="relative z-0 w-full p-3 dashboard-card md:w-1/2 xl:w-1/3">
  <div class="relative p-2 bg-white border rounded shadow">
    <% if AllEmployees.Count %>
    <button
      class="absolute inset-0 w-full h-full -m-2 transform translate-x-2 translate-y-2 bg-transparent cursor-pointer dashboard-toggle z-1">
      <div class="sr-only">Toggle</div>
    </button>
  <% end_if %>
    <div class="flex flex-row items-center">
      <div class="flex-shrink pr-4">
        <div class="p-3 text-orange-600 rounded">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 transform" viewBox="0 0 24 24" stroke-width="1"
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
        <h5 class="font-bold text-gray-500 uppercase">Total Employees</h5>
        <h3 class="text-3xl font-bold">
          $AllEmployees.Count
        </h3>
      </div>
    </div>
  </div>
  <% if AllEmployees.Count %>
  <div
    class="hidden overflow-hidden transition-transform ease-out origin-top transform border border-t-0 rounded rounded-t-none shadow dashboard-content">
    <ul class="w-full">
      <% loop AllEmployees %>
      <li class="w-full p-1 group hover:bg-gray-400 <% if Even %>bg-gray-200<% end_if %>">
        <a class="flex items-center" href="$Link">
          <% if Image %>
          <img src="$Image.FocusFill(100, 100).AbsoluteURL" alt="" class="block w-16 h-16 p-2 mr-5 rounded-full" />
          <% else %>
          <figure class="block w-16 h-16 p-2 mr-5">
            <img src="$Asset('images/default-image.svg')" alt="" class="bg-white rounded-full" />
          </figure>
          <% end_if %>
          <p>$FullName</p>
        </a>
      </li>
      <% end_loop %>
    </ul>
  </div>
  <% end_if %>
</div>
<!--/Metric Card-->
