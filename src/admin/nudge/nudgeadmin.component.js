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

  $ctrl.madeAction = false;
  $ctrl.madeAddition = false;
  $ctrl.whatDoing = '';
  $ctrl.simulateQuery = false;
  $ctrl.isDisabled    = false;
  $ctrl.noCache = false;
  $ctrl.madeEdit = false;
  $ctrl.editprompts = false;

  $ctrl.$onInit = function () {
    $ctrl.eventSources = $ctrl.dates;
  };

  $ctrl.alertEventOnClick = function(date, jsEvent, view){
    $ctrl.madeAction = false;
    $ctrl.madeAddition = false;
    $ctrl.whatDoing = '';
    $ctrl.whichtitle = date.title;
    $ctrl.whichnumid = date.numid;
    if (date.color !='purple'){
      $ctrl.editing = true;
      AdminService.getFpageResource($ctrl.whichnumid)
      .then(function(response){
        $ctrl.eresource = response.data;
      })
      .catch(function(error){
        console.log(error);
      });
    } else {
      $ctrl.editprompts = true;
      AdminService.getFpagePrompt(date.numid)
      .then(function(response){
        $ctrl.eresource = response.data;
        console.log('here: ', $ctrl.eresource);
        $ctrl.promptsLength = $ctrl.eresource.prompts.length;
        $ctrl.keys = $ctrl.eresource.prompts.map(function(v, i) {
          return i + 1;
          });
        console.log($ctrl.keys);
      })
      .catch(function(error){
        console.log(error);
      });
    }
  };

  $ctrl.whatDo = function(what){
    $ctrl.madeAction = false;
    $ctrl.madeAddition = false;
    if (what=='cancel'){
      $ctrl.editing = false;
      $ctrl.editprompts = false;
    } else if (what=='add') {
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
      $ctrl.editprompts = false;
    }
  };

  $ctrl.addPrompt = function() {
    $ctrl.promptsLength ++;
    $ctrl.eresource.prompts.push('');
    $ctrl.keys.push($ctrl.promptsLength);
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
    AdminService.aOreFPResource('delete', $ctrl.whichnumid, ' ', 0)
    .then(function(response){
      AdminService.GetDates()
        .then(function(response){
          $ctrl.eventSources.splice(0, $ctrl.eventSources.length)
          $ctrl.events = response.data;
          for(var i = 0; i < $ctrl.events.length; ++i) {
            $ctrl.eventSources.push($ctrl.events[i]);
          }
          $ctrl.madeAction = true;
          $ctrl.editing = false;
        })
        .catch(function(error) {
        });
    })
    .catch(function(error) {
    });
  };

  $ctrl.editFPResource = function (){
    if ($ctrl.edate==undefined){
      $ctrl.edate = "0";
    }
    var date = new Date($ctrl.edate).valueOf()/1000;
    console.log('edit', $ctrl.whichnumid, $ctrl.wview, date);
    AdminService.aOreFPResource('edit', $ctrl.whichnumid, $ctrl.wview, date)
    .then(function(response){
      AdminService.GetDates()
        .then(function(response){
          $ctrl.eventSources.splice(0, $ctrl.eventSources.length)
          $ctrl.events = response.data;
          for(var i = 0; i < $ctrl.events.length; ++i) {
            $ctrl.eventSources.push($ctrl.events[i]);
          }
          $ctrl.madeAction = true;
        })
        .catch(function(error) {
        });
    })
    .catch(function(error) {
    });
  };

  $ctrl.addFPResource = function (){
    if ($ctrl.adate==undefined){
      $ctrl.adate = "0";
    }
    var date = new Date($ctrl.adate).valueOf()/1000;
    AdminService.aOreFPResource('add', $ctrl.searchText, $ctrl.wview, date)
    .then(function(response){
      AdminService.GetDates()
        .then(function(response){
          $ctrl.eventSources.splice(0, $ctrl.eventSources.length)
          $ctrl.events = response.data;
          for(var i = 0; i < $ctrl.events.length; ++i) {
            $ctrl.eventSources.push($ctrl.events[i]);
          }
          $ctrl.madeAddition = true;
          $ctrl.madeAction = true;
        })
        .catch(function(error) {
        });
    })
    .catch(function(error) {
    });
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
