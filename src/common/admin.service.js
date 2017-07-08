(function () {
"use strict";

angular.module('common')
.service('AdminService', AdminService)
.constant('ApiPath', 'http://localhost:8888/rportal/ajax/');


AdminService.$inject = ['$http', 'ApiPath', 'Upload'];
function AdminService($http, ApiPath, Upload) {
  var service = this;

  service.GetNetids = function() {
    var response = $http({
      method: "GET",
      url: (ApiPath +"ajaxfiles.php"),
      params: {
        task:   'netids'
      }
    });
    return response;
  };

  service.getPending = function(){
    var response = $http({
      method: "GET",
      url: (ApiPath +"ajaxfiles.php"),
      params: {
        task:   'getPending'
      }
    });
    return response;
  };

  service.getWho = function(){
    var response = $http({
      method: "GET",
      url: (ApiPath +"ajaxfiles.php"),
      params: {
        task:   'getWho'
      }
    });
    return response;
  };

  service.getTitles = function(){
    var response = $http({
      method: "GET",
      url: (ApiPath +"ajaxfiles.php"),
      params: {
        task:   'getTitles'
      }
    });
    return response;
  };

  service.getUsers = function(){
    var response = $http({
      method: "GET",
      url: (ApiPath +"ajaxfiles.php"),
      params: {
        task:   'getUsers'
      }
    });
    return response;
  };

  service.getResources = function(searchwhat, numindex, searching){
    var response = $http({
      method: "GET",
      url: (ApiPath +"ajaxfiles.php"),
      params: {
        task:       'getEditResources',
        what:       searchwhat,
        numindex:   numindex,
        searching:  searching
      }
    });
    return response;
  };

  service.doDelete = function(numid, level, status){
    var response = $http({
      method: "GET",
      url: (ApiPath +"ajaxfiles.php"),
      params: {
        task: 'deleteresource',
        numid:  numid,
        level:  level,
        status: status
      }
    });
    return response;
  };

  service.aOreResource =function(numid, pdfFile, what, tagstring, type, title, description, link){
    var response = $http({
      method: "POST",
      url: (ApiPath +"aOreResource.php"),
      data: {
        numid:        numid,
        pdfFile:      pdfFile,
        what:         what,
        tags:         tagstring,
        type:         type,
        title:        title,
        description:  description,
        link:         link
      }
    });
    return response;
  };


}

})();
