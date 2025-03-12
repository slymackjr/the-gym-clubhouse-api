<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>4JS Fitness Center Statistics</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
        }
        .chart-container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <h1>4JS FITNESS CENTER STATISTICS FOR THE YEAR</h1>
    <div class="chart-container">
        {!! $chart->container() !!}
    </div>
    {!! $chart->script() !!}
</body>
</html>
