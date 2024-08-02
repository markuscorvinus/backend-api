<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>

    <script>
        function getCookie(name){
        const value = `; ${document.cookie}`;
        const parts = value.split(`; ${name}=`);
        if (parts.length === 2) {
            return parts.pop().split(';').shift();
        }
    }
    
    function login(){
        const csrfToken = decodeURIComponent(getCookie('XSRF-TOKEN'));
        console.log(`${csrfToken}`  );

        return fetch('/login', {
            headers: {
                'content-type': 'application/json',
                'accept': 'application/json',
                'x-xsrf-token': csrfToken
            },
            credentials: 'include',
            method: "POST",
            body: JSON.stringify({
                email: "hackerben@test.com",
                password: "hackerben"
            })
                
        })
    }

    fetch('/sanctum/csrf-cookie', {
        headers: {
            'content-type': 'application/json',
            'accept': 'application/json'
        },
        credentials: 'include'
    }).then(() => {
        return login();
    });

    </script>

</body>

</html>