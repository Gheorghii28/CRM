@extends('layouts.app')

@section('content')
<section class="bg-gray-50 dark:bg-gray-900">
  <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
      <a href="{{ url('/') }}" class="flex items-center mb-6 text-2xl font-semibold text-gray-900 dark:text-gray-400">
          <img class="w-8 h-8 mr-2 dark:hidden" src="{{ URL::asset('/images/management.png') }}" alt="logo">
          <img class="w-8 h-8 mr-2 hidden dark:block" src="{{ URL::asset('/images/management-dark-mode.png') }}" alt="logo">
          CRM    
      </a>
      <div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
          <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
              <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
              {{ __('Create an account') }}
              </h1>
              <form class="space-y-4 md:space-y-6"  method="POST" action="{{ route('register') }}">
                  @csrf
                  <div>
                      <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('Name') }}</label>
                      <input type="text" name="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Your Name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                      @error('name')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium" role="alert"><strong>{{ $message }}</strong></span></p>
                      @enderror
                  </div>
                  <div>
                      <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('Your email') }}</label>
                      <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="name@company.com" value="{{ old('email') }}" required autocomplete="email">
                      @error('email')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium" role="alert"><strong>{{ $message }}</strong></span></p>
                      @enderror
                  </div>
                  <div>
                      <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('Password') }}</label>
                      <input type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required autocomplete="new-password">
                      @error('password')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium" role="alert"><strong>{{ $message }}</strong></span></p>
                      @enderror
                  </div>
                  <div>
                      <label for="confirm-password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('Confirm Password') }}</label>
                      <input type="confirm-password" name="confirm-password" id="confirm-password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required autocomplete="new-password">
                  </div>
                  <button type="submit" class="w-full text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">{{ __('Create an account') }}</button>
                  <p class="text-sm font-light text-gray-500 dark:text-gray-400">
                      Already have an account? <a href="{{ route('login') }}" class="font-medium text-primary-600 hover:underline dark:text-primary-500">{{ __('Login here') }}</a>
                  </p>
              </form>
          </div>
      </div>
      <p class="dark:text-gray-600"><a href="https://www.flaticon.com/free-icons/crm" title="CRM icons">CRM icons created by Iconfromus - Flaticon</a></p>
  </div>
</section>
@endsection
