import {Extension} from '@tiptap/core'

export default Extension.create({
    name: 'idExtension',

    addGlobalAttributes() {
        return [
            {
                types: [
                    'heading',
                    'link',
                ],
                attributes: {
                    id: {
                        default: null,
                        parseHTML: element => element.getAttribute('id') ?? null,
                        renderHTML: attributes => {
                            if (!attributes.id) {
                                return null;
                            }
                            return {
                                id: attributes.id
                            }
                        },
                    },
                },
            },
        ]
    }
})
