<div class="min-w-52 w-full bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6">
 
   <div class="flex justify-between mb-5">
     <div>
         <h5 class="leading-none font-bold pb-2 text-3xl text-gray-500 dark:text-gray-400">{{ __('messages.payments_overview') }}</h5>
     </div>
      <button
        id="dropdown-default-btn-payments"
        data-dropdown-toggle="last-days-dropdown-payments"
        data-dropdown-placement="bottom"
        class="text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-gray-900 text-center inline-flex items-center dark:hover:text-white"
        type="button">
        {{ __('messages.last_7_days') }}
        <svg class="w-2.5 m-2.5 ms-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
        </svg>
      </button>
      <div id="last-days-dropdown-payments" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
          <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdown-default-btn-payments">
            <li class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white cursor-pointer" data-days="7">
              {{ __('messages.last_7_days') }}
           </li>
           <li class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white cursor-pointer" data-days="30">
              {{ __('messages.last_30_days') }}
           </li>
           <li class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white cursor-pointer" data-days="90">
              {{ __('messages.last_90_days') }}
           </li>
          </ul>
      </div>
   </div>
   
   <div id="financials-chart" class="[&>div]:mx-auto"></div>

   <div class="grid grid-cols-1 items-center border-gray-200 border-t dark:border-gray-700 justify-between mt-5">
      <div class="flex justify-between items-center pt-5">
         <div class="border-stroke py-2 dark:border-strokedark xsm:w-1/2 xsm:border-r">
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-gray-900 text-center inline-flex items-center dark:hover:text-white">{{ __('messages.received_amount') }}</p>
            <h4 id="received-amount" class="mt-1 text-title-sm font-bold text-black dark:text-white"></h4>
         </div>
         <div class="py-2 xsm:w-1/2">
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-gray-900 text-center inline-flex items-center dark:hover:text-white">{{ __('messages.due_amount') }}</p>
            <h4 id="due-amount" class="mt-1 text-title-sm font-bold text-black dark:text-white"></h4>
         </div>
      </div>
   </div>

 </div>
 