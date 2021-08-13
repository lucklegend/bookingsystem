<?php
checkIfAdmin($id, $user_type, $routes);
//Get the current pageURL
$pageURL = str_replace(".php","",$_SERVER['PHP_SELF']).'?crypted='.$_GET['crypted'];
//Setting up the Month arrays

$montharray = array (
  '1' => 'Jan',
  '2' => 'Feb',
  '3' => 'Mar',
  '4' => 'Apr',
  '5' => 'May',
  '6' => 'Jun',
  '7' => 'Jul',
  '8' => 'Aug',
  '9' => 'Sep',
  '10' => 'Oct',
  '11' => 'Nov',
  '12' => 'Dec'
);
  
$monthnum = array (
  '1' => '31',
  '2' => '28',
  '3' => '31',
  '4' => '30',
  '5' => '31',
  '6' => '30',
  '7' => '31',
  '8' => '31',
  '9' => '30',
  '10' => '31',
  '11' => '30',
  '12' => '31'
);
// END OF SETTING UP

?>
<div class="main-wrapper mdc-drawer-app-content">
  <!-- navbar -->
  <?php include_once('layout/navbar.php'); ?>
  <!-- end of navbar -->
  <!-- CONTENT HERE -->
  <div class="page-wrapper mdc-toolbar-fixed-adjust">
    <main class="content-wrapper">
      <div class="mdc-layout-grid">
        <div class="mdc-layout-grid__inner">
          <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-3-desktop mdc-layout-grid__cell--span-4-tablet">
            <div class="mdc-card info-card info-card--success">
              <div class="card-inner">
                <?php 
                  $managers = countActiveUsers(1, $conn);
                ?>
                <h5 class="card-title">Managers</h5>
                <h5 class="font-weight-light pb-2 mb-1 border-bottom">
                  <a href="<?php echo $routes['usersManager'];?>">
                    <?php echo $managers['countUsers'];?> Active Managers
                  </a>
                </h5>
                <p class="tx-12 text-muted"><?php echo $managers['percentage'];?>% of Active Users</p>
                <div class="card-icon-wrapper">
                  <i class="material-icons">verified_user</i>
                </div>
              </div>
            </div>
          </div>
          <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-3-desktop mdc-layout-grid__cell--span-4-tablet">
            <div class="mdc-card info-card info-card--danger">
              <div class="card-inner">
                <?php 
                  $residents = countActiveUsers(0, $conn);
                ?>
                <h5 class="card-title">Residents</h5>
                <h5 class="font-weight-light pb-2 mb-1 border-bottom"><?php echo $residents['countUsers'];?> Active Residents</h5>
                <p class="tx-12 text-muted"><?php echo $residents['percentage'];?>% of Active Users</p>
                <div class="card-icon-wrapper">
                  <i class="material-icons">person</i>
                </div>
              </div>
            </div>
          </div>
          <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-3-desktop mdc-layout-grid__cell--span-4-tablet">
            <div class="mdc-card info-card info-card--primary">
              <div class="card-inner">
                <?php
                  $clubs = countActiveUsers(2, $conn);
                ?>
                <h5 class="card-title">Club</h5>
                <h5 class="font-weight-light pb-2 mb-1 border-bottom"><?php echo $clubs['countUsers'];?> Active Club Users</h5>
                <p class="tx-12 text-muted"><?php echo $clubs['percentage'];?>% of Active Users</p>
                <div class="card-icon-wrapper">
                  <i class="material-icons">group</i>
                </div>
              </div>
            </div>
          </div>
          <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-3-desktop mdc-layout-grid__cell--span-4-tablet">
            <div class="mdc-card info-card info-card--info">
              <div class="card-inner">
                <?php
                  $currentYear = (int)date('Y');
                  $lastYear = (int)date('Y')-1;
                  $currentBooking = findBooking($currentYear, $conn);
                  $lastYearBooking = findBooking($lastYear, $conn);
                ?>
                <h5 class="card-title"><?php echo $currentYear; ?> Approved Book </h5>
                <h5 class="font-weight-light pb-2 mb-1 border-bottom"><?php echo $currentBooking['bookingAve'];?> booked / Month</h5>
                <p class="tx-12 text-muted"><?php echo $lastYearBooking['bookingAve'];?> Ave. Booked / Month, <?php echo $lastYear;?></p>
                <div class="card-icon-wrapper">
                  <i class="material-icons">credit_card</i>
                </div>
              </div>
            </div>
          </div>
          <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
            <div class="mdc-card">
              <div class="d-flex justify-content-between">
                <h4 class="card-title mb-0">Residents Booking Statistics</h4>
                <div>
                    <i class="material-icons refresh-icon">refresh</i>
                    <i class="material-icons options-icon ml-2">more_vert</i>
                </div>
              </div>
              <div class="container">
                <div class="row">
                  <div class="table-responsive">
                    <?php
                      if(isset($_GET['last'])) {	
                        if($_GET['last'] >= 1) {
                            $year = $_GET['year'] ;
                            $month = $_GET['last'];
                            $month_caption=date("M $year");		 
                            $lastmonth = $month;
                            if ($lastmonth < 1) {
                              $month = 12;
                              $year = $year - 1;
                            }
                            $month_caption = $montharray[$month] . " - " . $year;   
                        }
                        else {
                           $year = $_GET['year'] - '1';
                           $month = 12;
                           $month_caption=date("M $year");
                           $lastmonth = $month;
                           $month_caption = $montharray[$month] . " - " . $year;
                           
                        }
                      }
                       else if(isset($_GET['nexter'])) {	
                        if($_GET['nexter']<=12) {// start of last month calclulation
                           $year = $_GET['year'];
                           $month = $_GET['nexter'];
                           $month_caption=date("M $year");		 
                           $lastmonth = $month-1;
                           if ($lastmonth < 1) {
                             $month = 12;
                            $year = $year - 1;
                           }
                           $month_caption = $montharray[$month] . " - " . $year;
                         }
                         else {
                           $year = $_GET['year'] + '1';
                           $month = 1;
                           //$month_caption=date("M $year");
                           $lastmonth = $month;
                           //$month_caption = date('M - Y',$lastmonth);
                           $month_caption = $montharray[$month] . " - " . $year;
                         }
                       }
                       else {
                         if(isset($_GET['lastyear'])) {
                           $year = $_GET['lastyear'];
                           $month = date("n");
                           $month_caption=date("M $year");
                          $month_caption = $montharray[$month] . " - " . $year;
                          $lastmonth = $month;
                          
                         } 
                        else {
                          $year = date("Y");
                           $month = date("n");
                           $month_caption=date("M $year");
                          $month_caption = $montharray[$month] . " - " . $year;
                          $lastmonth = $month;
                        }
                        
                      }
                    ?>
                    <div class="spacer"></div>
                    <table width="100%">
                      <thead>
                        <tr>
                          <th colspan="5" class="text-center" align="center">
                            <a href="<?php echo $pageURL;?>" class="btn btn-info">
                              Last Year
                            </a>
                            <a href="<?php echo $pageURL;?>" class="btn btn-info">
                              << Previous Month
                            </a>
                            <button class="btn btn-light" disabled>
                              <strong>
                                August 2021
                              </strong>
                            </button>
                            <a href="<?php echo $pageURL;?>" class="btn btn-primary">
                              Next Month >>
                            </a>
                            <a href="<?php echo $pageURL;?>" class="btn btn-primary">
                              Next Year
                            </a>
                          </th>
                        </tr>
                      </thead>
                      <?php
                        //SQL for showing list
                      ?>
                      <tbody>
                        <tr></tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              
            </div> 
          </div>
          <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop mdc-layout-grid__cell--span-4-tablet">
            <div class="mdc-card bg-success text-white">
              <div class="d-flex justify-content-between">
                <h3 class="font-weight-normal">Impressions</h3>
                <i class="material-icons options-icon text-white">more_vert</i>
              </div>
              <div class="mdc-layout-grid__inner align-items-center">
                <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-4-desktop mdc-layout-grid__cell--span-3-tablet mdc-layout-grid__cell--span-2-phone">
                  <div>
                    <h5 class="font-weight-normal mt-2">Customers 58.39k</h5>
                    <h2 class="font-weight-normal mt-3 mb-0">636,757K</h2>
                  </div>
                </div>
                <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-8-desktop mdc-layout-grid__cell--span-5-tablet mdc-layout-grid__cell--span-2-phone">
                  <canvas id="impressions-chart" height="80"></canvas>
                </div>
              </div>
            </div>
          </div>
          <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop mdc-layout-grid__cell--span-4-tablet">
            <div class="mdc-card bg-info text-white">
                <div class="d-flex justify-content-between">
                  <h3 class="font-weight-normal">Traffic</h3>
                  <i class="material-icons options-icon text-white">more_vert</i>
                </div>
                <div class="mdc-layout-grid__inner align-items-center">
                  <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-4-desktop mdc-layout-grid__cell--span-3-tablet mdc-layout-grid__cell--span-2-phone">
                    <div>
                      <h5 class="font-weight-normal mt-2">Customers 58.39k</h5>
                      <h2 class="font-weight-normal mt-3 mb-0">636,757K</h2>
                    </div>
                  </div>
                  <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-8-desktop mdc-layout-grid__cell--span-5-tablet mdc-layout-grid__cell--span-2-phone">
                    <canvas id="traffic-chart" height="80"></canvas>
                  </div>
                </div>
            </div>
          </div>
          <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-8">
            <div class="mdc-card">
              <div class="d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-2 mb-sm-0">Revenue by location</h4>
                <div class="d-flex justtify-content-between align-items-center">
                  <p class="d-none d-sm-block text-muted tx-12 mb-0 mr-2">Goal reached</p>
                  <i class="material-icons options-icon">more_vert</i>
                </div>
              </div>
              <div class="d-block d-sm-flex justify-content-between align-items-center">
                <h6 class="card-sub-title mb-0">Sales performance revenue based by country</h6>
                <div class="mdc-tab-wrapper revenue-tab mdc-tab--secondary"> 
                  <div class="mdc-tab-bar" role="tablist">
                    <div class="mdc-tab-scroller">
                      <div class="mdc-tab-scroller__scroll-area">
                        <div class="mdc-tab-scroller__scroll-content">
                          <button class="mdc-tab mdc-tab--active" role="tab" aria-selected="true" tabindex="0">
                            <span class="mdc-tab__content">
                              <span class="mdc-tab__text-label">1W</span>
                            </span>
                            <span class="mdc-tab-indicator mdc-tab-indicator--active">
                              <span class="mdc-tab-indicator__content mdc-tab-indicator__content--underline"></span>
                            </span>
                            <span class="mdc-tab__ripple"></span>
                          </button>
                          <button class="mdc-tab mdc-tab" role="tab" aria-selected="true" tabindex="0">
                            <span class="mdc-tab__content">
                              <span class="mdc-tab__text-label">1M</span>
                            </span>
                            <span class="mdc-tab-indicator mdc-tab-indicator">
                              <span class="mdc-tab-indicator__content mdc-tab-indicator__content--underline"></span>
                            </span>
                            <span class="mdc-tab__ripple"></span>
                          </button>
                          <button class="mdc-tab mdc-tab" role="tab" aria-selected="true" tabindex="0">
                            <span class="mdc-tab__content">
                              <span class="mdc-tab__text-label">3M</span>
                            </span>
                            <span class="mdc-tab-indicator mdc-tab-indicator">
                              <span class="mdc-tab-indicator__content mdc-tab-indicator__content--underline"></span>
                            </span>
                            <span class="mdc-tab__ripple"></span>
                          </button>
                          <button class="mdc-tab mdc-tab" role="tab" aria-selected="true" tabindex="0">
                            <span class="mdc-tab__content">
                              <span class="mdc-tab__text-label">1Y</span>
                            </span>
                            <span class="mdc-tab-indicator mdc-tab-indicator">
                              <span class="mdc-tab-indicator__content mdc-tab-indicator__content--underline"></span>
                            </span>
                            <span class="mdc-tab__ripple"></span>
                          </button>
                          <button class="mdc-tab mdc-tab" role="tab" aria-selected="true" tabindex="0">
                            <span class="mdc-tab__content">
                              <span class="mdc-tab__text-label">ALL</span>
                            </span>
                            <span class="mdc-tab-indicator mdc-tab-indicator">
                              <span class="mdc-tab-indicator__content mdc-tab-indicator__content--underline"></span>
                            </span>
                            <span class="mdc-tab__ripple"></span>
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="content content--active">    
                  </div>
                  <div class="content">
                  </div>
                  <div class="content">    
                  </div>
                  <div class="content">
                  </div>
                  <div class="content">
                  </div>
                </div>
              </div>
              <div class="chart-container mt-4">
                <canvas id="revenue-chart" height="260"></canvas>
              </div>
            </div>
          </div>
          <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-4 mdc-layout-grid__cell--span-8-tablet">
            <div class="mdc-card">
              <div class="d-flex d-lg-block d-xl-flex justify-content-between">
                <div>
                  <h4 class="card-title">Order Statistics</h4>
                  <h6 class="card-sub-title">Customers 58.39k</h6>
                </div>
                <div id="sales-legend" class="d-flex flex-wrap"></div>
              </div>
              <div class="chart-container mt-4">
                <canvas id="chart-sales" height="260"></canvas>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
    <!-- layout/footer -->
    <?php include_once('layout/footer.php');?>
    <!-- end of layout/footer -->
  </div>
</div>