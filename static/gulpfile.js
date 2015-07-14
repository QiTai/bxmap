/**
 * Created by imsun on 2015/7/14.
 */
'use strict'

var gulp = require('gulp')
var sourcemaps = require('gulp-sourcemaps')
var babel = require('gulp-babel')
var webpack = require('webpack')

gulp.task('default', function (callback) {
  gulp.src('src/*.js')
    .pipe(sourcemaps.init())
    .pipe(babel({ optional: ['runtime'] }))
    .pipe(sourcemaps.write('.'))
    .pipe(gulp.dest('dist'))
    .on('end', function() {
      webpack({
        entry: './dist/main.js',
        output: {
          path: __dirname + '/dist',
          filename: 'bundle.js'
        },
        resolve: {
          alias: {
            echarts$: __dirname + '/echarts/echarts.js',
            echarts: __dirname + '/echarts',
            zrender$: __dirname + '/zrender/zrender.js',
            zrender: __dirname + '/zrender'
          }
        }
      }, function(err) {
        if (err) throw new Error('webpack', err)
        callback()
      })
    })
})
