(function () {
"use strict";

angular.module('ResourceApp')
.component('nudgeAdmin', {
  templateUrl: 'src/admin/nudge/nudgeadmin.html',
  controller: nudgeController,
  bindings: {
    title:  '@',
    dates:  '<'
  }
});

nudgeController.$inject = ['AdminService', '$scope', '$element']
function nudgeController(AdminService, $scope, $element, uiCalendarConfig) {
  var $ctrl = this;

  $ctrl.editing = false;
  $ctrl.madeAction = false;
  $ctrl.whatDoing = '';
  $ctrl.simulateQuery = false;
  $ctrl.isDisabled    = false;
  $ctrl.noCache = false;

  $ctrl.$onInit = function () {
    $ctrl.eventSources = $ctrl.dates;
    console.log($ctrl.eventSources);
  };

  $ctrl.alertEventOnClick = function(date, jsEvent, view){
    $ctrl.whichtitle = date.title;
    $ctrl.whichnumid = date.numid;
    $ctrl.editing = true;
    AdminService.getFpageResource($ctrl.whichnumid)
    .then(function(response){
      $ctrl.eresource = response.data;
    })
    .catch(function(error){
      console.log(error);
    });
  };

  $ctrl.whatDo = function(what){
    if (what=='cancel'){
      $ctrl.editing = false;
    } else if (what=='add') {
      $ctrl.madeAction = false;
      $ctrl.whatDoing = what;
      $ctrl.search = "";
      $ctrl.searchText = "";
      $ctrl.selectedItem = "";
      AdminService.getTitles()
      .then(function (response){
        $ctrl.notag
        $ctrl.states_array = response.data;
        $ctrl.states = [];
        for (var x=0; x<$ctrl.states_array.length; x++){
          $ctrl.states.push($ctrl.states_array[x].display);
        }
      })
      .catch(function (error) {
        console.log(error);
      });
    } else {
      $ctrl.madeAction = false;
      $ctrl.edate = new Date($ctrl.eresource.year, $ctrl.eresource.month-1, $ctrl.eresource.day, 0, 0, 0);
      $ctrl.wview = $ctrl.eresource.wview;
      $ctrl.whatDoing = what;
    }
  };

  $ctrl.querySearch = function (query) {
    var results = query ? $ctrl.states_array.filter( createFilterFor(query) ) : $ctrl.states_array,
        deferred;
      return results;
  }

  function createFilterFor(query) {
    var lowercaseQuery = angular.lowercase(query);
    return function filterFn(state) {
      var thestate = angular.lowercase(state.display);
      return (thestate.indexOf(lowercaseQuery) === 0);
    };
  };

  $ctrl.deleteFPResource = function (){
      console.log($ctrl.whichnumid);
      $ctrl.madeAction = true;
  };

  $ctrl.editFPResource = function (){
    if ($ctrl.edate==undefined){
      $ctrl.edate = "0";
    }
    var date = new Date($ctrl.edate);
    console.log("date: ", date.getDate());
    AdminService.aOreFPResource('edit', $ctrl.whichnumid, $ctrl.whichview, date)
    .then(function(response){
      console.log(response.data);
      $ctrl.madeAction = true;
    })
    .catch(function(error) {
    });
    $ctrl.madeAction = true;
  };

  $ctrl.addFPResource = function (){
    if ($ctrl.adate==undefined){
      $ctrl.adate = "0";
    }
    var date = new Date($ctrl.adate).valueOf()/1000;
    console.log('date: ', date);
    AdminService.aOreFPResource('add', $ctrl.searchText, $ctrl.wview, date)
    .then(function(response){
      AdminService.GetDates()
        .then(function(response){
          $ctrl.eventSources.splice(0, $ctrl.eventSources.length)
          $ctrl.events = response.data;
          for(var i = 0; i < $ctrl.events.length; ++i) {
            $ctrl.eventSources.push($ctrl.events[i]);
          }
          console.log($ctrl.eventSources);
        })
        .catch(function(error) {
        });
        $ctrl.madeAction = true;
    })
    .catch(function(error) {
    });
    $ctrl.madeAction = true;
  };

  /* config object */
  $ctrl.uiConfig = {
    calendar:{
      height: 350,
      editable: true,
      header:{
        left: 'month basicWeek basicDay',
        center: 'title',
        right: 'today prev,next'
      },
      eventClick: $ctrl.alertEventOnClick
    }
  };





}

})();
