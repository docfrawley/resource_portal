(function () {
'use strict';

angular.module('ResourceApp')
.config(RoutesConfig);

RoutesConfig.$inject = ['$stateProvider', '$urlRouterProvider'];
function RoutesConfig($stateProvider, $urlRouterProvider) {

  // Redirect to home page if no other URL matches
  $urlRouterProvider.otherwise('/');

  // *** Set up UI states ***
  $stateProvider

  // Home page
  .state('home', {
    url: '/',
    controller: 'HomeController',
    controllerAs: 'hctrl',
    templateUrl: 'src/home/home.html',
    resolve: {
      fplist: ['HomeService',function (HomeService) {
        return HomeService.FrontPage();
      }],
      tags: ['HomeService',function (HomeService) {
        return HomeService.getTags();
      }],
      prompts: ['HomeService',function (HomeService) {
        return HomeService.getPrompts();
      }]
    }
  })

  .state('admin', {
    url: '/admin',
    controller: 'AdminController',
    controllerAs: 'adctrl',
    templateUrl: 'src/admin/admin.php',
    resolve: {
      whoDetails: ['AdminService',function (AdminService) {
        return AdminService.getWho();
      }],
      pending: ['AdminService',function (AdminService) {
        return AdminService.getPending();
      }],
      netids: ['AdminService',function (AdminService) {
        return AdminService.GetNetids();
      }]
    }
  });


}

})();
