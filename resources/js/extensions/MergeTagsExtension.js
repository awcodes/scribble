import { Extension } from '@tiptap/core'
import Suggestion from '@tiptap/suggestion'
import MergeTagsList from '../components/MergeTagsList.svelte'
import tippy from 'tippy.js'
import { PluginKey } from '@tiptap/pm/state'

export default Extension.create({
    name: 'mergeTagsExtension',

    addOptions() {
        return {
            tags: {
                default: [],
            },
            statePath: {
                default: null,
            }
        }
    },

    addProseMirrorPlugins() {
        return [
            Suggestion({
                editor: this.editor,
                char: '{{',
                command: ({ editor, range, props }) => {
                    props.command({ editor, range })
                },
                startOfLine: false,
                pluginKey: new PluginKey('mergeTagsExtension'),
                items: ({ query }) => {
                    return this.options.tags.filter(item => item.toLowerCase().includes(query.toLowerCase()))
                },
                render: () => {
                    let component
                    let popup

                    return {
                        onStart: props => {
                            if (!props.clientRect) {
                                return
                            }

                            const element = document.createElement('div')

                            component = new MergeTagsList({
                                target: element,
                                props: {
                                    items: props.items,
                                    editor: props.editor,
                                    range: props.range,
                                    statePath: this.options.statePath,
                                }
                            })

                            popup = tippy('body', {
                                getReferenceClientRect: props.clientRect,
                                appendTo: () => document.body,
                                content: component.$$.root,
                                showOnCreate: true,
                                interactive: true,
                                trigger: 'manual',
                                placement: 'bottom-start',
                                theme: 'scribble-panel',
                                arrow: false,
                                zIndex: 40,
                            })
                        },
                        onUpdate(props) {
                            component.$set({
                                items: props.items,
                                editor: props.editor,
                                range: props.range,
                            })

                            component.resetIndex()

                            if (!props.clientRect) {
                                return
                            }

                            popup[0].setProps({
                                getReferenceClientRect: props.clientRect
                            })
                        },
                        onKeyDown(props) {
                            if (props.event.key === 'Escape') {
                                popup[0].hide()

                                return true
                            }

                            return component.onKeyDown(props)
                        },
                        onExit() {
                            popup[0].destroy()
                            component.$destroy()
                        }
                    }
                }
            }),
        ]
    }
})
