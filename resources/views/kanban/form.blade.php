<!-- Modal content -->
<div class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
    <!-- Modal header -->
    <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
            {{ __('messages.add_task') }}
        </h3>
        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="formModal">
            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
            <span class="sr-only">{{ __('messages.close_modal') }}</span>
        </button>
    </div>
    <!-- Modal body -->
    <form id="task-form" method="POST">
        @csrf
        <!-- Hidden input to determine the redirect route -->
        <input type="hidden" name="redirect_to" value="{{ request()->route()->getName() }}">
        
        <div class="grid gap-4 mb-4 sm:grid-cols-2">
            <!-- Title -->
            <div>
                <label for="title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('messages.task_title') }}</label>
                <input type="text" name="title" id="title" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="{{ __('messages.task_title_placeholder') }}" required="">
            </div>

            <!-- Task Description -->
            <div class="sm:col-span-2">
                <label for="task_description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('messages.task_description') }}</label>
                <textarea id="task_description" name="task_description" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="{{ __('messages.task_description_placeholder') }}" required=""></textarea>
            </div>

            <!-- Due Date -->
            <div>
                <label for="due_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('messages.due_date') }}</label>
                <input type="date" name="due_date" id="due_date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required="">
            </div>

            <!-- User (Assigned Employee) -->
            <div>
                <label for="user_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('messages.assigned_employee') }}</label>
                <select id="user_id" name="user_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                    <option value="" selected="">{{ __('messages.select_employee') }}</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Deal (Optional) -->
            <div>
                <label for="deal_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('messages.related_deal_optional') }}</label>
                <select id="deal_id" name="deal_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                    <option value="" selected="">{{ __('messages.no_deal') }}</option>
                    @foreach($deals as $deal)
                        <option value="{{ $deal->id }}">{{ $deal->deal_name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Status -->
            <div>
                <label for="status" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('messages.status') }}</label>
                <select id="status" name="status" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                    <option value="to-do" selected="">{{ __('messages.to_do') }}</option>
                    <option value="in-progress">{{ __('messages.in_progress') }}</option>
                    <option value="done">{{ __('messages.done') }}</option>
                </select>
            </div>
        </div>

        <!-- Order (Optional) hidden -->
        <div>
            <label for="order" class="hidden mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('messages.order_optional') }}</label>
            <input type="number" name="order" id="order" class="hidden bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="{{ __('messages.order_optional') }}">
        </div>

        <!-- Submit Button -->
        <button id="task-form-btn" type="submit" class="text-white inline-flex items-center bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
            <svg class="mr-1 -ml-1 w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
            {{ __('messages.add_new_task') }}
        </button>
    </form>
</div>
