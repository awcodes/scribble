<script>
    import { NodeViewWrapper, NodeViewContent } from 'svelte-tiptap'
    import { onMount, tick } from 'svelte'
    import { pounce, replaceTargetByComponent } from '../utils.js'
    import { getStatePath } from '../stores.js'
    import Injectable from './Injectable.svelte'

    export let editor;
    export let node;
    export let selected = false;
    export let updateAttributes;

    $: view = null;
    $: wrapper = null;
    $: renderEditableContent();

    const open = () => {
        pounce(node.attrs.identifier, { update: true, statePath: $getStatePath, ...node.attrs.values })
    }

    const removeBlock = () => {
        editor.commands.deleteSelection()
    }

    async function renderEditableContent() {
        await tick()

        const editable = wrapper.querySelectorAll('[contenteditable="true"]')

        if (editable.length > 0) {
            editable.forEach((el) => {
                replaceTargetByComponent(el, NodeViewContent, {
                    target: el.parentElement,
                    props: {
                        editor: editor
                    }
                })
            })
        }
    }

    const getView = () => {
        const component = document.querySelector('#scribble-renderer').getAttribute('wire:id')

        window.Livewire
            .find(component)
            .call('getView', node.attrs.identifier, node.attrs.values)
            .then(e => view = e)
            .then(() => {
                wrapper.addEventListener('change', (e) => {
                    let name = e.target.getAttribute('id').replace('data.', '')
                    let value = e.target.value
                    updateAttributes({ values: {...node.attrs.values, [name]: value } })
                })

                // renderEditableContent()
            })
    }

    onMount(() => {
        getView()

        window.addEventListener('updatedBlock', (e) => {
            if (e.detail.identifier === node.attrs.identifier && e.detail.statePath === $getStatePath) {
                updateAttributes({ values: e.detail.values })
                getView()
            }
        })
    })
</script>

<NodeViewWrapper>
    <div class="relative group bg-gray-900/5 dark:bg-white/5 rounded-md">
        <div class="transition rounded-md overflow-hidden z-10 relative {selected ? 'ProseMirror-selectednode' : ''}" bind:this={wrapper}>
            <!--{@html view}-->
            {#if view}
            <Injectable html={view} rules={[
                {regex: RegExp('(<div contenteditable.*?<\/div>)', 'gi'), component: NodeViewContent, props: {}}
            ]} />
            {/if}
        </div>
        <div class="scribble-block-actions transition opacity-0 absolute z-20 top-0 right-0 p-1 rounded-tr-md rounded-bl-lg flex items-center bg-gray-950 group-hover:opacity-100" contenteditable="false">
            <div data-drag-handle class="cursor-grabbing text-white block rounded p-1 hover:text-primary-500 hover:bg-gray-800">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4">
                    <path d="m22.67 12l-4.49 4.5l-2.51-2.5l1.98-2l-1.98-1.96l2.51-2.51zM12 1.33l4.47 4.49l-2.51 2.51L12 6.35l-2 1.98l-2.5-2.51zm0 21.34l-4.47-4.49l2.51-2.51L12 17.65l2-1.98l2.5 2.51zM1.33 12l4.49-4.5L8.33 10l-1.98 2l1.98 1.96l-2.51 2.51zM12 10a2 2 0 0 1 2 2a2 2 0 0 1-2 2a2 2 0 0 1-2-2a2 2 0 0 1 2-2"/>
                </svg>
            </div>
            {#if node.attrs.type !== 'static'}
            <button on:click|preventDefault|stopPropagation={open} type="button" class="text-white block rounded p-1 hover:text-primary-500 hover:bg-gray-800">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-4">
                    <path fill-rule="evenodd" d="M15 4.5A3.5 3.5 0 0 1 11.435 8c-.99-.019-2.093.132-2.7.913l-4.13 5.31a2.015 2.015 0 1 1-2.827-2.828l5.309-4.13c.78-.607.932-1.71.914-2.7L8 4.5a3.5 3.5 0 0 1 4.477-3.362c.325.094.39.497.15.736L10.6 3.902a.48.48 0 0 0-.033.653c.271.314.565.608.879.879a.48.48 0 0 0 .653-.033l2.027-2.027c.239-.24.642-.175.736.15.09.31.138.637.138.976ZM3.75 13a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" clip-rule="evenodd" />
                    <path d="M11.5 9.5c.313 0 .62-.029.917-.084l1.962 1.962a2.121 2.121 0 0 1-3 3l-2.81-2.81 1.35-1.734c.05-.064.158-.158.426-.233.278-.078.639-.11 1.062-.102l.093.001ZM5 4l1.446 1.445a2.256 2.256 0 0 1-.047.21c-.075.268-.169.377-.233.427l-.61.474L4 5H2.655a.25.25 0 0 1-.224-.139l-1.35-2.7a.25.25 0 0 1 .047-.289l.745-.745a.25.25 0 0 1 .289-.047l2.7 1.35A.25.25 0 0 1 5 2.654V4Z" />
                </svg>
            </button>
            {/if}
            <button on:click|preventDefault|stopPropagation={removeBlock} type="button" class="text-white block rounded p-1 hover:text-primary-500 hover:bg-gray-800">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-4">
                    <path fill-rule="evenodd" d="M5 3.25V4H2.75a.75.75 0 0 0 0 1.5h.3l.815 8.15A1.5 1.5 0 0 0 5.357 15h5.285a1.5 1.5 0 0 0 1.493-1.35l.815-8.15h.3a.75.75 0 0 0 0-1.5H11v-.75A2.25 2.25 0 0 0 8.75 1h-1.5A2.25 2.25 0 0 0 5 3.25Zm2.25-.75a.75.75 0 0 0-.75.75V4h3v-.75a.75.75 0 0 0-.75-.75h-1.5ZM6.05 6a.75.75 0 0 1 .787.713l.275 5.5a.75.75 0 0 1-1.498.075l-.275-5.5A.75.75 0 0 1 6.05 6Zm3.9 0a.75.75 0 0 1 .712.787l-.275 5.5a.75.75 0 0 1-1.498-.075l.275-5.5a.75.75 0 0 1 .786-.711Z" clip-rule="evenodd" />
                </svg>
            </button>
        </div>
    </div>
</NodeViewWrapper>
