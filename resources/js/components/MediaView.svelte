<script>
    import { NodeViewWrapper } from 'svelte-tiptap'
    import { onMount } from 'svelte'
    import { openScribbleModal } from '../utils.js'
    import BlockActions from './BlockActions.svelte'
    import DragHandle from './DragHandle.svelte'
    import BlockSettings from './BlockSettings.svelte'
    import RemoveBlock from './RemoveBlock.svelte'
    import Moveable from "svelte-moveable";

    export let editor;
    export let node;
    export let selected = false;
    export let updateAttributes;

    let target;

    const handleOpen = () => {
        openScribbleModal('media', {
            update: true,
            statePath: editor.storage?.statePathExtension.statePath ?? null,
            identifier: node.attrs.identifier,
            data: node.attrs
        })
    }

    const handleRemove = () => {
        editor.commands.deleteSelection()
    }

    onMount(() => {
        window.addEventListener('updatedBlock', (e) => {
            if (e.detail.statePath === editor.storage?.statePathExtension.statePath) {
                console.log(node.attrs)
            }
        })
    })

    function onResize(e) {
        e.target.querySelector('img').setAttribute('width', e.width)
        e.target.querySelector('img').setAttribute('height', e.height)
        e.target.style.transform = e.drag.transform
    }

    function onResizeEnd(e) {
        updateAttributes({
            width: e.target.querySelector('img').getAttribute('width'),
            height: e.target.querySelector('img').getAttribute('height')
        })

        editor.commands.focus()
    }
</script>

<NodeViewWrapper>
    <div class="scribble-block">
        <div
            class="scribble-block-content {selected ? 'ProseMirror-selectednode' : ''}"
            style="max-width: auto; max-height: auto; min-width: auto; min-height: auto"
            bind:this={target}
        >
            <img
                src={node.attrs.src}
                alt={node.attrs.alt}
                title={node.attrs?.title ?? null}
                width={parseInt(node.attrs.width)}
                height={parseInt(node.attrs.height)}
                loading={node.attrs.loading}
            />
        </div>
        {#if selected}
        <Moveable
            target={target}
            resizable={true}
            keepRatio={true}
            throttleResize={1}
            renderDirections={["se"]}
            on:resize={({ detail }) => onResize(detail)}
            on:resizeEnd={({ detail }) => onResizeEnd(detail)}
        />
        {/if}
        <BlockActions>
            <DragHandle />
            <BlockSettings {handleOpen} />
            <RemoveBlock {handleRemove} />
        </BlockActions>
    </div>
</NodeViewWrapper>
