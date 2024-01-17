<script>
    import { NodeViewWrapper } from 'svelte-tiptap'
    import { onMount } from 'svelte'

    export let node;
    // export let editor;
    // export let decoration;
    export let selected = false;
    // export let extension;
    // export let getPos;
    // export let deleteNode;
    // export let updateAttributes;

    let view = null;
    let wire = window.Livewire;

    const open = () => wire.emit('openModal', node.attrs.type, {data: node.attrs.values})

    const getView = () => {
        const component = document.querySelector('#scribble-renderer').getAttribute('wire:id')

        wire
            .find(component)
            .call('getView', node.attrs.type, node.attrs.values)
            .then(e => view = e)
    }

    onMount(() => {
        getView()

        window.addEventListener('updatedBlock', (e) => {
            if (e.detail === node.attrs.type) {
                getView()
            }
        })
    })
</script>

<NodeViewWrapper data-drag-handle>
    <div class="relative group">
        <div class="transition cursor-pointer rounded-md overflow-hidden z-10 relative {selected ? '' : ''}">
            {@html view}
        </div>

        <button on:click|preventDefault|stopPropagation={open} type="button" class="transition  absolute right-2 top-2 z-20 p-1 rounded-md bg-gray-200/30 hover:bg-gray-200 group-hover:opacity-100 opacity-0">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-700" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <circle cx="6" cy="10" r="2"></circle>
                <line x1="6" y1="4" x2="6" y2="8"></line>
                <line x1="6" y1="12" x2="6" y2="20"></line>
                <circle cx="12" cy="16" r="2"></circle>
                <line x1="12" y1="4" x2="12" y2="14"></line>
                <line x1="12" y1="18" x2="12" y2="20"></line>
                <circle cx="18" cy="7" r="2"></circle>
                <line x1="18" y1="4" x2="18" y2="5"></line>
                <line x1="18" y1="9" x2="18" y2="20"></line>
            </svg>
        </button>
    </div>
</NodeViewWrapper>
