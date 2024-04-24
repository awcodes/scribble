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

    addCommands() {
        return {
            setMedia: options => ({ commands }) => {
                const src = options?.url || options?.src;
                const imageTypes = ['jpg', 'jpeg', 'svg', 'png', 'webp'];

                const regex = /.*\.([a-zA-Z]*)\??/;
                const match = regex.exec(src);

                if (match !== null && imageTypes.includes(match[1])) {
                    commands.setImage({
                        src: src,
                        alt: options?.alt,
                        title: options?.title,
                        width: options?.width,
                        height: options?.height,
                        lazy: options?.lazy,
                        coordinates: options?.coordinates,
                    })
                } else {
                    commands.setDocument(options)
                }
            },
            setDocument: options => ({ chain }) => {
                if (! [null, undefined].includes(options.coordinates?.pos)) {
                    return chain().focus().extendMarkRange('link').setLink({ href: options.src }).insertContentAt({from: options.coordinates.pos, to: options.coordinates.pos}, {
                        type: this.name,
                        attrs: options,
                    }).run()
                }

                return chain().focus().extendMarkRange('link').setLink({ href: options.src }).insertContent(options?.link_text).run()
            },
            setImage: options => ({ chain }) => {
                if (! [null, undefined].includes(options.coordinates?.pos)) {
                    return chain().focus().insertContentAt({from: options.coordinates.pos, to: options.coordinates.pos}, {
                        type: this.name,
                        attrs: options,
                    }).run()
                }

                return chain().focus().insertContent({
                    type: this.name,
                    attrs: options,
                }).createParagraphNear().run()
            },
        }
    },

    addNodeView() {
        return SvelteNodeViewRenderer(MediaView)
    }
});
