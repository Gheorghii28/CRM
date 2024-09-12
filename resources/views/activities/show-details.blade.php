@extends('layouts.app')

@section('content')

<div class="min-w-52 w-full bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6 mb-4">
    
    <div class="flex justify-between">
      <div>
      </div>
        <button id="formModalButton-{{ $activity['id'] }}" data-modal-target="formModalActivity" data-modal-toggle="formModalActivity" type="button" value="{{ $activity['id'] }}" class="open_edit_form_activity text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-xs px-3 py-1.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Edit</button>
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
            <p class="text-2xl font-semibold leading-none text-gray-900 dark:text-white">Activity Details</p>
        
            <div class="mt-4">Activity Description</div>
            <p class="text-base font-semibold leading-none text-gray-900 dark:text-white">{{ $activity->activity_description }}</p>

            <div class="mt-4">Activity Notes</div>
            <p class="text-base font-semibold leading-none text-gray-900 dark:text-white">{{ $activity->notes }}</p>
        
            <div class="mt-4">Activity Type</div>
            <p class="text-base font-semibold leading-none text-gray-900 dark:text-white">{{ ucfirst($activity->activity_type) }}</p>
        
            <div class="mt-4">Location</div>
            <p class="text-base font-semibold leading-none text-gray-900 dark:text-white">{{ $activity->location }}</p>
            
            <div class="mt-4">Outcome</div>
            <p class="text-base font-semibold leading-none text-gray-900 dark:text-white">{{ $activity->outcome }}</p>
            
            <div class="mt-4">Date and Time</div>
            <p class="text-base font-semibold leading-none text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($activity->date)->format('F j, Y, g:i A') }}</p>
        </div>
        
        <!-- Second Column: Additional Information -->
        <div class="min-w-52 w-full">
            <p class="text-2xl font-semibold leading-none text-gray-900 dark:text-white">Additional Information</p>
            
            <div class="mt-4">Customer Name</div>
            <p class="text-base font-semibold leading-none text-gray-900 dark:text-white">{{ $activity->customer->firstname }} {{ $activity->customer->lastname }}</p>
            
            <div class="mt-4">Assigned Employee</div>
            <p class="text-base font-semibold leading-none text-gray-900 dark:text-white">{{ $activity->user->name }}</p>
            
            <div class="mt-4">Deal Name</div>
            <p class="text-base font-semibold leading-none text-gray-900 dark:text-white">{{ $activity->deal->deal_name }}</p>
            
            <div class="mt-4">Created On</div>
            <p class="text-base font-semibold leading-none text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($activity->created_at)->format('F j, Y, g:i A') }}</p>

            <div class="mt-4">Status</div>
            <p class="text-base font-semibold leading-none text-gray-900 dark:text-white">{{ ucfirst($activity->status) }}</p>

            <div class="mt-4">Priority</div>
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
            <p class="text-base font-semibold leading-none {{ $priorityClass  }}">{{ ucfirst($activity->priority) }}</p>
        </div>
    </div> 

</div>

