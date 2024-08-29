@extends('layouts.app')

@section('content')
<div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden min-h-screen">

    @if(session('success'))
        <div class="alert alert-success">
            <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md" role="alert">
                <div class="flex">
                  <div class="py-1"><svg class="fill-current h-6 w-6 text-teal-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/></svg></div>
                  <div>
                    <p class="font-bold">{{ session('success') }}</p>
                  </div>
                </div>
            </div> 
        </div>
    @endif
    @if ($errors->has('error'))
        <div class="alert alert-danger">
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">{{ $errors->first('error') }}</strong>
            </div>
        </div>
    @endif


    <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
        <div class="w-full md:w-1/2">
            <form action="/customers/search" method="GET" class="flex items-center gap-2" id="search-form" role="search">
                <label for="simple-search" class="sr-only">Search</label>
                <div class="relative w-full">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <input value="{{ request()->input('search') }}" name="search" type="text" id="simple-search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Search by Name, Email, Phone, or Address..." required="">
                </div>
                <button type="submit" class="whitespace-nowrap flex items-center justify-center text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800">
                    Search
                </button>
            </form>
        </div>
        <div class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0">
            <a href="/customers" class="whitespace-nowrap flex items-center justify-center text-white bg-gray-500 hover:bg-gray-600 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-gray-700 dark:hover:bg-gray-800 focus:outline-none dark:focus:ring-gray-800">
                Reset Search
            </a>
            <button id="formModalButton" data-modal-target="formModal" data-modal-toggle="formModal" type="button" class="flex items-center justify-center text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800">
                <svg class="h-3.5 w-3.5 mr-2" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path clip-rule="evenodd" fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                </svg>
                Add customer
            </button>
            <!-- Create modal -->
            <div id="formModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full">
                <div class="relative p-4 w-full max-w-2xl h-full md:h-auto">
                    <!-- Create content -->
                    @include('customers/form')
                </div>
            </div>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table id="customer-table-body" class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-4 py-3">Customer Name</th>
                    <th scope="col" class="px-4 py-3">Email</th>
                    <th scope="col" class="px-4 py-3">Phone</th>
                    <th scope="col" class="px-4 py-3">Address</th>
                    <th scope="col" class="px-4 py-3">Start of Relationship</th>
                    <th scope="col" class="px-4 py-3">
                        <span class="sr-only">Actions</span>
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($customers as $customer)
                @include('customers.delete', ['customer->' => $customer])
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
                                    <a href="{{ url('/customers/' . $customer['id'] . '/profile') }}" class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Show</a>
                                </li>
                                <li>
                                    <button id="formModalButton-{{ $customer['id'] }}" data-modal-target="formModal" data-modal-toggle="formModal" type="button" class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white w-full text-start">Edit</button>
                                </li>
                            </ul>
                            <div class="py-1">
                                <button data-modal-target="popup-modal-{{ $customer['id'] }}" data-modal-toggle="popup-modal-{{ $customer['id'] }}" value="{{ $customer['id'] }}" type="button" class="btn-delete block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white w-full text-start">Delete</button> 
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
 
        function highlightSearchTerm(text, term) {
            if (!term) return text;
            var pattern = new RegExp('('+ term +')', 'gi');
            return text.replace(pattern, '<span class="bg-yellow-300 text-black dark:bg-yellow-500 dark:text-white font-semibold rounded py-1">$1</span>');
        }

        const urlParams = new URLSearchParams(window.location.search);
        const searchTerm = urlParams.get('search');

        $('td, th').each(function() {
            let text = $(this).html();
            $(this).html(highlightSearchTerm(text, searchTerm));
        });

        $('.open_more').on('click', function(event) {
            const customerId = $(this).val();
            $.ajax({
                url: `/customers/${customerId}/get`,
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    const form = $('#customer-form');
                    const formBtn = $('#customer-form-btn');

                    form.attr('action', `/customers/${response.id}`);
                    form.attr('method', 'POST');
                    if ($('#customer-form input[name="_method"]').length === 0) {
                        form.append('<input type="hidden" name="_method" value="PUT">');
                    }
                    formBtn.text('Save');

                    resetFormFields(response);
                },
                error: function(error) {
                    console.error("Error open more CRUD options:", error);
                }
            }); 
        });

        $('.btn-delete').on('click', function(event) {
            const customerId = $(this).val();
            $.ajax({
                url: `/customers/${customerId}/get`,
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    const form = $('#customer-form-delete');

                    form.attr('action', `/customers/${response.id}`);
                    form.attr('method', 'POST');

                    if (form.find('input[name="_token"]').length === 0) {
                        const csrfToken = $('meta[name="csrf-token"]').attr('content');
                        form.append(`<input type="hidden" name="_token" value="${csrfToken}">`);
                    }

                    if ($('#customer-form-delete input[name="_method"]').length === 0) {
                        form.append('<input type="hidden" name="_method" value="DELETE">');
                    }
                },
                error: function(error) {
                    console.error("Error deleted:", error);
                }
            }); 
        });

        $('#formModalButton').on('click', function(event) {
            const form = $('#customer-form');
            const formBtn = $('#customer-form-btn');

            form.attr('action', '/customers');
            form.attr('method', 'POST');
            formBtn.html('<svg class="mr-1 -ml-1 w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>Add new customer');
            
            $('#customer-form input[name="_method"]').remove();

            resetFormFields({});
        });

        function resetFormFields(fieldValues) {
            const fields = {
                '#first-name': fieldValues.firstname || '',
                '#last-name': fieldValues.lastname || '',
                '#email': fieldValues.email || '',
                '#phone': fieldValues.phone || '',
                '#country': fieldValues.country || '',
                '#city': fieldValues.city || '',
                '#street-address': fieldValues.streetaddress || '',
                '#state-province': fieldValues.stateprovince || '',
                '#zip': fieldValues.zip || ''
            };

            for (const [selector, value] of Object.entries(fields)) {
                $(selector).val(value);
            }
        }
    });
</script>
@endsection