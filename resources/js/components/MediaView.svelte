<script>
    import { NodeViewWrapper } from 'svelte-tiptap'
    import { onMount } from 'svelte'
    import { pounce } from '../utils.js'
    import { getStatePath } from '../stores.js'
    import BlockActions from './BlockActions.svelte'
    import DragHandle from './DragHandle.svelte'
    import BlockSettings from './BlockSettings.svelte'
    import RemoveBlock from './RemoveBlock.svelte'

    export let editor;
    export let node;
    export let selected = false;
    export let updateAttributes;

    const open = () => {
        pounce('scribble-media', {
            update: true,
            statePath: $getStatePath,
            ...node.attrs
        })
    }

    onMount(() => {
        window.addEventListener('updatedBlock', (e) => {
            if (e.detail.type === node.attrs.type && e.detail.statePath === $getStatePath) {
                updateAttributes({ values: e.detail.values })
            }
        })
    })
</script>

<NodeViewWrapper>
    <div class="relative group bg-gray-900/5 dark:bg-white/5 rounded-md" style="min-height: 3rem;">
        <div class="transition rounded-md overflow-hidden z-10 relative {selected ? 'ProseMirror-selectednode' : ''}">
            <img
                src={node.attrs.src}
                alt={node.attrs.alt}
                title={node.attrs?.title ?? null}
                width={node.attrs.width}
                height={node.attrs.height}
                loading={node.attrs.loading}
            />
        </div>
        <BlockActions>
            <DragHandle />
            <BlockSettings {open} />
            <RemoveBlock {editor} />
        </BlockActions>
    </div>
</NodeViewWrapper>
