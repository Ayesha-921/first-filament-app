<x-filament-panels::page>
    @php
        $user = auth()->user();
        $avatarUrl = $user->avatar
            ? \Illuminate\Support\Facades\Storage::url($user->avatar)
            : null;
        $initials = strtoupper(substr($user->name ?? 'U', 0, 1));
    @endphp

    {{-- Avatar preview card --}}
    <div class="flex flex-col items-center gap-3 p-6 mb-4 rounded-xl bg-white dark:bg-gray-900 shadow-sm border border-gray-200 dark:border-gray-700">

        {{-- Circular avatar --}}
        <div class="relative" style="width:96px;height:96px;">
            @if ($avatarUrl)
                <div style="width:96px;height:96px;border-radius:9999px;overflow:hidden;flex-shrink:0;">
                    <img
                        src="{{ $avatarUrl }}"
                        alt="{{ $user->name }}"
                        style="width:100%;height:100%;object-fit:cover;display:block;"
                    />
                </div>
            @else
                <div style="width:96px;height:96px;border-radius:9999px;background:#f59e0b;display:flex;align-items:center;justify-content:center;">
                    <span style="font-size:2rem;font-weight:700;color:#fff;">{{ $initials }}</span>
                </div>
            @endif
        </div>

        {{-- Name & email --}}
        <div class="text-center">
            <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $user->name }}</p>
            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $user->email }}</p>
        </div>

        {{-- Edit / Delete avatar buttons --}}
        <div class="flex items-center gap-2 mt-1">
            {{-- Edit: scrolls down to the upload section --}}
            <a
                href="#avatar-upload"
                onclick="document.getElementById('avatar-upload').scrollIntoView({behavior:'smooth'});return false;"
                style="display:inline-flex;align-items:center;gap:6px;padding:6px 14px;font-size:0.75rem;font-weight:500;border-radius:8px;background:#f59e0b;color:#fff;text-decoration:none;cursor:pointer;"
            >
                <svg xmlns="http://www.w3.org/2000/svg" style="width:14px;height:14px;" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-8 8A2 2 0 0111 15H9a1 1 0 01-1-1v-2a2 2 0 01.586-1.414l8-8z"/>
                </svg>
                Change Photo
            </a>

            @if ($avatarUrl)
                <button
                    type="button"
                    wire:click="deleteAvatar"
                    wire:confirm="Are you sure you want to remove your profile photo?"
                    style="display:inline-flex;align-items:center;gap:6px;padding:6px 14px;font-size:0.75rem;font-weight:500;border-radius:8px;background:#ef4444;color:#fff;border:none;cursor:pointer;"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" style="width:14px;height:14px;" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm4 0a1 1 0 012 0v6a1 1 0 11-2 0V8z" clip-rule="evenodd"/>
                    </svg>
                    Remove Photo
                </button>
            @endif
        </div>
    </div>

    <div id="avatar-upload">
        <form wire:submit="save">
            {{ $this->form }}

            <div class="flex items-center gap-3 mt-6">
                @foreach ($this->getFormActions() as $action)
                    {{ $action }}
                @endforeach
            </div>
        </form>
    </div>

    <x-filament-actions::modals />
</x-filament-panels::page>
