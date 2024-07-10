import { Node } from "@tiptap/core";
import {
    getVimeoEmbedUrl,
    getYouTubeEmbedUrl
} from "../utils";

export default Node.create({
    name: "embed",

    group: 'block',

    selectable: true,

    draggable: true,

    atom: true,

    addOptions() {
        return {
            allowFullscreen: true,
            allow: 'autoplay; fullscreen; picture-in-picture',
            HTMLAttributes: {
                class: 'scribble-embed',
            },
            width: 640,
            height: 480,
        };
    },

    addAttributes() {
        return {
            style: {
                default: null,
                parseHTML: (element) => element.getAttribute("style"),
            },
            src: {
                default: null,
            },
            frameborder: {
                default: 0,
            },
            allowfullscreen: {
                default: this.options.allowFullscreen,
                parseHTML: () => this.options.allowFullscreen,
            },
            allow: {
                default: this.options.allow,
                parseHTML: (element) => element.getAttribute("allow"),
            },
            width: {
                default: this.options.width,
                parseHTML: (element) => element.getAttribute("width"),
            },
            height: {
                default: this.options.height,
                parseHTML: (element) => element.getAttribute("height"),
            },
            responsive: {
                default: true,
                parseHTML: (element) => element.classList.contains("responsive") ?? false,
            },
        };
    },

    parseHTML() {
        return [
            {
                tag: "iframe",
            },
        ];
    },

    addCommands() {
        return {
            setEmbed: (options) => ({tr, dispatch}) => {
                if (options?.start_at) {
                    options.options['start'] = options.start_at
                }

                if (options.src.includes('youtu')) {
                    options.src = getYouTubeEmbedUrl(options)
                } else if (options.src.includes('vimeo')) {
                    options.src = getVimeoEmbedUrl(options)
                }

                const { selection } = tr
                const node = this.type.create(options)

                if (dispatch) {
                    tr.replaceRangeWith(selection.from, selection.to, node)
                }

                return true
            }
        };
    },

    renderHTML({ HTMLAttributes }) {
        return ['div', this.options.HTMLAttributes, ['iframe', {
            class: HTMLAttributes.responsive ? 'responsive' : null,
            src: HTMLAttributes.src,
            width: HTMLAttributes.responsive ? HTMLAttributes.width * 10 : HTMLAttributes.width,
            height: HTMLAttributes.responsive ? HTMLAttributes.height * 10 : HTMLAttributes.height,
            allowfullscreen: HTMLAttributes.allowfullscreen,
            frameborder: HTMLAttributes.frameborder,
            allow: HTMLAttributes.allow,
            style: HTMLAttributes.responsive ? `aspect-ratio: ${HTMLAttributes.width} / ${HTMLAttributes.height}; width: 100%; height: auto;` : null,
        }]];
    },
});
