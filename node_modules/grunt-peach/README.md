# grunt-peach 

> Search and replace strings in SQL dumps, including PHP serialized strings.

Based on [Peach by Pete Saia](https://github.com/petesaia/Peach)

BETA - not tested - use at your own risk - but it's pretty much the code from
the Peach repo, which @petesaia has tests for.

## Getting Started
This plugin requires Grunt `~0.4.0`

If you haven't used [Grunt](http://gruntjs.com/) before, be sure to check out the [Getting Started](http://gruntjs.com/getting-started) guide, as it explains how to create a [Gruntfile](http://gruntjs.com/sample-gruntfile) as well as install and use Grunt plugins. Once you're familiar with that process, you may install this plugin with this command:

```shell
npm install grunt-peach --save-dev
```

Once the plugin has been installed, it may be enabled inside your Gruntfile with this line of JavaScript:

```js
grunt.loadNpmTasks('grunt-peach');
```

## Peach task
_Run this task with the `grunt peach` command._

Task targets, files and options may be specified according to the grunt [Configuring tasks](http://gruntjs.com/configuring-tasks) guide.

### Options

#### force
Type: `Boolean`
Default value: `true`

Set `force` to `true` to report errors but not fail the task.

### Usage examples

```js
// Project configuration.
grunt.initConfig({
  peach: {
    dev: {
      options: {
        force: true
      },
      src:  'input.sql',
      dest: 'output.sql',
      from: 'http://my-development-server.dev',
      to:   'http://the-production-server.com'
    }
  }
});
```

## Todos

 * Move output to grunt task instead of migrate.js exported module 
 * Optional async
 * Test (lol)

## Release History

 * 2013-05-24   v0.0.3   Fix writing to dest file
 * 2013-05-24   v0.0.1   Initial release
