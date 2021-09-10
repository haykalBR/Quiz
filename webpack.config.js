var Encore = require('@symfony/webpack-encore');
var dotenv = require('dotenv');
if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore
    .setOutputPath('public/build/')
    .setPublicPath('/build')
    .addEntry('app', './assets/app.ts')
    .splitEntryChunks()
    .enableSingleRuntimeChunk()
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(Encore.isProduction())

    .configureDefinePlugin(options => {
        const env = dotenv.config();

        if (env.error) {
            throw env.error;
        }

        options['process.env'].ELEMENT_PREFIX = JSON.stringify(env.parsed.ELEMENT_PREFIX);
        options['process.env'].MERCURE_URL = JSON.stringify(env.parsed.MERCURE_URL);
    })

    // enables @babel/preset-env polyfills
    .configureBabelPresetEnv((config) => {
        config.useBuiltIns = 'usage';
        config.corejs = 3;
        // config.presets.push('@babel/preset-flow');
        // config.presets.push('@babel/preset-react');
    })

    .configureBabel(function(babelConfig) {
        // add additional presets
        // babelConfig.presets.push('@babel/preset-flow');
        babelConfig.presets.push('@babel/preset-react');

        // no plugins are added by default, but you can add some
        // babelConfig.plugins.push('styled-jsx/babel');
    }, {
        // node_modules is not processed through Babel by default
        // but you can whitelist specific modules to process
        // includeNodeModules: ['foundation-sites'],

        // or completely control the exclude rule (note that you
        // can't use both "includeNodeModules" and "exclude" at
        // the same time)
        // exclude: /bower_components/
    })

    .autoProvideVariables({
        $: 'jquery'
    })

    // enables Sass/SCSS support
    .enableSassLoader()

    // uncomment if you use TypeScript
    .enableTypeScriptLoader()

// uncomment to get integrity="..." attributes on your script & link tags
// requires WebpackEncoreBundle 1.4 or higher
//.enableIntegrityHashes(Encore.isProduction())

// uncomment if you're having problems with a jQuery plugin
//  .autoProvidejQuery()

// uncomment if you use API Platform Admin (composer req api-admin)
//.enableReactPreset()
//.addEntry('admin', './assets/admin.js')
;


module.exports = Encore.getWebpackConfig();
