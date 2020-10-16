<div class="w-screen p-4 bg-gray-100 border border-gray-300 rounded-lg shadow-lg employee-card-holder">
  <div class="text-center form-messages"></div>
  <div class="flex flex-wrap overflow-hidden employee-card">
    <div class="flex flex-col w-full md:w-1/3">
      <% if Image %>
      <img src="$Image.AbsoluteURL" alt="$FullName"
        class="inline-block w-32 h-32 mx-auto mb-2 text-white rounded-full shadow-solid">
      <% else %>
      <svg xmlns="http://www.w3.org/2000/svg"
        class="inline-block w-32 h-32 mx-auto mb-2 text-white rounded-full shadow-solid" viewBox="0 0 24 24"
        stroke-width="1" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
        <circle cx="12" cy="7" r="4" />
        <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
      </svg>
      <% end_if %>
      <h2 class="text-xl text-center text-gray-800">$FullName</h2>
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
      <% if not hasSignedOut %>$SignOutForm($AppointmentOrLunch)<% end_if %>
      $LogOutForm
    </div>
    <div class="w-full md:w-2/3">
      <h3 class="mt-4 mb-2 text-3xl font-bold text-center">Today's Activity</h3>
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
      <% if hasSignedOut %>
      <p class="my-4 text-center">
        You are signed out for the day.
      </p>
      <% end_if %>
    </div>
  </div>
</div>
