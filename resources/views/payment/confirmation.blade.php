<!-- resources/views/thankyou.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <title>Payment Confirmation</title>
    <style>
        body {
            background-color: #f1f4f6;
            font-family: 'Roboto', sans-serif;
        }

        /* Container Styling */
        .thank-you-container {
            max-width: 700px;
            margin: 50px auto;
            padding: 30px;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
        }

        /* Header Styling */
        .thank-you-header {
            text-align: center;
            color: #28a745;
            margin-bottom: 30px;
        }

        .thank-you-header h1 {
            font-size: 32px;
            font-weight: 700;
        }

        .thank-you-header p {
            font-size: 18px;
            color: #555555;
        }

        /* Divider Styling */
        .divider {
            height: 1px;
            background-color: #e9ecef;
            margin: 20px 0;
        }

        /* Details Styling */
        .thank-you-details {
            margin-top: 20px;
            color: #444444;
        }

        .thank-you-details p {
            font-size: 18px;
            margin: 10px 0;
        }

        .thank-you-details .detail-label {
            font-weight: 600;
            color: #555555;
        }

        /* Button Styling */
        .action-buttons {
            margin-top: 30px;
            display: flex;
            justify-content: center;
            gap: 20px;
        }

        .print-button {
            background-color: #007bff;
            border: none;
            color: #ffffff;
            font-size: 16px;
            padding: 10px 20px;
            border-radius: 8px;
            transition: background-color 0.3s ease;
        }

        .print-button:hover {
            background-color: #0056b3;
        }

        .back-button {
            background-color: #6c757d;
            border: none;
            color: #ffffff;
            font-size: 16px;
            padding: 10px 20px;
            border-radius: 8px;
            transition: background-color 0.3s ease;
        }

        .back-button:hover {
            background-color: #5a6268;
        }

        /* Icon Styling */
        .icon-container {
            text-align: center;
            margin-bottom: 20px;
        }

        .icon-container i {
            font-size: 50px;
            color: #28a745;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="thank-you-container">
            <!-- Icon and Header -->
            <div class="icon-container">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="thank-you-header">
                <h1>Payment Successful!</h1>
                <p>Thank you for your payment. <br/> transaction has been completed successfully.</p>
            </div>

            <!-- Divider -->
            <div class="divider"></div>

            <!-- Payment Details -->
            <div class="thank-you-details">
                <p><span class="detail-label">Order ID:</span> {{ $orderId }}</p>
                <p><span class="detail-label">Transaction ID:</span> {{ $transactionId }}</p>
            </div>

            <!-- Action Buttons -->
            <div class="action-buttons">
                <button class="print-button" onclick="window.print()">
                    <i class="fas fa-print"></i> Download Invoice
                </button>
                <a href="http://localhost:4200/" class="back-button text-decoration-none">
                    <i class="fas fa-home"></i> Back to Eventoria
                </a>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
