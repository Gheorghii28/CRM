<li data-id="{{ $task->id }}" data-due-date="{{ $task->due_date }}" class="list-group-item p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 my-4">

    <div class="flex justify-between items-start">
        <h5 class="mb-4 text-2xl font-semibold tracking-tight text-gray-900 dark:text-white">{{ $task->title }}</h5>
        <button id="dropdownButton-{{ $task->id }}" data-dropdown-toggle="dropdown-{{ $task->id }}" class="inline-block text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-1.5" type="button">
            <span class="sr-only">Open dropdown</span>
            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 3">
                <path d="M2 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm6.041 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM14 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Z"/>
            </svg>
        </button>
        <!-- Dropdown menu -->
        <div id="dropdown-{{ $task->id }}" class="z-10 hidden text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
            <ul class="py-2" aria-labelledby="dropdownButton">
                <li>
                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Edit</a>
                </li>
                <li>
                    <a href="#" class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Delete</a>
                </li>
            </ul>
        </div>
    </div>

    <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">{{ $task->task_description }}</p>

    <div class="flex justify-between items-center">
        <button data-popover-target="popover-description-{{ $task->id }}" data-popover-placement="bottom-start" type="button">
            <svg class="w-4 h-4 text-gray-400 hover:text-gray-500" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path>
            </svg>
        </button>
        <div data-popover id="popover-description-{{ $task->id }}" role="tooltip" class="absolute z-10 invisible inline-block text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 w-72 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400">
            <div class="p-3 space-y-2">
                <h3 class="font-semibold text-gray-900 dark:text-white">Assigned Employee:</h3>
                <p>{{ $task->user->name }}</p>
                <h3 class="font-semibold text-gray-900 dark:text-white">Related Deal:</h3>
                <p>{{ $task->deal->deal_name }}</p>
                <h3 class="font-semibold text-gray-900 dark:text-white">Customer:</h3>
                <p>{{ $task->deal->customer->firstname }} {{ $task->deal->customer->lastname }}</p>
            </div>
            <div data-popper-arrow></div>
        </div>
        
        @php
            use Carbon\Carbon;
            $dueDate = Carbon::parse($task->due_date);
            $daysLeft = Carbon::now()->diffInDays($dueDate, false);
            $textColor = $task->status === 'done' ? 'text-green-800' : 'text-violet-800';
            $bgColor = $task->status === 'done' ? 'bg-green-200 dark:bg-green-300' : 'bg-violet-200 dark:bg-violet-300';
        @endphp
        <div class="{{ $textColor }} {{ $bgColor }} font-medium rounded-lg text-sm px-3 py-1 flex items-center gap-1">
            @if($task->status === 'done')
                <svg class="svg-done w-4 h-4 text-green-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 11.917 9.724 16.5 19 7.5"/>
                </svg>
                Done
            @else
                <svg class="svg-days-left w-4 h-4 text-violet-800" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                </svg>
                @if($daysLeft > 0)
                    {{ $daysLeft }} days left
                @elseif($daysLeft === 0)
                    Due today
                @else
                    Overdue by {{ abs($daysLeft) }} days
                @endif
            @endif
        </div>
        
    </div>
    
</li>