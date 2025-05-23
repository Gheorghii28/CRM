<!-- Modal content -->
<div class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
    <!-- Modal header -->
    <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
            {{ __('messages.add_activity') }}
        </h3>
        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="formModalActivity">
            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
            <span class="sr-only">Close modal</span>
        </button>
    </div>
    <!-- Modal body -->
    <form id="activity-form" method="POST">
        @csrf
        <!-- Hidden input to determine the redirect route -->
        <input type="hidden" name="redirect_to" value="{{ request()->route()->getName() }}">
        <div class="grid gap-4 mb-4 sm:grid-cols-2">
            <div>
                <label for="user_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('messages.assigned_employee') }}</label>
                <select id="user_id" name="user_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                    <option value="" selected="">{{ __('messages.select_employee') }}</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="customer_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('messages.customer') }}</label>
                <select id="customer_id" name="customer_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                    <option value="" selected="">{{ __('messages.select_customer') }}</option>
                    @foreach($customers as $customer)
                        <option value="{{ $customer->id }}">{{ $customer->firstname }} {{ $customer->lastname }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="activity_type" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('messages.activity_type') }}</label>
                <select id="activity_type" name="activity_type" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                    <option value="Call" selected="">{{ __('messages.call') }}</option>
                    <option value="Email">{{ __('messages.email') }}</option>
                    <option value="Meeting">{{ __('messages.meeting') }}</option>
                    <option value="Presentation">{{ __('messages.presentation') }}</option>
                </select>
            </div>
            <div>
                <label for="activity_description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('messages.description') }}</label>
                <textarea id="activity_description" name="activity_description" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="{{ __('messages.activity_description_placeholder') }}" required=""></textarea>
            </div>
            <div>
                <label for="date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('messages.date') }}</label>
                <input type="datetime-local" name="date" id="date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required="">
            </div>
            <div>
                <label for="status" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('messages.status') }}</label>
                <select id="status" name="status" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                    <option value="pending" selected>{{ __('messages.pending') }}</option>
                    <option value="completed">{{ __('messages.completed') }}</option>
                    <option value="scheduled">{{ __('messages.scheduled') }}</option>
                </select>
            </div>
            <div>
                <label for="priority" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('messages.priority') }}</label>
                <select id="priority" name="priority" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                    <option value="low" selected>{{ __('messages.low') }}</option>
                    <option value="medium">{{ __('messages.medium') }}</option>
                    <option value="high">{{ __('messages.high') }}</option>
                </select>
            </div>
            <div>
                <label for="deal_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('messages.deal') }}</label>
                <select id="deal_id" name="deal_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                    <option value="" selected="">{{ __('messages.no_deal') }}</option>
                    @foreach($deals as $deal)
                        <option value="{{ $deal->id }}">{{ $deal->deal_name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="location" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('messages.location') }}</label>
                <input type="text" name="location" id="location" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Location" required="">
            </div>
            <div>
                <label for="outcome" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('messages.outcome') }}</label>
                <input type="text" name="outcome" id="outcome" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="{{ __('messages.outcome_placeholder') }}" required="">
            </div>
            <div class="sm:col-span-2">
                <label for="notes" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('messages.notes') }}</label>
                <textarea id="notes" name="notes" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="{{ __('messages.additional_notes') }}" required=""></textarea>
            </div>
        </div>
        <button id="activity-form-btn" type="submit" class="text-white inline-flex items-center bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
            <svg class="mr-1 -ml-1 w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
            {{ __('messages.add_new_activity') }}
        </button>
    </form>
</div>
