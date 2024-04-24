import { Extension } from "@tiptap/core";
import { Plugin, PluginKey } from '@tiptap/pm/state'

export default Extension.create({
    name: 'dragAndDrop',
    addProseMirrorPlugins() {
        return [
            new Plugin({
                key: new PluginKey('dragAndDrop'),
                props: {
                    handleDrop(view, event) {
                        if (!event) return false

                        event.preventDefault()

                        const coordinates = view.posAtCoords({
                            left: event.clientX,
                            top: event.clientY,
                        })

                        if (event.dataTransfer.getData('block')) {
                            event.target.dispatchEvent(new CustomEvent('dragged-block', {
                                detail: {
                                    tool: event.dataTransfer.getData('block'),
                                    coordinates,
                                },
                                bubbles: true,
                            }))

                            return false
                        }

                        if (event.dataTransfer.getData('mergeTag')) {
                            event.target.dispatchEvent(new CustomEvent('dragged-merge-tag', {
                                detail: {
                                    tag: event.dataTransfer.getData('mergeTag'),
                                    coordinates,
                                },
                                bubbles: true,
                            }))

                            return false;
                        }

                        return false;
                    },
                },
            }),
        ]
    },
})
