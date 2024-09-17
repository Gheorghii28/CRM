<div class="p-4 md:p-6 bg-white dark:bg-gray-800 relative overflow-x-auto shadow-md sm:rounded-lg custom-height-570px scrollbar-none overflow-y-scroll">
   <h2 class="text-lg font-semibold text-gray-500 dark:text-gray-400 mb-5">{{ __('messages.last_notifications') }}</h2>
   <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
       <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
           <tr>
               <th scope="col" class="px-6 py-3">
                   {{ __('messages.deal_name') }}
               </th>
               <th scope="col" class="px-6 py-3">
                   {{ __('messages.note') }}
               </th>
           </tr>
       </thead>
       <tbody id="notes-table-body"></tbody>
   </table>
</div>