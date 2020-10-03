<div class="sign-in-modal overflow-auto" style="background-color: rgba(0,0,0,0.5)" x-show="showModal"
  :class="{ 'absolute inset-0 z-10 flex items-center justify-center': showModal }">
  <div class="transition bg-white w-11/12 md:max-w-md mx-auto rounded shadow-lg py-4 text-left px-6" x-show="showModal"
    @click.away="showModal = false" x-transition:enter="ease-out duration-300"
    x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100">
    <div class="flex justify-end items-center pb-3">
      <div class="cursor-pointer z-50" @click="showModal = false">
        $AssetIcon('x-close')
      </div>
    </div>
    $SignInForm
    <%-- <div class="flex justify-center items-center pt-2">
      <button class="modal-close button button-primary" @click="showModal = false">
        Cancel
      </button>
    </div> --%>
  </div>
</div>
