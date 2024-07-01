import CodeBlockLowlight from '@tiptap/extension-code-block-lowlight'
import { SvelteNodeViewRenderer } from 'svelte-tiptap'
import CodeBlockView from '../components/CodeBlockView.svelte'
import { lowlight } from 'lowlight/lib/common'

export default CodeBlockLowlight.extend({
    addOptions() {
        return {
            ...this.parent?.(),
            lowlight,
            languageClassPrefix: 'hljs language-'
        }
    },
    addNodeView() {
        return SvelteNodeViewRenderer(CodeBlockView)
    },
    addKeyboardShortcuts() {
        return {
            Tab: ({editor}) => {
                if (editor.isActive('codeBlock')) {
                    return editor.commands.insertContent('\t')
                }
            },
            'Shift-Tab': ({editor}) => {
                if (editor.isActive('codeBlock')) {
                    const pos = editor.view.state.selection.$head.pos
                    return editor.commands.deleteRange({from: pos - 1, to: pos})
                }
            }
        }
    }
})
