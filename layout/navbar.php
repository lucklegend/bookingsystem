<header class="mdc-top-app-bar">
  <div class="mdc-top-app-bar__row">
    <div class="mdc-top-app-bar__section mdc-top-app-bar__section--align-start">
      <button class="material-icons mdc-top-app-bar__navigation-icon mdc-icon-button sidebar-toggler">menu</button>
      <span class="mdc-top-app-bar__title">Greetings <?php echo $name;?>!</span>
    </div>
    <div class="mdc-top-app-bar__section mdc-top-app-bar__section--align-end mdc-top-app-bar__section-right">
    
      <div class="divider d-none d-md-block"></div>
      <div class="menu-button-container d-none d-md-block">
        <button class="mdc-button mdc-menu-button">
          <i class="mdi mdi-settings"></i>
        </button>
        <div class="mdc-menu mdc-menu-surface" tabindex="-1">
          <ul class="mdc-list" role="menu" aria-hidden="true" aria-orientation="vertical">
            <li class="mdc-list-item" role="menuitem">
              <div class="item-thumbnail item-thumbnail-icon-only">
                <i class="mdi mdi-alert-circle-outline text-primary"></i>
              </div>
              <div class="item-content d-flex align-items-start flex-column justify-content-center">
                <h6 class="item-subject font-weight-normal">Settings</h6>
              </div>
            </li>
            <li class="mdc-list-item" role="menuitem">
              <div class="item-thumbnail item-thumbnail-icon-only">
              <i class="mdi mdi-logout-variant text-primary"></i>                      
              </div>
              <div class="item-content d-flex align-items-start flex-column justify-content-center">
                <h6 class="item-subject font-weight-normal"><a href="<?php echo $routes['logout'];?>">Logout</a></h6>
              </div>
            </li>
          </ul>
        </div>
      </div>
      <div class="menu-button-container">
        <button class="mdc-button mdc-menu-button">
          <i class="mdi mdi-bell"></i>
          <span class="count-indicator">
            <span class="count">3</span>
          </span>
        </button>
        <div class="mdc-menu mdc-menu-surface" tabindex="-1">
          <h6 class="title"> <i class="mdi mdi-bell-outline mr-2 tx-16"></i> Notifications</h6>
          <ul class="mdc-list" role="menu" aria-hidden="true" aria-orientation="vertical">
            <li class="mdc-list-item" role="menuitem">
              <div class="item-thumbnail item-thumbnail-icon">
                <i class="mdi mdi-email-outline"></i>
              </div>
              <div class="item-content d-flex align-items-start flex-column justify-content-center">
                <h6 class="item-subject font-weight-normal">You received a new message</h6>
                <small class="text-muted"> 6 min ago </small>
              </div>
            </li>
            <li class="mdc-list-item" role="menuitem">
              <div class="item-thumbnail item-thumbnail-icon">
                <i class="mdi mdi-account-outline"></i>                      
              </div>
              <div class="item-content d-flex align-items-start flex-column justify-content-center">
                <h6 class="item-subject font-weight-normal">New user registered</h6>
                <small class="text-muted"> 15 min ago </small>
              </div>
            </li>
            <li class="mdc-list-item" role="menuitem">
              <div class="item-thumbnail item-thumbnail-icon">
                <i class="mdi mdi-alert-circle-outline"></i>
              </div>
              <div class="item-content d-flex align-items-start flex-column justify-content-center">
                <h6 class="item-subject font-weight-normal">System Alert</h6>
                <small class="text-muted"> 2 days ago </small>
              </div>
            </li> 
            <li class="mdc-list-item" role="menuitem">
              <div class="item-thumbnail item-thumbnail-icon">
                <i class="mdi mdi-update"></i>
              </div>
              <div class="item-content d-flex align-items-start flex-column justify-content-center">
                <h6 class="item-subject font-weight-normal">You have a new update</h6>
                <small class="text-muted"> 3 days ago </small>
              </div>
            </li> 
          </ul>
        </div>
      </div>
      
    </div>
  </div>
</header>