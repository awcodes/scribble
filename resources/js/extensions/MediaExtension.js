import Image from "@tiptap/extension-image";

export default Image.extend({
    name: 'media',

    selectable: true,

    addAttributes() {
        return {
            src: {
                default: null,
            },
            alt: {
                default: '',
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
            },
            alignment: {
                default: 'start',
                parseHTML: element => element.getAttribute('alignment'),
                renderHTML: attributes => {
                    let style;

                    switch(attributes.alignment) {
                        case 'center': style = 'margin-inline: auto'; break;
                        case 'end': style = 'margin-inline-start: auto'; break;
                        default: style = null;
                    }

                    return {
                        'alignment': attributes.alignment,
                        style,
                    }
                },
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
                        alignment: options?.alignment,
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
            setImage: options => ({ state, chain, commands }) => {
                if (! [null, undefined].includes(options.coordinates?.pos)) {
                    return chain().focus().insertContentAt({from: options.coordinates.pos, to: options.coordinates.pos}, {
                        type: this.name,
                        attrs: options,
                    }).run()
                }

                return chain().focus().insertContent({
                    type: this.name,
                    attrs: options,
                }).run()
            },
        }
    },
});
