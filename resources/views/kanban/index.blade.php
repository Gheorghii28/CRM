@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="space-y-8 md:grid md:grid-cols-2 lg:grid-cols-3 md:gap-4 md:space-y-0">
            @foreach(['to-do' => 'To Do', 'in-progress' => 'In Progress', 'done' => 'Done'] as $status => $title)
                <div class="">
                    <h4 class="mb-2 text-2xl font-semibold tracking-tight text-gray-900 dark:text-white">{{ $title }}</h4>
                    <ul id="list-{{ $status }}" class="list-group">
                        @foreach($tasks->where('status', $status) as $task)
                            @include('kanban.task')
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
                    });
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
    })  
</script>

@endsection

