<div class="p-4 rounded-lg border bg-gray-100 border-gray-300 shadow-lg w-screen max-w-screen-sm">
  <div class="flex flex-wrap overflow-hidden">
    <div class="w-full md:w-1/3 flex flex-col">
      <% if Image %>
      <img src="$Image.AbsoluteURL" alt="$FullName"
        class="inline-block h-32 w-32 mx-auto mb-2 rounded-full text-white shadow-solid">
      <% else %>
      <svg xmlns="http://www.w3.org/2000/svg"
        class="inline-block h-32 w-32 mx-auto mb-2 rounded-full text-white shadow-solid" viewBox="0 0 24 24"
        stroke-width="1" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
        <circle cx="12" cy="7" r="4" />
        <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
      </svg>
      <% end_if %>
      <h2 class="text-center text-xl text-gray-800">$FullName</h2>
      <% if $TodaysTimesheet.LunchOutTime %>
      <% if not $TodaysTimesheet.LunchInTime %>
      $LunchInForm($IsAppointment)
      <% end_if %>
      <% else %>
      $LunchOutForm($IsAppointment)
      <% end_if %>
      <% if $TodaysTimesheet.AppointmentOutTime %>
      <% if not $TodaysTimesheet.AppointmentInTime %>
      $AppointmentInForm($IsLunch)
      <% end_if %>
      <% else %>
      $AppointmentOutForm($IsLunch)
      <% end_if %>
      $SignOutForm($AppointmentOrLunch)
      $LogOutForm
    </div>
    <div class="w-full md:w-2/3">
      <h3 class="text-center mt-4 mb-2 text-3xl font-bold">Today's Activity</h3>
      <ul class="text-center">
        <li class="mb-1"><strong class="font-bold">Sign In:</strong> $TodaysTimesheet.SignInTime.Nice</li>
        <% if $TodaysTimesheet.LunchOutTime %>
        <li class="mb-1"><strong class="font-bold">Lunch:</strong> $TodaysTimesheet.LunchOutTime.Nice
          <% if $TodaysTimesheet.LunchInTime %>
          <span> - $TodaysTimesheet.LunchInTime.Nice</span>
          <% end_if %>
        </li>
        <% end_if %>
        <% if $TodaysTimesheet.AppointmentOutTime %>
        <li class="mb-1"><strong class="font-bold">Appointment:</strong> $TodaysTimesheet.AppointmentOutTime.Nice
          <% if $TodaysTimesheet.AppointmentInTime %>
          <span> - $TodaysTimesheet.AppointmentInTime.Nice</span>
          <% end_if %>
        </li>
        <% end_if %>
      </ul>
    </div>
  </div>
</div>
