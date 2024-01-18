<script>
    import cx from 'clsx'

    export let editor;
    export let tool;

    console.log(tool)

    $: isActive = (name, attrs = {}) => $editor.isActive(name, attrs);
</script>

<button
    type="button"
    on:click={tool.action}
    class="{cx(
        'rounded-sm p-1 bg-transparent hover:text-primary-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500',
        {
            'text-primary-400': isActive(tool.name),
            'text-white': !isActive(tool.name)
        }
    )}"
>
    {@html tool.icon}
</button>
