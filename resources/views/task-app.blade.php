<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <title>Task App</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="p-10 max-w-lg mx-auto">
    <div class="bg-gray-300 px-10 py-6 rounded" x-data="taskApp()">
        <form @submit.prevent="submit">
            <input
                type="text"
                class="w-full px-1"
                placeholder="Go to the market..."
                x-model="newTask"
            >
        </form>

        <ul class="list-disc mt-3">
            <template x-for="(task, index) in tasks" :key="index">
                <li>
                    <input type="checkbox" x-model="task.completed">
                    <span x-text="task.body" :class="{ 'line-through' : task.completed }"></span>
                </li>
            </template>
        </ul>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
