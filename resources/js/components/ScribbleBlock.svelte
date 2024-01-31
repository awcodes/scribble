<script>
    import { NodeViewWrapper } from 'svelte-tiptap'
    import { onMount, tick } from 'svelte'
    import { pounce } from '../utils.js'
    import { getStatePath } from '../stores.js'
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

    const open = () => {
        pounce(node.attrs.identifier, {
            update: true,
            statePath: $getStatePath,
            blockId: node.attrs.id,
            ...node.attrs.values
        })
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
                && e.detail.statePath === $getStatePath
                && e.detail.blockId === node.attrs.id
            ) {
                updateAttributes({ values: e.detail.values })
                getView()
                setTimeout(() => {
                    let currentNode = editor.$node('scribbleBlock', {id: node.attrs.id});
                    editor.commands.setNodeSelection(currentNode.pos)
                }, 100)
            }
        })
    })
</script>

<NodeViewWrapper>
    <div class="relative group bg-gray-900/5 dark:bg-white/5 rounded-md">
        <div class="transition rounded-md overflow-hidden z-10 relative {selected ? 'ProseMirror-selectednode' : ''}" bind:this={wrapper}>
            {@html view}
        </div>
        <BlockActions>
            <DragHandle />
            {#if node.attrs.type !== 'static'}
            <BlockSettings {open} />
            {/if}
            <RemoveBlock {editor} />
        </BlockActions>
    </div>
</NodeViewWrapper>
