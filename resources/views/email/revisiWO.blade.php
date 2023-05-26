<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <p style="font-size:12px">
        Dear Head {{$postEmail['headDepartement']}}, <br>
        Work order transaction with request code {{$post['request_code']}} has undergone revision,
    </p>
    <p style="font-size:12px;margin-left:10px;margin-top:10px">
        Request By   : {{$postEmail['request_by']}} <br>
        PIC          : {{$postEmail['pic']}} <br>
        Request Code : {{$post['request_code']}} <br>
        Request Type : {{$post['request_type']}} <br>
        Categories : {{$postEmail['categories']}} <br>
        Problem Type : {{$postEmail['problem_type']}} <br>
        WO Status : <b style="font-size:12px;margin-left:10px;margin-top:10px"> Doesn't Match </b> <br>
        <br>
    </p>
    <p style="font-size:12px">
        For detail of the work order transaction, please click  <a href="{{ url('work_order_list')}}">here</a> <br> 
       Thank you for your cooperation
    </p>
</body>
</html>