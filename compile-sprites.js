var assetsFile = './assets.json',
    assets = require(assetsFile),
    svgSrc = assets.site.prefix + assets.site.assets_src + '/svg',
    svgDest = assets.site.prefix + assets.site.assets_dest + '/svg';

var Spriter = require("svg-sprite"),
    fs      = require('fs'),
    mkdirp  = require('mkdirp'),
    path    = require('path'),
    glob    = require('glob'),
    cwd	    = path.resolve(svgSrc),
    File    = require('vinyl'),
    config	=
        {
            dest					: svgDest,						// Main output directory
            shape					: {							// SVG shape related options

                dimension: {							// Dimension related options
                    maxWidth: 128,						// Max. shape width
                    maxHeight: 128,						// Max. shape height
                },
                spacing: {							// Spacing related options
                    padding: 5,						// Padding around all shapes
                }
            },
            mode: {
                view: {			// Activate the «view» mode
                    bust: false,
                    prefix			: ".svg-%s",
                    render: {
                        scss: true		// Activate Sass output (with default options)
                    }
                },
                symbol: true
            }
        },
    spriter = new Spriter(config);

glob.glob('**/*.svg', {cwd: cwd}, function(err, files) {
    files.forEach(function(file){
        // Create and add a vinyl file instance for each SVG
        spriter.add(new File({
            path: path.join(cwd, file),							// Absolute path to the SVG file
            base: cwd,											// Base path (see `name` argument)
            contents: fs.readFileSync(path.join(cwd, file))		// SVG file contents
        }));
    });

    spriter.compile(function(error, result) {
        for (var mode in result) {
            for (var resource in result[mode]) {
                mkdirp.sync(path.dirname(result[mode][resource].path));
                fs.writeFileSync(result[mode][resource].path, result[mode][resource].contents);
            }
        }
    })
});
