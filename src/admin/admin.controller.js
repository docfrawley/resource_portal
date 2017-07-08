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
    if (which_mod == 'pending'){
      AdminService.getPending()
      .then(function (response){
        adctrl.pendingLength = pending.data.length;
        adctrl.pending = response.data;
      })
      .catch(function (error) {
        console.log(error);
      });
    }
    adctrl.which_module = which_mod;
  };



};

})();
