

/**
 * Grunt!
 */
module.exports = function(grunt) {

    // Project configuration.
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json')
    });

    grunt.loadNpmTasks('grunt-phplint');
    grunt.loadNpmTasks('grunt-composer');
    grunt.loadNpmTasks('grunt-contrib-jshint');

    // Default task(s).
    grunt.registerTask('init', ['composer:install']);

};