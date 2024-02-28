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
        Dear Head {{$post['request_for']}} Departement, <br>
        Here we attach the new work order as follows
    </p>
    <p style="font-size:12px;margin-left:10px;margin-top:10px">
        PIC : {{$postEmail['user_pic']}} <br>
        Request By : {{$postEmail['PIC']}} <br>
        Request Code : {{$post['request_code']}} <br>
        Request Type : {{$post['request_type']}} <br>
        Categories : {{$postEmail['categories']}} <br>
        Problem Type : {{$postEmail['problem_type']}} <br>
        Subject      : {{$post['subject']}} <br>
        Additional Info :  {{$post['add_info']}}<br>  
        WO Status : <b style="font-size:12px;margin-left:10px;margin-top:10px"> On Progress </b> <br>
    </p>
    <p style="font-size:12px">
        For details of the work order transaction, please click  <a href="{{ url('work_order_list')}}">here</a> <br> 
        That's all we can say, thank you for your cooperation
    </p>
</body>
</html>