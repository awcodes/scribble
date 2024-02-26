<script>
    import { NodeViewWrapper } from 'svelte-tiptap'
    import { onMount, tick } from 'svelte'
    import { pounce } from '../utils.js'
    import BlockSettings from './BlockSettings.svelte'
    import DragHandle from './DragHandle.svelte'
    import RemoveBlock from './RemoveBlock.svelte'
    import BlockActions from './BlockActions.svelte'

    export let editor;
    export let node;
    export let selected = false;
    export let updateAttributes;

    let view = null;
    $: wrapper = null;

    const handleOpen = () => {
        pounce(node.attrs.identifier, {
            update: true,
            statePath: editor.storage?.statePathExtension.statePath ?? null,
            blockId: node.attrs.id,
            ...node.attrs.values
        })
    }

    const handleRemove = () => {
        editor.commands.deleteSelection()
    }

    $: getView = () => {
        const component = document.querySelector('#scribble-renderer').getAttribute('wire:id')

        window.Livewire
            .find(component)
            .call('getView', node.attrs.identifier, node.attrs.values)
            .then(e => {
                view = e
            })
            .then(() => {
                wrapper.addEventListener('change', (e) => {
                    let name = e.target.getAttribute('id').replace('data.', '')
                    let value = e.target.value
                    updateAttributes({ values: {...node.attrs.values, [name]: value } })
                })
            })
    }

    onMount(() => {
        getView()

        window.addEventListener('updatedBlock', (e) => {
            if (
                e.detail.identifier === node.attrs.identifier
                && e.detail.statePath === editor.storage?.statePathExtension.statePath
                && e.detail.blockId === node.attrs.id
            ) {
                updateAttributes({ values: e.detail.values })
                getView()
            }
        })
    })
</script>

<NodeViewWrapper>
    <div class="scribble-block">
        <div class="scribble-block-content {selected ? 'ProseMirror-selectednode' : ''}" bind:this={wrapper}>
            {#if view}
                {@html view}
            {:else}
                <div class="loading-block">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </div>
            {/if}
        </div>
        <BlockActions>
            <DragHandle />
            {#if node.attrs.type !== 'static'}
            <BlockSettings {handleOpen} />
            {/if}
            <RemoveBlock {handleRemove} />
        </BlockActions>
    </div>
</NodeViewWrapper>
