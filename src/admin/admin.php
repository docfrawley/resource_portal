<div class="row">
  <div class="col-sm-3">
    <button type="button" class="btn btn-success btn-lg btn-block"
          ng-click="adctrl.changeModule('add')"
        >ADD RESOURCE</button>
    <button type="button" class="btn btn-success btn-lg btn-block"
          ng-click="adctrl.changeModule('edit')"
        >EDIT/DELETE</button>
    <button type="button" class="btn btn-success btn-lg btn-block"
        ng-click="adctrl.changeModule('analytics')"
        >ANALYTICS</button>
    <button type="button" class="btn btn-success btn-lg btn-block"
        ng-click="adctrl.changeModule('analytics')" ng-if="adctrl.who.level=='super'"
        >USER ADMIN</button>
    <button type="button" class="btn btn-success btn-lg btn-block"
        ng-click="adctrl.changeModule('nudge')" ng-if="adctrl.who.level=='super'"
        >NUDGE ADMIN</button>
    <button type="button" class="btn btn-success btn-lg btn-block"
        ng-click="adctrl.changeModule('pending')" ng-if="adctrl.who.level=='super'"
        >PENDING ({{adctrl.pendingLength}})</button>

  </div>
  <div class="col-sm-9">
    <div class="panel panel-default" ng-if="adctrl.which_module=='add'">
      <div class="panel-heading">
        <h3 class="panel-title">ADD RESOURCE...if you dare, {{adctrl.who.fname}}</h3>
      </div>
      <div class="panel-body">
        <add-edit
          what= 'add'
          who=  "adctrl.who"
          resource = ""></add-edit>
      </div>
    </div>
    <make-edits ng-if="adctrl.which_module=='edit'"
      title="EDIT/DELETE RESOURCES...if you dare"
      who="adctrl.who"
    ></make-edits>
    <pending-resources ng-if="adctrl.which_module=='pending'"
      title = "PENDING RESOURCES"
      who = "adctrl.who"
      list = 'adctrl.pending'
      ></pending-resources>
  </div>


</div>
