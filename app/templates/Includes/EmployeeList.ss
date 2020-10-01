<div class="flex">
  <% loop AllEmployees %>
  <div class="employee-badge flex flex-col items-center justify-center">
    <figure class="group relative grid place-content-center">
      <img src="$Image.AbsoluteURL" alt="$FullName"
        class="relative inline-block h-24 w-24 rounded-full text-white mx-auto is-{$CurrentStatusColor}">
      <div
        class="absolute w-4 h-4 bg-{$CurrentStatusColor}-500 border border-{$CurrentStatusColor}-700 rounded-full bottom-0 right-0 transform -translate-y-6 -translate-x-3">
      </div>
      <figcaption class="text-gray-700 text-center">$FullName</figcaption>
    </figure>
    <span
      class="bg-{$CurrentStatusColor}-200 text-{$CurrentStatusColor}-800 px-2 py-1 text-xs rounded-full text-center">$CurrentStatus</span>
  </div>
  <% end_loop %>
</div>
