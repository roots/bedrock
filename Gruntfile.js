module.exports = function(grunt) {
  "use strict";

  grunt.initConfig({
    secret: grunt.file.readJSON('secret.json'),
    peach: {
      url_to_dev: {
        options: {
          force: true
        },
        src:  'web/mysqldumps/latest_to_dev.sql',
        dest: 'web/mysqldumps/url_to_dev.sql',
        from: '<%= secret.host %>.<%= secret.host_tld %>',
        to:   '<%= secret.host %>.dev'
      },
      path_to_dev: {
        options: {
          force: true
        },
        src:  'web/mysqldumps/url_to_dev.sql',
        dest: 'web/mysqldumps/output_to_dev.sql',
        from: '/home/<%= secret.host %>/production/current/web',
        to:   '<%= secret.local_path %>/web'
      },
      url_staging_to_dev: {
        options: {
          force: true
        },
        src:  'web/mysqldumps/latest_staging_to_dev.sql',
        dest: 'web/mysqldumps/url_staging_to_dev.sql',
        from: '<%= secret.staging_sub %>.<%= secret.host %>.<%= secret.host_tld %>',
        to:   '<%= secret.host %>.dev'
      },
      path_staging_to_dev: {
        options: {
          force: true
        },
        src:  'web/mysqldumps/url_staging_to_dev.sql',
        dest: 'web/mysqldumps/output_staging_to_dev.sql',
        from: '/home/<%= secret.host %>/staging/current/web',
        to:   '<%= secret.local_path %>/web'
      },
      url_to_prod: {
        options: {
          force: true
        },
        src:  'web/mysqldumps/latest_to_prod.sql',
        dest: 'web/mysqldumps/url_to_prod.sql',
        from: '<%= secret.host %>.dev',
        to:   '<%= secret.host %>.<%= secret.host_tld %>'
      },
      path_to_prod: {
        options: {
          force: true
        },
        src:  'web/mysqldumps/url_to_prod.sql',
        dest: 'web/mysqldumps/output_to_prod.sql',
        from: '<%= secret.local_path %>/web',
        to:   '/home/<%= secret.host %>/production/current/web'
      },
      url_to_staging: {
        options: {
          force: true
        },
        src:  'web/mysqldumps/latest_to_prod.sql',
        dest: 'web/mysqldumps/url_to_staging.sql',
        from: '<%= secret.host %>.dev',
        to:   'pure.<%= secret.host %>.<%= secret.host_tld %>'
      },
      path_to_staging: {
        options: {
          force: true
        },
        src:  'web/mysqldumps/url_to_staging.sql',
        dest: 'web/mysqldumps/output_to_staging.sql',
        from: '<%= secret.local_path %>/web',
        to:   '/home/<%= secret.host %>/staging/current/web'
      }

    },
    exec: {
      get_prod_dump: {
        cmd: 'echo "Please be patient, this may take a minute or two... Getting database dump." && scp root@<%= secret.host %>:/tmp/mysqldumps/latest.sql.gz web/mysqldumps/latest_to_dev.sql.gz && echo "Aww yeah, tasty."'
      },
      unzip_prod: {
        cmd: 'gunzip -f web/mysqldumps/latest_to_dev.sql.gz'
      },
      get_staging_dump: {
        cmd: 'echo "Please be patient, this may take a minute or two... Getting database dump." && scp root@<%= secret.host %>:/tmp/mysqldumps/latest_staging.sql.gz web/mysqldumps/latest_staging_to_dev.sql.gz && echo "Aww yeah, tasty."'
      },
      unzip_staging: {
        cmd: 'gunzip -f web/mysqldumps/latest_staging_to_dev.sql.gz'
      },
      get_uploads: {
        cmd: 'echo "Please be patient, this may run for a bit... Getting uploads directory." && scp -r root@<%= secret.host %>:/home/<%= secret.host %>/production/current/web/app/uploads/* web/app/uploads/'
      },
      sync_uploads: {
        cmd: 'echo "Please be patient, this may run for a bit... Syncing uploads directory." && rsync -r root@<%= secret.host %>:/home/<%= secret.host %>/production/current/web/app/uploads/* web/app/uploads/'
      }
    }
  });

  // Load tasks
  grunt.loadNpmTasks('grunt-peach');
  grunt.loadNpmTasks('grunt-exec');

  // Register tasks
  grunt.registerTask('default', []);
  grunt.registerTask('db_to_dev', [ 'exec:get_prod_dump', 'exec:unzip_prod', 'peach:url_to_dev', 'peach:path_to_dev' ]);
  grunt.registerTask('db_to_prod', ['peach:url_to_prod', 'peach:path_to_prod']);
  grunt.registerTask('db_to_staging', ['peach:url_to_staging', 'peach:path_to_staging']);
  // Note: the following task does not use exec:get_staging_dump yet because this is not part of our server provisioning yet.
  grunt.registerTask('db_staging_to_dev', ['exec:unzip_staging','peach:url_staging_to_dev', 'peach:path_staging_to_dev']);
};