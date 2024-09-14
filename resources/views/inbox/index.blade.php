@extends('layouts.app')

@section('content')


<nav class="bg-white border-gray-200 dark:border-gray-600 dark:bg-gray-900 sm:rounded-lg">
  <div class="flex flex-wrap justify-between items-center mx-auto max-w-screen-xl p-4">
      <div class="flex items-center space-x-3 rtl:space-x-reverse">
          <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
            <path d="m17.418 3.623-.018-.008a6.713 6.713 0 0 0-2.4-.569V2h1a1 1 0 1 0 0-2h-2a1 1 0 0 0-1 1v2H9.89A6.977 6.977 0 0 1 12 8v5h-2V8A5 5 0 1 0 0 8v6a1 1 0 0 0 1 1h8v4a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1v-4h6a1 1 0 0 0 1-1V8a5 5 0 0 0-2.582-4.377ZM6 12H4a1 1 0 0 1 0-2h2a1 1 0 0 1 0 2Z"/>
          </svg>
          <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">Inbox</span>
      </div>
      <button data-collapse-toggle="mega-menu-full" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600" aria-controls="mega-menu-full" aria-expanded="false">
          <span class="sr-only">Open main menu</span>
          <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
          </svg>
      </button>
      <div id="mega-menu-full" class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1">
          <ul class="flex flex-col mt-4 font-medium md:flex-row md:mt-0 md:space-x-8 rtl:space-x-reverse">
              <li>
                  <button id="activities-menu-full-dropdown-button" data-collapse-toggle="activities-menu-full-dropdown" class="flex items-center justify-between w-full py-2 px-3 font-medium text-gray-900 border-b border-gray-100 md:w-auto hover:bg-gray-50 md:hover:bg-transparent md:border-0 md:hover:text-blue-600 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-blue-500 md:dark:hover:bg-transparent dark:border-gray-700">
                    Activities 
                    <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                    </svg>
                  </button>
              </li>
              <li>
                  <button id="notes-menu-full-dropdown-button" data-collapse-toggle="notes-menu-full-dropdown" class="flex items-center justify-between w-full py-2 px-3 font-medium text-gray-900 border-b border-gray-100 md:w-auto hover:bg-gray-50 md:hover:bg-transparent md:border-0 md:hover:text-blue-600 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-blue-500 md:dark:hover:bg-transparent dark:border-gray-700">
                    Notes 
                    <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                    </svg>
                  </button>
              </li>
              <li>
                  <button id="reports-menu-full-dropdown-button" data-collapse-toggle="reports-menu-full-dropdown" class="flex items-center justify-between w-full py-2 px-3 font-medium text-gray-900 border-b border-gray-100 md:w-auto hover:bg-gray-50 md:hover:bg-transparent md:border-0 md:hover:text-blue-600 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-blue-500 md:dark:hover:bg-transparent dark:border-gray-700">
                    Reports 
                    <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                    </svg>
                  </button>
              </li>
              <li>
                  <button id="tasks-menu-full-dropdown-button" data-collapse-toggle="tasks-menu-full-dropdown" class="flex items-center justify-between w-full py-2 px-3 font-medium text-gray-900 border-b border-gray-100 md:w-auto hover:bg-gray-50 md:hover:bg-transparent md:border-0 md:hover:text-blue-600 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-blue-500 md:dark:hover:bg-transparent dark:border-gray-700">
                    Tasks 
                    <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                    </svg>
                  </button>
              </li>
          </ul>
      </div>
  </div>
  <div id="activities-menu-full-dropdown" class="mt-1 bg-white border-gray-200 shadow-sm border-y dark:bg-gray-800 dark:border-gray-600 rounded-b-lg">
      <div class="grid max-w-screen-xl px-4 py-5 mx-auto text-gray-900 dark:text-white sm:grid-cols-2 md:grid-cols-3 md:px-6">
        @foreach ($inbox['activities'] as $activity)
            @include('inbox.modal-item', ['entityType' => 'activity', 'data' => $activity, 'i' => $activity->id])
        @endforeach
      </div>
  </div>
  <div id="notes-menu-full-dropdown" class="mt-1 bg-white border-gray-200 shadow-sm border-y dark:bg-gray-800 dark:border-gray-600 rounded-b-lg">
    <div class="grid max-w-screen-xl px-4 py-5 mx-auto text-gray-900 dark:text-white sm:grid-cols-2 md:grid-cols-3 md:px-6">
        @foreach ($inbox['notes'] as $note)
            @include('inbox.modal-item', ['entityType' => 'note', 'data' => $note, 'i' => $note->id])
        @endforeach
    </div>
  </div>
  <div id="reports-menu-full-dropdown" class="mt-1 bg-white border-gray-200 shadow-sm border-y dark:bg-gray-800 dark:border-gray-600 rounded-b-lg">
    <div class="grid max-w-screen-xl px-4 py-5 mx-auto text-gray-900 dark:text-white sm:grid-cols-2 md:grid-cols-3 md:px-6">
        @foreach ($inbox['reports'] as $report)
            @include('inbox.modal-item', ['entityType' => 'report', 'data' => $report, 'i' => $report->id])
        @endforeach
    </div>
  </div>
  <div id="tasks-menu-full-dropdown" class="mt-1 bg-white border-gray-200 shadow-sm border-y dark:bg-gray-800 dark:border-gray-600 rounded-b-lg">
    <div class="grid max-w-screen-xl px-4 py-5 mx-auto text-gray-900 dark:text-white sm:grid-cols-2 md:grid-cols-3 md:px-6">
        @foreach ($inbox['tasks'] as $task)
            @include('inbox.modal-item', ['entityType' => 'task', 'data' => $task, 'i' => $task->id])
        @endforeach
    </div>
  </div>
</nav>

@endsection

@section('scripts')
 <script>
    $(document).ready(function () {
        const menuIds = [
            'activities-menu-full-dropdown',
            'notes-menu-full-dropdown',
            'reports-menu-full-dropdown',
            'tasks-menu-full-dropdown'
        ]; 
        const buttonIds = [
            'activities-menu-full-dropdown-button',
            'notes-menu-full-dropdown-button',
            'reports-menu-full-dropdown-button',
            'tasks-menu-full-dropdown-button'
        ];
        const inactiveClasses = 'text-gray-900 dark:text-white';
        const activeClasses = 'text-blue-600 dark:text-blue-500';

        function hideAllMenus() {
            menuIds.forEach(menuId => {
                $(`#${menuId}`).hide();
            });
            buttonIds.forEach(buttonId => {
                $(`#${buttonId}`).removeClass(activeClasses).addClass(inactiveClasses);
            });
        }

        hideAllMenus();
        $('#activities-menu-full-dropdown').show();
        $('#activities-menu-full-dropdown-button').removeClass(inactiveClasses).addClass(activeClasses);
        $('[data-collapse-toggle]').on('click', function (e) {
            const currentDropdown = $(this).attr('data-collapse-toggle');
            const currentButton = $(this).attr('id');

            hideAllMenus();
            $(`#${currentDropdown}`).toggle();
            $(`#${currentButton}`).removeClass(inactiveClasses).toggleClass(activeClasses);
        });
    });
 </script>
@endsection