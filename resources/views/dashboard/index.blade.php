@extends('layouts.app')

@section('content')

   <div class="mb-8 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
      <div>
         <h2 id="overview-title" class="text-title-sm2 font-bold  text-gray-500 dark:text-gray-400">
            {{ __('messages.last_7_days_overview') }}
         </h2>
      </div>
      <button
         id="dropdown-default-btn-statistics"
         data-dropdown-toggle="last-days-dropdown-statistics"
         data-dropdown-placement="bottom"
         class="text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-gray-900 text-center inline-flex items-center dark:hover:text-white"
         type="button">
         {{ __('messages.last_7_days') }}
         <svg class="w-2.5 m-2.5 ms-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
         </svg>
      </button>
      <div id="last-days-dropdown-statistics" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
         <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdown-default-btn-statistics">
            <li class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white cursor-pointer" data-days="7">
               {{ __('messages.last_7_days') }}
            </li>
            <li class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white cursor-pointer" data-days="30">
               {{ __('messages.last_30_days') }}
            </li>
            <li class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white cursor-pointer" data-days="90">
               {{ __('messages.last_90_days') }}
            </li>
         </ul>
      </div>
   </div>
   

   @include('dashboard.statistics.index')

   <div class="mt-7.5 grid grid-cols-12 gap-4 md:gap-6 2xl:gap-7.5">
      <div class="col-span-12 xl:col-span-7">
         @include('dashboard.financials')
      </div>
      <div class="col-span-12 xl:col-span-5 scrollbar-thumb-custom scrollbar-track-custom-light">
         @include('dashboard.recent-activities')
      </div>
      <div class="col-span-12">
         @include('dashboard.reports')
      </div>
      <div class="col-span-12 xl:col-span-5 scrollbar-thumb-custom scrollbar-track-custom-light">
         @include('dashboard.notifications')
      </div>
      <div class="col-span-12 xl:col-span-7">
         @include('dashboard.tasks')
      </div>
   </div>
   
@endsection

