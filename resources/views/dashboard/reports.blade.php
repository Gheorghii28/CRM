<div class="p-4 md:p-6 bg-white dark:bg-gray-800 relative overflow-x-auto shadow-md sm:rounded-lg">
   <div class="flex justify-between mb-5">
      <h2 class="text-lg font-semibold text-gray-500 dark:text-gray-400">Last Reports</h2>
      <button
         id="dropdown-default-btn-reports"
         data-dropdown-toggle="last-days-dropdown-reports"
         data-dropdown-placement="bottom"
         class="text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-gray-900 text-center inline-flex items-center dark:hover:text-white"
         type="button">
         Last 7 days
         <svg class="w-2.5 m-2.5 ms-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
           <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
         </svg>
      </button>
      <div id="last-days-dropdown-reports" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
          <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdown-default-btn-reports">
            <li class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white cursor-pointer" data-days="7">
              Last 7 days
           </li>
           <li class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white cursor-pointer" data-days="30">
              Last 30 days
           </li>
           <li class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white cursor-pointer" data-days="90">
              Last 90 days
           </li>
          </ul>
      </div>
   </div>
   <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
       <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
           <tr>
               <th scope="col" class="px-6 py-3">
                   Name
               </th>
               <th scope="col" class="px-6 py-3">
                   Email
               </th>
               <th scope="col" class="px-6 py-3">
                   Project
               </th>
               <th scope="col" class="px-6 py-3">
                   Duration
               </th>
               <th scope="col" class="px-6 py-3">
                   Status
               </th>
           </tr>
       </thead>
       <tbody id="reports-table-body"></tbody>
   </table>
</div>