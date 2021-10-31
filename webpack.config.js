var Encore = require('@symfony/webpack-encore');
var dotenv = require('dotenv');

// Manually configure the runtime environment if not already configured yet by the "encore" command.
// It's useful when you use tools that rely on webpack.config.js file.
if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore
    // directory where compiled assets will be stored
    .setOutputPath('public/build/')
    // public path used by the web server to access the output path
    .setPublicPath('/build')
    // only needed for CDN's or sub-directory deploy
    //.setManifestKeyPrefix('build/')

    /*
     * ENTRY CONFIG
     *
     * Add 1 entry for each "page" of your app
     * (including one that's included on every page - e.g. "app")
     *
     * Each entry will result in one JavaScript file (e.g. app.js)
     * and one CSS file (e.g. app.css) if your JavaScript imports CSS.
     */

    .addEntry('app', './assets/app.ts')
    .addEntry('reflevel', './assets/Domain/RefLevel/index.ts')
    .addEntry('category', './assets/Domain/category/index.ts')
    .addEntry('refquestiontype', './assets/Domain/RefQuestionType/index.ts')
    .addEntry('ref_poste', './assets/Domain/RefPoste/index.ts')
    .addEntry('exam', './assets/Domain/Exam/index.ts')
    .addEntry('user', './assets/Domain/User/index.ts')
    .addEntry('technology', './assets/Domain/Technology/index.ts')
    .addStyleEntry('custom', './assets/styles/app.scss')
    // When enabled, Webpack "splits" your files into smaller pieces for greater optimization.
    .splitEntryChunks()
    // will require an extra script tag for runtime.js
    // but, you probably want this, unless you're building a single-page app
    .enableSingleRuntimeChunk()

    /*
     * FEATURE CONFIG
     *
     * Enable & configure other features below. For a full
     * list of features, see:
     * https://symfony.com/doc/current/frontend.html#adding-more-features
     */
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    // enables hashed filenames (e.g. app.abc123.css)
    .enableVersioning(Encore.isProduction())

    // define the environment variables
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