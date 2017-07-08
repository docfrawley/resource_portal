(function () {
"use strict";

angular.module('ResourceApp')
.component('showcase', {
  templateUrl: 'src/home/showcase/showcase.html',
  controller: scController,
  bindings: {
    title:    '@',
    list:    '<'
  }
});

scController.$inject = ['HomeService', '$scope', '$element']
function scController(HomeService, $scope, $element) {
  var $ctrl = this;
  $ctrl.watched = false;
  $scope.$on('youtube.player.playing', function ($event, player) {
    console.log("which vid: ", $ctrl.list.numid);
    HomeService.watched($ctrl.list.numid,'numviews')
      .then(function (response){
        console.log("done");
      })
      .catch(function (error) {
        console.log(error);
      });
  });

  // $ctrl.didwatch = function() {
  //   $ctrl.watched=true;
  //   console.log("here", $ctrl.watched);
  // };
}

})();
