<div class="pt-4 mx-auto max-w-screen-xl">
  <div class="w-screen max-w-full" id="calendar"></div>
</div>
<script defer>
  document.addEventListener('DOMContentLoaded', () => {
    const calendarEl = document.getElementById('calendar')
    const calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'dayGridWeek',
      height: '550px',
      headerToolbar: {
        end: 'dayGridWeek dayGridMonth today prev,next'
      },
      buttonText: {
        today: 'Today',
        month: 'Month',
        week: 'Week',
      }
    })
    calendar.render()
  })

</script>
