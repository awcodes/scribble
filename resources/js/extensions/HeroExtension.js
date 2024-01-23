import { Node, mergeAttributes } from "@tiptap/core";
import { SvelteNodeViewRenderer } from 'svelte-tiptap'
import HeroView from '../components/HeroView.svelte'

export const HeroExtension = Node.create({
    name: "hero",

    group: "block",

    content: "block+",

    addOptions() {
        return {
            colors: [
                'grayLight',
                'gray',
                'grayDark',
                'primary',
                'secondary',
                'tertiary',
                'accent'
            ],
            HTMLAttributes: {
                class: "hero-block"
            }
        }
    },

    addAttributes() {
        return {
            color: {
                default: 'primary',
                parseHTML: (element) => element.getAttribute('data-color'),
                renderHTML: (attributes) => {
                    if (! attributes.color) {
                        return null
                    }

                    return {
                        'data-color': attributes.color,
                    }
                }
            }
        }
    },

    parseHTML() {
        return [
            {
                tag: 'div',
                getAttrs: (element) => element.classList.contains('hero-block')
            }
        ]
    },

    renderHTML({ node, HTMLAttributes}) {
        return [
            'div',
            mergeAttributes(this.options.HTMLAttributes, HTMLAttributes),
            0
        ]
    },

    addCommands() {
        return {
            toggleHero: (attributes) => ({ commands }) => {
                return commands.toggleWrap(this.name, attributes)
            }
        }
    },

    addNodeView() {
        return SvelteNodeViewRenderer(HeroView)
    }
})
