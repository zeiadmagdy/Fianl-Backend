import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/js/app.js', // Your main JavaScript file
                'resources/css/app.css', // Your main CSS file
                'node_modules/admin-lte/dist/css/adminlte.min.css', // AdminLTE CSS
                'node_modules/@fullcalendar/core/main.min.css', // FullCalendar Core CSS
                'node_modules/@fullcalendar/daygrid/main.min.css', // FullCalendar Day Grid CSS
                'node_modules/@fullcalendar/interaction/main.min.css', // FullCalendar Interaction CSS
                'node_modules/admin-lte/plugins/jquery/jquery.min.js', // jQuery
                'node_modules/admin-lte/plugins/bootstrap/js/bootstrap.bundle.min.js', // Bootstrap JS
                'node_modules/admin-lte/dist/js/adminlte.min.js', // AdminLTE JS
                'node_modules/@fullcalendar/core/main.min.js', // FullCalendar Core JS
                'node_modules/@fullcalendar/daygrid/main.min.js', // FullCalendar Day Grid JS
                'node_modules/@fullcalendar/interaction/main.min.js', // FullCalendar Interaction JS
            ],
            refresh: true,
        }),
    ],
});
