<!--Metric Card-->
<div class="relative z-0 w-full p-3 dashboard-card md:w-1/2 xl:w-1/3">
  <div class="relative p-2 bg-white border rounded shadow">
    <% if LateEmployees.Count %>
    <button
      class="absolute inset-0 w-full h-full -m-2 transform translate-x-2 translate-y-2 bg-transparent cursor-pointer dashboard-toggle z-1">
      <div class="sr-only">Toggle</div>
    </button>
    <% end_if %>
    <div class="flex flex-row items-center">
      <div class="flex-shrink pr-4">
        <div class="p-3 text-red-600 rounded">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 transform" viewBox="0 0 24 24" stroke-width="1"
            stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
            <path
              d="M8.7 3h6.6c0.3 0 .5 .1 .7 .3l4.7 4.7c0.2 .2 .3 .4 .3 .7v6.6c0 .3 -.1 .5 -.3 .7l-4.7 4.7c-0.2 .2 -.4 .3 -.7 .3h-6.6c-0.3 0 -.5 -.1 -.7 -.3l-4.7 -4.7c-0.2 -.2 -.3 -.4 -.3 -.7v-6.6c0 -.3 .1 -.5 .3 -.7l4.7 -4.7c0.2 -.2 .4 -.3 .7 -.3z" />
            <line x1="12" y1="8" x2="12" y2="12" />
            <line x1="12" y1="16" x2="12.01" y2="16" />
          </svg>
        </div>
      </div>
      <div class="flex-1 text-right md:text-center">
        <h5 class="font-bold text-gray-500 uppercase">Late Sign-Ins</h5>
        <h3 class="text-3xl font-bold">
          $LateEmployees.Count
        </h3>
      </div>
    </div>
  </div>
  <% if LateEmployees.Count %>
  <div
    class="hidden overflow-hidden transition-transform ease-out origin-top transform border rounded shadow dashboard-content">
    <ul class="w-full">
      <% loop LateEmployees %>
      <li class="w-full p-1 group hover:bg-gray-400 <% if Even %>bg-gray-200<% else %>bg-gray-100<% end_if %>">
        <a class="flex items-center justify-start" href="$Link">
          <% if Image %>
          <img src="$Image.FocusFill(100, 100).AbsoluteURL" alt="" class="block w-16 h-16 p-2 mr-5 rounded-full" />
          <% else %>
          <figure class="block w-16 h-16 p-2 mr-5">
            <img src="$Asset('images/default-image.svg')" alt="" class="bg-white rounded-full" />
          </figure>
          <% end_if %>
          <div class="flex items-center justify-between w-full pr-3">
            <span>$FullName</span>
            <span>$LateSignIns.Count</span>
          </div>
        </a>
      </li>
      <% end_loop %>
    </ul>
  </div>
  <% end_if %>
</div>
<!--/Metric Card-->
