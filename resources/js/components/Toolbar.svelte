<script>
    import Button from './Button.svelte'
    import ColorPicker from './ColorPicker.svelte'

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

{#if editor && tools && tools.length > 0}
    <div class="scribble-toolbar">
        {#if tools.length}
            {#each tools as tool}
                {#if tool.type === 'divider'}
                    <div class="divider" />
                {:else if tool.identifier === 'color'}
                    <ColorPicker {editor} {tool} {handleToolClick} />
                {:else}
                    <Button {editor}
                        key={tool.identifier}
                        active={isActive(tool.active.extension, tool.active.attrs)}
                        on:click={() => handleToolClick(tool.identifier)}
                        hidden={tool.isHidden}
                    >
                        {@html tool.icon}
                    </Button>
                {/if}
            {/each}
        {/if}
    </div>
{/if}
