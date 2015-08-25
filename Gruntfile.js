var config = {

};
/**
 * Grunt!
 */
module.exports = function(grunt) {

    // Project configuration.
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        vagrant: {
            options: {
                // Task-specific options go here.
            },
            devup: {
               commands: ["halt", "up --provision"]
            }
        },
        //TODO: Setup Grunt tasks!
        "db_dump":{
            "production": {
                "options": {
                    "title": "Production DB",

                    "database": "db_name",
                    "user": "db_username",
                    "pass": "db_password",
                    "host": "db_host",

                    "ssh_host": "db_ssh_host",

                    "backup_to": "/db/backups/production.sql"
                }
            }
        }

    });

    grunt.loadNpmTasks('grunt-phplint');
    grunt.loadNpmTasks('grunt-composer');
    grunt.loadNpmTasks('grunt-contrib-jshint');
    grunt.loadNpmTasks('grunt-vagrant');
    // Default task(s).
    grunt.registerTask('init', ['composer:install', 'vagrant:devup']);

};