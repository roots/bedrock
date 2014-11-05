module.exports = function (grunt) {
  'use strict';

  // Project configuration.
  grunt.initConfig({
    pkg: '<json:package.json>',

// JSHINT //////////////////////////////////////////////////////////////////////
    jshint: {
      jshintrc: '.jshintrc',
      gruntfile: 'Gruntfile.js',
      peach:     'tasks/*.js'
    },

// PEACH ///////////////////////////////////////////////////////////////////////
    peach: {
      dev: {
        src:  'input.sql',
        dest: 'output.sql',
        from: 'http://truth2012-dev.arn.com',
        to:   'http://truth2012.dev'
      }
    }

  });

// LOAD TASKS //////////////////////////////////////////////////////////////////
  grunt.loadNpmTasks('grunt-contrib-jshint');
  grunt.loadTasks('tasks');

// REGISTER TASKS //////////////////////////////////////////////////////////////
  grunt.registerTask('test', ['jshint']);
  grunt.registerTask('default', ['jshint']);

};
