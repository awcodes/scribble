import { Node } from '@tiptap/core'
import { SvelteNodeViewRenderer } from 'svelte-tiptap'
import ScribbleBlockView from "./ScribbleBlock.svelte"
import { uuid } from "../utils/uuid"

export default Node.create({
    name: 'scribbleBlock',
    isBlock: true,
    inline: false,
    group: 'block',
    draggable: true,
    defining: true,
    selectable: true,

    addAttributes() {
        return {
            id: {
                default: null
            },
            type: {
                default: null
            },
            values: {
                default: {}
            },
        };
    },

    parseHTML() {
        return [
            {
                tag: 'scribble-block',
                getAttrs: (dom) => {
                    return JSON.parse(dom.innerHTML);
                },
            },
        ];
    },

    renderHTML({ HTMLAttributes }) {
        return ['scribble-block', JSON.stringify(HTMLAttributes)];
    },

    addCommands() {
        return {
            setScribbleBlock: (options) => ({ tr, state }) => {
                const { selection } = tr;

                const node = state.schema.nodes['paragraph'].create()

                tr.replaceRangeWith(selection.from - selection.$anchor.parentOffset, selection.to, node);

                window.Livewire.emit('openModal', options.type)

                return true
            },

            insertScribbleBlock: (options) => {
                return ({ tr, dispatch, state }) => {
                    const { selection } = tr;

                    const node = this.type.create({
                        ...{id: uuid()},
                        ...options
                    })

                    if (dispatch) {
                        tr.replaceRangeWith(selection.from - selection.$anchor.parentOffset, selection.to, node);
                    }

                    return true
                }
            },
        }
    },

    addNodeView() {
        return SvelteNodeViewRenderer(ScribbleBlockView)
    }
})
