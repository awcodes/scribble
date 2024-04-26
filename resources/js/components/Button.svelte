<script>
    import cx from 'clsx'

    export let editor
    export let key
    export let active = false
    export let hidden
</script>

{#if editor && !hidden}
<button
    type="button"
    on:click
    class={cx(
        `scribble-button scribble-${key}`,
        {
            'active': active
        }
    )}
>
    <slot />
</button>
{/if}
