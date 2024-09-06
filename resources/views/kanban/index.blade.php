@extends('layouts.app')

@section('content')

    <div class="container">
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
        <!-- Create modal -->
        <div id="formModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full">
            <div class="relative p-4 w-full max-w-2xl h-full md:h-auto">
                <!-- Create content -->
                @include('kanban.form')
            </div>
        </div>
        <div class="space-y-8 md:grid md:grid-cols-2 lg:grid-cols-3 md:gap-4 md:space-y-0">
            @foreach(['to-do' => 'To Do', 'in-progress' => 'In Progress', 'done' => 'Done'] as $status => $title)
                <div class="">
                    <div class="flex items-center justify-between">
                        <h4 class="mb-2 text-2xl font-semibold tracking-tight text-gray-900 dark:text-white">{{ $title }}</h4>
                        <button id="formModalButton-{{ $status }}" data-modal-target="formModal" data-modal-toggle="formModal" type="button" class="flex items-center justify-center p-2 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 font-bold text-gray-400 dark:text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:border-gray-800">
                            <svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                               <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16"/>
                            </svg>
                        </button>
                    </div>
                    <ul id="list-{{ $status }}" class="list-group min-h-20 rounded-lg">
                        @foreach($tasks->where('status', $status) as $task)
                            @include('kanban.task', ['task' => $task])
                            @include('partials.delete-modal', [
                                'entity' => $task,
                                'entityType' => 'task',
                                'entityName' => $task['title'],
                            ])
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>
    </div>

@endsection

@section('scripts')
<script src="https://raw.githack.com/SortableJS/Sortable/master/Sortable.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-sortablejs@latest/jquery-sortable.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script>
    $(document).ready(function() {
        @foreach(['to-do', 'in-progress', 'done'] as $status)
            $('#list-{{ $status }}').sortable({
                group: 'shared',
                animation: 150,
                ghostClass: 'bg-gray-500',
                onEnd: function (evt) {
                    const itemEl = $(evt.item);
                    const newStatus = evt.to.id.replace('list-', '');
                    const order = [].slice.call(evt.to.children).map(function (item) {
                        return item.dataset.id;
                    }).filter(id => id !== undefined && id !== "");;

                    $.ajax({
                        url: 'kanban/update-kanban',
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        data: {
                            id: itemEl.data('id'),
                            status: newStatus,
                            order: order
                        },
                        success: function(response) {
                            if (newStatus === 'done') {
                                itemEl.find('.text-violet-800').removeClass('text-violet-800').addClass('text-green-800');
                                itemEl.find('.bg-violet-200').removeClass('bg-violet-200 dark:bg-violet-300').addClass('bg-green-200 dark:bg-green-300');
                                itemEl.find('.svg-days-left').replaceWith('<svg class="w-4 h-4 text-green-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 11.917 9.724 16.5 19 7.5"/></svg>');
                                itemEl.find('.flex.items-center.gap-1').html('<svg class="w-4 h-4 text-green-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 11.917 9.724 16.5 19 7.5"/></svg> Done');
                            } else {
                                const dueDate = moment(itemEl.data('due-date')); 
                                const today = moment();
                                const daysLeft = dueDate.diff(today, 'days');
                                
                                itemEl.find('.text-green-800').removeClass('text-green-800').addClass('text-violet-800');
                                itemEl.find('.bg-green-200').removeClass('bg-green-200 dark:bg-green-300').addClass('bg-violet-200 dark:bg-violet-300');
                                itemEl.find('.svg-done').replaceWith('<svg class="w-4 h-4 text-violet-800" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path></svg>');
                                if (newStatus !== 'done') {
                                    itemEl.find('.flex.items-center.gap-1').html('<svg class="w-4 h-4 text-violet-800" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path></svg>' + (daysLeft > 0 ? daysLeft + ' days left' : (daysLeft === 0 ? 'Due today' : 'Overdue by ' + Math.abs(daysLeft) + ' days')));
                                }
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Update kanban failed:', status, error);
                        }
                    });

                },
            });
        @endforeach

        $('.open_more').on('click', function(event) {
            const taskId = $(this).val();
            $.ajax({
                url: `/kanban/${taskId}/get`,
                method: 'GET',
                dataType: 'json',
                success: function(taskData) {
                    const form = $('#task-form');
                    const formBtn = $('#task-form-btn');

                    form.attr('action', `/kanban/${taskData.id}`);
                    form.attr('method', 'POST');
                    if ($('#task-form input[name="_method"]').length === 0) {
                        form.append('<input type="hidden" name="_method" value="PUT">');
                    }
                    formBtn.text('Save');

                    resetFormFields(taskData);

                    $('#status').on('change', function(event) {
                        var selectedStatus = $(this).val();
                        $.ajax({
                            url: `/kanban/order`,
                            method: 'GET',
                            dataType: 'json',
                            data: { status: selectedStatus },
                            success: function(statusOrder) {
                                $('#order').val(statusOrder);    
                            },
                            error: function(error) {
                                console.error("Error get order:", error);
                            }
                        }); 
                    });
                },
                error: function(error) {
                    console.error("Error open more CRUD options:", error);
                }
            }); 
        });

        $('.btn-delete').on('click', function(event) {
            const taskId = $(this).val();
            console.log('taskId', taskId);
            const form = $('#modal-form-delete');
            form.attr('action', `/kanban/${taskId}`);
            form.attr('method', 'POST');
            if (form.find('input[name="_token"]').length === 0) {
                const csrfToken = $('meta[name="csrf-token"]').attr('content');
                form.append(`<input type="hidden" name="_token" value="${csrfToken}">`);
            }
            if ($('#modal-form-delete input[name="_method"]').length === 0) {
                form.append('<input type="hidden" name="_method" value="DELETE">');
            }
        });

        @foreach(['to-do', 'in-progress', 'done'] as $status)
            $('#formModalButton-{{ $status }}').on('click', function(event) {
                const taskStatus = '{{ $status }}';
                console.log('status', taskStatus)
                $.ajax({
                    url: `/kanban/order`,
                    method: 'GET',
                    dataType: 'json',
                    data: { status: taskStatus },
                    success: function(statusOrder) {
                        $('#order').val(statusOrder);    
                    },
                    error: function(error) {
                        console.error("Error get order:", error);
                    }
                }); 
                const form = $('#task-form');
                const formBtn = $('#task-form-btn');
                const fieldsValues = {};

                fieldsValues.status = '{{ $status }}';
                form.attr('action', '/kanban');
                form.attr('method', 'POST');
                formBtn.html('<svg class="mr-1 -ml-1 w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>Add new task');

                $('#task-form input[name="_method"]').remove();
                resetFormFields(fieldsValues);
            });
        @endforeach

        function resetFormFields(fieldValues) {
            const fields = {
                '#title': fieldValues.title || '',
                '#task_description': fieldValues.task_description || '',
                '#due_date': fieldValues.due_date || '',
                '#user_id': fieldValues.user_id || '',
                '#deal_id': fieldValues.deal_id || '', 
                '#status': fieldValues.status || 'to-do',
                '#order' : fieldValues.order || 0,
            };
        
            for (const [selector, value] of Object.entries(fields)) {
                $(selector).val(value);
            }
        }

    })  
</script>

@endsection

