@extends('layouts.app')

@section('content')
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
    <div class="gap-4 lg:grid lg:grid-cols-5">
        <div class="col-span-2 w-full h-full inline-block w-64 text-sm text-gray-500 dark:text-gray-400 flex flex-col gap-4">
            <div class="p-4 h-full bg-white border border-gray-200 rounded-lg shadow-sm dark:text-gray-400 dark:bg-gray-800 dark:border-gray-600">
              @include('activities.chart')
            </div>
        </div>

        <div class="col-span-3 w-full h-full inline-block w-64 text-sm text-gray-500 dark:text-gray-400 flex flex-col gap-4">
            <div class="p-3 bg-white border border-gray-200 rounded-lg shadow-sm dark:text-gray-400 dark:bg-gray-800 dark:border-gray-600">
                @include('activities.calendar')
            </div>
        </div>
        <div class="col-span-5 w-full h-full inline-block w-64 text-sm text-gray-500 dark:text-gray-400 flex flex-col gap-4">
            <div class=" dark:text-gray-400 ">
              @include('partials.search-form', [
                'actionUrl' => '/activities/search',
                'placeholder' => 'Search by User Name, Customer Name, Activity Type, Description, or Date...',
                'resetUrl' => '/activities',
                'buttonText' => 'Add activity',
                'formInclude' => 'activities/form'
              ])
              <div class="overflow-x-auto">
                  <div class="gap-4 md:grid lg:grid xl:grid 2xl:grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5">
                      @foreach ($activities as $activity)
                        @include('activities.delete', ['activity->' => $activity])
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
      let currentYear = new Date().getFullYear();
      let currentMonth = new Date().getMonth() + 1;

      renderChart();
      loadCalendar(currentYear, currentMonth);

      function renderChart() {
        const getChartOptions = () => {
          const seriesData = @json($activityTypeCounts->pluck('count'));
          const labelsData = @json($activityTypeCounts->pluck('activity_type'));
        
          return {
            series: seriesData,
            colors: ["#1C64F2", "#16BDCA", "#FDBA8C", "#E74694"],
            chart: {
              height: 320,
              width: "100%",
              type: "donut",
            },
            stroke: {
              colors: ["transparent"],
              lineCap: "",
            },
            plotOptions: {
              pie: {
                donut: {
                  labels: {
                    show: true,
                    name: {
                      show: true,
                      fontFamily: "Inter, sans-serif",
                      offsetY: 20,
                    },
                    total: {
                      showAlways: true,
                      show: true,
                      label: "Total Activities",
                      fontFamily: "Inter, sans-serif",
                      formatter: function (w) {
                        const sum = w.globals.seriesTotals.reduce((a, b) => {
                          return a + b
                        }, 0)
                        return sum
                      },
                    },
                    value: {
                      show: true,
                      fontFamily: "Inter, sans-serif",
                      offsetY: -20,
                      formatter: function (value) {
                        return value
                      },
                    },
                  },
                  size: "80%",
                },
              },
            },
            grid: {
              padding: {
                top: -2,
              },
            },
            labels: labelsData,
            dataLabels: {
              enabled: false,
            },
            legend: {
              position: "bottom",
              fontFamily: "Inter, sans-serif",
            },
            yaxis: {
              labels: {
                formatter: function (value) {
                  return value
                },
              },
            },
            xaxis: {
              labels: {
                formatter: function (value) {
                  return value
                },
              },
              axisTicks: {
                show: false,
              },
              axisBorder: {
                show: false,
              },
            },
          }
        }
        if ($("#donut-chart").length && typeof ApexCharts !== 'undefined') {
            const chart = new ApexCharts(document.getElementById("donut-chart"), getChartOptions());
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
      
        updateMonthYearDisplay(year, month);

        const today = new Date();
        const todayDay = today.getDate();
        const todayMonth = today.getMonth() + 1;
        const todayYear = today.getFullYear();
        let daysInMonth = new Date(year, month, 0).getDate();
        let firstDay = new Date(year, month - 1, 1).getDay();
        let calendarHTML = '<table class="w-full">';
        
        calendarHTML += '<thead><tr>';
        ['Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa', 'So'].forEach(day => {
            calendarHTML += `<th><div class="w-full flex justify-center"><p class="text-base font-medium text-center text-gray-800 dark:text-gray-100">${day}</p></div></th>`;
        });
        calendarHTML += '</tr></thead><tbody>';
        
        let currentDay = 1;
        for (let i = 0; i < 5; i++) {
            calendarHTML += '<tr>';
            for (let j = 1; j <= 7; j++) {
                if (i === 0 && j < firstDay || currentDay > daysInMonth) {
                    calendarHTML += '<td class="pt-6"><div class="px-2 py-2 cursor-pointer flex w-full justify-center"></div></td>';
                } else {
                    let dayActivities = activities.filter(function(activity) {
                        return new Date(activity.date).getDate() === currentDay;
                    });

                    let dayHTML;

                    if (currentDay === todayDay && month === todayMonth && year === todayYear) {
                      dayHTML = `
                        <div class="w-full h-full">
                            <div class="flex items-center justify-center w-full rounded-full cursor-pointer">
                                <a href="/activities/search?ids=${dayActivities.map(activity => activity.id).join(',')}"  role="link" tabindex="0" class="relative focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-700 focus:bg-indigo-500 hover:bg-indigo-500 text-base w-8 h-8 flex items-center justify-center font-medium text-white bg-indigo-700 rounded-full" data-activity-ids="${dayActivities.map(activity => activity.id).join(',')}">${currentDay}`;
                      if(dayActivities.length > 0) {
                        dayHTML += `<div class="absolute inline-flex items-center justify-center w-6 h-6 text-xs font-bold text-white bg-red-500 border-2 border-white rounded-full -top-3 -end-3 dark:border-gray-900">${dayActivities.length}</div>`;
                      }
                      dayHTML += '</a></div>'
                    } else {
                      dayHTML = `<div class="px-2 py-2 cursor-pointer flex w-full justify-center"><p class="text-base text-gray-500 dark:text-gray-100 font-medium">${currentDay}</p>`;
                      if(dayActivities.length > 0) {
                            dayHTML = `<div class="w-full h-full">
                            <div class="flex items-center justify-center w-full rounded-full cursor-pointer">
                                <a href="/activities/search?ids=${dayActivities.map(activity => activity.id).join(',')}" role="link" tabindex="0" class="relative focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-700 focus:bg-gray-500 hover:bg-gray-500 text-base w-8 h-8 flex items-center justify-center font-medium text-white bg-gray-700 rounded-full" data-activity-ids="${dayActivities.map(activity => activity.id).join(',')}">${currentDay}`;
                            dayHTML += `<div type="button" class="absolute inline-flex items-center justify-center w-6 h-6 text-xs font-bold text-white bg-red-500 border-2 border-white rounded-full -top-3 -end-3 dark:border-gray-900">${dayActivities.length}</div>`;
                            dayHTML += '</a></div>';
                      }
                    }

                    dayHTML += '</div>';
                    calendarHTML += `<td class="pt-6">${dayHTML}</td>`;
                    currentDay++;
                }
            }
            calendarHTML += '</tr>';
        }

        calendarHTML += '</tbody></table>';
        $('#calendar').html(calendarHTML);
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
        const monthNames = [
            "January", "February", "March", "April", "May", "June",
            "July", "August", "September", "October", "November", "December"
        ];
        const monthYearText = monthNames[month - 1] + ' ' + year;

        $('#currentMonthYear').text(monthYearText);
      }

      $('[aria-label="calendar forward"]').on('click', function() {
        changeMonth(1);
      });

      $('[aria-label="calendar backward"]').on('click', function() {
          changeMonth(-1);
      });

      $('.btn-delete').on('click', function(event) {
            const activityId = $(this).val();
            $.ajax({
                url: `/activities/${activityId}/get`,
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                  setupDeleteForm(response);
                },
                error: function(error) {
                    console.error("Error retrieving activity:", error);
                }
              }); 
      });

      $('.open_form').on('click', function(event) {
        const activityId = $(this).val();
        $.ajax({
            url: `/activities/options-dinamically`,
            method: 'GET',
            dataType: 'json',
            success: function(options) {
              populateDropdowns(options);
              setupActivityForm(activityId);
            },
            error: function(error) {
                console.error("Error open activity form options:", error);
            }
        });     
      });

      function setupDeleteForm(response) {
        const form = $('#activity-form-delete');

        form.attr('action', `/activities/${response.id}`);
        form.attr('method', 'POST');

        if (form.find('input[name="_token"]').length === 0) {
            const csrfToken = $('meta[name="csrf-token"]').attr('content');
            form.append(`<input type="hidden" name="_token" value="${csrfToken}">`);
        }

        if ($('#activity-form-delete input[name="_method"]').length === 0) {
            form.append('<input type="hidden" name="_method" value="DELETE">');
        }
      }

      function setupActivityForm(activityId = null) {
        const form = $('#activity-form');
        const formBtn = $('#activity-form-btn');

        if(activityId) {
          form.attr('action', `/activities/${activityId}`);
          form.attr('method', 'POST');
          if ($('#activity-form input[name="_method"]').length === 0) {
              form.append('<input type="hidden" name="_method" value="PUT">');
          }
          formBtn.text('Save');
          $.ajax({
            url: `/activities/${activityId}/get`,
            method: 'GET',
            dataType: 'json',
            success: function(response) {
              resetFormFields(response);
            },
            error: function(error) {
              console.error("Error open more CRUD options:", error);
            }
          });
        } else {
          form.attr('action', '/activities');
          form.attr('method', 'POST');
          formBtn.html('<svg class="mr-1 -ml-1 w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>Add new activity');
          $('#activity-form input[name="_method"]').remove();
          resetFormFields({});
        }
      }

      function populateDropdowns(options) {
        let userSelect = $('#user_id');
        userSelect.empty();
        userSelect.append('<option value="" selected>Select user</option>');
        options.users.forEach(function(user) {
            userSelect.append(`<option value="${user.id}">${user.name}</option>`);
        });
      
        let customerSelect = $('#customer_id');
        customerSelect.empty();
        customerSelect.append('<option value="" selected>Select customer</option>');
        options.customers.forEach(function(customer) {
            customerSelect.append(`<option value="${customer.id}">${customer.firstname} ${customer.lastname}</option>`);
        });
      
        let dealSelect = $('#deal_id');
        dealSelect.empty();
        dealSelect.append('<option value="" selected>Select deal</option>');
        options.deals.forEach(function(deal) {
            dealSelect.append(`<option value="${deal.id}">${deal.deal_name}</option>`);
        });
      }

      function resetFormFields(fieldValues) {
        const fields = {
            '#user_id': fieldValues.user_id || '',
            '#customer_id': fieldValues.customer_id || '',
            '#activity_type': fieldValues.activity_type ? fieldValues.activity_type.toLowerCase() : '',
            '#activity_description': fieldValues.activity_description || '',
            '#date': fieldValues.date || '',
            '#status': fieldValues.status || '',
            '#priority': fieldValues.priority || '',
            '#deal_id': fieldValues.deal_id || '',
            '#location': fieldValues.location || '',
            '#outcome': fieldValues.outcome || '',
            '#notes': fieldValues.notes || '',
            '#reminder': fieldValues.reminder || ''
        };
      
        for (const [selector, value] of Object.entries(fields)) {
            $(selector).val(value);
        }
      }
  });
</script>
@endsection