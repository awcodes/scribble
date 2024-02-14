import tippy from 'tippy.js'

export const uuid = () => {
    return ([1e7]+-1e3+-4e3+-8e3+-1e11).replace(/[018]/g, c =>
        (c ^ crypto.getRandomValues(new Uint8Array(1))[0] & 15 >> c / 4).toString(16)
    );
}

export const pounce = (component, args) => {
    window.Livewire.dispatch('pounce', { component: component, arguments: args })
}

export const commandRunner = (editor, commands, args = []) => {
    commands.forEach(command => {
        editor.chain().focus()[command.command](command?.arguments ?? args).run()
    })
}
