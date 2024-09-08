function createActivityRow(activity) {
    const activityType = capitalizeFirstLetter(activity.activity_type);
    return `
        <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                ${activityType}
            </th>
            <td class="px-6 py-4">
                ${activity.activity_description}
            </td>
        </tr>
    `;
}

function createReportRow(report) {
    return `
        <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                ${report.Name}
            </th>
            <td class="px-6 py-4">
                ${report.Email}
            </td>
            <td class="px-6 py-4">
                ${report.Project}
            </td>
            <td class="px-6 py-4">
                ${formatDuration(report.Duration)}
            </td>
            <td class="px-6 py-4">
                ${report.Status}
            </td>
        </tr>
    `;
}

function createNoteRow(note) {
    return `
        <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
            <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                ${note.deal_name}
            </th>
            <td class="px-6 py-4">
                ${note.note}
            </td>
        </tr>
    `;
}

function createTaskRow(task) {
    return `
        <div class="flex items-center justify-between odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 px-6 py-4">
            <div class="flex flex-grow items-center gap-4.5">
                <div>
                    <h4 class="mb-2 font-medium text-black dark:text-white">
                        ${task.title}
                    </h4>
                    <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:gap-5 dark:text-gray-400 text-gray-700">
                        <span class="flex items-center gap-1.5">
                            <span class="text-xs font-medium">${task.user_name}</span>
                        </span>
                        <span class="flex items-center gap-1.5">
                            <svg class="fill-current" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M14 2.65002H12.7V2.10002C12.7 1.80002 12.45 1.52502 12.125 1.52502C11.8 1.52502 11.55 1.77502 11.55 2.10002V2.65002H4.42505V2.10002C4.42505 1.80002 4.17505 1.52502 3.85005 1.52502C3.52505 1.52502 3.27505 1.77502 3.27505 2.10002V2.65002H2.00005C1.15005 2.65002 0.425049 3.35002 0.425049 4.22502V12.925C0.425049 13.775 1.12505 14.5 2.00005 14.5H14C14.85 14.5 15.575 13.8 15.575 12.925V4.20002C15.575 3.35002 14.85 2.65002 14 2.65002ZM1.57505 7.30002H3.70005V9.77503H1.57505V7.30002ZM4.82505 7.30002H7.45005V9.77503H4.82505V7.30002ZM7.45005 10.9V13.35H4.82505V10.9H7.45005ZM8.57505 10.9H11.2V13.35H8.57505V10.9ZM8.57505 9.77503V7.30002H11.2V9.77503H8.57505ZM12.3 7.30002H14.425V9.77503H12.3V7.30002ZM2.00005 3.77502H3.30005V4.30002C3.30005 4.60002 3.55005 4.87502 3.87505 4.87502C4.20005 4.87502 4.45005 4.62502 4.45005 4.30002V3.77502H11.6V4.30002C11.6 4.60002 11.85 4.87502 12.175 4.87502C12.5 4.87502 12.75 4.62502 12.75 4.30002V3.77502H14C14.25 3.77502 14.45 3.97502 14.45 4.22502V6.17502H1.57505V4.22502C1.57505 3.97502 1.75005 3.77502 2.00005 3.77502ZM1.57505 12.9V10.875H3.70005V13.325H2.00005C1.75005 13.35 1.57505 13.15 1.57505 12.9ZM14 13.35H12.3V10.9H14.425V12.925C14.45 13.15 14.25 13.35 14 13.35Z" fill=""></path>
                            </svg>
                            <span class="text-xs font-medium">${formatDate(task.due_date)}</span>
                        </span>
                    </div>
                </div>
            </div>
            <span class="rounded bg-meta-3/[0.08] px-2.5 py-1.5 text-sm font-medium text-meta-3 text-gray-700 dark:text-gray-400">${capitalizeFirstLetter(task.status).replace(/_/g, ' ')}</span>
        </div>
    `;
}

function renderWeekDaysHeader() {
    const weekDays = ['Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa', 'So'];
    return `
        <thead>
            <tr>${weekDays.map(day => `<th><div class="w-full flex justify-center"><p class="text-base font-medium text-center text-gray-800 dark:text-gray-100">${day}</p></div></th>`).join('')}</tr>
        </thead>
    `;
}

function renderEmptyDay() {
    return '<td class="pt-6"><div class="px-2 py-2 cursor-pointer flex w-full justify-center"></div></td>';
}

function renderDay(day, dayActivities, isToday) {
    const activityIds = dayActivities.map(activity => activity.id).join(',');
    const bgColor = isToday ? 'indigo-700' : 'gray-700';
    const hoverColor = isToday ? 'indigo-500' : 'gray-500';

    let dayHTML = `
        <div class="w-full h-full">
            <div class="flex items-center justify-center w-full rounded-full cursor-pointer">
                <a href="/activities/search?ids=${activityIds}" role="link" tabindex="0" class="relative focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-${bgColor} focus:bg-${hoverColor} hover:bg-${hoverColor} text-base w-8 h-8 flex items-center justify-center font-medium text-white bg-${bgColor} rounded-full" data-activity-ids="${activityIds}">
                    ${day}
    `;

    if (dayActivities.length > 0) {
        dayHTML += `
            <div class="absolute inline-flex items-center justify-center w-6 h-6 text-xs font-bold text-white bg-red-500 border-2 border-white rounded-full -top-3 -end-3 dark:border-gray-900">
                ${dayActivities.length}
            </div>
        `;
    }

    dayHTML += '</a></div></div>';
    return `<td class="pt-6">${dayHTML}</td>`;
}
