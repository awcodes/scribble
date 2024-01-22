<script>
    import {
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
    } from '../button-actions.js'
    import {
        Bold,
        Italic,
        Underline,
        Strikethrough,
        Code,
        Superscript,
        Subscript,
        Heading,
        List,
        ListOrdered,
        Quote,
        Minus,
        Link
    } from 'lucide-svelte'
    import Button from './Button.svelte'

    export let editor
</script>

{#if editor}
<div class="bubble-menu">
    <Button {editor} key="bold" on:click={() => toggleBold(editor)}><Bold size={16}/></Button>
    <Button {editor} key="italic" on:click={() => toggleItalic(editor)}><Italic size={16}/></Button>
    <Button {editor} key="underline" on:click={() => toggleUnderline(editor)}><Underline size={16}/></Button>
    <Button {editor} key="strike" on:click={() => toggleStrike(editor)}><Strikethrough size={16}/></Button>
    <Button {editor} key="code" on:click={() => toggleCode(editor)}><Code size={16}/></Button>
    <Button {editor} key="superscript" on:click={() => toggleSuperscript(editor)}><Superscript size={16}/></Button>
    <Button {editor} key="subscript" on:click={() => toggleSubscript(editor)}><Subscript size={16}/></Button>
    <Button {editor} key="heading" on:click={() => toggleHeading(editor, { level: 2 })}><Heading size={16}/></Button>
    <Button {editor} key="bullet-list" on:click={() => toggleBulletList(editor)}><List size={16}/></Button>
    <Button {editor} key="ordered-list" on:click={() => toggleOrderedList(editor)}><ListOrdered size={16}/></Button>
    <Button {editor} key="blockquote" on:click={() => toggleBlockquote(editor)}><Quote size={16}/></Button>
    <Button {editor} key="horizontal-rule" on:click={() => toggleHorizontalRule(editor)}><Minus size={16}/></Button>
    <Button {editor} key="link" on:click={() => toggleLink(editor)}><Link size={16}/></Button>
</div>
{/if}
