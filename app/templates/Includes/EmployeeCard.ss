<div
  class="employee-card p-4 rounded-lg border bg-gray-100 border-gray-500 grid place-content-center w-full max-w-lg shadow-lg">
  <img src="$Image.AbsoluteURL" alt="$FullName" class="inline-block h-32 w-32 mx-auto mb-2 rounded-full text-white shadow-solid">
  <h2 class="text-center text-xl text-gray-800">$FullName</h2>
  <% if $TodaysTimesheet.LunchOutTime %>
  <% if not $TodaysTimesheet.LunchInTime %>
  $LunchInForm
  <% end_if %>
  <% else %>
  $LunchOutForm
  <% end_if %>
  <% if $TodaysTimesheet.AppointmentOutTime %>
  <% if not $TodaysTimesheet.AppointmentInTime %>
  $AppointmentInForm
  <% end_if %>
  <% else %>
  $AppointmentOutForm
  <% end_if %>
  $SignOutForm

  <h3 class="text-center mt-4 mb-2 text-lg">Today's Activity</h3>
  <ul class="text-center">
    <li class="mb-1">Sign In: $TodaysTimesheet.SignInTime.Nice</li>
    <% if $TodaysTimesheet.LunchOutTime %>
    <li class="mb-1">Lunch: $TodaysTimesheet.LunchOutTime.Nice
      <% if $TodaysTimesheet.LunchInTime %>
      <span> - $TodaysTimesheet.LunchInTime.Nice</span>
      <% end_if %>
    </li>
    <% end_if %>
    <% if $TodaysTimesheet.AppointmentOutTime %>
    <li class="mb-1">Appointment: $TodaysTimesheet.AppointmentOutTime.Nice
      <% if $TodaysTimesheet.AppointmentInTime %>
      <span> - $TodaysTimesheet.AppointmentInTime.Nice</span>
      <% end_if %>
    </li>
    <% end_if %>
  </ul>
</div>
