<script>
    import {onMount, onDestroy} from "svelte";
    import {Editor} from '@tiptap/core'
    import Blockquote from '@tiptap/extension-blockquote'
    import Bold from '@tiptap/extension-bold'
    import {BubbleMenu as TiptapBubbleMenu} from '@tiptap/extension-bubble-menu'
    import BulletList from '@tiptap/extension-bullet-list'
    import ClassExtension from './extensions/ClassExtension.js'
    import Code from '@tiptap/extension-code'
    import CodeBlock from './extensions/CodeBlock.js'
    import Color from '@tiptap/extension-color'
    import CommandsExtension from './extensions/CommandsExtension.js'
    import Document from '@tiptap/extension-document'
    import DragAndDropExtension from './extensions/DragAndDropExtension.js'
    import Dropcursor from '@tiptap/extension-dropcursor'
    import Gapcursor from '@tiptap/extension-gapcursor'
    import Grid from './extensions/Grid/Grid.js'
    import GridColumn from './extensions/Grid/GridColumn.js'
    import Details from './extensions/Details/Details.js'
    import DetailsSummary from './extensions/Details/DetailsSummary.js'
    import DetailsContent from './extensions/Details/DetailsContent.js'
    import Focus from '@tiptap/extension-focus'
    import HardBreak from '@tiptap/extension-hard-break'
    import Heading from '@tiptap/extension-heading'
    import HorizontalRule from '@tiptap/extension-horizontal-rule'
    import IdExtension from './extensions/IdExtension.js'
    import Italic from '@tiptap/extension-italic'
    import LinkExtension from './extensions/LinkExtension.js'
    import ListItem from '@tiptap/extension-list-item'
    import MediaExtension from './extensions/MediaExtension.js'
    import MergeTag from './extensions/MergeTag.js'
    import MergeTagsExtension from './extensions/MergeTagsExtension.js'
    import OrderedList from '@tiptap/extension-ordered-list'
    import Paragraph from '@tiptap/extension-paragraph'
    import Placeholder from '@tiptap/extension-placeholder'
    import StatePathExtension from './extensions/StatePathExtension.js'
    import ScribbleBlock from './extensions/ScribbleBlock';
    import SlashExtension from './extensions/SlashExtension.js'
    import Strike from '@tiptap/extension-strike'
    import Subscript from '@tiptap/extension-subscript'
    import Superscript from '@tiptap/extension-superscript'
    import Table from '@tiptap/extension-table'
    import TableCell from '@tiptap/extension-table-cell'
    import TableHeader from '@tiptap/extension-table-header'
    import TableRow from '@tiptap/extension-table-row'
    import Text from '@tiptap/extension-text'
    import TextAlign from './extensions/TextAlignExtension.js'
    import TextStyle from '@tiptap/extension-text-style'
    import Underline from '@tiptap/extension-underline'
    import {openScribbleModal, commandRunner, replaceStatePath} from './utils.js'
    import Controls from './components/Controls.svelte'
    import BubbleMenu from './components/BubbleMenu.svelte'
    import Toolbar from './components/Toolbar.svelte'
    import BlockPanel from './components/BlockPanel.svelte'
    import cx from 'clsx'

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
    export let headingLevels = [1,2,3];

    tools = Array.from(new Set([
        ...bubbleTools.flat(),
        ...suggestionTools.flat(),
        ...toolbarTools.flat()
    ]))

    let jsonObject = tools.map(JSON.stringify);
    let uniqueSet = new Set(jsonObject);
    tools = Array.from(uniqueSet).map(JSON.parse);

    const coreExtensions = {
        'classExtension': ClassExtension,
        'commands': CommandsExtension,
        'document': Document,
        'dragAndDrop': DragAndDropExtension,
        'dropcursor': Dropcursor,
        'gapcursor': Gapcursor,
        'focus': Focus,
        'hardBreak': HardBreak,
        'history': History,
        'idExtension': IdExtension,
        'paragraph': Paragraph,
        'scribbleBlock': ScribbleBlock,
        'statePathExtension': StatePathExtension.configure({ statePath: statePath }),
        'textStyle': TextStyle,
        'text': Text,
    }

    const defaultExtensions = {
        'blockquote': Blockquote,
        'bold': Bold,
        'bulletList': BulletList,
        'code': Code,
        'codeBlock': CodeBlock,
        'color': Color,
        'details': [Details, DetailsContent, DetailsSummary],
        'grid': [Grid, GridColumn],
        'heading': Heading.configure({levels: headingLevels}),
        'horizontalRule': HorizontalRule,
        'italic': Italic,
        'link': LinkExtension,
        'listItem': ListItem,
        'media': MediaExtension,
        'orderedList': OrderedList,
        'strike': Strike,
        'subscript': Subscript,
        'superscript': Superscript,
        'table': [Table.configure({ resizable: true, }), TableRow, TableHeader, TableCell],
        'textAlign': TextAlign,
        'underline': Underline,
    }

    const customExtensions = window?.scribbleExtensions || {};

    tools.forEach(tool => {
        if (! Object.keys(defaultExtensions).includes(tool.extension)) {
            delete defaultExtensions[tool.extension]
        }

        if (! Object.keys(customExtensions).includes(tool.extension)) {
            delete customExtensions[tool.extension]
        }

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
                            blockId: data.detail.blockId,
                            values: data.detail.values,
                            coordinates: data.detail?.coordinates
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

                if (tool.type === 'modal' && data.detail.context === 'update') {
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

                if (typeof data.detail.values === 'string') {
                    commandRunner(editor, tool.commands, data.detail.values)
                    return
                }

                commandRunner(editor, tool.commands, {...data.detail.values, coordinates: data.detail?.coordinates})
            })
        }
    })

    onMount(() => {
        let extensions = Array.from(new Set([
            ...Object.values(coreExtensions).flat(),
            ...Object.values(defaultExtensions).flat(),
            ...Object.values(customExtensions).flat(),
        ]))

        if (bubbleTools?.length) {
            extensions.push(TiptapBubbleMenu.configure({
                element: bubbleMenuElement,
                tippyOptions: {
                    duration: [500, 0],
                    maxWidth: 'none',
                    placement: 'bottom-start',
                    theme: 'scribble-bubble',
                    interactive: true,
                },
                shouldShow: ({ editor, from, to }) => {
                    if (from === to && (
                        editor.isActive('link') ||
                        editor.isActive('table')
                    )) {
                        return true
                    }

                    if (from !== to && editor.isActive('link')) {
                        return true
                    }

                    return from !== to && ! (
                        bubbleTools.filter(tool => ! tool.isHidden).length === 0 ||
                        editor.isActive('scribbleBlock') ||
                        editor.isActive('slashExtension')
                    )
                },
            }))
        }

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

    $: isActive = (name, attrs = {}) => editor.isActive(name, attrs);

    const handleToolClick = (name, update = false, coordinates = null) => {
        const tool = tools.find((t) => { return t.identifier === name });

        switch (tool.type) {
            case 'command':
                commandRunner(editor, tool.commands);
                return
            case 'event':
                replaceStatePath(tool.event.data, statePath)
                window.Livewire.dispatch(tool.event.name, tool.event.data)
                return
            case 'modal':
                openScribbleModal(tool.identifier, {
                    statePath: statePath,
                    update: update,
                    identifier: tool.identifier,
                    data: editor.getAttributes(tool.extension),
                    coordinates: coordinates
                });
                return
            case 'static':
                editor.chain().insertScribbleBlock({
                    identifier: tool.identifier,
                    type: tool.type,
                    values: {},
                    coordinates: coordinates
                }).focus().run();
                return
            default:
                editor.commands.setScribbleBlock({
                    statePath: statePath,
                    identifier: tool.identifier,
                    type: tool.type,
                    coordinates: coordinates
                })
        }
    }

    window.addEventListener('insert-content', data => {
        if (data.detail.statePath !== statePath) {
            return
        }

        if (data.detail.type === 'media') {
            data.detail.media.forEach((item) => editor.chain().setMedia(item).focus().run())
        }
    })

    window.addEventListener('updateContent', e => {
        if (e.detail.statePath === statePath) {
            editor.chain().setContent(e.detail.newContent).run()
        }
    })
</script>

<div
    class={cx(
        `scribble-editor-wrapper`,
        {'has-empty-panel': ! ((suggestionTools && suggestionTools.length > 0) || (mergeTags && mergeTags.length > 0))}
    )}
>
    <Controls {editor} {statePath} />

    <Toolbar {editor} tools={toolbarTools} {handleToolClick} {isActive} />

    <BlockPanel {editor} tools={suggestionTools} mergeTags={mergeTags} {handleToolClick} {isActive} />

    <div class="scribble-editor" bind:this={element} />

    <div bind:this={bubbleMenuElement}>
        <BubbleMenu {editor} tools={bubbleTools} {handleToolClick} {isActive} />
    </div>
</div>
