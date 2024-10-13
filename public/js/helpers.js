function setupDeleteForm(url) {
    const form = $('#modal-form-delete');

    form.attr('action', url);
    form.attr('method', 'POST');
    if (form.find('input[name="_token"]').length === 0) {
        const csrfToken = $('meta[name="csrf-token"]').attr('content');

        form.append(`<input type="hidden" name="_token" value="${csrfToken}">`);
    }
    if ($('#modal-form-delete input[name="_method"]').length === 0) {
        form.append('<input type="hidden" name="_method" value="DELETE">');
    }
}

function setupEditForm(formSelector, submitButtonSelector, url, btnText, method = 'PUT') {
    const form = $(formSelector);
    const formBtn = $(submitButtonSelector);

    form.attr('action', url);
    form.attr('method', 'POST');
    formBtn.text(btnText);
    if (form.find('input[name="_method"]').length === 0) {
        form.append(`<input type="hidden" name="_method" value="${method}">`);
    }
}

function setupAddForm(formSelector, submitButtonSelector, actionUrl, btnHtml) {
    const form = $(formSelector);
    const formBtn = $(submitButtonSelector);

    form.attr('action', actionUrl);
    form.attr('method', 'POST');
    formBtn.html(btnHtml);
    form.find('input[name="_method"]').remove();
}


function populateFormFields(formType, fieldValues) {
    const formConfig = formConfigurations[formType];
    
    if (!formConfig) {
        console.error('Form configuration not found for', formType);
        return;
    }

    for (const [selector, fieldName] of Object.entries(formConfig)) {
        const value = fieldValues[fieldName] || '';
        if ($(selector).is('select')) {
            $(selector).val(value).change();
        } else {
            $(selector).val(value);
        }
    }
}

function loadFormData(baseUrl, resourceId, formType) {
    $.ajax({
        url: `${baseUrl}/${resourceId}/get`,
        method: 'GET',
        dataType: 'json',
        success: function(fieldValues) {
            populateFormFields(formType, fieldValues);
        },
        error: function(error) {
            console.error(`Error loading ${formType} data:`, error);
        }
    });
}

function handleDelete(buttonSelector, baseUrl) {
    $(buttonSelector).on('click', function(event) {
        const entityId = $(this).val();
        const url = `${baseUrl}/${entityId}`;
        
        setupDeleteForm(url);
    });
}

function capitalizeFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}

function formatDuration(seconds) {
   if (seconds < 60) {
       return `${seconds} seconds`;
   }
   if (seconds < 3600) {
       const minutes = Math.floor(seconds / 60);
       return `${minutes}m`;
   }
   if (seconds < 86400) {
       const hours = Math.floor(seconds / 3600);
       const minutes = Math.floor((seconds % 3600) / 60);
       return `${hours}h ${minutes}m`;
   }
   const days = Math.floor(seconds / 86400);
   const hours = Math.floor((seconds % 86400) / 3600);
   return `${days}d ${hours}h`;
}

function formatDate(date) {
   const options = { day: 'numeric', month: 'long', year: 'numeric' };
   return new Date(date).toLocaleDateString('en-GB', options);
}

function isToday(day, month, year) {
    const today = new Date();
    return day === today.getDate() && month === today.getMonth() + 1 && year === today.getFullYear();
}

function getActivitiesForDay(activities, day, month, year) {
    return activities.filter(activity => {
        const activityDate = new Date(activity.date);
        return activityDate.getDate() === day && activityDate.getMonth() + 1 === month && activityDate.getFullYear() === year;
    });
}
