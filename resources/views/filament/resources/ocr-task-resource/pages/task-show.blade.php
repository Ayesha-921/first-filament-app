@php
    $imageUrl = $record->image_path
        ? \Illuminate\Support\Facades\Storage::disk('public')->url($record->image_path)
        : null;

    $statusColors = [
        'queued'     => 'bg-yellow-100 text-yellow-800 ring-yellow-200 dark:bg-yellow-500/10 dark:text-yellow-400 dark:ring-yellow-500/20',
        'processing' => 'bg-blue-100 text-blue-800 ring-blue-200 dark:bg-blue-500/10 dark:text-blue-400 dark:ring-blue-500/20',
        'completed'  => 'bg-emerald-100 text-emerald-800 ring-emerald-200 dark:bg-emerald-500/10 dark:text-emerald-400 dark:ring-emerald-500/20',
        'failed'     => 'bg-red-100 text-red-800 ring-red-200 dark:bg-red-500/10 dark:text-red-400 dark:ring-red-500/20',
    ];
    $statusClass = $statusColors[$record->status] ?? 'bg-gray-100 text-gray-800';
@endphp

<x-filament-panels::page>
    <div class="max-w-2xl mx-auto w-full">

        {{-- Main card exactly like Create page --}}
        <div class="rounded-xl bg-white dark:bg-gray-900 shadow-sm ring-1 ring-gray-950/5 dark:ring-white/10">

            {{-- Section header matching Create page "OCR Submission" --}}
            <div class="px-6 py-5 border-b border-gray-100 dark:border-white/5 bg-gray-50/50 dark:bg-gray-800/30 rounded-t-xl">
                <h2 class="text-base font-semibold text-gray-900 dark:text-white">
                    OCR Submission
                </h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Upload an image to extract its text using the Flask AI service.
                </p>
                <div class="mt-2 inline-flex items-center gap-2">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ring-1 ring-inset {{ $statusClass }}">
                        {{ ucfirst($record->status) }}
                    </span>
                    @if ($record->processed_at)
                        <span class="text-xs text-gray-400 dark:text-gray-500">Processed {{ $record->processed_at->diffForHumans() }}</span>
                    @endif
                </div>
            </div>

            {{-- Card body matching form fields --}}
            <div class="px-6 py-6 space-y-6">

                {{-- Title field (read-only) --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Title
                    </label>
                    <div class="block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-3 py-2 text-sm text-gray-900 dark:text-white shadow-sm">
                        {{ $record->title }}
                    </div>
                </div>

                {{-- Image field (like form FileUpload) --}}
                @if ($imageUrl)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Image
                        </label>
                        <div class="rounded-xl border-2 border-dashed border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-800/50 p-6 flex justify-center">
                            <img
                                src="{{ $imageUrl }}"
                                alt="{{ $record->title }}"
                                class="max-h-96 w-auto rounded-lg object-contain shadow-sm"
                            />
                        </div>
                    </div>
                @endif

                {{-- Status / queue message --}}
                @if ($record->status === 'queued' || $record->status === 'processing')
                    <div class="flex items-center gap-3 p-4 rounded-xl bg-blue-50 dark:bg-blue-500/10 text-blue-800 dark:text-blue-300 ring-1 ring-inset ring-blue-200 dark:ring-blue-500/20">
                        <x-filament::icon icon="heroicon-o-clock" class="w-5 h-5 flex-shrink-0" />
                        <div>
                            <p class="font-medium">Your task is in queue.</p>
                            <p class="text-sm opacity-80">We'll notify you as soon as the OCR result is ready.</p>
                        </div>
                    </div>
                @elseif ($record->status === 'failed')
                    <div class="p-4 rounded-xl bg-red-50 dark:bg-red-500/10 text-red-800 dark:text-red-300 ring-1 ring-inset ring-red-200 dark:ring-red-500/20">
                        <p class="font-medium">Processing failed.</p>
                        @if ($record->error)
                            <pre class="mt-2 text-xs whitespace-pre-wrap font-mono">{{ $record->error }}</pre>
                        @endif
                    </div>
                @else
                    {{-- Extracted Text field with icon + copy button + bordered box --}}
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center gap-2">
                                <x-filament::icon icon="heroicon-o-document-text" class="w-4 h-4 text-gray-500 dark:text-gray-400" />
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Extracted Text
                                </label>
                            </div>

                            @if ($record->extracted_text)
                                <button
                                    type="button"
                                    x-data="{ copied: false }"
                                    x-on:click="navigator.clipboard.writeText(document.getElementById('ocr-text').innerText); copied = true; setTimeout(() =&gt; copied = false, 1500)"
                                    class="inline-flex items-center gap-1.5 text-xs font-medium text-primary-600 hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300 transition bg-primary-50 dark:bg-primary-500/10 px-2.5 py-1.5 rounded-md"
                                >
                                    <template x-if="!copied">
                                        <span class="inline-flex items-center gap-1">
                                            <x-filament::icon icon="heroicon-o-clipboard-document" class="w-3.5 h-3.5" />
                                            Copy
                                        </span>
                                    </template>
                                    <template x-if="copied">
                                        <span class="inline-flex items-center gap-1 text-emerald-600 dark:text-emerald-400">
                                            <x-filament::icon icon="heroicon-o-check" class="w-3.5 h-3.5" />
                                            Copied!
                                        </span>
                                    </template>
                                </button>
                            @endif
                        </div>

                        <div class="block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-3 py-2 text-sm text-gray-900 dark:text-white shadow-sm min-h-[6rem]">
                            <pre
                                id="ocr-text"
                                class="font-sans text-sm leading-relaxed text-gray-800 dark:text-gray-200 m-0 text-left whitespace-pre-wrap break-words"
                                style="white-space: pre-wrap; word-wrap: break-word; overflow-wrap: anywhere;"
                            >{{ $record->extracted_text ?: 'No text was extracted.' }}</pre>
                        </div>
                    </div>
                @endif

            </div>

            {{-- Card footer actions --}}
            <div class="px-6 py-4 border-t border-gray-100 dark:border-white/5 bg-gray-50/50 dark:bg-gray-800/30 rounded-b-xl flex items-center justify-end gap-3">
                <a
                    href="{{ \App\Filament\Resources\OcrTaskResource::getUrl('edit', ['record' => $record]) }}"
                    class="inline-flex items-center justify-center gap-2 rounded-lg bg-white dark:bg-gray-800 px-4 py-2 text-sm font-semibold text-gray-700 dark:text-gray-200 shadow-sm ring-1 ring-gray-300 dark:ring-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 transition"
                >
                    <x-filament::icon icon="heroicon-o-pencil-square" class="w-4 h-4" />
                    Edit
                </a>

                <a
                    href="{{ \App\Filament\Resources\OcrTaskResource::getUrl('edit', ['record' => $record]) }}"
                    class="inline-flex items-center justify-center gap-2 rounded-lg bg-red-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 transition"
                >
                    <x-filament::icon icon="heroicon-o-trash" class="w-4 h-4" />
                    Delete
                </a>
            </div>

        </div>

    </div>
</x-filament-panels::page>
