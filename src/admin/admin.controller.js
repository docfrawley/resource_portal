(function() {
'use strict'

angular.module('ResourceApp')
.controller('AdminController',AdminController)


AdminController.$inject=['AdminService', 'netids', 'whoDetails', 'pending'];
function AdminController(AdminService, netids, whoDetails, pending) {
  var adctrl=this;

  adctrl.pendingLength = pending.data.length;
  adctrl.who = whoDetails.data;
  adctrl.which_module = "add";
  adctrl.pending = pending.data;

  adctrl.changeModule = function(which_mod){
    switch (which_mod) {
      case 'useradmin':

        break;
      case 'pending':
      AdminService.getPending()
      .then(function (response){
        adctrl.pendingLength = pending.data.length;
        adctrl.pending = response.data;
      })
      .catch(function (error) {
        console.log(error);
      });
        break;
      default:
        break;
    }
    adctrl.which_module = which_mod;
  };

  adctrl.updatePendingNums = function(){

        console.log("pending num: ", adctrl.pendingLength);
        adctrl.pendingLength --;
        console.log("pending num: ", adctrl.pendingLength);
  };



};

})();
