<div class="min-w-52 w-full bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6">
  
  <div class="flex justify-between">
    <div>
      <h5 id="total-deals" class="leading-none text-3xl font-bold text-gray-900 dark:text-white pb-2"></h5>
      <p class="text-base font-normal text-gray-500 dark:text-gray-400">{{ __('messages.total_deals') }}</p>
    </div>
    <div
      class="flex items-center px-2.5 py-0.5 text-base font-semibold text-green-500 dark:text-green-500 text-center">
      <span id="trend-deals"></span>
      <div>
        <svg class="w-3 h-3 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 14">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13V1m0 0L1 5m4-4 4 4"/>
        </svg>
      </div>
    </div>
  </div>
  
  <div class="py-6" id="deal-chart"></div>

</div>
