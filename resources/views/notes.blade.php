<x-layouts.portal title="Notes">
    <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
        <div class="px-6 py-4 border-b flex items-center justify-between">
            <p class="text-sm text-gray-500">{{ $notes->count() }} materials available</p>

            <form method="GET" class="flex items-center gap-2">
                <label class="text-sm text-gray-500">Subject:</label>
                <select name="subject" onchange="this.form.submit()"
                        class="text-sm border-gray-200 rounded-lg py-1.5 pl-3 pr-8 text-gray-700 focus:ring-blue-500 focus:border-blue-500">
                    <option value="All" {{ !$subjectFilter || $subjectFilter === 'All' ? 'selected' : '' }}>All</option>
                    @foreach ($subjects as $subject)
                        <option value="{{ $subject }}" {{ $subjectFilter === $subject ? 'selected' : '' }}>
                            {{ $subject }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>

        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                <tr>
                    <th class="px-6 py-3">Title</th>
                    <th class="px-6 py-3">Subject</th>
                    <th class="px-6 py-3">Description</th>
                    <th class="px-6 py-3">Uploaded</th>
                    <th class="px-6 py-3">Download</th>
                    <th class="px-6 py-3">Ask AI</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse ($notes as $note)
                    <tr class="hover:bg-gray-50" x-data="{ modalOpen: false }">
                        <td class="px-6 py-4 font-medium text-gray-800">{{ $note->title }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 rounded text-xs font-medium bg-blue-50 text-blue-700">{{ $note->subject->name }}</span>
                        </td>
                        <td class="px-6 py-4 text-gray-600">{{ $note->description }}</td>
                        <td class="px-6 py-4 text-gray-500 text-xs">{{ $note->created_at->format('M j, Y') }}</td>
                        <td class="px-6 py-4">
                            @if ($note->file_path)
                                <a href="{{ route('notes.download', $note) }}" class="text-blue-600 text-sm font-medium hover:underline">Download</a>
                            @else
                                <span class="text-gray-300 text-xs">—</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <button @click="modalOpen = true"
                                    class="inline-flex items-center gap-1.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium px-3 py-1.5 rounded-lg transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M10 2a1 1 0 011 1v1.05A8.001 8.001 0 0117.95 11H19a1 1 0 110 2h-1.05A8.001 8.001 0 0111 19.95V21a1 1 0 11-2 0v-1.05A8.001 8.001 0 012.05 13H1a1 1 0 110-2h1.05A8.001 8.001 0 019 4.05V3a1 1 0 011-1z"/>
                                </svg>
                                Study with AI
                            </button>

                            <!-- Modal -->
                            <div x-show="modalOpen" x-cloak
                                 class="fixed inset-0 z-50 flex items-center justify-center"
                                 style="display: none;">
                                <div class="absolute inset-0 bg-black/40" @click="modalOpen = false"></div>

                                <div x-data="{
                                        messages: [],
                                        question: '',
                                        loading: false,
                                        send() {
                                            if (!this.question.trim() || this.loading) return;
                                            const q = this.question;
                                            this.messages.push({ role: 'user', text: q });
                                            this.question = '';
                                            this.loading = true;
                                            fetch('{{ route('notes.ask', $note) }}', {
                                                method: 'POST',
                                                headers: {
                                                    'Content-Type': 'application/json',
                                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                                },
                                                body: JSON.stringify({ question: q })
                                            })
                                            .then(r => r.json())
                                            .then(data => {
                                                this.messages.push({ role: 'ai', text: data.answer });
                                                this.loading = false;
                                                this.$nextTick(() => this.$refs.scrollArea.scrollTop = this.$refs.scrollArea.scrollHeight);
                                            })
                                            .catch(() => {
                                                this.messages.push({ role: 'ai', text: 'Something went wrong. Try again.' });
                                                this.loading = false;
                                            });
                                        }
                                    }"
                                    class="relative bg-white rounded-xl shadow-xl w-full max-w-lg h-[600px] flex flex-col z-10">

                                    <!-- Header -->
                                    <div class="px-5 py-4 border-b flex items-center justify-between">
                                        <div>
                                            <p class="text-sm font-semibold text-gray-800">Study with AI</p>
                                            <p class="text-xs text-gray-500">{{ $note->title }}</p>
                                        </div>
                                        <button @click="modalOpen = false" class="text-gray-400 hover:text-gray-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                            </svg>
                                        </button>
                                    </div>

                                    <!-- Chat area -->
                                    <div x-ref="scrollArea" class="flex-1 overflow-y-auto px-5 py-4 space-y-3">
                                        <template x-if="messages.length === 0">
                                            <p class="text-sm text-gray-400 text-center mt-8">
                                                Ask anything about "{{ $note->title }}" — I'll answer using only this note.
                                            </p>
                                        </template>
                                        <template x-for="(m, i) in messages" :key="i">
                                            <div :class="m.role === 'user' ? 'flex justify-end' : 'flex justify-start'">
                                                <div :class="m.role === 'user' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-800'"
                                                     class="max-w-[80%] rounded-lg px-3 py-2 text-sm" x-text="m.text"></div>
                                            </div>
                                        </template>
                                        <div x-show="loading" class="flex justify-start">
                                            <div class="bg-gray-100 text-gray-400 rounded-lg px-3 py-2 text-sm">Thinking...</div>
                                        </div>
                                    </div>

                                    <!-- Input -->
                                    <div class="px-5 py-4 border-t flex items-center gap-2">
                                        <input type="text" x-model="question" @keydown.enter="send()"
                                               placeholder="Ask a question about this note..."
                                               class="flex-1 text-sm border-gray-200 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                                        <button @click="send()" :disabled="loading"
                                                class="bg-blue-600 hover:bg-blue-700 disabled:opacity-50 text-white text-sm font-medium px-4 py-2 rounded-lg">
                                            Send
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-6 py-8 text-center text-gray-400">No notes available yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-layouts.portal>