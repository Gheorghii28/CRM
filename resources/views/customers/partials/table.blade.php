<!-- This style file is only included for PDF generation -->
@if (isset($pdfCSS))
    <style>
        {!! $pdfCSS !!}
    </style>
@endif

<table id="customer-table-body" class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
        <tr>
            <th scope="col" class="px-4 py-3">{{ __('messages.customer_name') }}</th>
            <th scope="col" class="px-4 py-3">{{ __('messages.email') }}</th>
            <th scope="col" class="px-4 py-3">{{ __('messages.phone') }}</th>
            <th scope="col" class="px-4 py-3">{{ __('messages.address') }}</th>
            <th scope="col" class="px-4 py-3">{{ __('messages.start_relationship') }}</th>
            <th scope="col" class="px-4 py-3">
                <button id="dropdown-button-customer" data-dropdown-toggle="dropdown-customer" value="" class="open_more inline-flex items-center p-0.5 text-sm font-medium text-center text-gray-500 hover:text-gray-800 rounded-lg focus:outline-none dark:text-gray-400 dark:hover:text-gray-100" type="button">
                    <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                    </svg>
                </button>
                <div id="dropdown-customer" class="hidden z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600">
                    <ul class="py-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdown-button-customer">
                        <li>
                            <a href="{{ url('/customers/view-pdf?page=' . request()->get('page', 1)) }}" target="_blank" class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">{{ __('messages.view_pdf') }}</a>
                        </li>
                        <li>
                            <a href="{{ url('/customers/download-pdf?page=' . request()->get('page', 1)) }}" class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">{{ __('messages.download_pdf') }}</a>
                        </li>
                    </ul>
                </div>
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach ($customers as $customer)
        @include('partials.delete-modal', [
            'entity' => $customer,
            'entityType' => 'customer',
            'entityName' => $customer['firstname'] . ' ' . $customer['lastname']
        ])
        @php
            $countries = \App\Helpers\CountryHelper::getCountries();
            $countryName = array_search($customer['country'], $countries) ?: $customer['country']; 
        @endphp
        <tr class="border-b dark:border-gray-700">
            <th scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $customer['firstname'] }} {{ $customer['lastname'] }}</th>
            <td class="px-4 py-3">{{ $customer['email'] }}</td>
            <td class="px-4 py-3">{{ $customer['phone'] }}</td>
            <td class="px-4 py-3">{{ $customer['streetaddress'] }}, {{ $customer['city'] }} {{ $customer['zip'] }}, {{ $customer['stateprovince'] }}, {{ $countryName }}</td>
            <td class="px-4 py-3">{{ $customer['created_at']->format('d F Y') }}</td>
            <td class="px-4 py-3 flex items-center justify-end">
                <button id="dropdown-button-{{ $customer['id'] }}" data-dropdown-toggle="dropdown-{{ $customer['id'] }}" value="{{ $customer['id'] }}" class="open_more inline-flex items-center p-0.5 text-sm font-medium text-center text-gray-500 hover:text-gray-800 rounded-lg focus:outline-none dark:text-gray-400 dark:hover:text-gray-100" type="button">
                    <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                    </svg>
                </button>
                <div id="dropdown-{{ $customer['id'] }}" class="hidden z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600">
                    <ul class="py-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdown-button-{{ $customer['id'] }}">
                        <li>
                            <a href="{{ url('/customers/' . $customer['id'] . '/profile') }}" class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">{{ __('messages.show') }}</a>
                        </li>
                        <li>
                            <button id="formModalButton-{{ $customer['id'] }}" data-modal-target="formModalCustomer" data-modal-toggle="formModalCustomer" type="button" class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white w-full text-start">{{ __('messages.edit') }}</button>
                        </li>
                    </ul>
                    <div class="py-1">
                        <button data-modal-target="popup-modal-{{ $customer['id'] }}" data-modal-toggle="popup-modal-{{ $customer['id'] }}" value="{{ $customer['id'] }}" type="button" class="btn-delete block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white w-full text-start">{{ __('messages.delete') }}</button> 
                    </div>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>