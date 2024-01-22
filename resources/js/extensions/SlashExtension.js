import { Extension } from '@tiptap/core'
import Suggestion from '@tiptap/suggestion'
import CommandsList from '../components/CommandsList.svelte'
import tippy from 'tippy.js'
import { PluginKey } from '@tiptap/pm/state'

export default Extension.create({
    name: 'slashExtension',

    addOptions() {
        return {
            blocks: {
                default: [],
            },
        }
    },

    addProseMirrorPlugins() {
        return [
            Suggestion({
                editor: this.editor,
                char: '/',
                command: ({ editor, range, props }) => {
                    props.command({ editor, range })
                },
                startOfLine: true,
                pluginKey: new PluginKey('slashExtension'),
                items: ({ query }) => {
                    return this.options.tools.filter(item => item.label.toLowerCase().includes(query.toLowerCase()))
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

                            component = new CommandsList({
                                target: element,
                                props: {
                                    items: props.items,
                                    editor: props.editor,
                                    range: props.range,
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
