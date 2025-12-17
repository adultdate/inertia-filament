<div class="flex w-full flex-col gap-1 text-left">
    <div class="flex items-center justify-between gap-2">
        <span class="truncate text-xs font-semibold leading-tight" x-text="event.title"></span>
        <span
            class="text-[10px] font-medium uppercase tracking-wide"
            x-show="Number(event.extendedProps.participants) > 0"
            x-text="`${event.extendedProps.participants} attending`"
        ></span>
    </div>
    <span class="text-[11px] font-medium" x-text="event.timeText"></span>
</div>
