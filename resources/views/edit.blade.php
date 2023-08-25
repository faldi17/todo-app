<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Todo - Laravel</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css">
</head>
<body class="bg-gray-200 p-4">
    <div class="lg:w-2/4 max-auto py-8 px-6 bg-white rounded-xl">
        <h1 class="font-bold text-3xl mb-4">Edit Todo</h1>
        <form class="flex flex-col space-y-4" action="/{{ $todo->id }}/updateTodo" method="post">
            @csrf
            @method('PUT')

            <input type="text" name="title" placeholder="The todo title" value="{{ $todo->title }}" class="py-3 px-4 bg-gray-100 rounded-xl">
            <textarea name="description" placeholder="The todo description" class="py-3 px-4 bg-gray-100 rounded-xl">{{ $todo->description }}</textarea>
            <div class="flex justify-end space-x-2">
                <button type="submit" class="py-2 px-4 bg-green-500 text-white rounded-md">Update</button>
                <a href="/" class="py-2 px-4 bg-gray-500 text-white rounded-md">Cancel</a>
            </div>
        </form>
    </div>

    <script>
        const textToType = "Todo App";
        const typedTextElement = document.getElementById('typed-text');
        let currentIndex = 0;

        const colors = ["#FF0000", "#00FF00", "#0000FF", "#FF00FF"];
        let colorIndex = 0;

        function typeText() {
            if (currentIndex < textToType.length) {
                typedTextElement.textContent += textToType[currentIndex];
                currentIndex++;
                setTimeout(typeText, 100);
            } else {
                changeColor();
            }
        }

        function changeColor() {
            typedTextElement.style.color = colors[colorIndex];
            colorIndex = (colorIndex + 1) % colors.length;
            setTimeout(changeColor, 1000);
        }

        typeText();
    </script>
</body>
</html>
