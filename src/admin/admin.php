<?
session_start(); 
if (isset($_SESSION["casnetid"])) { 
  ?>

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
        ng-click="adctrl.changeModule('useradmin')" ng-if="<? echo $_SESSION['level'];?>==super"
        >USER ADMIN</button>
    <button type="button" class="btn btn-success btn-lg btn-block"
        ng-click="adctrl.changeModule('nudge')" ng-if="<? echo $_SESSION['level'];?>==super"
        >NUDGE ADMIN</button>
    <button type="button" class="btn btn-success btn-lg btn-block"
        ng-click="adctrl.changeModule('pending')" ng-if="<? echo $_SESSION['level'];?>==super"
        >PENDING ({{adctrl.pendingLength}})</button>

  </div>
  <div class="col-sm-9">
    <div class="panel panel-default" ng-if="adctrl.which_module=='add'">
      <div class="panel-heading">
        <h3 class="panel-title">ADD RESOURCE...if you dare, <? echo $_SESSION['fullname'];?></h3>
      </div>
      <div class="panel-body">
        <add-edit
          what= 'add'
          resource = ""></add-edit>
      </div>
    </div>
    <make-edits ng-if="adctrl.which_module=='edit'"
      title="EDIT/DELETE RESOURCES...if you dare"
    ></make-edits>
    <pending-resources ng-if="adctrl.which_module=='pending'"
      title = "PENDING RESOURCES"
      list = 'adctrl.pending'
      update-pendings = 'adctrl.updatePendingNums()'
      ></pending-resources>
      <user-admin ng-if="adctrl.which_module=='useradmin'"
        title = "USER ADMINISTRATION"
      ></user-admin>
      <nudge-admin ng-if="adctrl.which_module=='nudge'"
        title = "NUDGE ADMINISTRATION"
        dates = 'adctrl.dates'
      ></nudge-admin>
  </div>


</div>
<? } else {
  echo "access denied.";
} ?>
