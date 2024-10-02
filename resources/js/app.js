import 'admin-lte/dist/css/adminlte.min.css';
import 'font-awesome/css/font-awesome.css';
import 'bootstrap/dist/css/bootstrap.min.css';
import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import interactionPlugin from '@fullcalendar/interaction';

document.addEventListener('DOMContentLoaded', function () {
    const calendarEl = document.getElementById('calendar');

    // Initialize the calendar
    const calendar = new Calendar(calendarEl, {
        plugins: [dayGridPlugin, interactionPlugin],
        initialView: 'dayGridMonth',

        // Fetch events from the API
        events: function(fetchInfo, successCallback, failureCallback) {
            let categoryId = document.getElementById('categoryFilter').value; // Get selected category
            let url = categoryId 
                ? `/api/eventsss?start=${fetchInfo.startStr}&end=${fetchInfo.endStr}&category_id=${categoryId}` 
                : `/api/eventss?start=${fetchInfo.startStr}&end=${fetchInfo.endStr}`; // Default fetch for all events

            console.log('API Request URL:', url); // Log the request URL

            fetch(url)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Fetched events:', data); // Log the fetched events for debugging
                    successCallback(data);
                })
                .catch(error => {
                    console.error('Error fetching events:', error);
                    failureCallback(error);
                });
        },

        // Handle event clicks
        eventClick: function(info) {
            const modalTitle = document.getElementById('modalEventTitle');
            const modalDescription = document.getElementById('modalEventDescription');
            const modalStart = document.getElementById('modalEventStart');
            const eventDetailsLink = document.getElementById('eventDetailsLink');

            modalTitle.innerText = info.event.title;
            modalDescription.innerText = 'Description: ' + info.event.extendedProps.description;
            modalStart.innerText = 'Start: ' + info.event.start.toLocaleString(); // Format date for display

            eventDetailsLink.href = `${baseUrl}/${info.event.id}`;
            const eventModal = new bootstrap.Modal(document.getElementById('eventModal'));
            eventModal.show();
        },

        // Optional: Custom render options for events
        eventDidMount: function(info) {
            const eventElement = info.el;
            // Add classes based on event type (past or future)
            const currentDate = new Date();
            const eventDate = info.event.start;

            // Determine past or future event and apply classes
            if (eventDate < currentDate) {
                eventElement.classList.add('event-past'); // Add past event styling
            } else {
                eventElement.classList.add('event-future'); // Add future event styling
            }
            eventElement.classList.add('border'); // Ensure all events have a border
        }
    });

    // Render the calendar
    calendar.render();

    // Add event listener for category filter change
    document.getElementById('categoryFilter').addEventListener('change', function() {
        const categoryId = this.value;
        if (categoryId) {
            calendar.refetchEvents(); // Refetch events only if a valid category is selected
        }
    });
});
