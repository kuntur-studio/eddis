const path = require('path');

module.exports = {
  entry: './src/index.js',
  output: {
    path: path.resolve(__dirname, 'dist'),
    filename: 'sedes-widget.js',
    library: {
      type: 'umd',
      name: 'SedesWidget'
    }
  },
  module: {
    rules: [
      {
        test: /\.(js|jsx)$/,
        exclude: /node_modules/,
        use: {
          loader: 'babel-loader',
          options: {
            presets: [
              ['@babel/preset-env', { 
                targets: "> 0.25%, not dead",
                useBuiltIns: 'usage',
                corejs: 3
              }],
              ['@babel/preset-react', {
                pragma: 'wp.element.createElement',
                pragmaFrag: 'wp.element.Fragment'
              }]
            ]
          }
        }
      }
    ]
  },
  resolve: {
    extensions: ['.js', '.jsx'],
    alias: {
      'react': '@wordpress/element',
      'react-dom': '@wordpress/element'
    }
  },
  externals: {
    'wp': 'wp'
  }
};
