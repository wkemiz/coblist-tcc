<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COBLIST</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .navbar {
    background: #c5cae9;
    color: #4a148c;
    padding: 15px;

    display: flex;
    align-items: center;
    gap: 10px;

    font-weight: 700;
    font-size: 20px;
}

.navbar img {
    width: var(--logo-size, 35px);
    height: auto;
}

.navbar .title {
    display: inline-block;
}

    

        .container {
            margin: 30px auto;
            width: 90%;
            max-width: 700px;
            background: #fff;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        input, select {
            width: 100%;
            padding: 10px;
            margin: 8px 0 20px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        button {
            padding: 10px 15px;
            background: #28a745;
            border: none;
            color: #fff;
            cursor: pointer;
            border-radius: 5px;
            font-size: 16px;
        }

        button:hover {
            background: #218838;
        }

        a {
            color: #007BFF;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <div class="navbar">
    <img src="{{ asset('images/logo.png') }}" alt="Logo">
    <span class="title">COBLIST</span>
</div>

    @yield('content')

</body>
</html>