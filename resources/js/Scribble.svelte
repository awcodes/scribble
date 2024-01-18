<script>
    import {onMount, onDestroy} from "svelte";
    import {createEditor, EditorContent, BubbleMenu} from 'svelte-tiptap';
    import StarterKit from '@tiptap/starter-kit';
    import ScribbleBlock from './extensions/ScribbleBlock';
    import Subscript from '@tiptap/extension-subscript'
    import Superscript from '@tiptap/extension-superscript'
    import { TextAlign } from './extensions/TextAlignExtension.js'
    import TextStyle from "@tiptap/extension-text-style"
    import SlashExtension from './extensions/SlashExtension.js'
    import cx from 'clsx'

    let editor;
    let view = null;
    let wire = window.Livewire;

    export let blocks;
    export let tools;
    export let content;
    export let statePath;

    onMount(() => {
        editor = createEditor({
            content,
            extensions: [
                StarterKit,
                ScribbleBlock,
                Subscript,
                Superscript,
                TextAlign.configure({
                    types: ['heading', 'paragraph']
                }),
                TextStyle,
                SlashExtension.configure({
                    blocks: blocks
                })
            ],
            onUpdate({editor}) {
                window.dispatchEvent(new CustomEvent('updatedEditor', {
                    detail: {
                        statePath: statePath,
                        content: editor.getHTML(),
                    }
                }));
            },
        })
    })

    blocks.forEach(e => {
        window.addEventListener(`insert-${e.name}`, data => {
            $editor.chain().insertScribbleBlock({
                type: e.name,
                values: data.detail
            }).focus().run();
        })

        window.addEventListener(`update-${e.name}`, data => {
            $editor.chain().updateScribbleBlock({
                values: data.detail
            })

            window.dispatchEvent(new CustomEvent('updateBlock', {
                detail: e.name
            }));
        })
    })

    $: isActive = (name, attrs = {}) => $editor.isActive(name, attrs);

    const handleToolClick = (tool) => {
        if (tool.type === 'default') {
            $editor.chain().focus()[tool.action](tool.actionArguments).run();
            return null;
        }

        if (tool.type === 'inline') {
            const component = document.querySelector('#scribble-renderer').getAttribute('wire:id')

            wire
                .find(component)
                .call('getView', node.attrs.type, node.attrs.values)
                .then(e => view = e)
            return null;
        }

        $editor.commands.setScribbleBlock({
            type: tool.identifier,
        })

        return null;
    }

    const bubbleMenuOptions = {
        maxWidth: 'none',
        placement: 'top-start',
        theme: 'scribble-bubble',
    }
</script>

<div class="scribble-editor-wrapper w-full">
    <EditorContent editor={$editor}/>
    {#if $editor}
        {#if !isActive('link')}
            <BubbleMenu editor={$editor} tippyOptions={bubbleMenuOptions}>
                <div class="flex items-center">
                    {#each tools as tool}
                        <button
                            type="button"
                            on:click={handleToolClick(tool)}
                            class="{cx(
                                'rounded-sm p-1 bg-transparent hover:text-primary-500 focus:outline-none focus:ring-1 focus:ring-primary-500',
                                {
                                    'text-primary-400': isActive(tool.extension),
                                    'text-white': !isActive(tool.extension)
                                }
                            )}"
                        >
                            {@html tool.icon}
                        </button>
                    {/each}
                </div>
            </BubbleMenu>
        {:else if isActive('link')}
            <BubbleMenu editor={$editor} tippyOptions={bubbleMenuOptions}>
                <button
                    type="button"
                    on:click={() => alert('open link modal')}
                    class="rounded-sm p-1 bg-transparent text-white hover:text-primary-500 focus:outline-none focus:ring-1 focus:ring-primary-500"
                >
                    {@html tools.find((item) => item.extension === 'link')?.icon}
                </button>
            </BubbleMenu>
        {/if}
    {/if}
</div>
