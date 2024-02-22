import { Node } from '@tiptap/core'
import { SvelteNodeViewRenderer } from 'svelte-tiptap'
import ScribbleBlockView from "../components/ScribbleBlock.svelte"
import { uuid, pounce } from "../utils.js"

export default Node.create({
    name: 'scribbleBlock',
    isBlock: true,
    inline: false,
    group: 'block',
    draggable: true,
    defining: true,
    selectable: true,

    addStorage() {
        return {
            statePath: null
        }
    },

    addAttributes() {
        return {
            id: {
                default: null
            },
            type: {
                default: 'block'
            },
            identifier: {
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
                pounce(options.identifier, { statePath: options.statePath })

                return true
            },

            insertScribbleBlock: (options) => {
                return ({ tr, dispatch, commands }) => {
                    const { selection } = tr;

                    const node = this.type.create({
                        ...{id: uuid()},
                        ...options,
                    })

                    if (dispatch) {
                        tr.replaceRangeWith(selection.from - selection.$anchor.parentOffset, selection.to, node)
                        commands.setNodeSelection(tr.mapping.map(tr.steps[tr.steps.length - 1].from), 1)
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
