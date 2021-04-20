const path = require('path');
const VuetifyLoaderPlugin = require('vuetify-loader/lib/plugin')

module.exports = {
  resolve: {
    alias: {
      '@': path.resolve('resources/js/'),
    },
  },
  plugins: [
    new VuetifyLoaderPlugin()
  ],
};


