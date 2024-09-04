export const uuid = () => {
    return ([1e7]+-1e3+-4e3+-8e3+-1e11).replace(/[018]/g, c =>
        (c ^ crypto.getRandomValues(new Uint8Array(1))[0] & 15 >> c / 4).toString(16)
    );
}

export const openScribbleModal = (component, args) => {
    window.Livewire.dispatch('openScribbleModal', { component: component, arguments: args })
}

export const commandRunner = (editor, commands, args = []) => {
    commands.forEach(command => {
        editor.chain().focus()[command.command](Object.keys(command?.arguments).length > 0 ? command.arguments : args).run()
    })
}

export const replaceStatePath = (data, statePath) => {
    if (typeof data != "object") return;
    if (!data) return; // null object

    for (const key in data) {
        if (['statePath'].includes(key)) {
            data[key] = statePath;
        } else {
            replaceStatePath(data[key], statePath);
        }
    }
}

export const isValidVimeoUrl = (url) => {
    return url.match(/(vimeo\.com)(.+)?$/);
};

export const getVimeoEmbedUrl = (options) => {
    // if is already an embed url, return it
    if (options.src.includes("/video/")) {
        return options.src;
    }

    const videoIdRegex = /\.com\/([0-9]+)/gm;
    const matches = videoIdRegex.exec(options.src);

    if (!matches || !matches[1]) {
        return null;
    }

    let outputUrl = `https://player.vimeo.com/video/${matches[1]}`;

    let params = [];

    if (Object.values(options.options).length > 0) {
        for (const [key, value] of Object.entries(options.options)) {
            params.push(`${key}=${value}`);
        }

        outputUrl += `?${params.join("&")}`;
    }

    return outputUrl;
};

export const isValidYoutubeUrl = (url) => {
    return url.match(/(youtube\.com|youtu\.be)(.+)?$/);
};

export const getYouTubeEmbedUrl = (options) => {
    const embedUrl = options.options.nocookie ? "https://www.youtube-nocookie.com/embed/" : "https://www.youtube.com/embed/";
    delete options.options.nocookie

    // if is already an embed url, return it
    if (options.src.includes("/embed/")) {
        return options.src;
    }

    // if is a youtu.be options.src, get the id after the /
    if (options.src.includes("youtu.be")) {
        const id = options.src.split("/").pop();

        if (!id) {
            return null;
        }
        return `${embedUrl}${id}`;
    }

    const videoIdRegex = /v=([-\w]+)/gm;
    const matches = videoIdRegex.exec(options.src);

    if (!matches || !matches[1]) {
        return null;
    }

    let outputUrl = `${embedUrl}${matches[1]}`;
    let params = [];

    if (Object.values(options.options).length > 0) {
        for (const [key, value] of Object.entries(options.options)) {
            params.push(`${key}=${value}`);
        }

        outputUrl += `?${params.join("&")}`;
    }

    return outputUrl;
};
