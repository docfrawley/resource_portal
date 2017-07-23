(function () {
"use strict";

angular.module('common')
.service('HomeService', HomeService)
.constant('ApiPath', 'http://localhost:8888/resource_portal/ajax/');


HomeService.$inject = ['$http', 'ApiPath'];
function HomeService($http, ApiPath) {
  var service = this;

  service.FrontPage = function() {
    var response = $http({
      method: "GET",
      url: (ApiPath +"ajaxfiles.php"),
      params: {
        task:   'frontpage'
      }
    });
    return response;
  };

  service.getPrompts = function(){
    var response = $http({
      method: "GET",
      url: (ApiPath +"ajaxfiles.php"),
      params: {
        task:   'prompts'
      }
    });
    return response;
  };

  service.getTags = function(){
    var response = $http({
      method: "GET",
      url: (ApiPath +"ajaxfiles.php"),
      params: {
        task:   'tags'
      }
    });
    return response;
  };

  service.searchRequest = function(tag, hsearch, what_kind, inTags){
    var response = $http({
      method: "GET",
      url: (ApiPath +"ajaxfiles.php"),
      params: {
        task:       'get_search',
        tag:        tag,
        hsearch:    hsearch,
        what_kind:  what_kind,
        inTags:     inTags
      }
    });
    return response;
  };

  service.watched = function(numid, whichone){
    var response = $http({
      method: "POST",
      url: (ApiPath +"didsee.php"),
      data: {
        numid:    numid,
        whichone: whichone,
        pressed:  'free'
      }
    });
    return response;
  };

  service.thumbchange =function(numid, whichone, pressed){
    var response = $http({
      method: "POST",
      url: (ApiPath +"didsee.php"),
      data: {
        numid:    numid,
        whichone: whichone,
        pressed:  pressed
      }
    });
    return response;
  };

}



})();
