<script>
    import {onMount, onDestroy} from "svelte";
    import {Editor} from '@tiptap/core'
    import {BubbleMenu as TiptapBubbleMenu} from '@tiptap/extension-bubble-menu'
    import ClassExtension from './extensions/ClassExtension.js'
    import CommandsExtension from './extensions/CommandsExtension.js'
    import Grid from './extensions/Grid/Grid.js'
    import GridColumn from './extensions/Grid/GridColumn.js'
    import Details from './extensions/Details/Details.js'
    import DetailsSummary from './extensions/Details/DetailsSummary.js'
    import DetailsContent from './extensions/Details/DetailsContent.js'
    import IdExtension from './extensions/IdExtension.js'
    import LinkExtension from './extensions/LinkExtension.js'
    import MediaExtension from './extensions/MediaExtension.js'
    import MergeTag from './extensions/MergeTag.js'
    import MergeTagsExtension from './extensions/MergeTagsExtension.js'
    import Placeholder from '@tiptap/extension-placeholder'
    import StarterKit from '@tiptap/starter-kit';
    import StatePathExtension from './extensions/StatePathExtension.js'
    import ScribbleBlock from './extensions/ScribbleBlock';
    import SlashExtension from './extensions/SlashExtension.js'
    import Subscript from '@tiptap/extension-subscript'
    import Superscript from '@tiptap/extension-superscript'
    import TextAlign from './extensions/TextAlignExtension.js'
    import TextStyle from '@tiptap/extension-text-style'
    import {Underline} from '@tiptap/extension-underline'
    import {pounce, commandRunner} from './utils.js'
    import Controls from './components/Controls.svelte'
    import BubbleMenu from './components/BubbleMenu.svelte'
    import Toolbar from './components/Toolbar.svelte'

    let editor;
    let element;
    let bubbleMenuElement;
    let tools;

    export let content;
    export let statePath;
    export let placeholder;
    export let bubbleTools;
    export let suggestionTools;
    export let toolbarTools;
    export let mergeTags;

    onMount(() => {
        let customExtensions = window?.scribbleExtensions || [];
        let extensions = [
            StatePathExtension.configure({
               statePath: statePath
            }),
            StarterKit,
            ClassExtension,
            CommandsExtension,
            LinkExtension,
            IdExtension,
            Grid,
            GridColumn,
            Details,
            DetailsContent,
            DetailsSummary,
            ScribbleBlock,
            Subscript,
            Superscript,
            MediaExtension,
            Underline,
            TextAlign.configure({
                types: ['heading', 'paragraph']
            }),
            TextStyle,
            TiptapBubbleMenu.configure({
                element: bubbleMenuElement,
                tippyOptions: {
                    maxWidth: 'none',
                    placement: 'bottom-start',
                    theme: 'scribble-bubble',
                    interactive: true,
                },
                shouldShow: ({ editor, from, to }) => {
                    if (from === to && editor.isActive('link')) {
                        return true
                    }

                    if (from !== to && editor.isActive('link')) {
                        return true
                    }

                    return from !== to && ! (
                        bubbleTools.filter(tool => ! tool.isHidden).length === 0 ||
                        editor.isActive('image') ||
                        editor.isActive('scribbleBlock') ||
                        editor.isActive('slashExtension')
                    )
                },
            }),
            ...customExtensions,
        ]

        if (suggestionTools?.length) {
            extensions.push(
                SlashExtension.configure({
                    tools: suggestionTools,
                    statePath: statePath,
                }),
            )

            extensions.push(
                Placeholder.configure({
                    placeholder: placeholder,
                    emptyEditorClass: 'is-editor-empty',
                }),
            )
        }

        if (mergeTags?.length) {
            extensions.push(
                MergeTag.configure({
                    mergeTags,
                }),
            )

            extensions.push(
                MergeTagsExtension.configure({
                    tags: mergeTags,
                    statePath: statePath
                })
            )
        }

        editor = new Editor({
            content: content,
            element: element,
            extensions: extensions,
            onFocus: () => {
                window.dispatchEvent(new CustomEvent('focusScribbleComponent', {
                    detail: {
                        statePath: statePath,
                    }
                }));
            },
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

    tools = Array.from(new Set([
        ...bubbleTools.flat(),
        ...suggestionTools.flat(),
        ...toolbarTools.flat()
    ]))

    let jsonObject = tools.map(JSON.stringify);
    let uniqueSet = new Set(jsonObject);
    tools = Array.from(uniqueSet).map(JSON.parse);

    $: isActive = (name, attrs = {}) => editor.isActive(name, attrs);

    tools.forEach(tool => {
        if (tool.options) {
            window.addEventListener(`handle-${tool.identifier}`, data => {
                if (data.detail.statePath !== statePath) {
                    return
                }

                if (tool.type === 'block' || tool.type === 'static') {
                    if (data.detail.context === 'insert') {
                        editor.chain().insertScribbleBlock({
                            identifier: tool.identifier,
                            type: tool.type,
                            values: data.detail.values
                        }).focus().run();
                    } else {
                        window.dispatchEvent(new CustomEvent('updatedBlock', {
                            detail: {
                                statePath: statePath,
                                identifier: tool.identifier,
                                type: tool.type,
                                blockId: data.detail.blockId,
                                values: data.detail.values
                            }
                        }));
                    }
                    return
                }

                commandRunner(editor, tool.commands, data.detail.values)
            })
        }
    })

    const handleToolClick = (tool, update = false) => {
        switch (tool.type) {
            case 'command':
                commandRunner(editor, tool.commands);
                return
            case 'modal':
                pounce(tool.identifier, {
                    statePath: statePath,
                    update: update,
                    identifier: tool.identifier,
                    data: editor.getAttributes(tool.extension)
                });
                return
            case 'static':
                editor.chain().insertScribbleBlock({
                    identifier: tool.identifier,
                    type: tool.type,
                    values: {}
                }).focus().run();
                return
            default:
                editor.commands.setScribbleBlock({
                    statePath: statePath,
                    identifier: tool.identifier,
                    type: tool.type,
                })
        }
    }

    window.addEventListener('updateContent', e => {
        if (e.detail.statePath === statePath) {
            editor.chain().setContent(e.detail.newContent).run()
        }
    })
</script>

<div class="scribble-editor-wrapper">
    <Controls {editor} {statePath} />

    <Toolbar {editor} tools={toolbarTools} {handleToolClick} {isActive} />

    <div class="scribble-editor" bind:this={element} />

    <div bind:this={bubbleMenuElement}>
        <BubbleMenu {editor} tools={bubbleTools} {handleToolClick} {isActive} />
    </div>
</div>
