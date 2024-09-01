<div class="flex items-center justify-center">
    <div class="w-full">
        <div class="p-4 dark:bg-gray-800 bg-white">
            <div class="px-4 flex items-center justify-between">
                <span id="currentMonthYear" tabindex="0" class="focus:outline-none  text-base font-bold dark:text-gray-100 text-gray-800">October 2020</span>
                <div class="flex items-center">
                    <button aria-label="calendar backward" class="focus:text-gray-400 hover:text-gray-400 text-gray-800 dark:text-gray-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-left" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <polyline points="15 6 9 12 15 18" />
                    </svg>
                </button>
                <button aria-label="calendar forward" class="focus:text-gray-400 hover:text-gray-400 ml-3 text-gray-800 dark:text-gray-100"> 
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler  icon-tabler-chevron-right" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <polyline points="9 6 15 12 9 18" />
                    </svg>
                </button>
                </div>
            </div>
            <div id="calendar" class="flex items-center justify-between pt-12 overflow-x-auto">
            </div>
        </div>
    </div>
</div>