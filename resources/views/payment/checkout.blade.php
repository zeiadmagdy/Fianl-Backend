
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
    .checkout-container {
        background-color: #ffffff;
        border: 1px solid #ddd;
        border-radius: 12px;
        padding: 30px;
        max-width: 700px;
        margin: 20px auto;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    .btn-custom {
        background-color: #901b20;
        color: #fff;
        padding: 12px 30px;
        border: none;
        border-radius: 25px;
        cursor: pointer;
        transition: all 0.3s ease-in-out;
        width: 100%;
        margin-top: 15px;
    }

    .btn-custom:hover {
        background-color: #721418;
    }

    .checkout-title {
        font-size: 28px;
        color: #901b20;
        text-align: center;
        margin-bottom: 30px;
    }

    .text-muted {
        text-align: center;
        margin-bottom: 20px;
        font-size: 1.1rem;
    }

    .custom-alerts {
        margin-top: 20px;
    }
</style>

<!-- Checkout Section -->
<div class="checkout-container">
    <!-- Success and Error Alerts -->
    @if ($message = \Session::get('success'))
        <div class="custom-alerts alert alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {!! $message !!}
        </div>
        <?php \Session::forget('success');?>
    @endif

    @if ($message = \Session::get('error'))
        <div class="custom-alerts alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {!! $message !!}
        </div>
        <?php \Session::forget('error');?>
    @endif

    <!-- Checkout Title -->
    <h2 class="checkout-title">Checkout Form</h2>

    <!-- Description -->
    <p class="text-muted">
        Securely pay for our exclusive events using PayMob. Enjoy a seamless and safe payment process with the confidence that your transaction is protected.
    </p>

    <!-- Payment Button -->
    <div class="text-center">
        <form action="{{route('credit')}}" method="POST">
            {{ csrf_field() }}
            <button type="submit" class="btn btn-custom">
                <i class="fa fa-lock me-2"></i> Pay with PayMob
            </button>
        </form>
    </div>
</div>
