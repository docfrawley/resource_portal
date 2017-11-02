(function() {
'use strict'

angular.module('ResourceApp')
.controller('HomeController',HomeController)


  HomeController.$inject = ['HomeService', 'fplist', 'tags', 'prompts', 'events', 'tools', '$interval', '$animate', '$log'];
  function HomeController(HomeService, fplist, tags, prompts, events, tools, $interval, $animate, $q, $log) {
  var hctrl=this;
    // hctrl.events = events;
    // console.log("what", events);

  var jsonObj = events.data.success.channel.item;
  hctrl.tools = tools.data;  
  hctrl.noEntry = false;
  var toolIndex = Math.floor((Math.random() * hctrl.tools.length));
  hctrl.theTool = hctrl.tools[toolIndex];
  hctrl.changeTools = function () {
    if (toolIndex == (hctrl.tools.length - 1)) {
      toolIndex = 0;
    } else {
      toolIndex++;
    }
    hctrl.theTool = hctrl.tools[toolIndex];
  };
  $interval(hctrl.changeTools, 10000);
  hctrl.events = [];
  var date = new Date();
  var year = date.getFullYear();
  for (var i = 0; i < 11; i++) {
    var event = [];
    var temp_title = jsonObj[i].title;
    if (temp_title.indexOf('CANCELLED') === -1) {
      var where_end_title = temp_title.indexOf('(') - 1;
      event['title'] = temp_title.slice(0, where_end_title);
      var temp_des = jsonObj[i].description;
      var where_start = temp_des.indexOf(':') + 2;
      var where_end = temp_des.indexOf('EDT') - 1;
      if (where_end < 0){
        where_end = temp_des.indexOf('EST') - 1;
      }
      // var where_endEST = temp_des.indexOf('EST') - 1;
      var temp_string = temp_des.slice(where_start, where_end);
      // temp_string = temp_des.slice(where_start, where_endEST);
      var first_part = temp_string.slice(0, temp_string.indexOf(year)-1);
      var second_part = temp_string.slice(temp_string.indexOf(year) +4);
      event['date'] = first_part;
      event['time'] = second_part.replace(/\s+/g, '');
      event['link'] = jsonObj[i].link;
      hctrl.events.push(event);
    }
  }
  
    hctrl.simulateQuery = false;
    hctrl.isDisabled    = false;
    hctrl.states        = tags.data;
    hctrl.states_array = [];
    for (var x=0; x<hctrl.states.length; x++){
      hctrl.states_array.push(hctrl.states[x].display);
    }


    hctrl.querySearch = function (query) {
      hctrl.noEntry = false;
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
  };

  hctrl.goSearch = function(hsearch){
    hctrl.search = hctrl.searchText.toLowerCase().trim();
    if (hctrl.search==""){
      hctrl.noEntry = true;
    } else {
      hctrl.noEntry = false;
      var inTags = hctrl.states_array.indexOf(hctrl.search) != -1;
      var whereTag = hctrl.states_array.indexOf(hctrl.search);
      var tag = (inTags) ? hctrl.states[whereTag].id : hctrl.search;
      HomeService.searchRequest(tag, hsearch, 's', inTags)
        .then(function (response) {
          hctrl.results = response.data;
          if (hctrl.results.length > 0) {
            hctrl.showsearch = true;
          } else {
            hctrl.notag = true;
          }
          console.log("what: ", hsearch, hctrl.results);
        })
        .catch(function (error) {
          console.log(error);
        });
    }
    
  };

  hctrl.latestAdditions =  function(){
    hctrl.search = "Latest Additions";
    HomeService.latestAdditions()
    .then(function (response){
      hctrl.results = response.data;
      hctrl.showsearch = true;
    })
    .catch(function (error) {
      console.log(error);
    });
  }

};



})();
