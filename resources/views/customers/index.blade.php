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
        @include('customers/partials/table')
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