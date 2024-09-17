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
            {{ __('messages.verify_email_address') }}
          </h2>
          @if (session('resent'))
            <div class="alert alert-success" role="alert">
                {{ __('messages.verification_link_sent') }}
            </div>
          @endif
            {{ __('messages.check_email_for_verification') }}
            {{ __('messages.did_not_receive_email') }},
          <form class="mt-4 space-y-4 lg:mt-5 md:space-y-5" method="POST" action="{{ route('verification.resend') }}">
              @csrf
              <button type="submit" class="w-full text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">{{ __('messages.request_another') }}</button>
          </form>
      </div>
      <p class="dark:text-gray-600"><a href="https://www.flaticon.com/free-icons/crm" title="CRM icons">{{ __('messages.crm_icons_credit') }}</a></p>
  </div>
</section>
@endsection
