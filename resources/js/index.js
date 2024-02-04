import Scribble from './Scribble.svelte'

export default function scribble(bubbleTools, suggestionTools, toolbarTools, state, statePath, placeholder) {
    return {
        bubbleTools,
        suggestionTools,
        toolbarTools,
        state,
        statePath,
        placeholder: placeholder ?? "press '/' for blocks",
        fullscreen: false,

        init() {
            const _this = this

            new Scribble({
                target: _this.$root,
                props: {
                    bubbleTools: _this.bubbleTools,
                    suggestionTools: _this.suggestionTools,
                    toolbarTools: _this.toolbarTools,
                    content: _this.state,
                    statePath: _this.statePath,
                    placeholder: _this.placeholder
                }
            });

            window.addEventListener('updatedEditor', e => {
                if (e.detail.statePath === _this.statePath) {
                    _this.state = e.detail.content
                }
            })
        },

        toggleFullscreen(event) {
            if (event.detail.statePath !== this.statePath) return
            this.fullscreen = !this.fullscreen
        },
    }
}
