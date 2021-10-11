const {getCustomConfig} = require('./webpack.base.config');
const {getAssetsEntries, BUILD_TYPE} = require('./paths');

const config = getCustomConfig(BUILD_TYPE.LEGACY, getAssetsEntries(BUILD_TYPE.LEGACY));

module.exports = config;
