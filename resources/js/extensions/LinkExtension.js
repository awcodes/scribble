import Link from '@tiptap/extension-link'

export default Link.extend({
    inclusive: false,

    addOptions() {
        return {
            openOnClick: false,
            linkOnPaste: true,
            autolink: false,
            protocols: [],
            HTMLAttributes: {},
            validate: undefined,
        }
    },

    addAttributes() {
        return {
            href: {
                default: null,
            },
            id: {
                default: null,
            },
            target: {
                default: this.options.HTMLAttributes.target,
            },
            hreflang: {
                default: null,
            },
            rel: {
                default: null,
            },
            referrerpolicy: {
                default: null,
            },
            class: {
                default: null,
            },
            as_button: {
                default: null,
                parseHTML: element => element.getAttribute('data-as-button') ?? null,
                renderHTML: attributes => {
                    if (!attributes.as_button) return

                    return {
                        'data-as-button': attributes.as_button,
                    }
                },
            },
            button_theme: {
                default: null,
                parseHTML: element => element.getAttribute('data-as-button-theme') ?? null,
                renderHTML: attributes => {
                    if (!attributes.button_theme) return

                    return {
                        'data-as-button-theme': attributes.button_theme,
                    }
                },
            },
        }
    },
})
