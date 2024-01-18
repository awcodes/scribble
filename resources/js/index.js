import Scribble from './Scribble.svelte'

export default function scribble(blocks, tools, state, statePath) {
    return {
        blocks,
        tools,
        state,
        statePath,

        init() {
            const _this = this

            new Scribble({
                target: _this.$root,
                props: {
                    blocks: _this.blocks,
                    tools: _this.tools,
                    content: _this.state,
                    statePath: _this.statePath,
                }
            });

            window.addEventListener('updatedEditor', e => {
                if (e.detail.statePath === _this.statePath) {
                    _this.state = e.detail.content
                }
            })
        }
    }
}
