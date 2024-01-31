<script>
    import {onMount, onDestroy} from "svelte";
    import { Editor } from '@tiptap/core'
    import BubbleMenu from '@tiptap/extension-bubble-menu'
    import ClassExtension from './extensions/ClassExtension.js'
    import CommandsExtension from './extensions/CommandsExtension.js'
    import Grid from './extensions/Grid/Grid.js'
    import GridColumn from './extensions/Grid/GridColumn.js'
    import HeroExtension from './extensions/HeroExtension.js'
    import IdExtension from './extensions/IdExtension.js'
    import LinkExtension from './extensions/LinkExtension.js'
    import MediaExtension from './extensions/MediaExtension.js'
    import Placeholder from '@tiptap/extension-placeholder'
    import StarterKit from '@tiptap/starter-kit';
    import ScribbleBlock from './extensions/ScribbleBlock';
    import SlashExtension from './extensions/SlashExtension.js'
    import Subscript from '@tiptap/extension-subscript'
    import Superscript from '@tiptap/extension-superscript'
    import TextAlign from './extensions/TextAlignExtension.js'
    import TextStyle from "@tiptap/extension-text-style"
    import { pounce, commandRunner } from './utils.js'
    import { getStatePath } from './stores.js'
    import Button from './components/Button.svelte'

    let editor;
    let element;
    let bubbleMenuElement;
    let bubbleTools;
    let suggestionTools;

    export let tools;
    export let content;
    export let statePath;
    export let placeholder;

    $getStatePath = statePath

    bubbleTools = tools.filter((tool) => tool.bubble === true)
    suggestionTools = tools.filter((tool) => tool.suggestion === true)

    onMount(() => {
        editor = new Editor({
            content: content,
            element: element,
            extensions: [
                StarterKit,
                ClassExtension,
                CommandsExtension,
                LinkExtension,
                IdExtension,
                Grid,
                GridColumn,
                ScribbleBlock,
                Subscript,
                Superscript,
                MediaExtension,
                HeroExtension,
                TextAlign.configure({
                    types: ['heading', 'paragraph']
                }),
                TextStyle,
                SlashExtension.configure({
                    tools: suggestionTools
                }),
                BubbleMenu.configure({
                    element: bubbleMenuElement,
                    tippyOptions: {
                        maxWidth: 'none',
                        placement: 'top-start',
                        theme: 'scribble-bubble',
                    },
                    shouldShow: ({ editor, from, to }) => {
                        if (from === to && editor.isActive('link')) {
                            return true
                        }

                        return from !== to && ! (
                            editor.isActive('image') ||
                            editor.isActive('scribbleBlock') ||
                            editor.isActive('slashExtension')
                        )
                    },
                }),
                Placeholder.configure({
                    placeholder: placeholder,
                    emptyEditorClass: 'is-editor-empty',
                }),
            ],
            onTransaction: () => {
                editor = editor
            },
            onUpdate({editor}) {
                window.dispatchEvent(new CustomEvent('updatedEditor', {
                    detail: {
                        statePath: statePath,
                        content: editor.getJSON(),
                    }
                }));
            },
        })
    })

    onDestroy(() => {
        editor.destroy()
    })

    const toggleFullscreen = () => {
        window.dispatchEvent(new CustomEvent('toggle-fullscreen', { detail: { statePath: statePath } }))
        editor.commands.focus()
    }

    $: isActive = (name, attrs = {}) => editor.isActive(name, attrs);

    tools.forEach(tool => {
        window.addEventListener(`insert-${tool.extension}`, data => {
            if (data.detail.statePath !== statePath) {
                return
            }

            if (tool.type === 'block' || tool.type === 'static') {
                editor.chain().insertScribbleBlock({
                    identifier: tool.identifier,
                    type: tool.type,
                    values: data.detail.values
                }).focus().run();

                return
            }

            commandRunner(editor, tool.commands, data.detail.values)
        })

        window.addEventListener(`update-${tool.extension}`, data => {
            if (data.detail.statePath !== statePath) {
                return
            }

            if (tool.type === 'block' || tool.type === 'static') {
                window.dispatchEvent(new CustomEvent('updatedBlock', {
                    detail: {
                        statePath: statePath,
                        identifier: tool.identifier,
                        type: tool.type,
                        blockId: data.detail.blockId,
                        values: data.detail.values
                    }
                }));

                return
            }

            commandRunner(editor, tool.commands, data.detail.values)
        })
    })

    const handleToolClick = (tool, update = false) => {
        switch (tool.type) {
            case 'command': commandRunner(editor, tool.commands); return
            case 'modal': pounce(tool.identifier, { statePath: tool.statePath, update: update, ...editor.getAttributes(tool.extension) }); return
            case 'static': editor.chain().insertScribbleBlock({
                    identifier: tool.identifier,
                    type: tool.type,
                    values: {}
                }).focus().run(); return
            default: editor.commands.setScribbleBlock({
                statePath: statePath,
                identifier: tool.identifier,
                type: tool.type,
            })
        }
    }
