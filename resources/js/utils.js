export const uuid = () => {
    return ([1e7]+-1e3+-4e3+-8e3+-1e11).replace(/[018]/g, c =>
        (c ^ crypto.getRandomValues(new Uint8Array(1))[0] & 15 >> c / 4).toString(16)
    );
}

export const pounce = (component, args) => {
    window.Livewire.dispatch('pounce', { component: component, arguments: args })
}

export const commandRunner = (editor, commands, args = null) => {
    commands.forEach(command => {
        editor.chain().focus()[command.command](args ?? command?.arguments ).run()
    })
}

export function replaceTargetByComponent(target, Component, options) {
    const frag = document.createDocumentFragment();
    let props = {
        name: target.name,
        id: target.id,
        ...target.dataset,
    }
    const component = new Component( Object.assign( {}, options, {
        target: frag,
        props: props,
    } ));
    target.replaceWith( frag );
}

export function replaceClassByComponent( classname, Component, options ) {
    const targets = document.getElementsByClassName(classname)
    for (const target of targets) {
        if (target.replaceWith) {
            replaceTargetByComponent(target, Component, options);
        }
    }
}

export function replaceIdByComponent( id, Component, options ) {
    const target = document.getElementsById(id)
    if (target && target.replaceWith) {
        replaceTargetByComponent(target, Component, options);
    }
}
