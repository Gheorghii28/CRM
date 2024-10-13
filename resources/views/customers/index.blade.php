@extends('layouts.app')

@section('content')
@include('components/alert-message')
<div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden min-h-screen">

    <div class="px-4">
        @include('partials.search-form', [
            'actionUrl' => '/customers/search',
            'placeholder' => __('messages.search_placeholder'),
            'resetUrl' => '/customers',
            'buttonText' => __('messages.add_customer'),
            'formInclude' => 'customers/form',
            'formModalId' => 'formModalCustomer'
        ])
    </div>

    <div class="overflow-x-auto">
        <table id="customer-table-body" class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-4 py-3">{{ __('messages.customer_name') }}</th>
                    <th scope="col" class="px-4 py-3">{{ __('messages.email') }}</th>
                    <th scope="col" class="px-4 py-3">{{ __('messages.phone') }}</th>
                    <th scope="col" class="px-4 py-3">{{ __('messages.address') }}</th>
                    <th scope="col" class="px-4 py-3">{{ __('messages.start_relationship') }}</th>
                    <th scope="col" class="px-4 py-3">
                        <span class="sr-only">{{ __('messages.actions') }}</span>
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
                <tr class="border-b dark:border-gray-700">
                    <th scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $customer['firstname'] }} {{ $customer['lastname'] }}</th>
                    <td class="px-4 py-3">{{ $customer['email'] }}</td>
                    <td class="px-4 py-3">{{ $customer['phone'] }}</td>
                    <td class="px-4 py-3">{{ $customer['streetaddress'] }}, {{ $customer['city'] }} {{ $customer['zip'] }}, {{ $customer['stateprovince'] }}, {{ $customer['country'] }}</td>
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
        <div id="table-paginator" class="p-4">
            <div>
                {{ $customers->appends(request()->input())->links() }}
            </div>
        </div>        
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        const urlParams = new URLSearchParams(window.location.search);
        const searchTerm = urlParams.get('search');

        function highlightSearchTerm(text, term) {
            if (!term) return text;
            const pattern = new RegExp('('+ term +')', 'gi');
            return text.replace(pattern, '<span class="bg-yellow-300 text-black dark:bg-yellow-500 dark:text-white font-semibold rounded py-1">$1</span>');
        }

        $('td, th').contents().filter(function() {
            return this.nodeType === Node.TEXT_NODE;
        }).each(function() {
            const originalText = $(this).text();
            const highlightedText = highlightSearchTerm(originalText, searchTerm);
            $(this).replaceWith(highlightedText);
        });

        $('.open_more').on('click', function(event) {
            const id = $(this).val();
            const btnText = "{{ __('messages.save') }}";
            setupEditForm('#customer-form', '#customer-form-btn', `/customers/${id}`, btnText);
            loadFormData('/customers', id, 'customerForm');
        });
        handleDelete('.btn-delete', '/customers');

        $('#formModalButton').on('click', function(event) {
            setupAddForm(
                '#customer-form',
                '#customer-form-btn',
                '/customers',
                '<svg class="mr-1 -ml-1 w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>{{ __('messages.add_new_customer') }}'
            );
            populateFormFields('customerForm', {});
        });
    });
</script>
@endsection