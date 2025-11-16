<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather Integration Test</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f8f9fa;
        }
        .weather-card {
            max-width: 500px;
            margin: 2rem auto;
        }
        .weather-icon {
            font-size: 3rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="weather-card card shadow-sm p-3">
            <h3 class="card-title text-center mb-3">Weather for {{ $city }}</h3>

            <form method="GET" class="mb-4 d-flex">
                <input type="text" name="city" value="{{ $city }}" class="form-control me-2" placeholder="Enter city">
                <button class="btn btn-primary">Check</button>
            </form>

            @if(isset($weather['error']))
                <div class="alert alert-danger text-center">{{ $weather['error'] }}</div>
            @else
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between">
                        <strong>Temperature:</strong>
                        <span>{{ $weather['main']['temp'] }} °C</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <strong>Condition:</strong>
                        <span class="text-capitalize">{{ $weather['weather'][0]['description'] }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <strong>Humidity:</strong>
                        <span>{{ $weather['main']['humidity'] }}%</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <strong>Wind:</strong>
                        <span>{{ $weather['wind']['speed'] }} m/s</span>
                    </li>
                </ul>
            @endif
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
