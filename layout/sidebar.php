<aside class="mdc-drawer mdc-drawer--dismissible mdc-drawer--open">
  <div class="mdc-drawer__header">
    <a href="<?php echo $routes['home'];?>?crypted=<?php echo $_GET['crypted'];?>" class="brand-logo">
      <img src="<?php echo $route?>assets/images/logo.png" alt="logo">
    </a>
  </div>
  <div class="mdc-drawer__content">
    <div class="user-info">
      <span class="name"><?php echo ($usertype==2) ? 'Club' : 'Resident'; ?></span>
      <span class="email">[<?php echo $username;?>]</span>
    </div>
    <div class="mdc-list-group">
      <nav class="mdc-list mdc-drawer-menu">
        <div class="mdc-list-item mdc-drawer-item">
          <a class="mdc-drawer-link" href="<?php echo $routes['home'];?>?crypted=<?php echo $_GET['crypted'];?>">
            <i class="material-icons mdc-list-item__start-detail mdc-drawer-item-icon" aria-hidden="true">home</i>
            Home
          </a>
        </div>
        
        <div class="mdc-list-item mdc-drawer-item">
          <a class="mdc-expansion-panel-link" href="#" data-toggle="expansionPanel" data-target="fb-sub-menu">
            <i class="material-icons mdc-list-item__start-detail mdc-drawer-item-icon" aria-hidden="true">collections_bookmark</i>
            Facility Booking
            <i class="mdc-drawer-arrow material-icons">chevron_right</i>
          </a>
          <div class="mdc-expansion-panel" id="fb-sub-menu">
            <nav class="mdc-list mdc-drawer-submenu">
              <div class="mdc-list-item mdc-drawer-item">
                <a class="mdc-drawer-link" href="pages/ui-features/buttons.html">
                  Place Booking
                </a>
              </div>
              <div class="mdc-list-item mdc-drawer-item">
                <a class="mdc-drawer-link" href="pages/ui-features/typography.html">
                  View Booking
                </a>
              </div>
            </nav>
          </div>
        </div>

        <div class="mdc-list-item mdc-drawer-item">
          <a class="mdc-expansion-panel-link" href="#" data-toggle="expansionPanel" data-target="oc-sub-menu">
            <i class="material-icons mdc-list-item__start-detail mdc-drawer-item-icon" aria-hidden="true">group</i>
            Our Community
            <i class="mdc-drawer-arrow material-icons">chevron_right</i>
          </a>
          <div class="mdc-expansion-panel" id="oc-sub-menu">
            <nav class="mdc-list mdc-drawer-submenu">
              <div class="mdc-list-item mdc-drawer-item">
                <a class="mdc-drawer-link" href="pages/ui-features/buttons.html">
                  Community News
                </a>
              </div>
              <div class="mdc-list-item mdc-drawer-item">
                <a class="mdc-drawer-link" href="pages/ui-features/typography.html">
                  Circular
                </a>
              </div>
              <div class="mdc-list-item mdc-drawer-item">
                <a class="mdc-drawer-link" href="pages/ui-features/buttons.html">
                  Calendar of Events
                </a>
              </div>
            </nav>
          </div>
        </div>

        <div class="mdc-list-item mdc-drawer-item">
          <a class="mdc-expansion-panel-link" href="#" data-toggle="expansionPanel" data-target="ul-sub-menu">
            <i class="material-icons mdc-list-item__start-detail mdc-drawer-item-icon" aria-hidden="true">insert_link</i>
            Useful Links
            <i class="mdc-drawer-arrow material-icons">chevron_right</i>
          </a>
          <div class="mdc-expansion-panel" id="ul-sub-menu">
            <nav class="mdc-list mdc-drawer-submenu">
              <div class="mdc-list-item mdc-drawer-item">
                <a class="mdc-drawer-link" href="pages/ui-features/typography.html">
                  Getting There
                </a>
              </div>
              <div class="mdc-list-item mdc-drawer-item">
                <a class="mdc-drawer-link" href="pages/ui-features/buttons.html">
                  Contractor/Supplier
                </a>
              </div>
            </nav>
          </div>
        </div>

        <div class="mdc-list-item mdc-drawer-item">
          <a class="mdc-drawer-link" href="pages/charts/chartjs.html">
            <i class="material-icons mdc-list-item__start-detail mdc-drawer-item-icon" aria-hidden="true">assignment</i>
            Application Forms
          </a>
        </div>

        <div class="mdc-list-item mdc-drawer-item">
          <a class="mdc-drawer-link" href="pages/charts/chartjs.html">
            <i class="material-icons mdc-list-item__start-detail mdc-drawer-item-icon" aria-hidden="true">gavel</i>
            By Laws
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