const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const CssMinimizerPlugin = require('css-minimizer-webpack-plugin');

module.exports = {
  entry: './src/index.js', // Punto de entrada del proyecto
  output: {
    path: path.resolve(__dirname, 'dist'), // Carpeta de salida
    filename: 'branches-widget.min.js', // Nombre del archivo de salida
    clean: true // Limpia el directorio dist antes de cada build
  },
  module: {
    rules: [
      {
        test: /\.jsx?$/, // Archivos JS y JSX
        exclude: /node_modules/, // Excluimos node_modules
        use: {
          loader: 'babel-loader',
          options: {
            presets: [
              '@babel/preset-env', // Para compilar JavaScript moderno
              '@babel/preset-react' // Para manejar JSX
            ]
          }
        }
      },
      {
        test: /\.scss$/,
        use: [
          MiniCssExtractPlugin.loader,
          {
            loader: 'css-loader',
            options: {
              importLoaders: 2 // Asegura que los loaders se apliquen a los @import
            }
          },
          {
            loader: 'postcss-loader',
            options: {
              postcssOptions: {
                plugins: [
                  'postcss-preset-env' // Autoprefixer y futuras CSS features
                ]
              }
            }
          },
          'sass-loader'
        ]
      }
    ]
  },
  resolve: {
    extensions: ['.js', '.jsx'], // Soporte para archivos .js y .jsx
    alias: {
      'react': '@wordpress/element', // Usamos @wordpress/element en lugar de react
    }
  },
  plugins: [
    new MiniCssExtractPlugin({
      filename: 'branches-widget.min.css',
      ignoreOrder: true // Evita warnings de orden CSS
    })
  ],
  optimization: {
    minimizer: [
      `...`, // Mantiene los minimizers por defecto de Webpack
      new CssMinimizerPlugin() // Minimiza el CSS
    ]
  },
  performance: {
    hints: false // Desactiva warnings de tamaño para assets grandes
  }
};

