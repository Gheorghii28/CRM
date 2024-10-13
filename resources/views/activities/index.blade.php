@extends('layouts.app')

@section('content')
    @include('components/alert-message')
    <div class="gap-4 lg:grid lg:grid-cols-5">
        <div class="col-span-2 w-full h-full text-sm text-gray-500 dark:text-gray-400 flex flex-col gap-4">
            <div class="p-4 h-full bg-white border border-gray-200 rounded-lg shadow-sm dark:text-gray-400 dark:bg-gray-800 dark:border-gray-600">
              @include('activities.chart')
            </div>
        </div>

        <div class="col-span-3 w-full h-full text-sm text-gray-500 dark:text-gray-400 flex flex-col gap-4">
            <div class="p-3 bg-white border border-gray-200 rounded-lg shadow-sm dark:text-gray-400 dark:bg-gray-800 dark:border-gray-600">
                @include('activities.calendar')
            </div>
        </div>
        <div class="col-span-5 w-full h-full text-sm text-gray-500 dark:text-gray-400 flex flex-col gap-4">
            <div class=" dark:text-gray-400 ">
              @include('partials.search-form', [
                'actionUrl' => '/activities/search',
                'placeholder' => __('messages.search_activity_placeholder'),
                'resetUrl' => '/activities',
                'buttonText' => __('messages.add_activity_button'),
                'formInclude' => 'activities/form',
                'formModalId' => 'formModalActivity'
              ])
              <div class="overflow-x-auto">
                  <div class="gap-4 md:grid lg:grid xl:grid 2xl:grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5">
                      @foreach ($activities as $activity)
                        @include('partials.delete-modal', [
                          'entity' => $activity,
                          'entityType' => 'activity',
                          'entityName' => $activity['activity_description']
                        ])
                        @include('activities.card', ['activity->' => $activity])
                      @endforeach
                  </div>
                  <div id="table-paginator" class="py-4">
                      <div>
                          {{ $activities->appends(request()->input())->links() }}
                      </div>
                  </div>        
              </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
      const monthNames = [
          "{{ __('messages.months.january') }}",
          "{{ __('messages.months.february') }}",
          "{{ __('messages.months.march') }}",
          "{{ __('messages.months.april') }}",
          "{{ __('messages.months.may') }}",
          "{{ __('messages.months.june') }}",
          "{{ __('messages.months.july') }}",
          "{{ __('messages.months.august') }}",
          "{{ __('messages.months.september') }}",
          "{{ __('messages.months.october') }}",
          "{{ __('messages.months.november') }}",
          "{{ __('messages.months.december') }}"
      ];
      const weekDays = [
        "{{ __('messages.weekdays.monday') }}",
        "{{ __('messages.weekdays.tuesday') }}",
        "{{ __('messages.weekdays.wednesday') }}",
        "{{ __('messages.weekdays.thursday') }}",
        "{{ __('messages.weekdays.friday') }}",
        "{{ __('messages.weekdays.saturday') }}",
        "{{ __('messages.weekdays.sunday') }}"
      ];  
      let currentYear = new Date().getFullYear();
      let currentMonth = new Date().getMonth() + 1;

      function renderChart() {
        const activityTypeCounts = @json($activityTypeCounts);
        const seriesData = activityTypeCounts.map(item => item.count);
        const labelsData = activityTypeCounts.map(item => item.activity_type);
        const customOptions = { totalLabel: "{{ __('messages.total_activities') }}" };

        if ($("#donut-chart").length && typeof ApexCharts !== 'undefined') {
          const chartOptions = getDonutChartOptions(seriesData, labelsData, customOptions);
          const chart = new ApexCharts(document.getElementById("donut-chart"), chartOptions);
          chart.render();
        }
      }

      function loadCalendar(year, month) {
        $.ajax({
                url: `/activities/${year}/${month}`,
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                  renderCalendar(response, year, month);
                },
                error: function(error) {
                    console.error("Error load calendar:", error);
                }
        });
      }

      function renderCalendar(activities, year, month) {
        const daysInMonth = new Date(year, month, 0).getDate();
        let firstDay = new Date(year, month - 1, 1).getDay();
        let currentDay = 1;
        let calendarHTML = '<table class="w-full">';
          
        firstDay = firstDay === 0 ? 7 : firstDay;
        calendarHTML += renderWeekDaysHeader(weekDays);
        calendarHTML += '<tbody>';
        
        for (let week = 0; week < 6; week++) { 
          calendarHTML += '<tr>';
          for (let dayOfWeek = 1; dayOfWeek <= 7; dayOfWeek++) {
              if (week === 0 && dayOfWeek < firstDay || currentDay > daysInMonth) {
                  calendarHTML += renderEmptyDay();
              } else {
                  const dayActivities = getActivitiesForDay(activities, currentDay, month, year);
                  const isTodayFlag = isToday(currentDay, month, year);
                  calendarHTML += renderDay(currentDay, dayActivities, isTodayFlag);
                  currentDay++;
              }
          }
          calendarHTML += '</tr>';
        
          if (currentDay > daysInMonth) break;
        }
      
        calendarHTML += '</tbody></table>';
        $('#calendar').html(calendarHTML);
        updateMonthYearDisplay(year, month);
      }


      function changeMonth(increment) {
            currentMonth += increment;
            if (currentMonth > 12) {
                currentMonth = 1;
                currentYear++;
            } else if (currentMonth < 1) {
                currentMonth = 12;
                currentYear--;
            }
            loadCalendar(currentYear, currentMonth);
      }

      function updateMonthYearDisplay(year, month) {
        const monthYearText = monthNames[month - 1] + ' ' + year;

        $('#currentMonthYear').text(monthYearText);
      }
      
      renderChart();
      loadCalendar(currentYear, currentMonth);

      $('[aria-label="calendar forward"]').on('click', function() {
        changeMonth(1);
      });

      $('[aria-label="calendar backward"]').on('click', function() {
          changeMonth(-1);
      });

      $('.open_more').on('click', function(event) {
        const id = $(this).val();
        const btnText = "{{ __('messages.save') }}";
        setupEditForm('#activity-form', '#activity-form-btn', `/activities/${id}`, btnText);
        loadFormData('/activities', id, 'activityForm');
      });
      handleDelete('.btn-delete', '/activities');

      $('#formModalButton').on('click', function(event) {
        setupAddForm(
          '#activity-form',
          '#activity-form-btn',
          '/activities',
          '<svg class="mr-1 -ml-1 w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>{{ __('messages.add_new_activity') }}'
        );
        populateFormFields('activityForm', {});
      });
  });
</script>
@endsection