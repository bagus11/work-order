<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Card</title>
    <!-- Link to Google Fonts for Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <!-- Link to Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Apply Poppins font to the entire body */
        body {
            font-family: 'Poppins', sans-serif;
        }

        .employee-card {
            width: 340px;
            height: 208px; /* Adjust the height as needed */
            border: 1px solid #ddd;
            border-radius: 8px;
            text-align: center;
            background-image: url('{{ public_path('card/front.png') }}'); /* Set image as background */
            background-size: cover; /* Ensure the image covers the whole card */
            background-position: center; /* Center the image */
            position: relative;
        }
    </style>
</head>
<body>
    <div class="employee-card">
        <div class="row">
            <div class="col-6 offset-6 mt-2" style="margin-top:15px">
                <p style="font-size: 10px;font-weight:bold;">{{$employee->name}}
                    <br><strong style="font-size: 7px;font-weight:100;">{{$employee->title}}</strong>
                </p>
            </div>
        </div>
        <div class="row p-0" style="margin-top:-15px;height:30px !important">
            <div class="col-6 offset-6" style="margin-top:10px;">
                <p style="font-size:8px;color:white;margin-left:37px;margin-top:3px;text-align:left !important">
                    {{$employee->phone}}
                </p>
            </div>
        </div>
        <div class="row p-0" style="margin-top:-20px;height:30px !important">
            <div class="col-6 offset-6" style="margin-top:10px;">
                <p style="font-size:8px;color:white;margin-left:37px;margin-top:3px;text-align:left !important">
                    {{$employee->email}}
                </p>
            </div>
        </div>
       
    </div>

    <!-- Bootstrap JS (optional but recommended for full functionality) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
