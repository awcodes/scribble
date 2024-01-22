const chainer = (editor, fn, args = {}) => editor.chain().focus()[fn](args).run()

const toggleBold = editor => chainer(editor, 'toggleBold')
const toggleItalic = editor => chainer(editor, 'toggleItalic')
const toggleUnderline = editor => chainer(editor, 'toggleUnderline')
const toggleStrike = editor => chainer(editor, 'toggleStrike')
const toggleCode = editor => chainer(editor, 'toggleCode')
const toggleSuperscript = editor => chainer(editor, 'toggleSuperscript')
const toggleSubscript = editor => chainer(editor, 'toggleSubscript')
const toggleHeading = (editor, args) => chainer(editor, 'toggleHeading', args)
const toggleBulletList = editor => chainer(editor, 'toggleBulletList')
const toggleOrderedList = editor => chainer(editor, 'toggleOrderedList')
const toggleBlockquote = editor => chainer(editor, 'toggleBlockquote')
const toggleHorizontalRule = editor => chainer(editor, 'toggleHorizontalRule')
const toggleLink = editor => chainer(editor, 'toggleLink')

export {
    toggleBold,
    toggleItalic,
    toggleUnderline,
    toggleStrike,
    toggleCode,
    toggleSuperscript,
    toggleSubscript,
    toggleHeading,
    toggleBulletList,
    toggleOrderedList,
    toggleBlockquote,
    toggleHorizontalRule,
    toggleLink
}
