<div class="grid xl:grid-cols-3 lg:grid-cols-2 sm:grid-cols-1 gap-4">
    
    <div class="min-w-52 w-full bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6 text-gray-500 dark:text-gray-400">
    
        <div class="flex justify-between items-center mb-4">
            <div>
                <p class="text-xl font-semibold leading-none text-gray-500 dark:text-gray-400">{{ __('messages.employee_info') }}</p>
            </div>
        </div>
        <div class="min-w-52 w-full">
            
            <p class="text-2xl font-semibold leading-none text-gray-900 dark:text-white">{{ $activity->user->name }}</p>
            
            <div class="mt-4">{{ __('messages.email_address') }}</div>
            <p class="text-base font-semibold leading-none text-gray-900 dark:text-white">{{ $activity->user->email }}</p>
            
            <div class="mt-4">{{ __('messages.role') }}</div>
            <p class="text-base font-semibold leading-none text-gray-900 dark:text-white">{{ ucfirst($activity->user->role) }}</p>
            
            <div class="mt-4">{{ __('messages.account_created_on') }}</div>
            <p class="text-base font-semibold leading-none text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($activity->user->created_at)->format('F j, Y, g:i A') }}</p>
            
            <div class="mt-4">{{ __('messages.last_updated_on') }}</div>
            <p class="text-base font-semibold leading-none text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($activity->user->updated_at)->format('F j, Y, g:i A') }}</p>
        </div>
        
        

    </div>

    <div class="min-w-52 w-full bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6 text-gray-500 dark:text-gray-400">
    
        <div class="flex justify-between items-center mb-4">
            <div>
                <p class="text-xl font-semibold leading-none text-gray-500 dark:text-gray-400">{{ __('messages.deal_info') }}</p>
            </div>
        </div>
        <div class="min-w-52 w-full">

            <p class="text-2xl font-semibold leading-none text-gray-900 dark:text-white">{{ $activity->deal->deal_name }}</p>
            
            <div class="mt-4">{{ __('messages.deal_value') }}</div>
            <p class="text-base font-semibold leading-none text-gray-900 dark:text-white">
                ${{ number_format($activity->deal->deal_value, 2) }}
            </p>
            
            <div class="mt-4">{{ __('messages.stage') }}</div>
            <p class="text-base font-semibold leading-none text-gray-900 dark:text-white">{{ ucfirst($activity->deal->stage) }}</p>
            
            <div class="mt-4">{{ __('messages.close_date') }}</div>
            <p class="text-base font-semibold leading-none text-gray-900 dark:text-white">
                {{ \Carbon\Carbon::parse($activity->deal->close_date)->format('F j, Y') }}
            </p>
            
            <div class="mt-4">{{ __('messages.account_created_on') }}</div>
            <p class="text-base font-semibold leading-none text-gray-900 dark:text-white">
                {{ \Carbon\Carbon::parse($activity->deal->created_at)->format('F j, Y, g:i A') }}
            </p>
            
            <div class="mt-4">{{ __('messages.last_updated_on') }}</div>
            <p class="text-base font-semibold leading-none text-gray-900 dark:text-white">
                {{ \Carbon\Carbon::parse($activity->deal->updated_at)->format('F j, Y, g:i A') }}
            </p>
        </div>
        

    </div>

    <div class="min-w-52 w-full bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6 text-gray-500 dark:text-gray-400">
    
        <div class="flex justify-between items-center mb-4">
            <div>
                <p class="text-xl font-semibold leading-none text-gray-500 dark:text-gray-400">{{ __('messages.customer_info') }}</p>
            </div>
            <button id="formModalBtn-{{ $activity->customer->id }}" data-modal-target="formModalCustomer" data-modal-toggle="formModalCustomer" type="button" value="{{ $activity->customer->id }}" class="open_edit_form_customer text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-xs px-3 py-1.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">{{ __('messages.edit') }}</button>
            <div id="formModalCustomer" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full">
                <div class="relative p-4 w-full max-w-2xl h-full md:h-auto">
                    <!-- Create content -->
                    @include('customers/form')
                </div>
            </div>
        </div>
        <div class="min-w-52 w-full">

            <p class="text-2xl font-semibold leading-none text-gray-900 dark:text-white">{{ $activity->customer->firstname }} {{ $activity->customer->lastname }}</p>
            
            <div class="mt-4">{{ __('messages.email_address') }}</div>
            <p class="text-base font-semibold leading-none text-gray-900 dark:text-white">{{ $activity->customer->email }}</p>
            
            <div class="mt-4">{{ __('messages.home_address') }}</div>
            <p class="text-base font-semibold leading-none text-gray-900 dark:text-white">
                {{ $activity->customer->streetaddress ?? __('messages.address_not_provided') }},
                {{ $activity->customer->city ?? __('messages.city_not_provided') }},
                {{ $activity->customer->stateprovince ?? __('messages.state_not_provided') }},
                {{ $activity->customer->zip ?? __('messages.zip_not_provided') }},
                {{ $activity->customer->country ?? __('messages.country_not_provided') }}
            </p>
            
            <div class="mt-4">{{ __('messages.phone_number') }}</div>
            <p class="text-base font-semibold leading-none text-gray-900 dark:text-white">{{ $activity->customer->phone ?? __('messages.phone_not_provided') }}</p>
            
            <div class="mt-4">{{ __('messages.account_created_on') }}</div>
            <p class="text-base font-semibold leading-none text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($activity->customer->created_at)->format('F j, Y, g:i A') }}</p>
            
            <div class="mt-4">{{ __('messages.last_updated_on') }}</div>
            <p class="text-base font-semibold leading-none text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($activity->customer->updated_at)->format('F j, Y, g:i A') }}</p>
        </div>
        

    </div>
</div>