<script>
    import cx from 'clsx'

    export let editor
    export let key
</script>

{#if editor}
<button
    type="button"
    class:active={editor.isActive(key)}
    on:click
    class={cx(
        `rounded-sm p-1 bg-transparent hover:text-primary-500 focus:outline-none focus:ring-1 focus:ring-primary-500 ${key}`,
        {
            'text-inherit': !editor.isActive(key),
            'text-primary-500': editor.isActive(key)
        }
    )}
>
    <slot />
</button>
{/if}
