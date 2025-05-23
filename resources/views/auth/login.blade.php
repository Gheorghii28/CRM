@extends('layouts.app')

@section('content')
<section class="bg-gray-50 dark:bg-gray-900">
  <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
      <a href="{{ url('/') }}" class="flex items-center mb-6 text-2xl font-semibold text-gray-900 dark:text-gray-400">
          <img class="w-8 h-8 mr-2 dark:hidden" src="{{ URL::asset('/images/management.png') }}" alt="logo">
          <img class="w-8 h-8 mr-2 hidden dark:block" src="{{ URL::asset('/images/management-dark-mode.png') }}" alt="logo">
          {{ __('messages.crm') }}
      </a>
      <div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
          <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
              <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                {{ __('messages.login_to_account') }}
              </h1>
              <form method="POST" action="{{ route('login') }}" class="space-y-4 md:space-y-6">
                @csrf
                  <div>
                      <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('messages.your_email') }}</label>
                      <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="{{ __('messages.email_placeholder') }}" value="{{ old('email') }}" required autocomplete="email" autofocus>
                      @error('email')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium" role="alert"><strong>{{ $message }}</strong></span></p>
                      @enderror  
                  </div>
                  <div>
                      <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('messages.password') }}</label>
                      <input type="password" name="password" id="password" placeholder="{{ __('messages.password_placeholder') }}" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required autocomplete="current-password">
                      @error('password')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium" role="alert"><strong>{{ $message }}</strong></span></p>
                      @enderror 
                  </div>
                  <div class="flex items-center justify-between">
                      <div class="flex items-start">
                          <div class="flex items-center h-5">
                            <input id="remember" aria-describedby="remember" type="checkbox" name="remember" class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-primary-600 dark:ring-offset-gray-800" {{ old('remember') ? 'checked' : '' }}>
                          </div>
                          <div class="ml-3 text-sm">
                            <label for="remember" class="text-gray-500 dark:text-gray-300">{{ __('messages.remember_me') }}</label>
                          </div>
                      </div>
                      @if (Route::has('password.request'))
                            <a class="text-sm font-medium text-primary-600 hover:underline dark:text-primary-500" href="{{ route('password.request') }}">
                                {{ __('messages.forgot_password') }}
                            </a>
                      @endif
                  </div>
                  <button type="submit" class="w-full text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">{{ __('messages.login') }}</button>
                  <button type="button" onclick="window.location.href='{{ route('guest.login') }}'" class="w-full py-2.5 px-5 me-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">{{ __('messages.guest_login') }}</button>
                  <p class="text-sm font-light text-gray-500 dark:text-gray-400">
                      {{ __('messages.no_account') }} <a class="font-medium text-primary-600 hover:underline dark:text-primary-500" href="{{ route('register') }}">{{ __('messages.sign_up') }}</a>
                  </p>
              </form>
          </div>
      </div>
      <p class="dark:text-gray-600"><a href="https://www.flaticon.com/free-icons/crm" title="CRM icons">{{ __('messages.crm_icons_credit') }}</a></p>
  </div>
</section>
@endsection
