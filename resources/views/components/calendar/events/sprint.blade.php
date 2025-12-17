<div class="flex w-full flex-col gap-1 text-left">
    <div class="flex items-center justify-between gap-2">
        <span class="truncate text-xs font-semibold leading-tight" x-text="event.title"></span>
        <span
            class="inline-flex items-center gap-1 text-[10px] font-medium uppercase tracking-wide"
            x-show="Boolean(event.extendedProps.priority)"
        >
            <span
                class="h-1.5 w-1.5 rounded-full"
                x-bind:class="{
                    'bg-emerald-500': event.extendedProps.priority === 'Low',
                    'bg-sky-500': event.extendedProps.priority === 'Medium',
                    'bg-amber-500': event.extendedProps.priority === 'High',
                    'bg-rose-500': event.extendedProps.priority === 'Urgent',
                }"
            ></span>
            <span x-text="event.extendedProps.priority"></span>
        </span>
    </div>
    <span class="text-[11px] font-medium" x-text="event.timeText"></span>
</div>
