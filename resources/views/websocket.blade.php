<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <title>Document</title>
</head>

    

<body>
<main class="d-flex align-center h-100vh">

    <ul id="list-messages" class="px-1 d-flex flex-col">
    </ul>

    <form id="form" class="w-100 d-flex flex-col">
        <span class="pl-1" id="span-typing"></span>
{{--    <label for="input-message">Message:</label>--}}
        <input
            id="input-message"
            class="py-2 pl-1"
            placeholder="Type a message"
            type="text">
    </form>

</main>
</body>
</html>