@php
    $statusColors = [
        'queued'     => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-500/10 dark:text-yellow-400',
        'processing' => 'bg-blue-100 text-blue-800 dark:bg-blue-500/10 dark:text-blue-400',
        'completed'  => 'bg-green-100 text-green-800 dark:bg-green-500/10 dark:text-green-400',
        'failed'     => 'bg-red-100 text-red-800 dark:bg-red-500/10 dark:text-red-400',
    ];
    $statusClass = $statusColors[$record->status] ?? 'bg-gray-100 text-gray-800';
@endphp

<x-filament-panels::page>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Left: image + meta --}}
        <div class="lg:col-span-1 space-y-4">
            <div class="rounded-xl border border-gray-200 dark:border-white/10 bg-white dark:bg-gray-900 p-4 shadow-sm">
                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-3">Uploaded Image</h3>
                @if ($record->image_path)
                    <img
                        src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($record->image_path) }}"
                        alt="{{ $record->title }}"
                        class="w-full h-auto rounded-lg border border-gray-200 dark:border-white/10 object-contain"
                    />
                @else
                    <p class="text-sm text-gray-500">No image uploaded.</p>
                @endif
            </div>

            <div class="rounded-xl border border-gray-200 dark:border-white/10 bg-white dark:bg-gray-900 p-4 shadow-sm space-y-3">
                <div>
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Title</h3>
                    <p class="mt-1 text-base font-semibold text-gray-900 dark:text-gray-100">
                        {{ $record->title }}
                    </p>
                </div>

                <div>
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</h3>
                    <span class="mt-1 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusClass }}">
                        {{ ucfirst($record->status) }}
                    </span>
                </div>

                @if ($record->user)
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Submitted By</h3>
                        <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $record->user->name }}</p>
                    </div>
                @endif

                <div>
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Submitted At</h3>
                    <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                        {{ $record->created_at?->format('M d, Y H:i') }}
                    </p>
                </div>

                @if ($record->processed_at)
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Processed At</h3>
                        <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                            {{ $record->processed_at->format('M d, Y H:i') }}
                        </p>
                    </div>
                @endif
            </div>

            @if ($record->notes)
                <div class="rounded-xl border border-gray-200 dark:border-white/10 bg-white dark:bg-gray-900 p-4 shadow-sm">
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Notes</h3>
                    <p class="text-sm text-gray-900 dark:text-gray-100 whitespace-pre-wrap">{{ $record->notes }}</p>
                </div>
            @endif
        </div>

        {{-- Right: extracted text --}}
        <div class="lg:col-span-2">
            <div class="rounded-xl border border-gray-200 dark:border-white/10 bg-white dark:bg-gray-900 p-4 shadow-sm h-full">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100">Extracted Text</h3>
                    @if ($record->status === 'completed' && $record->extracted_text)
                        <button
                            type="button"
                            onclick="navigator.clipboard.writeText(document.getElementById('ocr-text').innerText)"
                            class="text-xs px-2.5 py-1 rounded-md border border-gray-300 dark:border-white/10 hover:bg-gray-50 dark:hover:bg-white/5"
                        >
                            Copy
                        </button>
                    @endif
                </div>

                @if ($record->status === 'queued' || $record->status === 'processing')
                    <div class="flex items-center gap-3 p-4 rounded-lg bg-blue-50 dark:bg-blue-500/10 text-blue-800 dark:text-blue-300">
                        <x-filament::icon icon="heroicon-o-clock" class="w-5 h-5" />
                        <div>
                            <p class="font-medium">Your task is in queue.</p>
                            <p class="text-sm opacity-80">We'll notify you as soon as the OCR result is ready.</p>
                        </div>
                    </div>
                @elseif ($record->status === 'failed')
                    <div class="p-4 rounded-lg bg-red-50 dark:bg-red-500/10 text-red-800 dark:text-red-300">
                        <p class="font-medium">Processing failed.</p>
                        @if ($record->error)
                            <pre class="mt-2 text-xs whitespace-pre-wrap">{{ $record->error }}</pre>
                        @endif
                    </div>
                @else
                    <pre id="ocr-text" class="whitespace-pre-wrap text-sm text-gray-900 dark:text-gray-100 bg-gray-50 dark:bg-white/5 rounded-lg p-4 max-h-[600px] overflow-auto font-mono">{{ $record->extracted_text ?: 'No text was extracted.' }}</pre>
                @endif
            </div>
        </div>
    </div>
</x-filament-panels::page>
