import preset from './vendor/filament/support/tailwind.config.preset'

module.exports = {
    presets: [preset],
    content: [
        './resources/views/**/*.{blade.php,svelte,js}',
    ],
}
