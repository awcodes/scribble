<script>
    import { pounce } from '../utils/pounce.js'

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

            console.log(item)
            if (item.type === 'block' && item.prerender) {
                editor.chain().insertScribbleBlock({
                    type: item.identifier,
                    statePath: item.statePath,
                    values: {}
                }).focus().run();
            } else {
                switch (item.type) {
                    case 'command':
                        editor.chain().focus().deleteRange(range)[item.command](item.commandArguments).run();
                        break
                    case 'modal':
                        editor.commands.deleteRange(range);
                        pounce(item.identifier, { statePath: item.statePath, ...editor.getAttributes(item.extension) });
                        break
                    default:
                        editor.commands.setScribbleBlock({
                            type: item.identifier,
                            statePath: item.statePath,
                        })
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
    class="w-56 max-h-56 overflow-y-auto scrollbar-hide text-xs rounded-lg shadow-lg ring-1 ring-gray-950/5 transition dark:ring-white/10"
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
                        class="p-2 w-full flex gap-2 items-center cursor-pointer select-none { item.index === selectedIndex ? 'bg-gray-800 active-option' : 'hover:bg-gray-800' }"
                    >
                        <span class="shrink-0 rounded-md flex items-center justify-center text-gray-200">
                            {@html item.icon}
                        </span>
                        <span class="flex-1 text-left">
                            <span class="block">{item.label}</span>
                            {#if item.description}
                            <span class="block text-xs text-gray-300">{item.description}</span>
                            {/if}
                        </span>
                    </button>
                {/each}
            {/each}
        {/if}

        {#if !items.length}
            <div class="p-2 text-gray-200">No blocks found</div>
        {/if}
    </div>
</div>
