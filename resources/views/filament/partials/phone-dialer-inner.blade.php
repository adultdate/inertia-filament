<div x-data="{ number: '', status: 'idle', append(d){ this.number += d; this.status='editing' }, backspace(){ this.number = this.number.slice(0,-1); if(!this.number) this.status='idle' }, clear(){ this.number=''; this.status='idle' }, call(){ if(!this.number) return; this.status='calling'; window.dispatchEvent(new CustomEvent('phone-dialer.call',{ detail: { number: this.number } })) }, hangup(){ this.status='idle'; window.dispatchEvent(new CustomEvent('phone-dialer.hangup')) } }" wire:ignore class="space-y-3">
    <div class="flex items-center justify-between">
        <div class="text-sm text-gray-400">Dial</div>
        <div class="text-sm text-gray-500">Status: <span x-text="status"></span></div>
    </div>

    <div class="mt-4 rounded-lg bg-gray-50 p-4 dark:bg-gray-800/50">
        <div class="bg-gray-900 p-3 rounded-md flex items-center justify-between">
            <div class="text-2xl font-medium text-white truncate" x-text="number || '—'"></div>
            <div class="flex items-center gap-2">
                <button type="button" @click="backspace()" class="fi-topbar-action-button" title="Backspace">
                    <x-filament::icon icon="heroicon-s-backspace" class="w-4 h-4" />
                </button>
                <button type="button" @click="clear()" class="fi-topbar-action-button" title="Clear">
                    <x-filament::icon icon="heroicon-s-x-mark" class="w-4 h-4" />
                </button>
            </div>
        </div>

        <div class="grid grid-cols-3 gap-2 mt-4">
            @php
                $keys = ['1','2','3','4','5','6','7','8','9','+','0','#'];
            @endphp
            @foreach($keys as $key)
                <button
                    type="button"
                    @click="append('{{ $key }}')"
                    title="{{ $key }}"
                    aria-label="Dial {{ $key }}"
                    class="relative rounded-md border border-gray-700 py-3 text-lg font-medium text-white bg-gray-800 hover:bg-gray-900 transition-colors duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-primary-500"
                >
                    {{ $key }}
                </button>
            @endforeach
        </div>

        <div class="flex gap-2 mt-4">
            <button type="button" @click="call()" class="flex-1 bg-green-600 hover:bg-green-500 text-white rounded-md py-2">Call</button>
            <button type="button" @click="hangup()" class="flex-1 bg-red-600 hover:bg-red-500 text-white rounded-md py-2">Hangup</button>
        </div>
    </div>
</div>
