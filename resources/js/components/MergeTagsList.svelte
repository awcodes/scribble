<script>
    export let items
    export let editor
    export let range

    let selectedIndex = 0
    let dropdown

    export const resetIndex = () => selectedIndex = 0

    export const onKeyDown = ({ event }) => {
        if (event.key === 'ArrowUp') {
            upHandler()
            return true
        }

        if (event.key === 'ArrowDown') {
            downHandler()
            return true
        }

        if (event.key === 'Enter') {
            enterHandler()
            return true
        }

        return false
    }

    const upHandler = () => {
        selectedIndex = ((selectedIndex + items.length) - 1) % items.length
        scrollToSelect()
    }

    const downHandler = () => {
        selectedIndex = (selectedIndex + 1) % items.length
        scrollToSelect()
    }

    const enterHandler = () => {
        selectItem(selectedIndex)
    }

    const selectItem = index => {
        const item = items[index]

        if (item) {
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
                        attrs: {id: item}
                    },
                    {
                        type: 'text',
                        text: ' '
                    },
                ])
                .run()

            window.getSelection()?.collapseToEnd()
        }
    }

    const scrollToSelect = () => {
        setTimeout(() => {
            dropdown.querySelector('.active-option').scrollIntoView({
                behavior: 'smooth',
                block: 'nearest',
                inline: 'end',
            })
        }, 0)
    }
</script>

<div
    class="scribble-merge-tags"
    bind:this={dropdown}
>
    <div class="group">
        {#if items.length}
            {#each items as item, i}
                <button
                    on:click={() => selectItem(i)}
                    class=" { i ===
                    selectedIndex ? 'active-option' : '' }"
                >
                    <span class="text">
                        {item}
                    </span>
                </button>
            {/each}
        {/if}

        {#if !items.length}
            <div class="no-blocks">No merge tags set</div>
        {/if}
    </div>
</div>
