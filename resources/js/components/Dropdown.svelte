<script>
    import { pounce, commandRunner } from '../utils.js'
    import { getStatePath } from '../stores.js'
    import tippy from 'tippy.js'
    import Button from './Button.svelte'

    export let items
    export let editor
    export let range

    let selectedIndex = 0
    let dropdown
    let trigger

    function tooltip(node, params) {
        let tip = tippy(node, {
            appendTo: () => document.body,
            content: dropdown,
            showOnCreate: false,
            interactive: true,
            triggerTarget: trigger,
            trigger: 'manual',
            placement: 'bottom-start',
            theme: 'scribble-panel',
            arrow: false,
            zIndex: 40,
        });
        return {
            update: (newParams) => {
                tip.setProps(newParams);
            },
            destroy: () => {
                tip.destroy();
            }
        }
    }

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
            // editor.commands.deleteRange(range);
            switch (item.type) {
                case 'command':
                    commandRunner(editor, item.commands)
                    break
                case 'modal':
                    pounce(item.identifier, { statePath: $getStatePath, ...editor.getAttributes(item.extension) });
                    break
                case 'static':
                    editor.chain().insertScribbleBlock({
                        identifier: item.identifier,
                        type: item.type,
                        values: {}
                    }).focus().run();
                    break
                default:
                    editor.commands.setScribbleBlock({
                        identifier: item.identifier,
                        statePath: item.statePath,
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

<div class="dropdown">
    <div class="flex-1">
        <button type="button" bind:this={trigger} {editor} use:tooltip
                class="rounded-sm p-1 bg-transparent hover:text-primary-500 focus:outline-none focus:ring-1 focus:ring-primary-500">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                 stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
        </button>
    </div>
    {#if dropdown}
    <div
        class="w-56 max-h-56 overflow-y-auto scrollbar-hide text-xs rounded-lg shadow-lg ring-1 ring-gray-950/5 transition dark:ring-white/10 hidden"
        bind:this={dropdown}
    >
        <div>
            {#if items.length}
                {#each items as item, index}
                    <Button {editor} key={item.extension} on:click={() => selectItem(index)}>
                        {@html item.icon}
                    </Button>
                {/each}
            {/if}
        </div>
    </div>
        {/if}
</div>
