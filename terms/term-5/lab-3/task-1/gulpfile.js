const gulp = require("gulp");
const browserSync = require("browser-sync").create();

gulp.task("task-1", function (callback) {
  console.log("Task 1");
  callback();
});

gulp.task("task-2", function (callback) {
  console.log("Task 2");
  callback();
});

gulp.task("browserSync", function () {
  browserSync.init({
    server: {
      baseDir: "./",
    },
  });

  gulp.watch("*.html").on("change", browserSync.reload);
});

gulp.task("default", gulp.series("browserSync"));
// gulp.task("default", gulp.series("task-1", "task-2"));
// gulp.task("default", gulp.parallel("task-1", "task-2"));
