module.exports = {
    filenameHashing: false,
    publicPath: './',
    outputDir: 'dist',
    chainWebpack: config => {
        config.plugins.delete('html');
        config.plugins.delete('preload');
        config.plugins.delete('prefetch');
    },
    devServer: {
        writeToDisk: true,
        hot: false,
    },
    productionSourceMap: false,
}