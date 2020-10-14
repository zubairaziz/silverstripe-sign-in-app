<div class="overflow-auto sign-in-modal" style="background-color: rgba(0,0,0,0.5)" x-show="showModal"
  :class="{ 'absolute inset-0 z-10 flex items-center justify-center': showModal }">
  <div class="w-11/12 px-6 py-4 mx-auto text-left transition bg-white rounded shadow-lg md:max-w-md" x-show="showModal"
    @click.away="showModal = false" x-transition:enter="ease-out duration-300"
    x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100">
    <div class="flex items-center justify-end pb-3">
      <div class="z-50 text-gray-800 cursor-pointer hover:text-gray-600" @click="showModal = false">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" class="w-5 h-5" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
      </div>
    </div>
    $SignInForm
  </div>
</div>
