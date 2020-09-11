const Encore = require('@symfony/webpack-encore');
const dotenv = require('dotenv');
const path = require('path');

if (!Encore.isRuntimeEnvironmentConfigured()) {
  Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore
  .configureDefinePlugin(options => {
    const env = dotenv.config({path: path.join(__dirname, '.env.local')});

    if (env.error) {
      throw env.error;
    }

    options['process.env'].RECAPTCHA_SITE_KEY = JSON.stringify(env.parsed.RECAPTCHA_SITE_KEY);
  })

Encore
  .setOutputPath('public/build/')
  .setPublicPath('/build')

  .addEntry('admin', './admin/index.js')

  .addEntry('site.layout', './assets/layout/index.js')
  .addEntry('site.index', './assets/pages/index/index.js')

  .addEntry('program.view', './assets/pages/program/view.js')

  .addEntry('provider.index', './assets/pages/provider/index.js')
  .addEntry('provider.view', './assets/pages/provider/view.js')

  .addEntry('static.favorite', './assets/pages/static/favorite.js')
  .addEntry('static.compare', './assets/pages/static/compare.js')

  .addEntry('site.user.profile', './assets/profile/user-profile.js')
  .addEntry('site.provider.profile', './assets/profile/provider-profile.js')

  .addEntry('program.add', './assets/program-form/index.js')

  .splitEntryChunks()

  .enableSingleRuntimeChunk()

  .cleanupOutputBeforeBuild()
  .enableBuildNotifications()
  .enableSourceMaps(!Encore.isProduction())
  .enableVersioning(Encore.isProduction())
  .configureBabelPresetEnv((config) => {
    config.useBuiltIns = 'usage';
    config.corejs = 3;
  })
  .configureCssLoader((options) => {
    options.camelCase = true;
  })

  .enableReactPreset()
  .enableSassLoader()
  .enableEslintLoader()
;

module.exports = Encore.getWebpackConfig();
