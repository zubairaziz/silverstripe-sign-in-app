<!--Metric Card-->
<div class="relative z-0 w-full p-3 dashboard-card md:w-1/2 xl:w-1/3">
  <div class="relative p-2 bg-white border rounded shadow">
    <% if BirthdayEmployees.Count %>
    <button
    class="absolute inset-0 w-full h-full -m-2 transform translate-x-2 translate-y-2 bg-transparent cursor-pointer dashboard-toggle z-1">
      <div class="sr-only">Toggle</div>
    </button>
    <% end_if %>
    <div class="flex flex-row items-center">
      <div class="flex-shrink pr-4">
        <div class="p-3 text-green-600 rounded">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 transform" viewBox="0 0 24 24" stroke-width="1"
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
        <h5 class="font-bold text-gray-500 uppercase">Upcoming Birthdays</h5>
        <h3 class="text-3xl font-bold">
          $BirthdayEmployees.Count
        </h3>
      </div>
    </div>
  </div>
  <% if BirthdayEmployees.Count %>
  <div
    class="hidden overflow-hidden transition-transform ease-out origin-top transform border rounded shadow dashboard-content">
    <ul class="w-full">
      <% loop BirthdayEmployees.Sort('BirthdayDate', ASC) %>
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
            <span>$Birthday.Format('MMMM d')</span>
          </div>
        </a>
      </li>
      <% end_loop %>
    </ul>
  </div>
  <% end_if %>
</div>
<!--/Metric Card-->
