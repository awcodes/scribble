import { callOrReturn, getExtensionField, Node, mergeAttributes } from '@tiptap/core'
import { TextSelection } from '@tiptap/pm/state'
import { createGrid } from './utils/createGrid.js'

export default Node.create({
    name: 'grid',
    group: 'block',
    defining: true,
    isolating: true,
    allowGapCursor: false,
    content: 'gridColumn+',
    gridRole: 'grid',
    addOptions() {
        return {
            HTMLAttributes: {
                class: 'scribble-grid',
            },
        }
    },
    addAttributes() {
        return {
            'data-type': {
                default: 'responsive',
                parseHTML: (element) => element.getAttribute('data-type'),
            },
            'data-columns': {
                default: 2,
                parseHTML: (element) => element.getAttribute('data-columns'),
            },
            'data-stack-at': {
                default: 'md',
                parseHTML: (element) => element.getAttribute('data-stack-at'),
            },
            'style': {
                default: null,
                parseHTML: (element) => element.getAttribute('style'),
                renderHTML: (attributes) => {
                    return {
                        style: `grid-template-columns: repeat(${attributes['data-columns']}, 1fr);`,
                    }
                },
            },
        }
    },
    parseHTML() {
        return [
            {
                tag: 'div',
                getAttrs: (node) => (node.classList.contains("scribble-grid") && ! node.classList.contains("-column")) && null,
            },
        ]
    },
    renderHTML({ HTMLAttributes }) {
        return ['div', mergeAttributes(this.options.HTMLAttributes, HTMLAttributes), 0]
    },
    addCommands() {
        return {
            insertGrid:
                ({ columns = 2, stack_at, asymmetric, left_span = null, right_span = null, coordinates = null } = {}) =>
                    ({ tr, dispatch, editor }) => {
                        const node = createGrid(editor.schema, columns, stack_at, asymmetric, left_span, right_span)

                        if (dispatch) {
                            const offset = tr.selection.anchor + 1

                            if (! [null, undefined].includes(coordinates?.pos)) {
                                tr.replaceRangeWith(coordinates.pos, coordinates.pos, node)
                                    .scrollIntoView()
                                    .setSelection(TextSelection.near(tr.doc.resolve(offset)))
                            } else {
                                tr.replaceSelectionWith(node)
                                    .scrollIntoView()
                                    .setSelection(TextSelection.near(tr.doc.resolve(offset)))
                            }
                        }

                        return true
                    },
        }
    },
    extendNodeSchema(extension) {
        const context = {
            name: extension.name,
            options: extension.options,
            storage: extension.storage,
        }

        return {
            gridRole: callOrReturn(getExtensionField(extension, 'gridRole', context)),
        }
    },
})
