<?php
  $serverURL = $_SERVER['PHP_SELF'];
  $explode = explode('/',$serverURL);
  $countExplode = count($explode);
  $linkPage = $explode[$countExplode - 2];
 

  function getActive($linkName,$linkPage){
    if($linkPage == $linkName){
      echo 'active';
    }else{
 
    }
  }

  function showSubMenu($linkName,$parentSub){
    if($parentSub == $linkName){
      echo 'style="display:block;"';
    }
  }
  
?>
<script type="text/javascript">
  var elems = document.body.getElementsByTagName("a");
  var ahrefs = document.body.getElementsByClassName('mdc-drawer-link active');
  for(var i =0; i<ahrefs.length; i++){
    ahrefs.classList.remove('active');
    console.log('remove');
  }
  console.log(ahrefs);
</script>
<aside class="mdc-drawer mdc-drawer--dismissible mdc-drawer--open">
  <div class="mdc-drawer__header">
    <a href="<?php echo $routes['home'];?>?crypted=<?php echo $_GET['crypted'];?>" class="brand-logo">
      <img src="<?php echo $routes['URL'];?>assets/images/logo.png" alt="logo">
    </a>
  </div>
  <div class="mdc-drawer__content">
    <div class="user-info">
        <span class="name">Admin</span>
      <span class="email">[<?php echo $username;?>]</span>
    </div>
    <div class="mdc-list-group">
      <nav class="mdc-list mdc-drawer-menu">
        <div class="mdc-list-item mdc-drawer-item">
          <a class="mdc-drawer-link <?php if($explode[$countExplode -1] == 'index.php'){echo 'active';}?>" href="<?php echo $routes['home'];?>?crypted=<?php echo $_GET['crypted'];?>">
            <i class="material-icons mdc-list-item__start-detail mdc-drawer-item-icon" aria-hidden="true">home</i>
            Home
          </a>
        </div>

        <div class="mdc-list-item mdc-drawer-item">
          <a class="mdc-expansion-panel-link" href="#" data-toggle="expansionPanel" data-target="sm-sub-menu">
            <i class="material-icons mdc-list-item__start-detail mdc-drawer-item-icon" aria-hidden="true">business</i>
            System
            <i class="mdc-drawer-arrow material-icons">chevron_right</i>
          </a>
          <div class="mdc-expansion-panel" id="sm-sub-menu" <?php showSubMenu('system',$parentSub);?>>
            <nav class="mdc-list mdc-drawer-submenu">
              <div class="mdc-list-item mdc-drawer-item">
                <a class="mdc-drawer-link <?php getActive('users',$linkPage);?>" href="<?php echo $routes['users'];?>">
                  Manage Users
                </a>
              </div>
              <div class="mdc-list-item mdc-drawer-item">
                <a class="mdc-drawer-link" href="#">
                  Create Facilities
                </a>
              </div>
              <div class="mdc-list-item mdc-drawer-item">
                <a class="mdc-drawer-link" href="#">
                  Manage Facilities
                </a>
              </div>
              <div class="mdc-list-item mdc-drawer-item">
                <a class="mdc-drawer-link" href="#">
                  Facility Barring
                </a>
              </div>
              <div class="mdc-list-item mdc-drawer-item">
                <a class="mdc-drawer-link <?php getActive('calendar',$linkPage);?>" href="<?php echo $routes['calendar'];?>">
                  Calendar/Events
                </a>
              </div>
            </nav>
          </div>
        </div>

        <div class="mdc-list-item mdc-drawer-item">
          <a class="mdc-expansion-panel-link" href="#" data-toggle="expansionPanel" data-target="mc-sub-menu">
            <i class="material-icons mdc-list-item__start-detail mdc-drawer-item-icon" aria-hidden="true">dashboard</i>
            Manage Content
            <i class="mdc-drawer-arrow material-icons">chevron_right</i>
          </a>
          <div class="mdc-expansion-panel" id="mc-sub-menu" <?php showSubMenu('manage content',$parentSub);?>>
            <nav class="mdc-list mdc-drawer-submenu">
              <div class="mdc-list-item mdc-drawer-item">
                <a class="mdc-drawer-link <?php getActive('amenities',$linkPage);?>" href="<?php echo $routes['amenities'];?>">
                  Amenities
                </a>
              </div>
              <div class="mdc-list-item mdc-drawer-item">
                <a class="mdc-drawer-link" href="#">
                  Application Form
                </a>
              </div>
              <div class="mdc-list-item mdc-drawer-item">
                <a class="mdc-drawer-link" href="#">
                  News/Circular
                </a>
              </div>
              <div class="mdc-list-item mdc-drawer-item">
                <a class="mdc-drawer-link" href="#">
                  Useful Info
                </a>
              </div>
            </nav>
          </div>
        </div>

        <div class="mdc-list-item mdc-drawer-item">
          <a class="mdc-drawer-link" href="#">
            <i class="material-icons mdc-list-item__start-detail mdc-drawer-item-icon" aria-hidden="true">collections_bookmark</i>
            Facility Booking
          </a>
        </div>

        <div class="mdc-list-item mdc-drawer-item">
          <a class="mdc-drawer-link" href="#">
            <i class="material-icons mdc-list-item__start-detail mdc-drawer-item-icon" aria-hidden="true">book</i>
            Booking Reports
          </a>
        </div>

        <div class="mdc-list-item mdc-drawer-item">
          <a class="mdc-drawer-link" href="http://helpdesk.axonhq.net" target="_blank">
            <i class="material-icons mdc-list-item__start-detail mdc-drawer-item-icon" aria-hidden="true">pages</i>
            Axon Helpdesk
          </a>
        </div>
      </nav>
    </div>

    <div class="profile-actions">
      <p class="mdc-typography mdc-theme--light center" style="text-align:center;">
        Developed by<br>
        Axon Consulting <br>
        www.axon.com.sg<br><br>
        Tel: +65 6344 9618<br>
        Fax: +65 6344 9766<br>
        e: info@axon.com.sg
      </p>
    </div>
  </div>
</aside>