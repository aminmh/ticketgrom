<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{asset('css/app.css')}}">

    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }
    </style>
</head>

<body>
    <div id="app">
        <div class="container">
            <h1>Home</h1>
        </div>
    </div>
</body>

</html>

<script src="{{asset('js/app.js')}}"></script>

<script>
    axios.get('/api/user');
    Echo.private('message.for.me.2').notification((notification) => {
        console.log(notification);
    });
    // Echo.private('tickets.inbox.4').notification((notification) => {
    //     console.log(notification);
    // });
    // axios.get("/sanctum/csrf-cookie").then(res => {

    // axios.post('/user/login', {
    //     username: "damion59",
    //     password: "12345678"
    // }).then(result => {
    //     console.log(result);
    //     // Echo.private('tickets.inbox').notification((notification) => {
    //     //     console.log(notification.type);
    //     // });

    // }).catch(err => console.error(err))
    // })
</script>
