<script>
    export let items
    export let editor
    export let range

    let selectedIndex = 0
    let dropdown
    let groups

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

    $: getGroups(items)

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
            if (item.type === 'custom') {
                editor.commands.setScribbleBlock({
                    type: item.name,
                })
            }

            if (item.type === 'default') {
                const action = editor.chain().focus().deleteRange(range)

                switch (item.name) {
                    case 'scribble.heading':
                        action.setHeading({ level: 1 }).run()
                        break
                    case 'scribble.blockquote':
                        action.toggleBlockquote().run()
                        break
                    case 'scribble.horizontalRule':
                        action.setHorizontalRule().run()
                        break
                    case 'scribble.orderedList':
                        action.toggleOrderedList().run()
                        break
                    case 'scribble.bulletList':
                        action.toggleBulletList().run()
                        break
                    default:
                        console.error(`Block "${item.name}" not implemented`)
                }
            }
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
    class="w-56 max-h-56 overflow-y-auto scrollbar-hide text-xs rounded-lg bg-white shadow-lg ring-1 ring-gray-950/5 transition dark:divide-white/5 dark:bg-gray-900 dark:ring-white/10"
    bind:this={dropdown}
>
    <div>
        {#if items.length}
            {#each Object.keys(groups) as group}
                {#if group }
                    <div class="text-xs my-1 px-2 font-bold">{group}</div>
                {/if}
                {#each groups[group] as item}
                    <button
                        on:click={() => selectItem(item.index)}
                        class="p-2 w-full flex gap-2 items-center cursor-pointer select-none { item.index === selectedIndex ? 'bg-gray-100 dark:bg-gray-700 active-option' : 'hover:bg-gray-50 dark:hover:bg-gray-800' }"
                    >
                        <span class="shrink-0 rounded-md flex items-center justify-center text-gray-700 dark:text-gray-200">
                            {@html item.icon}
                        </span>
                        <span class="flex-1 text-left">
                            <span class="block">{item.title}</span>
                            {#if item.description}
                            <span class="block text-gray-500 text-xs dark:text-gray-300">{item.description}</span>
                            {/if}
                        </span>
                    </button>
                {/each}
            {/each}
        {/if}

        {#if !items.length}
            <div class="p-2 text-gray-700 dark:text-gray-200">No blocks found</div>
        {/if}
    </div>
</div>
