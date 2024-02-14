import { mergeAttributes, Node } from '@tiptap/core'

export default Node.create({
    name: 'mergeTag',

    group: 'inline',

    inline: true,

    selectable: false,

    atom: true,

    addAttributes() {
        return {
            id: {
                default: null,
                parseHTML: element => element.getAttribute('data-id'),
                renderHTML: attributes => {
                    if (!attributes.id) {
                        return {}
                    }

                    return {
                        'data-id': attributes.id
                    }
                }
            },
        }
    },

    parseHTML() {
        return [
            {
                tag: `span[data-type='${this.name}']`
            }
        ]
    },

    renderHTML({ node, HTMLAttributes }) {
        return [
            'span',
            mergeAttributes(
                { 'data-type': this.name },
                HTMLAttributes
            ),
            `{{ ${node.attrs.id} }}`,
        ]
    },

    renderText({ node }) {
        return `{{ ${node.attrs.id} }}`
    },

    addKeyboardShortcuts() {
        return {
            Backspace: () =>
                this.editor.commands.command(({ tr, state }) => {
                    let isMergeTag = false
                    const { selection } = state
                    const { empty, anchor } = selection

                    if (!empty) {
                        return false
                    }

                    state.doc.nodesBetween(anchor - 1, anchor, (node, pos) => {
                        if (node.type.name === this.name) {
                            isMergeTag = true
                            tr.insertText(
                                '{{',
                                pos,
                                pos + node.nodeSize
                            )

                            return false
                        }
                    })

                    return isMergeTag
                })
        }
    },

    addCommands() {
        return {
            insertMergeTag: (attributes) => ({ chain, state }) => {
                const currentChain = chain()

                if (! [null, undefined].includes(attributes.coordinates?.pos)) {
                    currentChain.insertContentAt(
                        { from: attributes.coordinates.pos, to: attributes.coordinates.pos },
                        [
                            { type: this.name, attrs: { id: attributes.tag } },
                            { type: 'text', text: ' ' },
                        ],
                    )

                    return currentChain
                }
            },
        }
    },
})
