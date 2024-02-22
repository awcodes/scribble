import {Extension} from '@tiptap/core'

export default Extension.create({
    name: 'statePathExtension',

    addOptions() {
        return {
            statePath: null,
        }
    },

    addStorage() {
        return {
            statePath: null
        }
    },

    onCreate() {
        this.storage.statePath = this.options.statePath
    }
})
