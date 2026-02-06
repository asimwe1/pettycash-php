import preset from '../../../../vendor/filament/filament/tailwind.config.preset'

export default {
    presets: [preset],
    content: [
        './app/Filament/**/*.php',
        './resources/views/filament/**/*.blade.php',
        './vendor/filament/**/*.blade.php',
    ],
    theme: {
        extend: {
            colors: {
                primary: {
                    50: '#E5F1FF',
                    100: '#CCE2FF',
                    200: '#99C5FF',
                    300: '#66A8FF',
                    400: '#338BFF',
                    500: '#007AFF', // California Blue
                    600: '#0062CC',
                    700: '#004A99',
                    800: '#003166',
                    900: '#001933',
                    950: '#000C1A',
                },
            },
        },
    },
}
