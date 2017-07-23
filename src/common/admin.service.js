(function () {
"use strict";

angular.module('common')
.service('AdminService', AdminService)
.constant('ApiPath', 'http://localhost:8888/resource_portal/ajax/');


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

  service.getUser = function(index) {
    var response = $http({
      method: "GET",
      url: (ApiPath +"ajaxfiles.php"),
      params: {
        task:   'getUser',
        index:  index
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

  service.dResource = function(numid){
    var response = $http({
      method: "GET",
      url: (ApiPath +"ajaxfiles.php"),
      params: {
        task: 'dresource',
        numid:  numid
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

  service.deleteUser = function(numindex) {
    var response = $http({
      method: "GET",
      url: (ApiPath +"ajaxfiles.php"),
      params: {
        task: 'deleteuser',
        numindex:  numindex
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

  service.approveResource = function(numid, tagstring, title, description){
    var response = $http({
      method: "POST",
      url: (ApiPath +"approveResource.php"),
      data: {
        numid:        numid,
        tags:         tagstring,
        title:        title,
        description:  description
      }
    });
    return response;
  };

  service.adOredUser = function(whatDo, user){
    var response = $http({
      method: "POST",
      url: (ApiPath +"aoreuser.php"),
      data: {
        whatDo:   whatDo,
        numindex: user.numindex,
        fname:    user.fname,
        lname:    user.lname,
        netid:    user.netid,
        level:    user.level,
        webhook:  user.webhook
      }
    });
    return response;
  }

}

})();
