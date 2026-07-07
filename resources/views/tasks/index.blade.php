<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>To-Do List</title>
    <script>
        // Apply saved theme before paint to avoid a flash
        (function () {
            const stored = localStorage.getItem('theme');
            const dark = stored ? stored === 'dark' : window.matchMedia('(prefers-color-scheme: dark)').matches;
            document.documentElement.classList.toggle('dark', dark);
        })();
    </script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gray-100 px-4 py-10 text-gray-900 transition-colors dark:bg-gray-900 dark:text-gray-100">
    <div class="mx-auto max-w-lg animate-pop-in overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-black/5 transition-colors dark:bg-gray-800 dark:ring-white/10">
        <div class="flex items-center justify-between border-b border-gray-100 p-6 dark:border-gray-700">
            <h1 class="text-xl font-semibold">📝 To-Do List</h1>
            <div class="flex items-center gap-1">
                <button
                    id="theme-toggle"
                    type="button"
                    aria-label="Toggle dark mode"
                    class="rounded-lg p-2 text-gray-500 transition-colors hover:bg-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                >
                    <!-- Moon: shown in light mode -->
                    <svg class="block h-5 w-5 dark:hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z" />
                    </svg>
                    <!-- Sun: shown in dark mode -->
                    <svg class="hidden h-5 w-5 dark:block" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="4" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 2v2m0 16v2m10-10h-2M4 12H2m15.07-7.07l-1.42 1.42M6.34 17.66l-1.41 1.41m12.73 0l-1.41-1.41M6.34 6.34L4.93 4.93" />
                    </svg>
                </button>
                <button
                    id="feedback-open"
                    type="button"
                    aria-label="Send feedback"
                    class="rounded-lg p-2 text-gray-500 transition-colors hover:bg-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                >
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z" />
                    </svg>
                </button>
            </div>
        </div>

        @if (session('feedback_status'))
            <div class="animate-slide-in border-b border-green-100 bg-green-50 px-6 py-3 text-sm text-green-700 dark:border-green-900 dark:bg-green-900/30 dark:text-green-300">
                {{ session('feedback_status') }}
            </div>
        @endif

        <form class="flex gap-2 px-6 py-4" action="{{ route('tasks.store') }}" method="POST">
            @csrf
            <input
                type="text"
                name="title"
                maxlength="255"
                placeholder="Add a new task..."
                autofocus
                class="flex-1 rounded-lg border border-gray-300 px-3 py-2.5 text-sm transition-colors focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 dark:placeholder-gray-400"
            >
            <button type="submit" class="rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-medium text-white transition-colors hover:bg-blue-700 active:scale-95">
                Add
            </button>
        </form>

        @error('title')
            <div class="px-6 pb-2 text-sm text-red-500">{{ $message }}</div>
        @enderror

        <ul class="px-6 pb-4">
            @forelse ($tasks as $task)
                <li
                    class="flex animate-slide-in items-center gap-3 border-b border-gray-100 py-3 last:border-none dark:border-gray-700"
                    style="animation-delay: {{ $loop->index * 60 }}ms"
                >
                    <form action="{{ route('tasks.toggle', $task) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="text-lg leading-none transition-transform hover:scale-125 active:scale-90">{{ $task->completed ? '✅' : '⬜' }}</button>
                    </form>
                    <span class="flex-1 transition-colors duration-300 {{ $task->completed ? 'text-gray-400 line-through dark:text-gray-500' : '' }}">{{ $task->title }}</span>
                    <form action="{{ route('tasks.destroy', $task) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-sm font-medium text-red-500 transition-colors hover:text-red-700 active:scale-95">Delete</button>
                    </form>
                </li>
            @empty
                <li class="py-6 text-center text-gray-400 dark:text-gray-500">No tasks yet. Add one above!</li>
            @endforelse
        </ul>
    </div>

    {{-- Feedback modal --}}
    <div
        id="feedback-modal"
        data-open="{{ $errors->hasAny(['message', 'rating']) ? '1' : '0' }}"
        class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 p-4"
    >
        <div class="w-full max-w-md animate-pop-in rounded-xl bg-white p-6 shadow-xl dark:bg-gray-800">
            <div class="mb-4 flex items-center justify-between">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Send feedback</h2>
                <button type="button" data-feedback-close aria-label="Close" class="rounded p-1 text-gray-400 transition-colors hover:text-gray-700 dark:hover:text-gray-200">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form action="{{ route('feedback.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="rating" class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">Rating (optional)</label>
                    <select
                        id="rating"
                        name="rating"
                        class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm transition-colors focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100"
                    >
                        <option value="">No rating</option>
                        <option value="5" @selected(old('rating') == 5)>★★★★★ — Excellent</option>
                        <option value="4" @selected(old('rating') == 4)>★★★★ — Good</option>
                        <option value="3" @selected(old('rating') == 3)>★★★ — Okay</option>
                        <option value="2" @selected(old('rating') == 2)>★★ — Poor</option>
                        <option value="1" @selected(old('rating') == 1)>★ — Bad</option>
                    </select>
                </div>
                <div>
                    <label for="message" class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">Message</label>
                    <textarea
                        id="message"
                        name="message"
                        rows="4"
                        maxlength="1000"
                        required
                        placeholder="Tell us what you think..."
                        class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm transition-colors focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 dark:placeholder-gray-400"
                    >{{ old('message') }}</textarea>
                    @error('message')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" data-feedback-close class="rounded-lg px-4 py-2.5 text-sm font-medium text-gray-600 transition-colors hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700">
                        Cancel
                    </button>
                    <button type="submit" class="rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-medium text-white transition-colors hover:bg-blue-700 active:scale-95">
                        Send
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
