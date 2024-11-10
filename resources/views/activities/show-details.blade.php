@extends('layouts.app')

@section('content')

    @include('components/alert-message')
    @include('activities/partials/activity-info')
    @include('activities/partials/related-entities')

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        const activityId = @json($activity).id;

        $('.open_edit_form_activity').on('click', function(event) {
            const id = $(this).val();
            const btnText = "{{ __('messages.save') }}";
            setupEditForm('#activity-form', '#activity-form-btn', `/activities/${id}`, btnText);
            loadFormData('/activities', id, 'activityForm');
        });

        $('.open_edit_form_customer').on('click', function(event) {
            const id = $(this).val();
            const btnText = "{{ __('messages.save') }}";
            setupEditForm('#customer-form', '#customer-form-btn', `/customers/${id}/${activityId}`, btnText);
            loadFormData('/customers', id, 'customerForm');
        });
    });
</script>
@endsection