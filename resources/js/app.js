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
            fetch(`/api/eventss?start=${fetchInfo.startStr}&end=${fetchInfo.endStr}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log(data); // Log the data for debugging
                    // Format the data as needed
                    const formattedEvents = data.map(event => {
                        const eventStart = new Date(event.start);
                        const eventEnd = new Date(event.end);
                        const now = new Date();

                        // Determine if the event is in the past or future
                        const isPast = eventEnd < now; // Change to eventStart for single-day events

                        return {
                            id: event.id,
                            title: event.title,
                            start: event.start,
                            end: event.end,
                            description: event.description || '', // Optional description
                            classNames: isPast ? 'event-past' : 'event-future' // Set class based on event date
                        };
                    });
                    successCallback(formattedEvents); // Pass the formatted events to FullCalendar
                })
                .catch(error => {
                    console.error('Error fetching events:', error);
                    failureCallback(error);
                });
        },

        // Handle event clicks
        eventClick: function(info) {
            // Get modal elements
            const modalTitle = document.getElementById('modalEventTitle');
            const modalDescription = document.getElementById('modalEventDescription');
            const modalStart = document.getElementById('modalEventStart');
            const eventDetailsLink = document.getElementById('eventDetailsLink');

            // Set modal content
            modalTitle.innerText = info.event.title;
            modalDescription.innerText = 'Description: ' + info.event.extendedProps.description;
            modalStart.innerText = 'Start: ' + info.event.start.toString();

            // Set the event details link to route to the event show page
            eventDetailsLink.href = `${baseUrl}/${info.event.id}`; // Use the base URL defined in the script tag

            // Show the modal
            const eventModal = new bootstrap.Modal(document.getElementById('eventModal'));
            eventModal.show();
        },

        // Optional: Custom render options for events
        eventDidMount: function(info) {
            const eventElement = info.el;
            eventElement.classList.add('border'); // Add a class for border styling
        }
    });

    // Render the calendar
    calendar.render();
});
