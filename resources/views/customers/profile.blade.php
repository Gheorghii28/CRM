@extends('layouts.app')

@section('content')
 
    <section class="min-h-screen overflow-hidden">
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

        <div class="gap-4 lg:grid lg:grid-cols-5">
          
            <div class="col-span-2 w-full h-full text-sm text-gray-500 dark:text-gray-400 flex flex-col gap-4">
                <div class="p-3 bg-white border border-gray-200 rounded-lg shadow-sm dark:text-gray-400 dark:bg-gray-800 dark:border-gray-600">
                    <div class="flex items-center justify-between mb-2">
                        <img class="w-10 h-10 rounded-full" src="{{ URL::asset('/images/user.png') }}" alt="user photo">
                        
                        <button id="formModalButton-{{ $customer['id'] }}" data-modal-target="formModalCustomer" data-modal-toggle="formModalCustomer" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-xs px-3 py-1.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Edit</button>
                        <div id="formModalCustomer" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full">
                            <div class="relative p-4 w-full max-w-2xl h-full md:h-auto">
                                <!-- Create content -->
                                @include('customers/form')
                            </div>
                        </div>
                    </div>
                    <p class="text-2xl font-semibold leading-none text-gray-900 dark:text-white">{{ $customer['firstname'] }} {{ $customer['lastname'] }}</p>
                    <div class="mt-4">Email address</div>
                    <p class="text-base font-semibold leading-none text-gray-900 dark:text-white">{{ $customer['email'] }}</p>
                    <div class="mt-4">Home address</div>
                    <p class="text-base font-semibold leading-none text-gray-900 dark:text-white">{{ $customer['streetaddress'] }}, {{ $customer['city'] }} {{ $customer['zip'] }}, {{ $customer['stateprovince'] }}, {{ $customer['country'] }}</p>
                    <div class="mt-4">Phone number</div>
                    <p class="text-base font-semibold leading-none text-gray-900 dark:text-white">{{ $customer['phone'] }}</p>
                    <div class="mt-4">Account Created On</div>
                    <p class="text-base font-semibold leading-none text-gray-900 dark:text-white">{{ $customer['created_at']->format('d F Y') }}</p>
                    <div class="mt-4">Last Updated On</div>
                    <p class="text-base font-semibold leading-none text-gray-900 dark:text-white">{{ $customer['updated_at']->format('d F Y') }}</p>
                </div>
                <div class="p-3 bg-white border border-gray-200 rounded-lg shadow-sm dark:text-gray-400 dark:bg-gray-800 dark:border-gray-600">
                    <div class="flex items-center justify-between mb-2">
                        <h2 class="mb-4 text-2xl tracking-tight font-bold text-gray-900 dark:text-white">Associated Contacts</h2>
                        <div></div>
                    </div>
                    @if($customer->contacts->isEmpty())
                        <p>No contacts found for this customer.</p>
                    @else
                        <ul class="list-group">
                            @foreach($customer->contacts as $contact)
                                <li class="list-group-item">
                                    <a class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white rounded-md" href="{{ url('/contacts/' . $contact['id'] . '/profile') }}">
                                        <strong>Name:</strong> {{ $contact->contact_name }} <br>
                                        <strong>Email:</strong> {{ $contact->contact_email }} <br>
                                        <strong>Phone:</strong> {{ $contact->contact_phone }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
                <div class="p-3 bg-white border border-gray-200 rounded-lg shadow-sm dark:text-gray-400 dark:bg-gray-800 dark:border-gray-600">
                    <div class="flex items-center justify-between mb-2">
                        <h2 class="mb-4 text-2xl tracking-tight font-bold text-gray-900 dark:text-white">Activities Overview</h2>
                        <div></div>
                    </div>
                    @if($customer->activities->isEmpty())
                        <p>No activities found for this customer.</p>
                    @else
                        <ul class="list-group">
                            @foreach($customer->activities as $activity)
                                <li class="list-group-item">
                                    <a class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white rounded-md" href="{{ url('/activities/' . $activity['id'] . '/details') }}">
                                        <strong>Activity:</strong> {{ $activity->activity_type }} <br>
                                        <strong>Description:</strong> {{ $activity->activity_description }} <br>
                                        <strong>Employee Responsible:</strong> {{ $activity->user->name }} <br>
                                        <strong>Date:</strong> {{ $activity->created_at->format('d M Y') }}
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
                        <h2 class="mb-4 text-2xl tracking-tight font-bold text-gray-900 dark:text-white">Financial Overview</h2>

                        <div class="w-full bg-white rounded-lg shadow dark:bg-gray-800">
                            <div class="flex items-center justify-between mb-6">
                                <div><p><strong>Total Value of Deals</strong></p><span class="text-2xl font-semibold leading-none text-gray-900 dark:text-white">${{ number_format($totalDealValue, 2) }}</span></div>
                                <div><p><strong>Outstanding Balance</strong></p><span class="text-2xl font-semibold leading-none text-gray-900 dark:text-white">${{ number_format($outstandingBalance, 2) }}</span></div>
                            </div>
                            <div id="grid-chart"></div>
                        </div>

                    </div>
                </div>

                <div class="p-3 bg-white border border-gray-200 rounded-lg shadow-sm dark:text-gray-400 dark:bg-gray-800 dark:border-gray-600">
                    <div class="flex items-center justify-between mb-2">
                        <h2 class="mb-4 text-2xl tracking-tight font-bold text-gray-900 dark:text-white">Notes</h2>
                        <div></div>
                    </div>
                    @if($customer->notes->isEmpty())
                        <p>No notes found for this customer.</p>
                    @else
                        <ul class="list-group">
                            @foreach($customer->notes as $note)
                                <li class="list-group-item">
                                    <a class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white rounded-md" href="{{ url('/notes/' . $note['id'] . '/details') }}">
                                        <strong>{{ $note->note_content }}</strong><br>
                                        <small>Created by {{ $note->user->name }} on {{ $note->created_at->format('d M Y') }}</small>
                                        @if($note->deal)
                                            <br>
                                            <small>Related to Deal: {{ $note->deal->deal_name }} (Value: ${{ number_format($note->deal->deal_value, 2) }})</small>
                                        @endif
                                    </a>
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

        setupEditForm('#customer-form', '#customer-form-btn', `/customers/${customer.id}`);
        populateFormFields('customerForm', customer);
        setupFinancialChart(deals, payments, invoices, transactions, dates);

        function setupFinancialChart(deals, payments, invoices, transactions, dates) {
            const seriesData = [
                { name: "Total Deal Value", data: deals },
                { name: "Payments", data: payments },
                { name: "Invoices", data: invoices },
                { name: "Transactions", data: transactions },
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