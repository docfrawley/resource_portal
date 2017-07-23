(function() {
'use strict'

angular.module('ResourceApp')
.controller('HomeController',HomeController)


HomeController.$inject=['HomeService', 'fplist', 'tags', 'prompts', '$interval', '$animate', '$log'];
function HomeController(HomeService, fplist, tags, prompts, $interval, $animate, $q, $log) {
  var hctrl=this;

    hctrl.simulateQuery = false;
    hctrl.isDisabled    = false;
    hctrl.states        = tags.data;
    hctrl.states_array = [];
    for (var x=0; x<hctrl.states.length; x++){
      hctrl.states_array.push(hctrl.states[x].display);
    }


    hctrl.querySearch = function (query) {
      var results = query ? hctrl.states.filter( createFilterFor(query) ) : hctrl.states,
          deferred;
          hctrl.notag = false;
      // if (hctrl.simulateQuery) {
      //   deferred = $q.defer();
      //   $timeout(function () { deferred.resolve( results ); }, Math.random() * 1000, false);
      //   return deferred.promise;
      // } else {
        return results;
      // }
    }

    // hctrl.searchTextChange = function (text) {
    //   $log.info('Text changed to ' + text);
    // }
    //
    // hctrl.selectedItemChange =function (item) {
    //   $log.info('Item changed to ' + JSON.stringify(item));
    // }

    function createFilterFor(query) {
      var lowercaseQuery = angular.lowercase(query);

      return function filterFn(state) {
        var thestate = angular.lowercase(state.display);
        return (thestate.indexOf(lowercaseQuery) === 0);
      };

    }

  hctrl.showsearch=false;
  hctrl.fpvids = fplist.data;
  hctrl.headerArray = prompts.data;
  hctrl.index = 0;
  hctrl.myHeader = hctrl.headerArray[hctrl.index];
  hctrl.changeHeader = function(){
    if (hctrl.index == (hctrl.headerArray.length - 1)){
      hctrl.index = 0;
    } else {
      hctrl.index++;
    }
    hctrl.myHeader = hctrl.headerArray[hctrl.index];
  };
    $interval(hctrl.changeHeader, 6000);

  hctrl.search = "";
  hctrl.notag = false;
  hctrl.newSearch = function(){
    hctrl.showsearch=false;
    hctrl.search = "";
    hctrl.notag = false;
    hctrl.searchText = "";
    hctrl.selectedItem = "";
  }
  hctrl.goSearch = function(hsearch){
    hctrl.search = hctrl.searchText;
    var inTags = hctrl.states_array.indexOf(hctrl.search)!=-1;
    console.log(hctrl.search, hsearch, 's', inTags);
    HomeService.searchRequest(hctrl.search, hsearch, 's', inTags)
      .then(function (response){
        hctrl.results = response.data;
        if (hctrl.results.length>0){
          hctrl.showsearch = true;
        } else {
          hctrl.notag = true;
        }
      })
      .catch(function (error) {
        console.lsaog(error);;;;;;asdf
      });
  };

};



})();
