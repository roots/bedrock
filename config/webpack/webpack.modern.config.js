const {getCustomConfig} = require('./webpack.base.config');
const {getAssetsEntries, BUILD_TYPE} = require('./paths');

const config = getCustomConfig(BUILD_TYPE.MODERN, getAssetsEntries(BUILD_TYPE.MODERN));

module.exports = config;
