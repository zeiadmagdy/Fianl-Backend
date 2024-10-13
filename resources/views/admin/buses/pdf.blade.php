<!DOCTYPE html>
<html lang="ar"> <!-- Changed to Arabic language -->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تفاصيل الحافلة - {{ $bus->name }}</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap');

        body {
            font-family: 'Cairo', sans-serif; /* Ensure correct Arabic font */
            direction: rtl; /* Set the text direction to RTL */
            text-align: right; /* Align text to the right */
            margin: 20px; /* Add some margin for better spacing */
            background-color: #f9f9f9; /* Light background for better contrast */
        }
        h1 {
            color: #007bff; /* Blue color for main title */
            font-size: 24px; /* Larger size for main title */
            margin-bottom: 20px; /* Space below main title */
        }
        h2 {
            color: #333; /* Dark color for subheadings */
            font-size: 20px; /* Size for subheadings */
            margin-top: 20px; /* Space above subheadings */
            margin-bottom: 10px; /* Space below subheadings */
        }
        .card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Enhanced shadow */
            background-color: #fff; /* White background for cards */
            display: inline-block; /* Allow side-by-side display */
            width: 45%; /* Set card width */
            vertical-align: top; /* Align cards vertically */
        }
        .driver-info {
            display: flex; /* Use flexbox for layout */
            align-items: center; /* Center items vertically */
        }
        .driver-image {
            flex: 0 0 auto; /* Don't allow the image to grow or shrink */
            margin-right: 15px; /* Space between image and text */
        }
        .driver-image img {
            max-width: 100px; /* Set max width for the image */
            border-radius: 8px; /* Rounded corners for the image */
        }
        .driver-details {
            flex: 1; /* Allow text to take up remaining space */
            margin-right: 50px; /* Space between image and text */
        }
        ul {
            list-style-type: none; /* Remove bullet points */
            padding: 0; /* Remove padding */
        }
        li {
            margin-bottom: 10px; /* Space between list items */
            margin-right: 50px; /* Space between list items and icons */
        }
        .points {
            margin-top: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px; /* Space above the table */
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: right; /* Align table content to the right */
        }
        th {
            background-color: #007bff; /* Blue background for table header */
            color: white; /* White text for header */
        }
        tr:nth-child(even) {
            background-color: #f2f2f2; /* Light gray background for even rows */
        }

        
    </style>
</head>
<body>
    <h1>تفاصيل الحافلة</h1>

    <div class="card">
        <h2>معلومات الحافلة</h2>
        <ul>
            <li><strong>اسم الحافلة:</strong> {{ $bus->name }}</li>
            <li><strong>رقم الحافلة:</strong> {{ $bus->bus_number }}</li>
            <li><strong>سعة الحافلة:</strong> {{ $bus->capacity }}</li>
        </ul>
    </div>

    <div class="card">
        <h2>معلومات السائق</h2>
        <div class="driver-info">
            
            <div class="driver-details">
                @if ($bus->driver)
                    <p><strong>الاسم:</strong> {{ $bus->driver->name }}</p>
                    <p><strong>الهاتف:</strong> {{ $bus->driver->phone_number }}</p>
                @else
                    <p>لا يوجد سائق معين لهذه الحافلة بعد.</p>
                @endif
            </div>
        </div>
    </div>

    <h2>النقاط</h2>
    <table>
        <thead>
            <tr>
                <th>الاسم</th>
                <th>الوصف</th>
                <th>وقت الوصول</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($bus->points->sortBy('arrived_time') as $point)
                <tr>
                    <td>{{ $point->name }}</td>
                    <td>{{ $point->description }}</td>
                    <td>{{ $point->arrived_time }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
