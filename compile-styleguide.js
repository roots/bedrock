var assetsFile = './assets.json',
    assets = require(assetsFile);

var glob = require('glob'),
    fs   = require('fs');

gulp.task('build-styleguide-js', function () {
    //console.log('build-styleguide-js');
    var thisPipe = jsCompile(getStyleGuideJsData());
    //console.log('end-build-styleguide-js');
    return thisPipe;
});

function jsCompile() {
    getStyleGuideJsData()
}


var oldVersions = jsData.output+jsData.name+'*.js';
glob(oldVersions,function(err,files){
    if (err) throw err;
    // Delete files
    files.forEach(function(item,index,array){
        fs.unlink(item, function(err){
            if (err) throw err;
        });
    });
});


function getStyleGuideJsData() {
    //Watch styleguide JS
    var styleGuideJsFolder = assets.site.prefix + assets.site.assets_src + '/../../styleguide/js',
        jsFilesDefinitionAsJson = styleGuideJsFolder + '/js.json',
        jsFilesDefinition = require(jsFilesDefinitionAsJson),
        jsFiles = [];

    var cpt = 0;
    for (var componentName in jsFilesDefinition) {
        for (var fileName in jsFilesDefinition[componentName]) {
            jsFiles[cpt] = path.resolve(styleGuideJsFolder + '/components/' + componentName + '/' + jsFilesDefinition[componentName][fileName]);
            cpt++;
        }
    }

    var styleguideJsData = {
        name: 'styleguide',
        files: jsFiles,
        watchers: jsFiles,
        output: path.resolve(assets.site.prefix + assets.site.assets_src + '/../../styleguide/js/compiled') + '/',
        destName: 'styleguide.js'
    }
    return styleguideJsData;
}