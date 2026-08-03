<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Student Portal' }} - Kaunda Square Secondary School</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans antialiased">
    <div class="flex min-h-screen">
        <aside class="w-64 bg-[#0B1739] text-white flex flex-col shrink-0">
            <div class="px-6 py-6 border-b border-white/10">
                <p class="font-semibold text-sm tracking-wide">Kaunda Square Secondary School</p>
                <p class="text-xs text-blue-300 mt-0.5">Student Portal</p>
            </div>

            <div class="px-6 py-6 border-b border-white/10 flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-blue-500/20 flex items-center justify-center text-sm font-medium">
                    {{ substr(auth()->user()->first_name, 0, 1) }}{{ substr(auth()->user()->last_name, 0, 1) }}
                </div>
                <div>
                    <p class="text-sm font-medium">{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</p>
                    <p class="text-xs text-white/50">{{ auth()->user()->class }} - {{ auth()->user()->stream }}</p>
                </div>
            </div>

            @php
                $navItems = [
                    ['label' => 'Dashboard', 'route' => 'dashboard'],
                    ['label' => 'Timetable', 'route' => 'timetable'],
                    ['label' => 'Grades', 'route' => 'grades'],
                    ['label' => 'Notes', 'route' => 'notes'],
                ];
            @endphp

            <nav class="flex-1 px-3 py-4 space-y-1">
                @foreach ($navItems as $item)
                    <a href="{{ route($item['route']) }}"
                       class="block px-3 py-2 rounded-lg text-sm font-medium transition
                              {{ request()->routeIs($item['route']) ? 'bg-blue-600 text-white' : 'text-white/70 hover:bg-white/5 hover:text-white' }}">
                        {{ $item['label'] }}
                    </a>
                @endforeach
            </nav>

            <div class="px-6 py-4 border-t border-white/10">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-sm text-white/60 hover:text-white transition">Sign Out</button>
                </form>
            </div>
        </aside>

        <div class="flex-1 flex flex-col">
            <header class="bg-white border-b px-8 py-5">
                <h1 class="text-lg font-semibold text-gray-800">{{ $title ?? 'Dashboard' }}</h1>
            </header>
            <main class="flex-1 p-8">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>