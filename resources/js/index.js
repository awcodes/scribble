import Scribble from './Scribble.svelte'

export default function scribble(tools, state, statePath, placeholder) {
    return {
        tools,
        state,
        statePath,
        placeholder: placeholder ?? "press '/' for blocks",
        fullscreen: false,

        init() {
            const _this = this

            new Scribble({
                target: _this.$root,
                props: {
                    tools: _this.tools,
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
