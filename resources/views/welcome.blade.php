<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css">
</head>
<body class="bg-gray-200 p-4">
    <div class="lg:w-2/4 max-auto py-8 px-6 bg-white rounded-xl">
        <h1 id="typed-text" class="font-bold text-5xl text-center mb-8"></h1>
        <div class="mb-6">
            <form class="flex flex-col space-y-4" action="/" method="post">
                @csrf

                <input type="text" name="title" placeholder="The todo title" class="py-3 px-4 bg-gray-100 rounded-xl">
                <textarea name="description" placeholder="The todo description" class="py-3 px-4 bg-gray-100 rounded-xl"></textarea>
                <button class="w-28 py-4 px-8 bg-green-500 text-white rounded-xl">Add</button>
            </form>
        </div>

        <hr>

        <div class="mt-2">
            @foreach ($todos as $todo)
                <div
                    @class([
                        'py-4 flex item-center border-b border-gray-300 px-3',
                        $todo->isDone ? 'bg-green-200' : ''
                    ])
                >
                    <div class="flex-1 pr-8">
                        <h3 class="text-lg font-semibold">{{ $todo->title }}</h3>
                        <p class="text-gray-500">{{ $todo->description }}</p>
                    </div>

                    <div class="flex space-x-3">
                        <form action="/{{ $todo->id }}" method="post">
                            @csrf
                            @method('PATCH')

                            <button class="py-2 px-2 bg-green-500 text-white rounded-xl">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                </svg>
                            </button>
                        </form>

                        <a href="/{{ $todo->id }}/edit" class="py-2 px-2 bg-blue-500 text-white rounded-xl">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                            </svg>
                        </a>

                        <form action="/{{ $todo->id }}" method="post" onsubmit="return confirmDelete('{{ $todo->title }}', {{ $todo->id }})">
                            @csrf
                            @method('DELETE')
                            <button class="py-2 px-2 bg-red-500 text-white rounded-xl">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div id="deleteModal" class="fixed inset-0 flex items-center justify-center z-50 hidden">
        <div class="absolute inset-0 bg-black opacity-50"></div>
        <div class="bg-white rounded-lg p-4 shadow-md relative">
            <p class="text-lg mb-4">Apakah Anda yakin ingin menghapus tugas ini?</p>
            <div class="flex justify-end space-x-2">
                <button class="px-4 py-2 bg-red-500 text-white rounded-md" onclick="closeModal()">Batal</button>
                <form id="deleteForm" method="post">
                    @csrf
                    @method('DELETE')
                    <button class="px-4 py-2 bg-green-500 text-white rounded-md" onclick="closeModal()">Hapus</button>
                </form>
            </div>
        </div>
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

        function confirmDelete(title, taskId) {
            document.getElementById('deleteModal').classList.remove('hidden');
            const deleteForm = document.getElementById('deleteForm');
            deleteForm.action = '/' + taskId;
            return false;
        }

        function closeModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }

        typeText();
    </script>
</body>
</html>
