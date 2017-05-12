let webpack = require('webpack');
let path = require('path');

let inProduction = process.env.NODE_ENV === 'production';

module.exports = {
    entry: './app/Resources/assets/js/main.js',
    output: {
        path: path.resolve(__dirname, './web/js'),
        filename: 'app.js'
    },
    resolve: {
    alias: {
      'vue$': 'vue/dist/vue.esm.js' // 'vue/dist/vue.common.js' for webpack 1
    }
  },
    module: { 
      rules: [
      {
        test: /\.vue$/,
        loader: 'vue-loader',
        options: {
          loaders: {
            'scss': 'vue-style-loader!css-loader!sass-loader',
            'sass': 'vue-style-loader!css-loader!sass-loader?indentedSyntax'
        }
          // other vue-loader options go here
          }
          },
          { 
            test: /\.js$/, 
            exclude: /node_modules/, 
            loader: "babel-loader" 
        },

        ]
    },

     plugins: []
};

if(inProduction) {
    module.exports.plugins = (module.exports.plugins || []).concat([
    new webpack.DefinePlugin({
      'process.env': {
        NODE_ENV: '"production"'
      }
    }),
    new webpack.optimize.UglifyJsPlugin({
      sourceMap: true,
      compress: {
        warnings: false
      }
    }),
    new webpack.LoaderOptionsPlugin({
      minimize: true
    })
  ])
}