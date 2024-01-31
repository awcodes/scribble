import Image from "@tiptap/extension-image";
import { SvelteNodeViewRenderer } from 'svelte-tiptap'
import MediaView from '../components/MediaView.svelte'

export default Image.extend({
    selectable: true,

    addAttributes() {
        return {
            src: {
                default: null,
            },
            alt: {
                default: null,
            },
            title: {
                default: null,
            },
            width: {
                default: null,
            },
            height: {
                default: null,
            },
            loading: {
                default: null,
            },
            sizes: {
                default: null,
            },
            srcset: {
                default: null,
            }
        };
    },

    addNodeView() {
        return SvelteNodeViewRenderer(MediaView)
    }
});
