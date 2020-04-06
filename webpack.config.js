const Encore = require('@symfony/webpack-encore');

if (!Encore.isRuntimeEnvironmentConfigured()) {
  Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

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
