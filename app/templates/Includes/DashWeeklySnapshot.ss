<div class="w-full p-2 md:p-4">
  <div class="w-full bg-white rounded shadow">
    <h2 class="px-2 py-1 text-xl font-bold text-center text-gray-800 md:text-2xl md:px-4 md:py-2">
      Weekly Snapshot
    </h2>
    <div class="p-2 md:p-4">
      <canvas class="week-chart"
        data-type="line"
        data-labels="<% loop WeeklySnapshotData %>$Date.DayOfWeek ($Date.Format(MMM d))<% if not Last %>,<% end_if %><% end_loop %>"
        data-signin='<% loop WeeklySnapshotData %><% if SignInTime %>$SignInTime.Format("HH.mm")<% else %>NaN<% end_if %><% if not Last %>,<% end_if %><% end_loop %>'
        data-signinlabels='<% loop WeeklySnapshotData %><% if SignInTime %>$SignInTime.Nice<% else %>NaN<% end_if %><% if not Last %>,<% end_if %><% end_loop %>'
        data-signout='<% loop WeeklySnapshotData %><% if SignOutTime %>$SignOutTime.Format("HH.mm")<% else %>NaN<% end_if %><% if not Last %>,<% end_if %><% end_loop %>'
        data-lunchout='<% loop WeeklySnapshotData %><% if LunchOutTime %>$LunchOutTime.Format("HH.mm")<% else %>NaN<% end_if %><% if not Last %>,<% end_if %><% end_loop %>'
        data-lunchin='<% loop WeeklySnapshotData %><% if LunchInTime %>$LunchInTime.Format("HH.mm")<% else %>NaN<% end_if %><% if not Last %>,<% end_if %><% end_loop %>'
        data-appointmentout='<% loop WeeklySnapshotData %><% if AppointmentOutTime %>$AppointmentOutTime.Format("HH.mm")<% else %>NaN<% end_if %><% if not Last %>,<% end_if %><% end_loop %>'
        data-appointmentin='<% loop WeeklySnapshotData %><% if AppointmentInTime %>$AppointmentInTime.Format("HH.mm")<% else %>NaN<% end_if %><% if not Last %>,<% end_if %><% end_loop %>'>
      </canvas>
      <%--
        ('h:m a')
        $Date.Format(YYY-MM-dd)
      --%>
    </div>
  </div>
</div>
