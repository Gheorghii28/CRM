<div class="col-span-1 p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:text-gray-400 dark:bg-gray-800 dark:border-gray-600">
    <div class="flex items-center justify-between gap-4 mb-2">
        <div>
            @php
              $date = new \DateTime($activity['date']);
              $formattedDate = $date->format('H:i j F Y');
            @endphp
            <p class="text-xs font-light leading-3 text-gray-500 dark:text-gray-300">{{ $formattedDate }}</p>
            <a tabindex="0" class="focus:outline-none text-lg font-medium leading-5 text-gray-800 dark:text-gray-100 mt-2">{{ ucfirst($activity['activity_type']) }}</a>
        </div>

        <button id="dropdown-button-{{ $activity['id'] }}" data-dropdown-toggle="dropdown-{{ $activity['id'] }}" value="{{ $activity['id'] }}" class="open_more inline-flex items-center p-0.5 text-sm font-medium text-center text-gray-500 hover:text-gray-800 rounded-lg focus:outline-none dark:text-gray-400 dark:hover:text-gray-100" type="button">
            <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
            </svg>
        </button>
        <div id="dropdown-{{ $activity['id'] }}" class="hidden z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600">
            <ul class="py-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdown-button-{{ $activity['id'] }}">
                <li>
                    <a href="{{ url('/activities/' . $activity['id'] . '/show-details') }}" class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Show</a>
                </li>
                <li>
                    <button id="formModalButton-{{ $activity['id'] }}" data-modal-target="formModal" data-modal-toggle="formModal" type="button" value="{{ $activity['id'] }}" class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white w-full text-start">Edit</button>
                </li>
            </ul>
            <div class="py-1">
                <button data-modal-target="popup-modal-{{ $activity['id'] }}" data-modal-toggle="popup-modal-{{ $activity['id'] }}" value="{{ $activity['id'] }}" type="button" class="btn-delete block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white w-full text-start">Delete</button> 
            </div>
        </div>
        
      
    </div>

    <p class="text-sm pt-2 leading-4 text-gray-600 dark:text-gray-300">{{ $activity->activity_description }}</p>

    <div class="mt-4">Customer Name</div>
    <p class="text-base font-semibold leading-none text-gray-900 dark:text-white border-b pb-4 border-gray-400 border-dashed">{{ $activity->customer->firstname }} {{ $activity->customer->lastname }}</p>
                    
    <div class="">Priority</div>
    @php
      $priorityClass = 'text-gray-900';
      switch($activity->priority) {
          case 'low':
              $priorityClass = 'text-green-500';
              break;
          case 'medium':
              $priorityClass = 'text-yellow-500';
              break;
          case 'high':
              $priorityClass = 'text-red-500';
              break;
      }
    @endphp
    <p class="text-base font-semibold leading-none {{ $priorityClass }}">{{ ucfirst($activity['priority']) }}</p>
</div>