<article>
  <% if IsLoggedIn %>
  <% with LoggedInEmployee %>
  <div class="employee-card my-2 p-4 flex flex-col items-center justify-center">
    <img src="$Image.AbsoluteURL" alt="$FullName" class="inline-block h-32 w-32 rounded-full text-white shadow-solid">
    <h2>$FullName</h2>
  </div>
  <% end_with %>
  <div class="button-toolbar-center">
    $SignOutForm
  </div>
  <% else %>
  <!--Overlay-->
  <div class="overflow-auto" style="background-color: rgba(0,0,0,0.5)" x-show="showModal"
    :class="{ 'absolute inset-0 z-10 flex items-center justify-center': showModal }">
    <!--Dialog-->
    <div class="bg-white w-11/12 md:max-w-md mx-auto rounded shadow-lg py-4 text-left px-6" x-show="showModal"
      @click.away="showModal = false" x-transition:enter="ease-out duration-300"
      x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100">

      <!--Title-->
      <div class="flex justify-between items-center pb-3">
        <p class="text-2xl text-center text-3xl font-bold">Sign In!</p>
        <div class="cursor-pointer z-50" @click="showModal = false">
          $AssetIcon('x-close')
        </div>
      </div>

      <!-- content -->
      $SignInForm

      <!--Footer-->
      <%-- <div class="flex justify-end pt-2">
          <button
            class="px-4 bg-transparent p-3 rounded-lg text-indigo-500 hover:bg-gray-100 hover:text-indigo-400 mr-2"
            @click="alert('Additional Action');">Action</button>
          <button class="modal-close px-4 bg-indigo-500 p-3 rounded-lg text-white hover:bg-indigo-400"
            @click="showModal = false">Cancel</button>
        </div> --%>

    </div>
    <!--/Dialog -->
  </div><!-- /Overlay -->
  <% end_if %>
</article>
