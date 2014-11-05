var grunt = require('grunt')
  , lf = grunt.util.linefeed
  , path = require('path')
  , fs = require('fs')
  , assert = require('assert')
  , testDir = path.join(process.cwd(), 'test')
  , opts = { gruntfile: path.join(testDir, 'Gruntfile.js') }
  , tasks = [
      'exec:test1'
    , 'exec:test2'
    , 'exec:test3:42:love'
    , 'exec:test4'
    , 'exec:test5'
    , 'exec:test6'
    , 'exec:test7'
    ];

grunt.tasks(tasks, opts, function() {
  var tests = [
        { name: 'test1', expected: 'bruce willis was dead' + lf }
      , { name: 'test2' , expected: 'grunt@' + grunt.version + lf }
      , {
          name: 'test3'
        , expected: [
            'the answer to life is 42', 'thoughts on tacos? love'
          ].join(', ') + lf
        }
      , {
          name: 'test4'
        , expected:'you can use callback, and error, stdout, stderr can be used as arguments' + lf
        }
      , { name: 'test7', expected: 'you do not even need an object' + lf }
      ]
    , outputPath;

  tests.forEach(function(test) {
    outputPath = path.join(testDir, test.name);
    assert.equal(fs.readFileSync(outputPath, 'utf8'), test.expected);

    // clean up
    fs.unlinkSync(outputPath);

    grunt.log.ok(test.name +' passed');
  });
});
