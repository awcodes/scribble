<script>
    import { NodeViewWrapper, NodeViewContent } from 'svelte-tiptap'
    import cx from 'clsx'

    export let editor;
    export let updateAttributes;

    let selectedColor = 'gray';

    const removeBlock = () => {
        editor.commands.deleteSelection()
    }

    const handleColorChange = () => {
        updateAttributes({ color: selectedColor })
    }
</script>

<NodeViewWrapper>
    <div
        class={cx(
            'relative group p-6',
            selectedColor
        )}
    >
        <div class="transition rounded-md relative">
            <NodeViewContent />
        </div>
        <div class="scribble-block-actions transition opacity-0 absolute z-20 top-0 right-0 p-1 rounded-tr-md rounded-bl-lg flex items-center bg-gray-950 group-hover:opacity-100" contenteditable="false">
            <div data-drag-handle class="cursor-grabbing text-white block rounded p-1 hover:text-primary-500 hover:bg-gray-800">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4">
                    <path d="m22.67 12l-4.49 4.5l-2.51-2.5l1.98-2l-1.98-1.96l2.51-2.51zM12 1.33l4.47 4.49l-2.51 2.51L12 6.35l-2 1.98l-2.5-2.51zm0 21.34l-4.47-4.49l2.51-2.51L12 17.65l2-1.98l2.5 2.51zM1.33 12l4.49-4.5L8.33 10l-1.98 2l1.98 1.96l-2.51 2.51zM12 10a2 2 0 0 1 2 2a2 2 0 0 1-2 2a2 2 0 0 1-2-2a2 2 0 0 1 2-2"/>
                </svg>
            </div>
            <select name="backgroundColor" bind:value={selectedColor} on:change={handleColorChange} class="text-sm py-1 rounded bg-gray-900 text-white">
                <option value="null">Color</option>
                <option value="primary">Primary</option>
                <option value="secondary">Secondary</option>
                <option value="tertiary">Tertiary</option>
                <option value="accent">Accent</option>
                <option value="grayLight">Gray - Light</option>
                <option value="gray">Gray</option>
                <option value="grayDark">Gray - Dark</option>
            </select>
            <button on:click|preventDefault|stopPropagation={removeBlock} type="button" class="text-white block rounded p-1 hover:text-primary-500 hover:bg-gray-800">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-4">
                    <path fill-rule="evenodd" d="M5 3.25V4H2.75a.75.75 0 0 0 0 1.5h.3l.815 8.15A1.5 1.5 0 0 0 5.357 15h5.285a1.5 1.5 0 0 0 1.493-1.35l.815-8.15h.3a.75.75 0 0 0 0-1.5H11v-.75A2.25 2.25 0 0 0 8.75 1h-1.5A2.25 2.25 0 0 0 5 3.25Zm2.25-.75a.75.75 0 0 0-.75.75V4h3v-.75a.75.75 0 0 0-.75-.75h-1.5ZM6.05 6a.75.75 0 0 1 .787.713l.275 5.5a.75.75 0 0 1-1.498.075l-.275-5.5A.75.75 0 0 1 6.05 6Zm3.9 0a.75.75 0 0 1 .712.787l-.275 5.5a.75.75 0 0 1-1.498-.075l.275-5.5a.75.75 0 0 1 .786-.711Z" clip-rule="evenodd" />
                </svg>
            </button>
        </div>
    </div>
</NodeViewWrapper>