<div class="grid xl:grid-cols-3 lg:grid-cols-2 sm:grid-cols-1 gap-4">
    
    <div class="min-w-52 w-full bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6 text-gray-500 dark:text-gray-400">
    
        <div class="flex justify-between items-center mb-4">
            <div>
                <p class="text-xl font-semibold leading-none text-gray-500 dark:text-gray-400">Employee Info</p>
            </div>
        </div>
        <div class="min-w-52 w-full">
            
            <p class="text-2xl font-semibold leading-none text-gray-900 dark:text-white">{{ $activity->user->name }}</p>
            
            <div class="mt-4">Email address</div>
            <p class="text-base font-semibold leading-none text-gray-900 dark:text-white">{{ $activity->user->email }}</p>
            
            <div class="mt-4">Role</div>
            <p class="text-base font-semibold leading-none text-gray-900 dark:text-white">{{ ucfirst($activity->user->role) }}</p>
            
            <div class="mt-4">Account Created On</div>
            <p class="text-base font-semibold leading-none text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($activity->user->created_at)->format('F j, Y, g:i A') }}</p>
            
            <div class="mt-4">Last Updated On</div>
            <p class="text-base font-semibold leading-none text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($activity->user->updated_at)->format('F j, Y, g:i A') }}</p>
        </div>
        
        

    </div>

    <div class="min-w-52 w-full bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6 text-gray-500 dark:text-gray-400">
    
        <div class="flex justify-between items-center mb-4">
            <div>
                <p class="text-xl font-semibold leading-none text-gray-500 dark:text-gray-400">Deal Info</p>
            </div>
        </div>
        <div class="min-w-52 w-full">

            <p class="text-2xl font-semibold leading-none text-gray-900 dark:text-white">{{ $activity->deal->deal_name }}</p>
            
            <div class="mt-4">Deal Value</div>
            <p class="text-base font-semibold leading-none text-gray-900 dark:text-white">
                ${{ number_format($activity->deal->deal_value, 2) }}
            </p>
            
            <div class="mt-4">Stage</div>
            <p class="text-base font-semibold leading-none text-gray-900 dark:text-white">{{ ucfirst($activity->deal->stage) }}</p>
            
            <div class="mt-4">Close Date</div>
            <p class="text-base font-semibold leading-none text-gray-900 dark:text-white">
                {{ \Carbon\Carbon::parse($activity->deal->close_date)->format('F j, Y') }}
            </p>
            
            <div class="mt-4">Deal Created On</div>
            <p class="text-base font-semibold leading-none text-gray-900 dark:text-white">
                {{ \Carbon\Carbon::parse($activity->deal->created_at)->format('F j, Y, g:i A') }}
            </p>
            
            <div class="mt-4">Last Updated On</div>
            <p class="text-base font-semibold leading-none text-gray-900 dark:text-white">
                {{ \Carbon\Carbon::parse($activity->deal->updated_at)->format('F j, Y, g:i A') }}
            </p>
        </div>
        

    </div>

    <div class="min-w-52 w-full bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6 text-gray-500 dark:text-gray-400">
    
        <div class="flex justify-between items-center mb-4">
            <div>
                <p class="text-xl font-semibold leading-none text-gray-500 dark:text-gray-400">Customer Info</p>
            </div>
            <button id="formModalBtn-{{ $activity->customer->id }}" data-modal-target="formModalCustomer" data-modal-toggle="formModalCustomer" type="button" value="{{ $activity->customer->id }}" class="open_edit_form_customer text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-xs px-3 py-1.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Edit</button>
            <div id="formModalCustomer" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full">
                <div class="relative p-4 w-full max-w-2xl h-full md:h-auto">
                    <!-- Create content -->
                    @include('customers/form')
                </div>
            </div>
        </div>
        <div class="min-w-52 w-full">

            <p class="text-2xl font-semibold leading-none text-gray-900 dark:text-white">{{ $activity->customer->firstname }} {{ $activity->customer->lastname }}</p>
            
            <div class="mt-4">Email address</div>
            <p class="text-base font-semibold leading-none text-gray-900 dark:text-white">{{ $activity->customer->email }}</p>
            
            <div class="mt-4">Home address</div>
            <p class="text-base font-semibold leading-none text-gray-900 dark:text-white">
                {{ $activity->customer->streetaddress ?? 'Address not provided' }},
                {{ $activity->customer->city ?? 'City not provided' }},
                {{ $activity->customer->stateprovince ?? 'State not provided' }},
                {{ $activity->customer->zip ?? 'ZIP not provided' }},
                {{ $activity->customer->country ?? 'Country not provided' }}
            </p>
            
            <div class="mt-4">Phone number</div>
            <p class="text-base font-semibold leading-none text-gray-900 dark:text-white">{{ $activity->customer->phone ?? 'Phone not provided' }}</p>
            
            <div class="mt-4">Account Created On</div>
            <p class="text-base font-semibold leading-none text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($activity->customer->created_at)->format('F j, Y, g:i A') }}</p>
            
            <div class="mt-4">Last Updated On</div>
            <p class="text-base font-semibold leading-none text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($activity->customer->updated_at)->format('F j, Y, g:i A') }}</p>
        </div>
        

    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        const activityId = @json($activity).id;

        $('.open_edit_form_activity').on('click', function(event) {
            const id = $(this).val();
            setupAndLoadFormData('#activity-form', '#activity-form-btn', '/activities', id, 'activityForm');
        });

        $('.open_edit_form_customer').on('click', function(event) {
            const id = $(this).val();
            setupAndLoadFormData('#customer-form', '#customer-form-btn', '/customers', id, 'customerForm', activityId);
        });
    });
</script>
@endsection