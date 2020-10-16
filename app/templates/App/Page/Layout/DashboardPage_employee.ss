<div>
  <div class="absolute top-0 left-0">
    <a href="$Link" class="block w-20 h-20 text-white rounded-br-full bg-primary-500 hover:opacity-50">
      <span class="block pt-5 pl-3 text-lg">
        Back
      </span>
    </a>
  </div>
  <% with Employee %>

  <h1 class="pt-3 text-4xl font-bold text-center text-gray-800 md:pt-5">$FullName</h1>

  <div class="container w-full pt-10 mx-auto">

    <div class="grid grid-flow-row grid-cols-1 auto-rows-max sm:grid-cols-2 md:grid-cols-3">

      <div class="w-full col-span-1">
        <%-- Image --%>
        <div class="w-full p-2 md:p-4">
          <div class="grid w-full bg-white rounded shadow place-content-center">
            <% if Image %>
            <img src="$Image.FocusFill(300, 300).AbsoluteURL" alt="" class="block w-40 h-40 p-2 rounded-full" />
            <% else %>
            <figure class="block w-40 h-40 p-2">
              <img src="$Asset('images/default-image.svg')" alt="" class="bg-white rounded-full" />
            </figure>
            <% end_if %>
          </div>
        </div>
        <%-- Birthday --%>
        <div class="w-full p-2 md:p-4">
          <div class="grid w-full bg-white rounded shadow place-content-center">
            <h2 class="px-2 py-1 text-xl font-bold text-center text-gray-800 md:text-2xl md:px-4 md:py-2">Birthday</h2>
            <div class="grid p-2 text-green-600 rounded place-content-center">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 transform" viewBox="0 0 24 24" stroke-width="1"
                stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <rect x="3" y="8" width="18" height="4" rx="1" />
                <line x1="12" y1="8" x2="12" y2="21" />
                <path d="M19 12v7a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-7" />
                <path d="M7.5 8a2.5 2.5 0 0 1 0 -5a4.8 8 0 0 1 4.5 5a4.8 8 0 0 1 4.5 -5a2.5 2.5 0 0 1 0 5" />
              </svg>
            </div>
            <p class="px-2 py-1 text-center text-gray-800 md:text-lg md:px-4 md:py-2">
              $Birthday.Nice
            </p>
          </div>
        </div>
        <%-- Anniversary --%>
        <div class="w-full p-2 md:p-4">
          <div class="grid w-full bg-white rounded shadow place-content-center">
            <h2 class="px-2 py-1 text-xl font-bold text-center text-gray-800 md:text-2xl md:px-4 md:py-2">Anniversary
            </h2>
            <div class="grid p-2 text-blue-600 rounded place-content-center">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 transform" viewBox="0 0 24 24" stroke-width="1"
                stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <circle cx="12" cy="9" r="6" />
                <polyline points="9 14.2 9 21 12 19 15 21 15 14.2" transform="rotate(-30 12 9)" />
                <polyline points="9 14.2 9 21 12 19 15 21 15 14.2" transform="rotate(30 12 9)" />
              </svg>
            </div>
            <p class="px-2 py-1 text-center text-gray-800 md:text-lg md:px-4 md:py-2">
              $Anniversary.Nice
            </p>
          </div>
        </div>
        <%-- Late --%>
        <div class="w-full p-2 md:p-4">
          <div class="grid w-full bg-white rounded shadow place-content-center">
            <h2 class="px-2 py-1 text-xl font-bold text-center text-gray-800 md:text-2xl md:px-4 md:py-2">Late Sign-Ins
            </h2>
            <div class="grid p-2 text-red-600 rounded place-content-center">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 transform" viewBox="0 0 24 24" stroke-width="1"
                stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path
                  d="M8.7 3h6.6c0.3 0 .5 .1 .7 .3l4.7 4.7c0.2 .2 .3 .4 .3 .7v6.6c0 .3 -.1 .5 -.3 .7l-4.7 4.7c-0.2 .2 -.4 .3 -.7 .3h-6.6c-0.3 0 -.5 -.1 -.7 -.3l-4.7 -4.7c-0.2 -.2 -.3 -.4 -.3 -.7v-6.6c0 -.3 .1 -.5 .3 -.7l4.7 -4.7c0.2 -.2 .4 -.3 .7 -.3z" />
                <line x1="12" y1="8" x2="12" y2="12" />
                <line x1="12" y1="16" x2="12.01" y2="16" />
              </svg>
            </div>
            <p class="px-2 py-1 text-center text-gray-800 md:text-lg md:px-4 md:py-2">
              $LateSignIns.Count
            </p>
          </div>
        </div>
      </div>
      <div class="w-full col-span-1 md:col-span-2">
        <% include DashDailySnapshot %>
        <% include DashWeeklySnapshot %>
      </div>

    </div>

  </div>
  <% end_with %>
</div>
