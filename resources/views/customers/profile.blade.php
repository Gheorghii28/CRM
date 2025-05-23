@extends('layouts.app')

@section('content')
 
    @include('components/alert-message')
    <section class="min-h-screen overflow-hidden">
        <div class="gap-4 lg:grid lg:grid-cols-5">
          
            <div class="col-span-2 w-full h-full text-sm text-gray-500 dark:text-gray-400 flex flex-col gap-4">
                <div class="p-3 bg-white border border-gray-200 rounded-lg shadow-sm dark:text-gray-400 dark:bg-gray-800 dark:border-gray-600">
                    <div class="flex items-center justify-between mb-2">
                        <img class="w-10 h-10 rounded-full" src="{{ URL::asset('/images/user.png') }}" alt="user photo">
                        
                        <button id="formModalButton-{{ $customer['id'] }}" data-modal-target="formModalCustomer" data-modal-toggle="formModalCustomer" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-xs px-3 py-1.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">{{ __('messages.edit') }}</button>
                        <div id="formModalCustomer" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full">
                            <div class="relative p-4 w-full max-w-2xl h-full md:h-auto">
                                <!-- Create content -->
                                @include('customers/form')
                            </div>
                        </div>
                    </div>
                    <p class="text-2xl font-semibold leading-none text-gray-900 dark:text-white">{{ $customer['firstname'] }} {{ $customer['lastname'] }}</p>
                    <div class="mt-4">{{ __('messages.email_address') }}</div>
                    <p class="text-base font-semibold leading-none text-gray-900 dark:text-white">{{ $customer['email'] }}</p>
                    <div class="mt-4">{{ __('messages.home_address') }}</div>
                    @php
                        $countries = \App\Helpers\CountryHelper::getCountries();
                        $countryName = array_search($customer['country'], $countries) ?: $customer['country']; 
                    @endphp
                    <p class="text-base font-semibold leading-none text-gray-900 dark:text-white">{{ $customer['streetaddress'] }}, {{ $customer['city'] }} {{ $customer['zip'] }}, {{ $customer['stateprovince'] }}, {{ $countryName }}</p>
                    <div class="mt-4">{{ __('messages.phone_number') }}</div>
                    <p class="text-base font-semibold leading-none text-gray-900 dark:text-white">{{ $customer['phone'] }}</p>
                    <div class="mt-4">{{ __('messages.account_created_on') }}</div>
                    <p class="text-base font-semibold leading-none text-gray-900 dark:text-white">{{ $customer['created_at']->format('d F Y') }}</p>
                    <div class="mt-4">{{ __('messages.last_updated_on') }}</div>
                    <p class="text-base font-semibold leading-none text-gray-900 dark:text-white">{{ $customer['updated_at']->format('d F Y') }}</p>
                </div>
                <div class="p-3 bg-white border border-gray-200 rounded-lg shadow-sm dark:text-gray-400 dark:bg-gray-800 dark:border-gray-600">
                    <div class="flex items-center justify-between mb-2">
                        <h2 class="mb-4 text-2xl tracking-tight font-bold text-gray-900 dark:text-white">{{ __('messages.associated_contacts') }}</h2>
                        <div></div>
                    </div>
                    @if($customer->contacts->isEmpty())
                        <p>{{ __('messages.no_contacts_found') }}</p>
                    @else
                        <ul class="list-group">
                            @foreach($customer->contacts as $contact)
                                <li class="list-group-item">
                                    <div class="block py-2 px-4 bg-gray-100 dark:bg-gray-600 dark:text-white rounded-md mb-2">
                                        <strong>{{ __('messages.name') }}:</strong> {{ $contact->contact_name }} <br>
                                        <strong>{{ __('messages.email') }}:</strong> {{ $contact->contact_email }} <br>
                                        <strong>{{ __('messages.phone') }}:</strong> {{ $contact->contact_phone }}
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
                <div class="p-3 bg-white border border-gray-200 rounded-lg shadow-sm dark:text-gray-400 dark:bg-gray-800 dark:border-gray-600">
                    <div class="flex items-center justify-between mb-2">
                        <h2 class="mb-4 text-2xl tracking-tight font-bold text-gray-900 dark:text-white">{{ __('messages.activities_overview') }}</h2>
                        <div></div>
                    </div>
                    @if($customer->activities->isEmpty())
                        <p>{{ __('messages.no_activities_found') }}</p>
                    @else
                        <ul class="list-group">
                            @foreach($customer->activities as $activity)
                                <li class="list-group-item">
                                    <a class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white rounded-md" href="{{ url('/activities/' . $activity['id'] . '/show-details') }}">
                                        <strong>{{ __('messages.activity') }}:</strong> {{ $activity->activity_type }} <br>
                                        <strong>{{ __('messages.description') }}:</strong> {{ $activity->activity_description }} <br>
                                        <strong>{{ __('messages.employee_responsible') }}:</strong> {{ $activity->user->name }} <br>
                                        <strong>{{ __('messages.date') }}:</strong> {{ $activity->created_at->format('d M Y') }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>

            <div class="col-span-3 w-full h-full text-sm text-gray-500 dark:text-gray-400 flex flex-col gap-4">
                
                <div class="p-3 bg-white border border-gray-200 rounded-lg shadow-sm dark:text-gray-400 dark:bg-gray-800 dark:border-gray-600">

                    <div class="font-light text-gray-500 sm:text-lg dark:text-gray-400">
                        <h2 class="mb-4 text-2xl tracking-tight font-bold text-gray-900 dark:text-white">{{ __('messages.financial_overview') }}</h2>

                        <div class="w-full bg-white rounded-lg shadow dark:bg-gray-800">
                            <div class="flex items-center justify-between mb-6">
                                <div><p><strong>{{ __('messages.total_value_of_deals') }}</strong></p><span class="text-2xl font-semibold leading-none text-gray-900 dark:text-white">${{ number_format($totalDealValue, 2) }}</span></div>
                                <div><p><strong>{{ __('messages.outstanding_balance') }}</strong></p><span class="text-2xl font-semibold leading-none text-gray-900 dark:text-white">${{ number_format($outstandingBalance, 2) }}</span></div>
                            </div>
                            <div id="grid-chart"></div>
                        </div>

                    </div>
                </div>

                <div class="p-3 bg-white border border-gray-200 rounded-lg shadow-sm dark:text-gray-400 dark:bg-gray-800 dark:border-gray-600">
                    <div class="flex items-center justify-between mb-2">
                        <h2 class="mb-4 text-2xl tracking-tight font-bold text-gray-900 dark:text-white">{{ __('messages.notes') }}</h2>
                        <div></div>
                    </div>
                    @if($customer->notes->isEmpty())
                        <p>{{ __('messages.no_notes_found') }}</p>
                    @else
                        <ul class="list-group">
                            @foreach($customer->notes as $note)
                                <li class="list-group-item">
                                    <div class="block py-2 px-4 bg-gray-100 dark:bg-gray-600 dark:text-white rounded-md mb-2">
                                        <strong>{{ $note->note_content }}</strong><br>
                                        <small>{{ __('messages.created_by') }} {{ $note->user->name }} {{ __('messages.on') }} {{ $note->created_at->format('d M Y') }}</small>
                                        @if($note->deal)
                                            <br>
                                            <small>{{ __('messages.related_to_deal') }}: {{ $note->deal->deal_name }} ({{ __('messages.value') }}: ${{ number_format($note->deal->deal_value, 2) }})</small>
                                        @endif
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>

            </div>

        </div>
    </section>
   
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        const customer = @json($customer);
        const deals = @json(array_values($formattedDeals->toArray()));
        const payments = @json(array_values($formattedPayments->toArray()));
        const invoices = @json(array_values($formattedInvoices->toArray()));
        const transactions = @json(array_values($formattedTransactions->toArray()));
        const dates = @json($dates);
        const btnText = "{{ __('messages.save') }}";

        setupEditForm('#customer-form', '#customer-form-btn', `/customers/${customer.id}`, btnText);
        populateFormFields('customerForm', customer);
        setupFinancialChart(deals, payments, invoices, transactions, dates);

        function setupFinancialChart(deals, payments, invoices, transactions, dates) {
            const seriesData = [
                { name: "{{ __('messages.total_deal_value') }}", data: deals },
                { name: "{{ __('messages.payments') }}", data: payments },
                { name: "{{ __('messages.invoices') }}", data: invoices },
                { name: "{{ __('messages.transactions') }}", data: transactions },
            ];
            const chartConfig = {
                height: "100%",
                colors: ["#1A56DB", "#7E3BF2", "#10B981", "#F97316"],
                yAxisFormatter: (value) => value ? `$${value}` : '$0',
                legend: {
                    show: true,
                    position: 'top',
                    horizontalAlign: 'right',
                }
            };
            const options = getAreaChartOptions(seriesData, dates, chartConfig);

            if ($("#grid-chart").length && typeof ApexCharts !== 'undefined') {
                const chart = new ApexCharts(document.getElementById("grid-chart"), options);
                chart.render();
            }
        }
    });
</script>
@endsection