@extends('layouts.app')

@section('content')
<section class="bg-gray-50 dark:bg-gray-900">
  <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
      <a href="{{ url('/') }}" class="flex items-center mb-6 text-2xl font-semibold text-gray-900 dark:text-white">
          <img class="w-8 h-8 mr-2" src="{{ URL::asset('/images/management.png') }}" alt="logo">
          CRM    
      </a>
      <div class="w-full p-6 bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md dark:bg-gray-800 dark:border-gray-700 sm:p-8">
          <h2 class="mb-1 text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
          {{ __('Confirm Password') }}
          </h2>
          <p class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('Please confirm your password before continuing.') }}</p>
          <form class="mt-4 space-y-4 lg:mt-5 md:space-y-5" method="POST" action="{{ route('password.confirm') }}">
              @csrf
              <div>
                  <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('Password') }}</label>
                  <input type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required autocomplete="current-password">
                  @error('password')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium" role="alert"><strong>{{ $message }}</strong></span></p>
                  @enderror
              </div>
              <button type="submit" class="w-full text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">{{ __('Confirm Password') }}</button>
              @if (Route::has('password.request'))
                <a class="text-sm font-medium text-primary-600 hover:underline dark:text-primary-500" href="{{ route('password.request') }}">
                    {{ __('Forgot password?') }}
                </a>
              @endif
          </form>
      </div>
      <p><a href="https://www.flaticon.com/free-icons/crm" title="CRM icons">CRM icons created by Iconfromus - Flaticon</a></p>
  </div>
</section>
@endsection
