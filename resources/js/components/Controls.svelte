<script>
    import Button from './Button.svelte'

    export let editor
    export let statePath

    const toggleFullscreen = () => {
        window.dispatchEvent(new CustomEvent('toggle-fullscreen', { detail: { statePath: statePath } }))
        editor.commands.focus()
    }
</script>

{#if editor}
<div class="scribble-controls">
    <div class="scribble-controls-panel">
        <Button {editor} key="undo" on:click={() => editor.chain().focus().undo().run()}>
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 512 512">
                <path fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="32" d="M240 424v-96c116.4 0 159.39 33.76 208 96c0-119.23-39.57-240-208-240V88L64 256Z"/>
            </svg>
        </Button>
        <Button {editor} key="redo" on:click={() => editor.chain().focus().redo().run()}>
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 512 512">
                <path fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="32" d="M448 256L272 88v96C103.57 184 64 304.77 64 424c48.61-62.24 91.6-96 208-96v96Z"/>
            </svg>
        </Button>
        <Button {editor} key="clear" on:click={() => editor.chain().focus().clearContent(true).run()}>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path d="M13.9999 18.9967H20.9999V20.9967H11.9999L8.00229 20.9992L1.51457 14.5115C1.12405 14.1209 1.12405 13.4878 1.51457 13.0972L12.1212 2.49065C12.5117 2.10012 13.1449 2.10012 13.5354 2.49065L21.3136 10.2688C21.7041 10.6593 21.7041 11.2925 21.3136 11.683L13.9999 18.9967ZM15.6567 14.5115L19.1922 10.9759L12.8283 4.61197L9.29275 8.1475L15.6567 14.5115Z"/>
            </svg>
        </Button>
        <Button {editor} key="enter-fullscreen" on:click={toggleFullscreen}>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path fill="none" d="M0 0h24v24H0z"/><path d="M20 3h2v6h-2V5h-4V3h4zM4 3h4v2H4v4H2V3h2zm16 16v-4h2v6h-6v-2h4zM4 19h4v2H2v-6h2v4z"/>
            </svg>
        </Button>
        <Button {editor} key="exit-fullscreen" on:click={toggleFullscreen}>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path fill="none" d="M0 0h24v24H0z"/><path d="M18 7h4v2h-6V3h2v4zM8 9H2V7h4V3h2v6zm10 8v4h-2v-6h6v2h-4zM8 15v6H6v-4H2v-2h6z"/>
            </svg>
        </Button>
    </div>
</div>
{/if}
