<!-- This style file is only included for PDF generation -->
@if (isset($pdfCSS))
    <style>
        {!! $pdfCSS !!}
    </style>
@endif

<div class="min-w-52 w-full bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6 mb-4">
    
    <div class="flex justify-between">
        <div>
        </div>
        <button id="dropdown-button-{{ $activity['id'] }}" data-dropdown-toggle="dropdown-{{ $activity['id'] }}" value="{{ $activity['id'] }}" class="open_more inline-flex items-center p-0.5 text-sm font-medium text-center text-gray-500 hover:text-gray-800 rounded-lg focus:outline-none dark:text-gray-400 dark:hover:text-gray-100" type="button">
            <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
            </svg>
        </button>
        <div id="dropdown-{{ $activity['id'] }}" class="hidden z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600">
            <ul class="py-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdown-button-{{ $activity['id'] }}">
                <li>
                    <a href="{{ url('/activities/' . $activity['id'] . '/view-pdf') }}" target="_blank" class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">{{ __('messages.view_pdf') }}</a>
                </li>
                <li>
                    <a href="{{ url('/activities/' . $activity['id'] . '/download-pdf') }}" class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">{{ __('messages.download_pdf') }}</a>
                </li>
            </ul>
            <div class="py-1">
                <button id="formModalButton-{{ $activity['id'] }}" data-modal-target="formModalActivity" data-modal-toggle="formModalActivity" type="button" value="{{ $activity['id'] }}" class="open_edit_form_activity block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white w-full text-start">{{ __('messages.edit') }}</button>
            </div>
        </div>
        <div id="formModalActivity" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full">
            <div class="relative p-4 w-full max-w-2xl h-full md:h-auto">
                <!-- Create content -->
                @include('activities/form')
            </div>
        </div>
    </div>

    <div class="grid lg:grid-cols-2 sm:grid-cols-1 gap-4 text-gray-500 dark:text-gray-400">
        <!-- First Column: Activity Details -->
        <div class="min-w-52 w-full">
            <p class="text-2xl font-semibold leading-none text-gray-900 dark:text-white">{{ __('messages.activity_details') }}</p>
        
            <div class="mt-4">{{ __('messages.activity_description') }}</div>
            <p class="text-base font-semibold leading-none text-gray-900 dark:text-white">{{ $activity->activity_description }}</p>

            <div class="mt-4">{{ __('messages.activity_notes') }}</div>
            <p class="text-base font-semibold leading-none text-gray-900 dark:text-white">{{ $activity->notes }}</p>
        
            <div class="mt-4">{{ __('messages.activity_type') }}</div>
            <p class="text-base font-semibold leading-none text-gray-900 dark:text-white">{{ ucfirst($activity->activity_type) }}</p>
        
            <div class="mt-4">{{ __('messages.location') }}</div>
            <p class="text-base font-semibold leading-none text-gray-900 dark:text-white">{{ $activity->location }}</p>
            
            <div class="mt-4">{{ __('messages.outcome') }}</div>
            <p class="text-base font-semibold leading-none text-gray-900 dark:text-white">{{ $activity->outcome }}</p>
            
            <div class="mt-4">{{ __('messages.date_and_time') }}</div>
            <p class="text-base font-semibold leading-none text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($activity->date)->format('F j, Y, g:i A') }}</p>
        </div>
        
        <!-- Second Column: Additional Information -->
        <div class="min-w-52 w-full">
            <p class="text-2xl font-semibold leading-none text-gray-900 dark:text-white">{{ __('messages.additional_information') }}</p>
            
            <div class="mt-4">{{ __('messages.customer_name') }}</div>
            <p class="text-base font-semibold leading-none text-gray-900 dark:text-white">{{ $activity->customer->firstname }} {{ $activity->customer->lastname }}</p>
            
            <div class="mt-4">{{ __('messages.assigned_employee') }}</div>
            <p class="text-base font-semibold leading-none text-gray-900 dark:text-white">{{ $activity->user->name }}</p>
            
            <div class="mt-4">{{ __('messages.deal') }}</div>
            <p class="text-base font-semibold leading-none text-gray-900 dark:text-white">{{ $activity->deal->deal_name }}</p>
            
            <div class="mt-4">{{ __('messages.created_on') }}</div>
            <p class="text-base font-semibold leading-none text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($activity->created_at)->format('F j, Y, g:i A') }}</p>

            <div class="mt-4">{{ __('messages.status') }}</div>
            <p class="text-base font-semibold leading-none text-gray-900 dark:text-white">{{ __('messages.' . $activity['status']) }}</p>

            <div class="mt-4">{{ __('messages.priority') }}</div>
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
            <p class="text-base font-semibold leading-none {{ $priorityClass  }}">{{ __('messages.' . $activity['priority'] . '_priority') }}</p>
        </div>
    </div> 

</div>