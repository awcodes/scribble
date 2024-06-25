<script>
    import { NodeViewContent, NodeViewWrapper } from 'svelte-tiptap'
    import BlockActions from './BlockActions.svelte'

    export let node;
    export let extension;
    export let updateAttributes;

    let languages = extension.options.lowlight.listLanguages()
    let selectedLanguage = node.attrs.language ?? null
</script>

<NodeViewWrapper>
    <div class="scribble-code-block">
        <BlockActions>
            <select
                contenteditable="false"
                bind:value={selectedLanguage}
                on:change={() => updateAttributes({language: selectedLanguage})}
            >
                <option value={null}>
                    auto
                </option>
                <option disabled>
                    —
                </option>
                {#each languages as language}
                    <option value={language}>
                        {language}
                    </option>
                {/each}
            </select>
        </BlockActions>
        <pre class={extension.options.HTMLAttributes.class}><NodeViewContent as="code" class={`${extension.options.languageClassPrefix}${node.attrs.language}`}/></pre>
    </div>
</NodeViewWrapper>
