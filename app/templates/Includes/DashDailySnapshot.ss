<div class="w-full p-2 md:p-4">
  <div class="w-full bg-white rounded shadow">
    <h2 class="px-2 py-1 text-xl font-bold text-center text-gray-800 md:text-2xl md:px-4 md:py-2">
      Daily Snapshot
    </h2>
    <table class="relative w-full rounded-b table-auto">
      <% with TodaysTimesheet %>
      <tr class="relative px-2 py-1 bg-white border-t border-b md:px-4 md:py-2">
        <th class="px-2 py-1 text-left border-r md:w-48 md:px-4 md:py-2">Sign In</th>
        <td class="px-2 py-1 text-left md:px-4 md:py-2">
          <input class="w-full bg-transparent outline-none focus:outline-none focus:font-weight:bold time-picker"
            data-default-date="$SignInTime.Format('h:m a')"></input>
        </td>
        <td class="w-8">
          <button class="grid text-green-600 place-content-center hover:opacity-50">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" stroke-width="1"
              stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
              <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
              <path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2"></path>
              <circle cx="12" cy="14" r="2"></circle>
              <polyline points="14 4 14 8 8 8 8 4"></polyline>
            </svg>
          </button>
        </td>
      </tr>
      <tr class="relative px-2 py-1 bg-gray-100 border-b md:px-4 md:py-2">
        <th class="px-2 py-1 text-left border-r md:w-48 md:px-4 md:py-2">Sign Out</th>
        <td class="px-2 py-1 text-left md:px-4 md:py-2">
          <input class="w-full bg-transparent outline-none focus:outline-none focus:font-weight:bold time-picker"
            data-default-date="$SignOutTime.Format('h:m a')"></input>
        </td>
        <td class="w-8">
          <button class="grid text-green-600 place-content-center hover:opacity-50">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" stroke-width="1"
              stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
              <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
              <path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2"></path>
              <circle cx="12" cy="14" r="2"></circle>
              <polyline points="14 4 14 8 8 8 8 4"></polyline>
            </svg>
          </button>
        </td>
      </tr>
      <tr class="relative px-2 py-1 bg-white border-b md:px-4 md:py-2">
        <th class="px-2 py-1 text-left border-r md:w-48 md:px-4 md:py-2">Lunch Out</th>
        <td class="px-2 py-1 text-left md:px-4 md:py-2">
          <input class="w-full bg-transparent outline-none focus:outline-none focus:font-weight:bold time-picker"
            data-default-date="$LunchOutTime.Format('h:m a')"></input>
        </td>
        <td class="w-8">
          <button class="grid text-green-600 place-content-center hover:opacity-50">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" stroke-width="1"
              stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
              <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
              <path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2"></path>
              <circle cx="12" cy="14" r="2"></circle>
              <polyline points="14 4 14 8 8 8 8 4"></polyline>
            </svg>
          </button>
        </td>
      </tr>
      <tr class="relative px-2 py-1 bg-gray-100 border-b md:px-4 md:py-2">
        <th class="px-2 py-1 text-left border-r md:w-48 md:px-4 md:py-2">Lunch In</th>
        <td class="px-2 py-1 text-left md:px-4 md:py-2">
          <input class="w-full bg-transparent outline-none focus:outline-none focus:font-weight:bold time-picker"
            data-default-date="$LunchInTime.Format('h:m a')"></input>
        </td>
        <td class="w-8">
          <button class="grid text-green-600 place-content-center hover:opacity-50">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" stroke-width="1"
              stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
              <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
              <path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2"></path>
              <circle cx="12" cy="14" r="2"></circle>
              <polyline points="14 4 14 8 8 8 8 4"></polyline>
            </svg>
          </button>
        </td>
      </tr>
      <tr class="relative px-2 py-1 bg-white border-b md:px-4 md:py-2">
        <th class="px-2 py-1 text-left border-r md:w-48 md:px-4 md:py-2">Appointment Out</th>
        <td class="px-2 py-1 text-left md:px-4 md:py-2">
          <input class="w-full bg-transparent outline-none focus:outline-none focus:font-weight:bold time-picker"
            data-default-date="$AppointmentOutTime.Format('h:m a')"></input>
        </td>
        <td class="w-8">
          <button class="grid text-green-600 place-content-center hover:opacity-50">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" stroke-width="1"
              stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
              <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
              <path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2"></path>
              <circle cx="12" cy="14" r="2"></circle>
              <polyline points="14 4 14 8 8 8 8 4"></polyline>
            </svg>
          </button>
        </td>
      </tr>
      <tr class="relative px-2 py-1 bg-gray-100 border-b md:px-4 md:py-2">
        <th class="px-2 py-1 text-left border-r md:w-48 md:px-4 md:py-2">Appointment In</th>
        <td class="px-2 py-1 text-left md:px-4 md:py-2">
          <input class="w-full bg-transparent outline-none focus:outline-none focus:font-weight:bold time-picker"
            data-default-date="$AppointmentInTime.Format('h:m a')"></input>
        </td>
        <td class="w-8">
          <button class="grid text-green-600 place-content-center hover:opacity-50">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" stroke-width="1"
              stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
              <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
              <path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2"></path>
              <circle cx="12" cy="14" r="2"></circle>
              <polyline points="14 4 14 8 8 8 8 4"></polyline>
            </svg>
          </button>
        </td>
      </tr>
      <% end_with %>
    </table>
  </div>
</div>
