<!-- Modal toggle -->
<div class="flex justify-center">
    <div id="{{ $entityType }}-ModalButton-{{ $i }}" data-modal-target="{{ $entityType }}-Modal-{{ $i }}" data-modal-toggle="{{ $entityType }}-Modal-{{ $i }}" class="block p-3 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer">
        @if($entityType === 'activity')
            <div class="font-semibold">{{ $data->notes }}</div>
            <span class="text-sm text-gray-500 dark:text-gray-400">{{ $data->activity_description }}</span>
        @elseif($entityType === 'note')
            <div class="font-semibold">{{ $data->customer->firstname }} {{ $data->customer->lastname }}</div>
            <span class="text-sm text-gray-500 dark:text-gray-400">{{ $data->note_content }}</span>
        @elseif($entityType === 'report')
            <div class="font-semibold">{{ $data->report_title }}</div>
            <span class="text-sm text-gray-500 dark:text-gray-400">{{ $data->report_content }}</span>
        @elseif($entityType === 'task')
            <div class="font-semibold">{{ $data->title }}</div>
            <span class="text-sm text-gray-500 dark:text-gray-400">{{ $data->task_description }}</span>
        @endif
    </div>
</div>

<!-- Main modal -->
<div id="{{ $entityType }}-Modal-{{ $i }}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full">
    <div class="relative p-4 w-full max-w-2xl h-full md:h-auto">
        <!-- Modal content -->
        <div class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
            <!-- Modal header -->
            <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    {{ __('messages.details') }}
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="{{ $entityType }}-Modal-{{ $i }}">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    <span class="sr-only">{{ __('messages.close_modal') }}</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="grid gap-4 mb-4 sm:grid-cols-2 text-gray-500 dark:text-gray-400">
                @if($entityType === 'activity')
                    <div>
                        <div class="mt-4">{{ __('messages.activity_type') }}</div>
                        <p class="text-base font-semibold leading-none text-gray-900 dark:text-white">{{ $data->activity_type }}</p>
                    </div>
                    <div>
                        <div class="mt-4">{{ __('messages.activity_description') }}</div>
                        <p class="text-base font-semibold leading-none text-gray-900 dark:text-white">{{ $data->activity_description }}</p>
                    </div>
                    <div>
                        <div class="mt-4">{{ __('messages.location') }}</div>
                        <p class="text-base font-semibold leading-none text-gray-900 dark:text-white">{{ $data->location }}</p>
                    </div>
                    <div>
                        <div class="mt-4">{{ __('messages.status') }}</div>
                        <p class="text-base font-semibold leading-none text-gray-900 dark:text-white">{{ $data->status }}</p>
                    </div>
                    <div>
                        <div class="mt-4">{{ __('messages.notes') }}</div>
                        <p class="text-base font-semibold leading-none text-gray-900 dark:text-white">{{ $data->notes }}</p>
                    </div>
                    <div>
                        <div class="mt-4">{{ __('messages.outcome') }}</div>
                        <p class="text-base font-semibold leading-none text-gray-900 dark:text-white">{{ $data->outcome }}</p>
                    </div>
                    @if($data->customer)
                        <div>
                            <div class="mt-4">{{ __('messages.customer_name') }}</div>
                            <p class="text-base font-semibold leading-none text-gray-900 dark:text-white">{{ $data->customer->firstname }} {{ $data->customer->lastname }}</p>
                        </div>
                    @endif
                    @if($data->deal)
                        <div>
                            <div class="mt-4">{{ __('messages.deal_name') }}</div>
                            <p class="text-base font-semibold leading-none text-gray-900 dark:text-white">{{ $data->deal->deal_name }}</p>
                        </div>
                    @endif
                    @php
                      $date = new \DateTime($data['date']);
                      $formattedDate = $date->format('H:i j F Y');
                    @endphp
                    <div>
                        <div class="mt-4">{{ __('messages.scheduled_for') }}</div>
                        <p class="text-base font-semibold leading-none text-gray-900 dark:text-white">{{ $formattedDate }}</p>
                    </div>
                    @php
                      $priorityClass = 'text-gray-900';
                      switch($data->priority) {
                          case 'low':
                              $priorityClass = 'text-green-500';
                              break;
                          case 'medium':
                              $priorityClass = 'text-yellow-500';
                              break;
                          case 'high':
                              $priorityClass = 'text-red-500';
                              break;
                      }
                    @endphp
                    <div>
                        <div class="mt-4">{{ __('messages.priority') }}</div>
                        <p class="text-base font-semibold leading-none {{ $priorityClass }}">{{ ucfirst($data->priority) }}</p>
                    </div>
                @elseif($entityType === 'note')
                    <div>
                        <div class="mt-4">{{ __('messages.note_content') }}</div>
                        <p class="text-base font-semibold leading-none text-gray-900 dark:text-white">{{ $data->note_content }}</p>
                    </div>
                    <div>
                        <div class="mt-4">{{ __('messages.created_at') }}</div>
                        <p class="text-base font-semibold leading-none text-gray-900 dark:text-white">{{ $data->created_at }}</p>
                    </div>
                    @if($data->customer)
                        <div>
                            <div class="mt-4">{{ __('messages.customer_name') }}</div>
                            <p class="text-base font-semibold leading-none text-gray-900 dark:text-white">{{ $data->customer->firstname }} {{ $data->customer->lastname }}</p>
                        </div>
                    @endif
                    @if($data->deal)
                        <div>
                            <div class="mt-4">{{ __('messages.deal_title') }}</div>
                            <p class="text-base font-semibold leading-none text-gray-900 dark:text-white">{{ $data->deal->deal_name }}</p>
                        </div>
                    @endif
                @elseif($entityType === 'report')
                    <div>
                        <div class="mt-4">{{ __('messages.report_title') }}</div>
                        <p class="text-base font-semibold leading-none text-gray-900 dark:text-white">{{ $data->report_title }}</p>
                    </div>
                    <div>
                        <div class="mt-4">{{ __('messages.report_content') }}</div>
                        <p class="text-base font-semibold leading-none text-gray-900 dark:text-white">{{ $data->report_content }}</p>
                    </div>
                    <div>
                        <div class="mt-4">{{ __('messages.status') }}</div>
                        <p class="text-base font-semibold leading-none text-gray-900 dark:text-white">{{ $data->status }}</p>
                    </div>
                    <div>
                        <div class="mt-4">{{ __('messages.duration') }}</div>
                        <p class="text-base font-semibold leading-none text-gray-900 dark:text-white">{{ $data->duration }}</p>
                    </div>
                @elseif($entityType === 'task')
                    <div>
                        <div class="mt-4">{{ __('messages.task_title') }}</div>
                        <p class="text-base font-semibold leading-none text-gray-900 dark:text-white">{{ $data->title }}</p>
                    </div>
                    <div>
                        <div class="mt-4">{{ __('messages.task_description') }}</div>
                        <p class="text-base font-semibold leading-none text-gray-900 dark:text-white">{{ $data->task_description }}</p>
                    </div>
                    <div>
                        <div class="mt-4">{{ __('messages.due_date') }}</div>
                        <p class="text-base font-semibold leading-none text-gray-900 dark:text-white">{{ $data->due_date }}</p>
                    </div>
                    <div>
                        <div class="mt-4">{{ __('messages.status') }}</div>
                        <p class="text-base font-semibold leading-none text-gray-900 dark:text-white">{{ $data->status }}</p>
                    </div>
                    @if($data->deal)
                        <div>
                            <div class="mt-4">{{ __('messages.deal_title') }}</div>
                            <p class="text-base font-semibold leading-none text-gray-900 dark:text-white">{{ $data->deal->deal_name }}</p>
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>