// Packages
const path                 = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const SpriteLoaderPlugin   = require('svg-sprite-loader/plugin');
const RemovePlugin         = require('remove-files-webpack-plugin');

// Vars
const projectBasePath        = '../../';
const assetsSrcPath          = `${projectBasePath}/assets-src`;
const nodeModulesPath        = `${projectBasePath}/node_modules`;
const docrootPath            = `${projectBasePath}/deploy/docroot`;
const distPath               = `${docrootPath}/dist`;
const fontawesomePackagePath = `${nodeModulesPath}/@fortawesome/fontawesome-free`;

// Config
module.exports = {
    mode: 'none',
    entry: {
        app: [
            path.resolve(__dirname, `${assetsSrcPath}/js/index.js`),
            path.resolve(__dirname, `${assetsSrcPath}/scss/main.scss`),
        ],
        icons: [
            path.resolve(__dirname, `${fontawesomePackagePath}/svgs/solid/arrow-right.svg`),
        ],
    },
    output: {
        path: path.resolve(__dirname, `${distPath}`),
        clean: true,
        filename: './js/[name].min.js',
    },
    module: {
        rules: [
            {
                test: /\.js$/i,
                exclude: /node_modules/,
                loader: 'babel-loader',
                options: {
                    presets: ['@babel/preset-env',],
                },
            },
            {
                test: /\.(woff|woff2|eot|ttf|otf)$/i,
                type: 'asset/resource',
                generator: {
                    filename: 'fonts/[name][ext]',
                }
            },
            {
                test: /\.(png|jpg|jpeg|gif)$/i,
                type: 'asset/resource',
                generator: {
                    filename: 'media/img/[name][ext]',
                },
            },
            {
                test: /\.svg$/i,
                use: [
                    {
                        loader: 'svg-sprite-loader',
                        options: {
                            extract: true,
                            outputPath: 'media/sprites/',
                            spriteFilename: '[chunkname].svg',
                        },
                    },
                    'svgo-loader',
                ],
            },
        ],
    },
    resolve: {
        extensions: ['.js'],
        alias: {
            JsComponents: path.resolve(__dirname, `${assetsSrcPath}/js/components/`),
        },
    },
    plugins: [
        new MiniCssExtractPlugin({
            filename: './css/main.min.css',
        }),
        new SpriteLoaderPlugin({
            plainSprite: true,
        }),
        new RemovePlugin({
            after: {
                root: path.resolve(__dirname, `${distPath}/js`),
                include: [
                    'icons.min.js',
                ],
                trash: true,
            },
        }),
    ],
};
