<script>
    import { NodeViewWrapper } from 'svelte-tiptap'
    import { onMount } from 'svelte'
    import { pounce } from '../utils.js'
    import BlockActions from './BlockActions.svelte'
    import DragHandle from './DragHandle.svelte'
    import BlockSettings from './BlockSettings.svelte'
    import RemoveBlock from './RemoveBlock.svelte'

    export let editor;
    export let node;
    export let selected = false;
    export let updateAttributes;

    const handleOpen = () => {
        pounce('scribble-media', {
            update: true,
            statePath: editor.storage?.statePathExtension.statePath ?? null,
            ...node.attrs
        })
    }

    const handleRemove = () => {
        editor.commands.deleteSelection()
    }

    onMount(() => {
        window.addEventListener('updatedBlock', (e) => {
            if (
                e.detail.type === node.attrs.type
                && e.detail.statePath === editor.storage?.statePathExtension.statePath
            ) {
                updateAttributes({ values: e.detail.values })
            }
        })
    })
</script>

<NodeViewWrapper>
    <div class="scribble-block">
        <div class="scribble-block-content {selected ? 'ProseMirror-selectednode' : ''}">
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
            <BlockSettings {handleOpen} />
            <RemoveBlock {handleRemove} />
        </BlockActions>
    </div>
</NodeViewWrapper>
