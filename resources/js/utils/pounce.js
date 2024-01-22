export const pounce = (component, args) => {
    window.Livewire.dispatch('pounce', { component: component, arguments: args })
}
