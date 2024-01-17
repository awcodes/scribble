import Scribble from './Scribble.svelte'

export default function scribble(blocks, state, statePath) {
    return {
        blocks,
        state,
        statePath,

        init() {
            const _this = this

            new Scribble({
                target: _this.$root,
                props: {
                    blocks: _this.blocks,
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
