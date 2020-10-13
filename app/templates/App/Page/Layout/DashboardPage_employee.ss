<div class="absolute inset-0 w-screen h-full bg-gray-200">
  <div class="absolute top-0 left-0">
    <div class="w-24 h-24 bg-primary block rounded-full absolute z-0 transform -translate-x-8 -translate-y-10"></div>
    <a href="$Link" class="absolute top-0 left-0 p-2 text-gray-100 hover:text-gray-200">Back</a>
  </div>
  <% with Employee %>
  <h1 class="text-4xl text-gray-800 text-center font-bold">$FullName</h1>
  <div class="container w-full mx-auto pt-10">
    <div class="flex flex-wrap">
      <%-- Image --%>
      <div class="w-full p-2 md:p-4">
        <div class="w-full bg-white grid place-content-center rounded shadow">
          <% if Image %>
          <img src="$Image.FocusFill(100, 100).AbsoluteURL" alt="" class="h-40 w-40 block rounded-full p-2" />
          <% else %>
          <figure class="h-40 w-40 block p-2">
            <img src="$Asset('images/default-image.svg')" alt="" class="rounded-full bg-white" />
          </figure>
          <% end_if %>
        </div>
      </div>
      <%-- Birthday --%>
      <div class="w-full p-2 md:p-4">
        <div class="w-full bg-white grid place-content-center rounded shadow">
          $Birthday.Nice
        </div>
      </div>
      <%-- Anniversary --%>
      <div class="w-full p-2 md:p-4">
        <div class="w-full bg-white grid place-content-center rounded shadow">
          $Anniversary.Nice
        </div>
      </div>
      <%-- Late --%>
      <div class="w-full p-2 md:p-4">
        <div class="w-full bg-white grid place-content-center rounded shadow">
          $Anniversary.Nice
        </div>
      </div>
    </div>
  </div>
  <% end_with %>
</div>