</script>

<div class="scribble-editor-wrapper w-full">
    {#if editor}
        <div class="scribble-controls">
            <div class="scribble-controls-panel inline-flex px-2 items-center rounded-full border border-gray-950/10 dark:border-white/20 shadow-md">
                <Button {editor} key="undo" on:click={() => editor.chain().focus().undo().run()}>
                    <svg class="size-5" xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 512 512">
                        <path fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="32" d="M240 424v-96c116.4 0 159.39 33.76 208 96c0-119.23-39.57-240-208-240V88L64 256Z"/>
                    </svg>
                </Button>
                <Button {editor} key="redo" on:click={() => editor.chain().focus().redo().run()}>
                    <svg class="size-5" xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 512 512">
                        <path fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="32" d="M448 256L272 88v96C103.57 184 64 304.77 64 424c48.61-62.24 91.6-96 208-96v96Z"/>
                    </svg>
                </Button>
                <Button {editor} key="clear" on:click={() => editor.chain().focus().clearContent(true).run()}>
                    <svg class="size-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M13.9999 18.9967H20.9999V20.9967H11.9999L8.00229 20.9992L1.51457 14.5115C1.12405 14.1209 1.12405 13.4878 1.51457 13.0972L12.1212 2.49065C12.5117 2.10012 13.1449 2.10012 13.5354 2.49065L21.3136 10.2688C21.7041 10.6593 21.7041 11.2925 21.3136 11.683L13.9999 18.9967ZM15.6567 14.5115L19.1922 10.9759L12.8283 4.61197L9.29275 8.1475L15.6567 14.5115Z"/>
                    </svg>
                </Button>
                <Button {editor} key="enter-fullscreen" on:click={toggleFullscreen}>
                    <svg class="size-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path fill="none" d="M0 0h24v24H0z"/><path d="M20 3h2v6h-2V5h-4V3h4zM4 3h4v2H4v4H2V3h2zm16 16v-4h2v6h-6v-2h4zM4 19h4v2H2v-6h2v4z"/>
                    </svg>
                </Button>
                <Button {editor} key="exit-fullscreen" on:click={toggleFullscreen}>
                    <svg class="size-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path fill="none" d="M0 0h24v24H0z"/><path d="M18 7h4v2h-6V3h2v4zM8 9H2V7h4V3h2v6zm10 8v4h-2v-6h6v2h-4zM8 15v6H6v-4H2v-2h6z"/>
                    </svg>
                </Button>
            </div>
        </div>
    {/if}
    <div class="scribble-editor" bind:this={element} />
    <div bind:this={bubbleMenuElement}>
        {#if editor}
            <div class="flex items-center">
            {#if !isActive('link')}
                {#each bubbleTools as tool}
                    <Button {editor} key={tool.extension} on:click={() => handleToolClick(tool)}>
                        {@html tool.icon}
                    </Button>
                {/each}
            {:else if isActive('link')}
                <span class="max-w-xs text-sm leading-none truncate overflow-hidden whitespace-nowrap">{editor.getAttributes('link').href}</span>
                <Button {editor} key="editLink" on:click={() => handleToolClick(tools.find((item) => item.extension === 'link'), true)}>
                    {@html tools.find((item) => item.extension === 'link')?.icon}
                </Button>
                <Button {editor} key="unsetLink" on:click={() => editor.chain().focus().extendMarkRange('link').unsetLink().selectTextblockEnd().run()}>
                    <svg class="size-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M17 17H22V19H19V22H17V17ZM7 7H2V5H5V2H7V7ZM18.364 15.5355L16.9497 14.1213L18.364 12.7071C20.3166 10.7545 20.3166 7.58866 18.364 5.63604C16.4113 3.68342 13.2455 3.68342 11.2929 5.63604L9.87868 7.05025L8.46447 5.63604L9.87868 4.22183C12.6123 1.48816 17.0445 1.48816 19.7782 4.22183C22.5118 6.9555 22.5118 11.3877 19.7782 14.1213L18.364 15.5355ZM15.5355 18.364L14.1213 19.7782C11.3877 22.5118 6.9555 22.5118 4.22183 19.7782C1.48816 17.0445 1.48816 12.6123 4.22183 9.87868L5.63604 8.46447L7.05025 9.87868L5.63604 11.2929C3.68342 13.2455 3.68342 16.4113 5.63604 18.364C7.58866 20.3166 10.7545 20.3166 12.7071 18.364L14.1213 16.9497L15.5355 18.364ZM14.8284 7.75736L16.2426 9.17157L9.17157 16.2426L7.75736 14.8284L14.8284 7.75736Z"/>
                    </svg>
                </Button>
            {/if}
            </div>
        {/if}
    </div>
</div>
