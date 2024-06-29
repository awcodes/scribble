<script>
    import { onMount } from 'svelte'
    import Pickr from '@simonwep/pickr';
    import {commandRunner} from '../utils.js'

    export let editor;
    export let tool;

    let parent;
    let picker;

    onMount(() => {
        picker = Pickr.create({
            el: parent,
            theme: 'nano',
            useAsButton: false,
            components: {
                palette: true,
                opacity: true,
                hue: true,
                preview: true,
                interaction: {
                    input: true,
                    save: true,
                    clear: true,
                }
            }
        })

        picker.on('save', (color) => {
            if (! color) {
                editor.chain().focus().unsetColor().run()
                return
            }

            commandRunner(editor, tool.commands, color.toHEXA())
        })
    })

</script>

<button
    type="button"
    class="scribble-button scribble-color"
    bind:this={parent}
>
    {@html tool.icon}
</button>
