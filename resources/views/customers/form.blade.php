<!-- Modal content -->
<div class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
    <!-- Modal header -->
    <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
            {{ __('messages.add_customer') }}
        </h3>
        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="formModalCustomer">
            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
            <span class="sr-only">{{ __('messages.close_modal') }}</span>
        </button>
    </div>
    <!-- Modal body -->
    <form id="customer-form" method="POST">
        @csrf
        <!-- Hidden input to determine the redirect route -->
        <input type="hidden" name="redirect_to" value="{{ request()->route()->getName() }}">
        
        <div class="grid gap-4 mb-4 sm:grid-cols-2">
            <div>
                <label for="first-name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('messages.first_name') }}</label>
                <input type="text" name="firstname" id="first-name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="{{ __('messages.first_name') }}" required="">
            </div>
            <div>
                <label for="last-name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('messages.last_name') }}</label>
                <input type="text" name="lastname" id="last-name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="{{ __('messages.last_name') }}" required="">
            </div>
            <div>
                <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('messages.email') }}</label>
                <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="example@gmail.com" required="">
            </div>
            <div>
                <label for="phone" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('messages.phone') }}</label>
                <input type="tel" pattern="\+?[0-9\s\-]{7,15}" name="phone" id="phone" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="+123-456-7890" required="">
            </div>
            <div>
                <label for="country" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('messages.select_country') }}</label>
                <select id="country" name="country" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                    <option value="" selected="">{{ __('messages.select_country') }}</option>
                    <option value="US">United States</option>
                    <option value="DE">Germany</option>
                    <option value="FR">France</option>
                    {{-- TODO: more options --}}
                </select>
            </div>
            <div>
                <label for="city" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('messages.city') }}</label>
                <input type="text" name="city" id="city" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="New York" required="">
            </div>
            <div class="sm:col-span-2">
                <label for="street-address" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('messages.street_address') }}</label>
                <input id="street-address" type="text" name="streetaddress" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="123 Main St" required="">                   
            </div>
            <div>
                <label for="state-province" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('messages.state_province') }}</label>
                <input type="text" name="stateprovince" id="state-province" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="California" required="">
            </div>
            <div>
                <label for="zip" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('messages.zip_postal_code') }}</label>
                <input type="number" name="zip" id="zip" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="12345" required="">
            </div>
        </div>
        <button id="customer-form-btn" type="submit" class="text-white inline-flex items-center bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
            <svg class="mr-1 -ml-1 w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
            {{ __('messages.add_new_customer') }}
        </button>
    </form>
</div>