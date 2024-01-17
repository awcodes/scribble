<script>
    export let items
    export let editor

    let selectedIndex = 0
    let dropdown
    let groups

    const getGroups = array => {
        let map = array.map((e, i) => {
            e.index = i
            return e
        })

        groups = map.reduce(function (r, a) {
            r[a.group] = r[a.group] || []
            r[a.group].push(a)
            return r
        }, Object.create(null))
    }

    $: getGroups(items)

    export const resetIndex = () => selectedIndex = 0

    export const onKeyDown = ({event}) => {
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
                    type: item.name
                })
            }

            if (item.type === 'default') {
                const action = editor.chain().focus()

                switch (item.name) {
                    case 'heading':
                        action.setHeading({ level: 1 }).run()
                        break
                    case 'blockquote':
                        action.toggleBlockquote().run()
                        break
                    case 'horizontalRule':
                        action.setHorizontalRule().run()
                        break
                    case 'orderedList':
                        action.toggleOrderedList().run()
                        break
                    case 'bulletList':
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
                inline: 'end'
            })
        }, 0)
    }
</script>

<div
    class="w-56 max-h-56 overflow-y-auto scrollbar-hide rounded-md bg-white text-gray-900 text-sm  shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
    bind:this={dropdown}
>
    <div class="py-1">
        {#if items.length}
            {#each Object.keys(groups) as group}
                {#if group }
                    <div class="text-xs my-1 px-2 font-bold">{group}</div>
                {/if}
                {#each groups[group] as item}
                    <button
                        on:click={() => selectItem(item.index)}
                        class="p-2 space-x-2 flex items-center cursor-pointer select-none { item.index === selectedIndex ? 'bg-gray-100 active-option' : 'hover:bg-gray-50' }"
                    >
                        <span class="w-9 h-9 rounded-md border flex items-center justify-center text-gray-700">
                            {@html item.icon}
                        </span>
                        <span class="flex-1">
                            <span>{item.title}</span>
                            <span class="text-gray-500 text-xs">{item.description}</span>
                        </span>
                    </button>
                {/each}
            {/each}
        {/if}

        {#if !items.length}
            <div class="p-2 text-gray-500">No blocks found</div>
        {/if}
    </div>
</div>
