const { CleanWebpackPlugin } = require('clean-webpack-plugin')
const BundleAnalyzerPlugin = require('webpack-bundle-analyzer')
  .BundleAnalyzerPlugin
const CopyWebpackPlugin = require('copy-webpack-plugin')
const FriendlyErrorsWebpackPlugin = require('friendly-errors-webpack-plugin')
const ImageminPlugin = require('imagemin-webpack-plugin').default
const MiniCssExtractPlugin = require('mini-css-extract-plugin')
const OptimizeCSSAssetsPlugin = require('optimize-css-assets-webpack-plugin')
const SVGSpritemapPlugin = require('svg-spritemap-webpack-plugin')
const TerserJSPlugin = require('terser-webpack-plugin')
const WebpackAssetsManifest = require('webpack-assets-manifest')
const BrowserSyncPlugin = require('browser-sync-webpack-plugin')
const WorkboxPlugin = require('workbox-webpack-plugin')
const chokidar = require('chokidar')
const { merge } = require('webpack-merge')
const path = require('path')
const webpack = require('webpack')

const DEV_MODE = process.env.NODE_ENV !== 'production'
const PROD_MODE = !DEV_MODE
const USE_ANALYZE = process.env.ANALYZE !== undefined
const USE_SOURCEMAPS = process.env.SOURCEMAPS !== undefined
const USE_SYNC = process.env.SYNC !== undefined
const THEME_PATH = path.resolve(__dirname, 'app/client')

const PATHS = {
  APP: `app`,
  SRC: path.join(THEME_PATH, 'src'),
  DIST: path.resolve(THEME_PATH, 'dist'),
  PUBLIC: `/_resources/app/client/dist/`,
  MODULES: path.resolve(__dirname, 'node_modules'),
}

const WebpackConfig = {
  mode: process.env.NODE_ENV,

  entry: {
    app: path.join(PATHS.SRC, 'index.js'),
  },

  output: {
    filename: '[name].js',
    path: PATHS.DIST,
    publicPath: PATHS.PUBLIC,
  },

  resolve: {
    extensions: ['.js'],
    alias: {
      scripts: path.resolve(PATHS.SRC, 'scripts'),
      styles: path.resolve(PATHS.SRC, 'styles'),
      images: path.resolve(PATHS.SRC, 'images'),
    },
  },

  externals: {
    moment: 'moment',
  },

  module: {
    rules: [
      {
        test: /.(js)$/,
        exclude: [PATHS.MODULES],
        use: [
          {
            loader: 'babel-loader',
            options: {
              cacheDirectory: true,
            },
          },
          {
            loader: 'eslint-loader',
            options: {
              cache: true,
            },
          },
        ],
      },
      {
        test: /\.css$/,
        sideEffects: true,
        use: [
          {
            loader: MiniCssExtractPlugin.loader,
            options: {
              hmr: DEV_MODE,
            },
          },
          'cache-loader',
          {
            loader: 'css-loader',
            options: {
              sourceMap: PROD_MODE || USE_SOURCEMAPS,
            },
          },
          {
            loader: 'postcss-loader',
            ident: 'postcss',
            options: {
              sourceMap: PROD_MODE || USE_SOURCEMAPS,
              postcssOptions: {
                plugins: [
                  'postcss-import',
                  'tailwindcss',
                  'postcss-nested',
                  'postcss-pxtorem',
                  'autoprefixer',
                ],
              },
            },
          },
        ],
      },
      {
        test: /\.(jpe?g|ico|gif|png|svg)$/,
        use: {
          loader: 'url-loader',
          options: {
            name: 'images/[name].[ext]',
            limit: 1024 * 8,
          },
        },
      },
      {
        test: /\.(ttf|eot|woff|woff2)$/,
        use: {
          loader: 'file-loader',
          options: {
            name: 'fonts/[name].[ext]',
          },
        },
      },
    ],
  },

  optimization: {
    runtimeChunk: 'single',
    splitChunks: {
      cacheGroups: {
        vendor: {
          test: /[\\/]node_modules[\\/]/,
          name: 'vendor',
          chunks: 'all',
        },
      },
    },
  },

  plugins: [
    new CleanWebpackPlugin({
      cleanStaleWebpackAssets: false,
      cleanAfterEveryBuildPatterns: ['*hot-update*'],
    }),
    new CopyWebpackPlugin({
      patterns: [
        {
          from: 'images',
          to: 'images/',
          context: PATHS.SRC,
          noErrorOnMissing: true,
        },
        {
          from: 'icons',
          to: 'icons/',
          context: PATHS.SRC,
          noErrorOnMissing: true,
        },
      ],
    }),
    new SVGSpritemapPlugin(path.join(PATHS.SRC, 'icons/*.svg'), {
      styles: {
        filename: '~spritemap.scss',
      },
      output: {
        svgo: {
          plugins: [
            {
              convertColors: {
                currentColor: true,
              },
            },
          ],
        },
      },
    }),
    new MiniCssExtractPlugin({
      filename: '[name].css',
    }),
    new WebpackAssetsManifest({
      entrypoints: true,
    }),
    new webpack.ProvidePlugin({
      Selectors: [
        path.resolve(PATHS.SRC, 'scripts/common/selectors.js'),
        'default',
      ],
      ajax: [path.resolve(PATHS.SRC, 'scripts/common/ajax.js'), 'default'],
    }),
  ],

  devServer: {
    before(_, server) {
      chokidar
        .watch([path.join(PATHS.APP, 'templates/**/*.ss')])
        .on('all', () => {
          server.sockWrite(server.sockets, 'content-changed')
        })
    },
    hot: true,
    overlay: true,
    compress: true,
    disableHostCheck: true,
    headers: {
      'Access-Control-Allow-Origin': '*',
    },
    stats: {
      builtAt: false,
      children: false,
      colors: true,
      entrypoints: false,
      hash: false,
      modules: false,
      version: false,
    },
    writeToDisk: true,
    watchOptions: {
      ignored: [PATHS.MODULES],
    },
  },
}

if (USE_ANALYZE) {
  WebpackConfig.plugins.push(
    new BundleAnalyzerPlugin({
      analyzerMode: 'server',
    })
  )
}

if (USE_SYNC) {
  WebpackConfig.plugins.push(
    new BrowserSyncPlugin(
      {
        host: 'localhost',
        port: 3000,
        proxy: 'http://signinapp.test:8080/',
      },
      {
        reload: false,
      }
    )
  )
}

if (DEV_MODE) {
  module.exports = merge(WebpackConfig, {
    devtool: 'inline-cheap-module-source-map',
    optimization: {
      noEmitOnErrors: true,
    },
    plugins: [
      new FriendlyErrorsWebpackPlugin({
        clearConsole: true,
      }),
    ],
  })
}

if (PROD_MODE) {
  module.exports = merge(WebpackConfig, {
    devtool: 'source-map',
    plugins: [
      new ImageminPlugin({
        test: ['images/**'],
      }),
      new WorkboxPlugin.GenerateSW(),
    ],
    optimization: {
      minimizer: [
        new TerserJSPlugin({
          cache: true,
          parallel: true,
          sourceMap: true,
        }),
        new OptimizeCSSAssetsPlugin(),
      ],
    },
  })
}
