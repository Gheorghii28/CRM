@extends('layouts.app')

@section('content')
<section class="bg-gray-50 dark:bg-gray-900">
  <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
      <a href="{{ url('/') }}" class="flex items-center mb-6 text-2xl font-semibold text-gray-900 dark:text-gray-400">
         <img class="w-8 h-8 mr-2 dark:hidden" src="{{ URL::asset('/images/management.png') }}" alt="logo">
         <img class="w-8 h-8 mr-2 hidden dark:block" src="{{ URL::asset('/images/management-dark-mode.png') }}" alt="logo">
         {{ __('messages.crm') }}
      </a>
      <div class="w-full p-6 bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md dark:bg-gray-800 dark:border-gray-700 sm:p-8">
          <h2 class="mb-1 text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
          {{ __('messages.change_password') }}
          </h2>
          @if (session('status'))
            <div class="alert alert-success dark:text-gray-400" role="alert">
                {{ session('status') }}
            </div>
          @endif
          <form class="mt-4 space-y-4 lg:mt-5 md:space-y-5" method="POST" action="{{ route('password.email') }}">
              @csrf
              <div>
                  <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('messages.your_email') }}</label>
                  <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="name@company.com" value="{{ old('email') }}" required autocomplete="email" autofocus>
                  @error('email')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium" role="alert"><strong>{{ $message }}</strong></span></p>
                  @enderror
              </div>
              <button type="submit" class="w-full text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">{{ __('messages.send_password_reset_link') }}</button>
          </form>
      </div>
      <p class="dark:text-gray-600"><a href="https://www.flaticon.com/free-icons/crm" title="CRM icons">{{ __('messages.crm_icons_credit') }}</a></p>
  </div>
</section>
@endsection
