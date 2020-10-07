<div class="tabset fixed relative bg-gray-100 h-full w-full rounded-t p-4 shadow-lg" x-cloak>
  <button class="tabset-close w-full text-center outline-none focus:outline-none flex items-center justify-center">
    <svg class="transform w-8 h-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
      stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 13l-7 7-7-7m14-8l-7 7-7-7" />
    </svg>
  </button>
  <div class="tab w-full" id="tab-1" x-cloak>
    <% include EmployeeList %>
  </div>

  <div class="tab w-full" id="tab-2" x-cloak>
    <% include Calendar %>
  </div>

  <div class="tab w-full" id="tab-3" x-cloak>
    <% include UploadForm %>
  </div>
</div>
