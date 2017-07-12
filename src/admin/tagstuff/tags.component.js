(function () {
"use strict";

angular.module('ResourceApp')
.component('tagEdits', {
  templateUrl: 'src/admin/tagstuff/tagEdits.html',
  controller: tagsController,
  bindings: {
    tagstring:  '<',
    changeString: '&'
  }
});

tagsController.$inject = ['AdminService', 'HomeService', '$scope', '$element']
function tagsController(AdminService, HomeService, $scope, $element) {
  var $ctrl = this;

  $ctrl.$onInit = function () {
    $ctrl.rtags = $ctrl.tagstring.split(",");
    console.log("ehllo: ", $ctrl.rtags);
    $ctrl.tagsin = [];
    HomeService.getTags()
    .then(function (response){
      $ctrl.tags = response.data;
      $ctrl.tagsin = [];
      for (var i = 0; i < $ctrl.tags.length; i++) {
        var temp_array=[];
        temp_array.value = $ctrl.tags[i].value;
        temp_array.display = $ctrl.tags[i].display;
        temp_array.id = $ctrl.tags[i].id;
        temp_array.show = ($ctrl.rtags.includes(temp_array.id));
        $ctrl.tags[i].show = !temp_array.show;
        $ctrl.tagsin.push(temp_array);
      }
    })
    .catch(function (error) {
      console.log(error);
    });
  };



  $ctrl.changeShow = function(index){
    $ctrl.tags[index].show = !$ctrl.tags[index].show;
    $ctrl.tagsin[index].show = !$ctrl.tagsin[index].show;
    var tagstring= "";
    for (var i = 0; i < $ctrl.tagsin.length; i++) {
      if ($ctrl.tagsin[i].show){
        tagstring += $ctrl.tagsin[i].id+',';
      }
    };
    tagstring = tagstring.slice(0, -1);
    console.log("tagstring: ", tagstring);
    $ctrl.changeString({nstring: tagstring});
  };

}

})();
