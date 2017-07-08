(function () {
"use strict";

angular.module('ResourceApp')
.component('pendingResources', {
  templateUrl: 'src/admin/pending/pending.html',
  controller: pendingController,
  bindings: {
    title:  '@',
    who:    '<',
    list:   '<'
  }
});

pendingController.$inject = ['AdminService', '$scope', '$element']
function pendingController(AdminService, $scope, $element) {
  var $ctrl = this;

  $ctrl.$onInit = function () {
    $ctrl.level = $ctrl.who.level;
  };

  $ctrl.approveUpdate = function (index){
    $ctrl.resource = $ctrl.list[index];
    $ctrl.whatDo = 'approve';
  };

  $ctrl.deleteUpdate = function (index){
    $ctrl.resource = $ctrl.list[index];
    $ctrl.whatDo = 'delete';
  };

}

})();
