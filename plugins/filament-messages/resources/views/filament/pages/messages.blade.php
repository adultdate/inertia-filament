<x-filament-panels::page class="!p-0 !max-w-none !block">
    <div style="display: flex; width: 100%; height: calc(100vh - 8rem);">
        {{-- LEFT SIDEBAR: Conversations List --}}
        <div style="width: 24rem; flex-shrink: 0; overflow: hidden; background-color: #ffffff; border-right: 1px solid #e5e7eb;" class="dark:border-gray-700 dark:bg-gray-950">
            <livewire:fm-inbox :selectedConversation="$selectedConversation" />
        </div>

        {{-- RIGHT MAIN: Chat Area --}}
        <div style="flex: 1; display: flex; flex-direction: column; overflow: hidden; background-color: #ffffff;" class="dark:bg-gray-950">
            <livewire:fm-messages :selectedConversation="$selectedConversation" />
        </div>
    </div>
</x-filament-panels::page>

@script
<script>
    const stripWireIdArtifacts = () => {
        document.querySelectorAll('body, body *').forEach((node) => {
            node.childNodes.forEach((child) => {
                if (child.nodeType === Node.TEXT_NODE && child.textContent.trim().match(/^<\s*wire:id="[^"]+">$/)) {
                    child.remove();
                }
            });
        });
    };

    const wireIdObserver = new MutationObserver(stripWireIdArtifacts);

    stripWireIdArtifacts();
    wireIdObserver.observe(document.body, { childList: true, subtree: true });
</script>
@endscript
