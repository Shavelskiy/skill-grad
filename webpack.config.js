const Encore = require('@symfony/webpack-encore');
const dotenv = require('dotenv');
const path = require('path');

if (!Encore.isRuntimeEnvironmentConfigured()) {
  Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore
  .configureDefinePlugin(options => {
    const env = dotenv.config({ path:  path.join(__dirname, '.env.local') });

    if (env.error) {
      throw env.error;
    }

    options['process.env'].RECAPTCHA_SITE_KEY = JSON.stringify(env.parsed.RECAPTCHA_SITE_KEY);
  })

Encore
  .setOutputPath('public/build/')
  .setPublicPath('/build')

  .addEntry('admin.layout', './assets/admin/layout/index.js')
  .addEntry('admin.login', './assets/admin/pages/login/index.js')

  .addEntry('site.layout', './assets/layout/index.js')
  .addEntry('site.index', './assets/pages/index.js')
  .addEntry('site.profile', './assets/pages/profile.js')

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

  .enableSassLoader()
  .enableVueLoader()

  .copyFiles({
    from: './assets/admin/images',
    to: 'images/[path][name].[ext]',
    pattern: /\.(png|jpg|jpeg)$/
  })
;

module.exports = Encore.getWebpackConfig();
