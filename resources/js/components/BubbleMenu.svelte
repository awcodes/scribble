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
        {#if !isActive('link')}
            {#if tools.length}
                {#each tools as tool}
                    {#if tool.type === 'divider'}
                        <div class="divider" />
                    {:else}
                        <Button {editor}
                            key={tool.extension}
                            active={isActive(tool.active.extension, tool.active.attrs)}
                            on:click={() => handleToolClick(tool)}
                            hidden={tool.isHidden}
                        >
                            {@html tool.icon}
                        </Button>
                    {/if}
                {/each}
            {/if}
        {:else if isActive('link')}
            <span class="link-preview">{editor.getAttributes('link').href}</span>
            <Button {editor} key="editLink" on:click={() => handleToolClick(tools.find((item) => item.extension === 'link'), true)}>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M6.41421 15.89L16.5563 5.74786L15.1421 4.33365L5 14.4758V15.89H6.41421ZM7.24264 17.89H3V13.6474L14.435 2.21233C14.8256 1.8218 15.4587 1.8218 15.8492 2.21233L18.6777 5.04075C19.0682 5.43128 19.0682 6.06444 18.6777 6.45497L7.24264 17.89ZM3 19.89H21V21.89H3V19.89Z"/>
                </svg>
            </Button>
            <Button {editor} key="unsetLink" on:click={() => editor.chain().focus().extendMarkRange('link').unsetLink().selectTextblockEnd().run()}>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M17 17H22V19H19V22H17V17ZM7 7H2V5H5V2H7V7ZM18.364 15.5355L16.9497 14.1213L18.364 12.7071C20.3166 10.7545 20.3166 7.58866 18.364 5.63604C16.4113 3.68342 13.2455 3.68342 11.2929 5.63604L9.87868 7.05025L8.46447 5.63604L9.87868 4.22183C12.6123 1.48816 17.0445 1.48816 19.7782 4.22183C22.5118 6.9555 22.5118 11.3877 19.7782 14.1213L18.364 15.5355ZM15.5355 18.364L14.1213 19.7782C11.3877 22.5118 6.9555 22.5118 4.22183 19.7782C1.48816 17.0445 1.48816 12.6123 4.22183 9.87868L5.63604 8.46447L7.05025 9.87868L5.63604 11.2929C3.68342 13.2455 3.68342 16.4113 5.63604 18.364C7.58866 20.3166 10.7545 20.3166 12.7071 18.364L14.1213 16.9497L15.5355 18.364ZM14.8284 7.75736L16.2426 9.17157L9.17157 16.2426L7.75736 14.8284L14.8284 7.75736Z"/>
                </svg>
            </Button>
        {/if}
    </div>
{/if}