@section('scripts')
 <script>
   $(document).ready(function () {

      const days = 7;
      const dateRange = getFormattedDateRange(days);

      updateStatistics(dateRange.startDate, dateRange.endDate, days);
      updateFinancials(dateRange.startDate, dateRange.endDate, days);
      updateActivities();
      updateReports(dateRange.startDate, dateRange.endDate, days, 10);
      updateNotes();
      updateTasks();

      $('#last-days-dropdown-statistics li').on('click', function(event) {
         const days = $(this).data('days');
         const dateRange = getFormattedDateRange(days);

         updateStatistics(dateRange.startDate, dateRange.endDate, days);
      });

      $('#last-days-dropdown-payments li').on('click', function(event) {
         const days = $(this).data('days');
         const dateRange = getFormattedDateRange(days);

         updateFinancials(dateRange.startDate, dateRange.endDate, days);
      });

      $('#last-days-dropdown-reports li').on('click', function(event) {
         const days = $(this).data('days');
         const dateRange = getFormattedDateRange(days);

         updateReports(dateRange.startDate, dateRange.endDate, days, 10);
      });

      function updateStatistics(startDate, endDate, days) {
         updateTextWithDays('#overview-title', days);
         updateTextWithDays('#dropdown-default-btn-statistics', days);
         $.ajax({
            url: '/dashboard/fetch-statistics',
            method: 'GET',
            data: {
                start_date: startDate,
                end_date: endDate,
                days: days
            },
            dataType: 'json',
            success: function(response) {
                renderStatistics(response);
            },
            error: function(error) {
                console.error("Error loading statistics charts:", error);
            }
        }); 
      }

      function updateActivities() {
         $.ajax({
            url: '/dashboard/10/latest-activities',
            method: 'GET',
            dataType: 'json',
            success: function(response) {
               renderActivities(response);
            },
            error: function(error) {
                console.error("Error loading activities:", error);
            }
        }); 
      }

      function updateReports(startDate, endDate, days, limit) {
         $.ajax({
            url: '/dashboard/fetch-reports',
            method: 'GET',
            data: {
                start_date: startDate,
                end_date: endDate,
                days: days,
                limit: limit
            },
            dataType: 'json',
            success: function(response) {
               renderReports(response);
            },
            error: function(error) {
                console.error("Error loading reports:", error);
            }
        }); 
      }

      function updateNotes() {
         $.ajax({
            url: 'dashboard/10/latest-notes',
            method: 'GET',
            dataType: 'json',
            success: function(response) {
               renderNotes(response);
            },
            error: function(error) {
                console.error("Error loading notes:", error);
            }
        }); 
      }

      function updateTasks() {
         $.ajax({
            url: '/dashboard/10/latest-tasks',
            method: 'GET',
            dataType: 'json',
            success: function(response) {
               renderTasks(response);
            },
            error: function(error) {
                console.error("Error loading tasks:", error);
            }
        }); 
      }

      function updateFinancials(startDate, endDate, days) {
         updateTextWithDays('#dropdown-default-btn-payments', days);
         $.ajax({
            url: '/dashboard/fetch-financials',
            method: 'GET',
            data: {
                start_date: startDate,
                end_date: endDate,
                days: days
            },
            dataType: 'json',
            success: function(response) {
                renderAreaChart(response, '#financials-chart', {
                   seriesNames: ["Received Amount"],
                   colors: ["#7E3BF2", "#1A56DB"],
                   show: true,
                   height: 340,
                   yAxisFormatter: (value) => value ? `$${value}` : '$0',
               });
               updateElementText('#received-amount', response.total_received_for_period);
               updateElementText('#due-amount', response.total_due_for_period);
            },
            error: function(error) {
                console.error("Error loading financials chart:", error);
            }
        }); 
      }

      function getFormattedDateRange(days) {
         const endDate = new Date();
         let startDate = new Date();
         startDate.setDate(endDate.getDate() - days);

         const formattedEndDate = endDate.toISOString().split('T')[0]; // yyyy-mm-dd
         const formattedStartDate = startDate.toISOString().split('T')[0]; // yyyy-mm-dd

         return {
             startDate: formattedStartDate,
             endDate: formattedEndDate
         };
      }

      function renderStatistics(response) {
         renderAreaChart(response.customer, '#customer-chart', {
            seriesNames: ["New Customers per Day"],
            colors: ["#7E3BF2", "#1A56DB"],
            showGrid: false,
         });
         renderPieChart(response.deal, '#deal-chart');
         renderAreaChart(response.employee, '#employee-chart', {
            seriesNames: ["New Sales Employees per Day"],
            colors: ["#7E3BF2", "#1A56DB"],
            showGrid: false,
         });
         updateElementText('#total-customers', response.customer.new_total);
         updateElementText('#total-deals', response.deal.new_total);
         updateElementText('#total-employees', response.employee.new_total);
         updateTrendText('#trend-customers', response.customer.trend_percentage);
         updateTrendText('#trend-deals', response.deal.trend_percentage.active_trend);
         updateTrendText('#trend-employees', response.employee.trend_percentage);
      }

      function renderContent(response, tableBodySelector, createRowFn) {
          const tableBody = $(tableBodySelector);
          const rows = response.map(item => createRowFn(item)).join('');
          tableBody.empty();
          tableBody.append(rows);
      }

      function renderActivities(response) {
         renderContent(response, '#activity-table-body', createActivityRow);
      }

      function renderReports(response) {
         renderContent(response, '#reports-table-body', createReportRow);
      }

      function renderNotes(response) {
         renderContent(response, '#notes-table-body', createNoteRow);
      }

      function renderTasks(response) {
         renderContent(response, '#tasks-table-body', createTaskRow);
      }

      function updateElementText(selector, newValue) {
         $(selector).text(newValue);
      }

      function updateTrendText(selector, newValue) {
         const containerElement = $(selector).closest('div');
         const addClass = newValue >= 0 ? 'text-green-500 dark:text-green-500' : 'text-red-500 dark:text-red-500';
         const removeClass = newValue >= 0 ? 'text-red-500 dark:text-red-500' : 'text-green-500 dark:text-green-500';
         const svgElement = containerElement.find('div');
         containerElement.removeClass(removeClass).addClass(addClass);
         svgElement.toggleClass('rotate-180', newValue < 0);
         updateElementText(selector, newValue.toString() + '%'); 
      }

      function renderAreaChart(response, chartElement, options) {
         const seriesData = [
                { name: options.seriesNames[0], data: response.total_per_day }
         ];
         const labelsData = response.date_per_day;
         const chartOptions = getAreaChartOptions(seriesData, labelsData, options);

         if ($(chartElement).length && typeof ApexCharts !== 'undefined') {
            $(chartElement).empty();
            const newChartDiv = document.createElement('div');
            newChartDiv.id = 'new-chart-' + Math.random().toString(36).substr(2, 9);
            document.querySelector(chartElement).appendChild(newChartDiv);
            const chart = new ApexCharts(newChartDiv, chartOptions);
            chart.render();
         }
      }

      function renderPieChart(response, chartElement) {
         const seriesData = response.values;
         const labelsData = response.keys;
         const chartOptions = getPieChartOptions(seriesData, labelsData);

         if ($(chartElement).length && typeof ApexCharts !== 'undefined') {
            $(chartElement).empty();
            const newChartDiv = document.createElement('div');
            newChartDiv.id = 'new-chart-' + Math.random().toString(36).substr(2, 9);
            document.querySelector(chartElement).appendChild(newChartDiv);
            const chart = new ApexCharts(newChartDiv, chartOptions);
            chart.render();
         }
      }

      function updateTextWithDays(selector, days) {
         const element = $(selector);
         const currentText = element.text();
         const newText = currentText.replace(/\d+/, days);
         element.text(newText);
      }
   });
 </script>
@endsection
