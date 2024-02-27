<script>
    import { pounce, commandRunner } from '../utils.js'

    export let items
    export let editor
    export let range
    export let statePath

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
            editor.commands.deleteRange(range);
            switch (item.type) {
                case 'command':
                    commandRunner(editor, item.commands)
                    break
                case 'modal':
                    pounce(item.options, {
                        statePath: statePath,
                        identifier: item.identifier,
                        data: editor.getAttributes(item.extension)
                    });
                    break
                case 'static':
                    editor.chain().insertScribbleBlock({
                        identifier: item.identifier,
                        type: item.type,
                        statePath: statePath,
                        blockId: item.blockId,
                        values: {}
                    }).focus().run();
                    break
                default:
                    editor.commands.setScribbleBlock({
                        identifier: item.identifier,
                        statePath: statePath,
                        blockId: item.blockId,
                    })
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
    class="scribble-suggestions"
    bind:this={dropdown}
>
    <div class="group">
        {#if items.length}
            {#each Object.keys(groups) as group}
                {#if group }
                    <div class="group-title">{group}</div>
                {/if}
                {#each groups[group] as item}
                    <button
                        on:click={() => selectItem(item.index)}
                        class=" { item.index ===
                        selectedIndex ? 'active-option' : '' }"
                    >
                        <span class="icon">
                            {@html item.icon}
                        </span>
                        <span class="text">
                            <span class="label">{item.label}</span>
                            {#if item.description}
                            <span class="description">{item.description}</span>
                            {/if}
                        </span>
                    </button>
                {/each}
            {/each}
        {/if}

        {#if !items.length}
            <div class="no-blocks">No blocks found</div>
        {/if}
    </div>
</div>
