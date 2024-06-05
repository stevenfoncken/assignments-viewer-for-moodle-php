module.exports = {
    plugins: [
        [
            'postcss-import',
        ],
        [
            'postcss-url',
        ],
        [
            'postcss-preset-env',
            {
                stage: 3,
                features: {
                    'custom-media-queries': {},
                    'custom-properties': {},
                },
            },
        ],
        [
            'autoprefixer',
        ],
        [
            'cssnano',
            {
                preset: 'default',
                discardComments: { removeAll: false },
            },
        ],
    ],
};
