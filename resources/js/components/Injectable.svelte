<script>
    import { NodeViewContent } from 'svelte-tiptap'

    export let html;

    export let rules;

    let parsedHtml = [html];

    rules.forEach(rule => {
        parsedHtml = parsedHtml.map(substr => substr.split(rule.regex)).flat();
    })

    console.log(parsedHtml);
</script>

{#each parsedHtml as part}
    {@const match = (rules.find(rule => rule.regex.test(part)))}
    {#if match}
        <svelte:component this={match.component} {...match.props}>
            <div style="white-space: inherit;"><p><br class="ProseMirror-trailingBreak"></p></div>
        </svelte:component>
    {:else}
        {@html part}
    {/if}
{/each}
