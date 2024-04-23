<script>
    import Button from './Button.svelte'
    import cx from 'clsx'

    export let editor
    export let isActive
    export let tools
    export let mergeTags
    export let handleToolClick

    let groups = {}
    let open = true

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

    const insertMergeTag = (tag) => {
        const range = editor.view.state.selection
        const nodeAfter = editor.view.state.selection.$to.nodeAfter
        const overrideSpace = nodeAfter?.text?.startsWith(' ')

        if (overrideSpace) {
            range.to += 1
        }

        editor
            .chain()
            .focus()
            .insertContentAt(range, [
                {
                    type: 'mergeTag',
                    attrs: {id: tag}
                },
                {
                    type: 'text',
                    text: ' '
                },
            ])
            .run()
    }
</script>

{#if editor && ((tools && tools.length > 0) || (mergeTags && mergeTags.length > 0))}
    <div
         class={cx(
                `scribble-panel`,
                {
                    'collapsed': !open
                }
            )}
    >
        <div class="scribble-panel-toggle">
            <button type="button" class="scribble-button" aria-label="Toggle panel" on:click={() => open = !open}>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                     stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                </svg>
            </button>
        </div>
        <div class="scribble-panel-tools">
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
                            <span>{tool.label}</span>
                        </Button>
                    {/if}
                {/each}
            {/if}
            {#if mergeTags.length}
                {#each mergeTags as tag}
                    <Button {editor}
                        key={tag}
                        active={false}
                        on:click={() => insertMergeTag(tag)}
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M4 18V14.3C4 13.4716 3.32843 12.8 2.5 12.8H2V11.2H2.5C3.32843 11.2 4 10.5284 4 9.7V6C4 4.34315 5.34315 3 7 3H8V5H7C6.44772 5 6 5.44772 6 6V10.1C6 10.9858 5.42408 11.7372 4.62623 12C5.42408 12.2628 6 13.0142 6 13.9V18C6 18.5523 6.44772 19 7 19H8V21H7C5.34315 21 4 19.6569 4 18ZM20 14.3V18C20 19.6569 18.6569 21 17 21H16V19H17C17.5523 19 18 18.5523 18 18V13.9C18 13.0142 18.5759 12.2628 19.3738 12C18.5759 11.7372 18 10.9858 18 10.1V6C18 5.44772 17.5523 5 17 5H16V3H17C18.6569 3 20 4.34315 20 6V9.7C20 10.5284 20.6716 11.2 21.5 11.2H22V12.8H21.5C20.6716 12.8 20 13.4716 20 14.3Z"></path></svg>
                        <span>{tag}</span>
                    </Button>
                {/each}
            {/if}
        </div>
    </div>
{/if}
