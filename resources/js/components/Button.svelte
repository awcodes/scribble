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
    class:active={active}
    on:click
    class={cx(
        `scribble-button ${key}`,
        {
            'active': active
        }
    )}
>
    <slot />
</button>
{/if}
