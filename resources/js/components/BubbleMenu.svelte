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
                            active={isActive(tool.extension, tool.activeAttributes)}
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
                    <path d="M18.3643 15.5353L16.95 14.1211L18.3643 12.7069C20.3169 10.7543 20.3169 7.58847 18.3643 5.63585C16.4116 3.68323 13.2458 3.68323 11.2932 5.63585L9.87898 7.05007L8.46477 5.63585L9.87898 4.22164C12.6127 1.48797 17.0448 1.48797 19.7785 4.22164C22.5121 6.95531 22.5121 11.3875 19.7785 14.1211L18.3643 15.5353ZM15.5358 18.3638L14.1216 19.778C11.388 22.5117 6.9558 22.5117 4.22213 19.778C1.48846 17.0443 1.48846 12.6122 4.22213 9.87849L5.63634 8.46428L7.05055 9.87849L5.63634 11.2927C3.68372 13.2453 3.68372 16.4112 5.63634 18.3638C7.58896 20.3164 10.7548 20.3164 12.7074 18.3638L14.1216 16.9496L15.5358 18.3638ZM14.8287 7.75717L16.2429 9.17139L9.17187 16.2425L7.75766 14.8282L14.8287 7.75717Z"/>
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
