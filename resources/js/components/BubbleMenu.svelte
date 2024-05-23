<script>
    import Button from './Button.svelte'

    export let editor
    export let isActive
    export let tools
    export let handleToolClick

    let groups = {}

    const getGroups = array => {
        let map = array.map((e, i) => {
            e.index = i
            return e
        })

        groups = map.reduce(function(r, a) {
            r[a.group] = r[a.group] || []
            r[a.group].push(a)
            return r
        }, Object.create(null))
    }

    $: getGroups(tools)
</script>

{#if editor}
    <div class="scribble-bubble-menu">
        {#if !isActive('link') && !isActive('media')}
            {#if tools.length}
                {#each tools as tool}
                    {#if tool.type === 'divider'}
                        <div class="divider" />
                    {:else}
                        <Button {editor}
                            key={tool.extension}
                            active={isActive(tool.active.extension, tool.active.attrs)}
                            on:click={() => handleToolClick(tool.extension)}
                            hidden={tool.isHidden}
                        >
                            {@html tool.icon}
                        </Button>
                    {/if}
                {/each}
            {/if}
        {:else if isActive('link')}
            <span class="link-preview">{editor.getAttributes('link').href}</span>
            <Button {editor} key="editLink" on:click={() => handleToolClick('link', true)}>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M6.41421 15.89L16.5563 5.74786L15.1421 4.33365L5 14.4758V15.89H6.41421ZM7.24264 17.89H3V13.6474L14.435 2.21233C14.8256 1.8218 15.4587 1.8218 15.8492 2.21233L18.6777 5.04075C19.0682 5.43128 19.0682 6.06444 18.6777 6.45497L7.24264 17.89ZM3 19.89H21V21.89H3V19.89Z"/>
                </svg>
            </Button>
            <Button {editor} key="unsetLink" on:click={() => editor.chain().focus().extendMarkRange('link').unsetLink().selectTextblockEnd().run()}>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M17 17H22V19H19V22H17V17ZM7 7H2V5H5V2H7V7ZM18.364 15.5355L16.9497 14.1213L18.364 12.7071C20.3166 10.7545 20.3166 7.58866 18.364 5.63604C16.4113 3.68342 13.2455 3.68342 11.2929 5.63604L9.87868 7.05025L8.46447 5.63604L9.87868 4.22183C12.6123 1.48816 17.0445 1.48816 19.7782 4.22183C22.5118 6.9555 22.5118 11.3877 19.7782 14.1213L18.364 15.5355ZM15.5355 18.364L14.1213 19.7782C11.3877 22.5118 6.9555 22.5118 4.22183 19.7782C1.48816 17.0445 1.48816 12.6123 4.22183 9.87868L5.63604 8.46447L7.05025 9.87868L5.63604 11.2929C3.68342 13.2455 3.68342 16.4113 5.63604 18.364C7.58866 20.3166 10.7545 20.3166 12.7071 18.364L14.1213 16.9497L15.5355 18.364ZM14.8284 7.75736L16.2426 9.17157L9.17157 16.2426L7.75736 14.8284L14.8284 7.75736Z"/>
                </svg>
            </Button>
        {:else if isActive('media')}
            <Button {editor} key="editMedia" on:click={() => handleToolClick('media', true)}>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-4">
                    <path fill-rule="evenodd" d="M15 4.5A3.5 3.5 0 0 1 11.435 8c-.99-.019-2.093.132-2.7.913l-4.13 5.31a2.015 2.015 0 1 1-2.827-2.828l5.309-4.13c.78-.607.932-1.71.914-2.7L8 4.5a3.5 3.5 0 0 1 4.477-3.362c.325.094.39.497.15.736L10.6 3.902a.48.48 0 0 0-.033.653c.271.314.565.608.879.879a.48.48 0 0 0 .653-.033l2.027-2.027c.239-.24.642-.175.736.15.09.31.138.637.138.976ZM3.75 13a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" clip-rule="evenodd" />
                    <path d="M11.5 9.5c.313 0 .62-.029.917-.084l1.962 1.962a2.121 2.121 0 0 1-3 3l-2.81-2.81 1.35-1.734c.05-.064.158-.158.426-.233.278-.078.639-.11 1.062-.102l.093.001ZM5 4l1.446 1.445a2.256 2.256 0 0 1-.047.21c-.075.268-.169.377-.233.427l-.61.474L4 5H2.655a.25.25 0 0 1-.224-.139l-1.35-2.7a.25.25 0 0 1 .047-.289l.745-.745a.25.25 0 0 1 .289-.047l2.7 1.35A.25.25 0 0 1 5 2.654V4Z" />
                </svg>
            </Button>
            <Button {editor} key="removeMedia" on:click={() => editor.commands.deleteSelection()}>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-4">
                    <path fill-rule="evenodd" d="M5 3.25V4H2.75a.75.75 0 0 0 0 1.5h.3l.815 8.15A1.5 1.5 0 0 0 5.357 15h5.285a1.5 1.5 0 0 0 1.493-1.35l.815-8.15h.3a.75.75 0 0 0 0-1.5H11v-.75A2.25 2.25 0 0 0 8.75 1h-1.5A2.25 2.25 0 0 0 5 3.25Zm2.25-.75a.75.75 0 0 0-.75.75V4h3v-.75a.75.75 0 0 0-.75-.75h-1.5ZM6.05 6a.75.75 0 0 1 .787.713l.275 5.5a.75.75 0 0 1-1.498.075l-.275-5.5A.75.75 0 0 1 6.05 6Zm3.9 0a.75.75 0 0 1 .712.787l-.275 5.5a.75.75 0 0 1-1.498-.075l.275-5.5a.75.75 0 0 1 .786-.711Z" clip-rule="evenodd" />
                </svg>
            </Button>
        {/if}
    </div>
{/if}
