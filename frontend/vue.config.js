// vue.config.js
module.exports = {
  devServer: {
    proxy: {
      '/api': {
        target: 'http://localhost/CRUD-System-main/backend',
        changeOrigin: true,
        pathRewrite: { '^/api': '' },
      },
    },
  },
};
