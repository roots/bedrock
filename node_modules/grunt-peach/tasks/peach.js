/*
 * grunt-peach
 * http://github.com/davidosomething/grunt-peach
 *
 * Copyright (c) 2013 David O'Trakoun
 * Licensed under the MIT license
 */
module.exports = function (grunt) {
  'use strict';

  var peach = require('./lib/migrate.js').init(grunt);

  grunt.registerMultiTask('peach', 'Replace values in SQL, including PHP serialized strings.', function () {
    var done = this.async();

    var tryMigrate;
    var haystack;
    var outputFile = this.data.dest;
    var failed = 0;
    var options = this.options({
      force: true
    });
    var force = options.force;
    delete options.force;

    var complete = function (data) {
      if (data === null) {
        failed = force;
      }
      if (!failed) {
        grunt.file.write(outputFile, data);
        grunt.log.ok('Wrote migrated SQL dump to ' + outputFile);
      }
      else {
        grunt.log.error('Migration failed');
      }
      done(failed);
    };

    ////////////////////////////////////////////////////////////////////////
    // begin
    ////////////////////////////////////////////////////////////////////////
    haystack = grunt.file.read(this.data.src);
    tryMigrate = peach.migrate(haystack, this.data.from, this.data.to, complete);
    if (tryMigrate) {
      tryMigrate.init();
    }
    else {
      complete(null);
    }
  });

};
