<div
  class="employee-card my-2 p-4 flex flex-col items-center justify-center rounded-lg border bg-gray-100 border-gray-500 grid place-content-center max-w-lg shadow-lg">
  <img src="$Image.AbsoluteURL" alt="$FullName" class="inline-block h-32 w-32 rounded-full text-white shadow-solid">
  <h2>$FullName</h2>
  <h3>Today's Activity</h3>
  <ul>
    <li>Sign In: $TodaysTimesheet.SignInTime.Nice</li>
    <% if $TodaysTimesheet.LunchOutTime %>
    <li>Lunch: $TodaysTimesheet.LunchOutTime.Nice
      <% if $TodaysTimesheet.LunchInTime %>
      <span> - $TodaysTimesheet.LunchInTime.Nice</span>
      <% end_if %>
    </li>
    <% end_if %>
    <% if $TodaysTimesheet.AppointmentOutTime %>
    <li>Appointment: $TodaysTimesheet.AppointmentOutTime.Nice
      <% if $TodaysTimesheet.AppointmentInTime %>
      <span> - $TodaysTimesheet.AppointmentInTime.Nice</span>
      <% end_if %>
    </li>
    <% end_if %>
  </ul>
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
</div>
