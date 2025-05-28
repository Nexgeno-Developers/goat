<?php
$controller = "";
if($user_type == 'parent'){
  $controller = 'parents';
} else{
  $controller = $user_type;
}
?>
<!-- ========== Left Sidebar Start ========== -->
<div class="left-side-menu left-side-menu-detached content-main">

  <!-- <div class="leftbar-user">
    <a href="javascript: void(0);">
      <img src="<?php //echo $this->user_model->get_user_image($this->session->userdata('user_id')); ?>?<?php //echo time() ?>" alt="user-image" height="42" class="rounded-circle shadow-sm">
      <?php
      //$user_details = $this->user_model->get_user_details($this->session->userdata('user_id'));
      ?>
      <span class="leftbar-user-name"><?php //echo $user_details['name']; ?></span>
    </a>
  </div> -->
  <!--- Sidemenu -->
  <ul class="metismenu side-nav side-nav-light">
    <!-- <li class="side-nav-title side-nav-item"><?php echo get_phrase('navigation'); ?></li> -->
    <li class="side-nav-item">
      <a href="<?php echo site_url($controller.'/dashboard'); ?>" class="side-nav-link">
      <i class="mdi mdi-home"></i>
        <span> <?php echo get_phrase('dashboard'); ?> </span>
      </a>
    </li>
    
    <?php if(access('manage_vyapari')){ ?>
    <li class="side-nav-item">
      <a href="<?php echo site_url($controller.'/manage_vyapari'); ?>" class="side-nav-link">
        <i class="mdi mdi-book-open-page-variant"></i>
        <span> <?php echo get_phrase('vyapari'); ?> </span>
      </a>
    </li>  
    <?php } ?>
    

    
    <?php if(access('exit_verification')){ ?>
    <li class="side-nav-item">
      <a href="<?php echo site_url($controller.'/exit_verification'); ?>" class="side-nav-link">
        <i class="mdi mdi-barcode-scan"></i>
        <span> <?php echo get_phrase('security_exit'); ?> </span>
      </a>
    </li>
    <?php } ?>
    
    <?php if(access('manage_admins')){ ?>
    <li class="side-nav-item">
      <a href="<?php echo site_url($controller.'/manage_admins'); ?>" class="side-nav-link">
        <i class="mdi mdi-account-group"></i>
        <span> <?php echo get_phrase('manage_users'); ?> </span>
      </a>
    </li>  
    <?php } ?>
    
    
    <?php if(access('master_list')){ ?>
        <li class="side-nav-item sub_menu">
           <a href="javascript: void(0);" class="side-nav-link" style="pointer-events: none;">
           <i class="mdi mdi-database"></i>
           <span><?php echo get_phrase('Master'); ?></span>
           </a>
           <ul class="side-nav-second-level collapse" aria-expanded="false">

              <?php if($this->session->userdata('role_type') != 'inward') { ?>
    
                <?php if(access('master_list')){ ?>
                <li>
                  <a href="<?php echo site_url($controller.'/manage_broker'); ?>">Manage Broker</a>
                </li>
                <?php } ?>
                
                <?php if(access('master_list')){ ?>
                <li>
                  <a href="<?php echo site_url($controller.'/manage_gwala'); ?>">Manage Gawala</a>
                </li>
                <?php } ?>

              <?php } else { ?>

                <?php if(access('master_list')){ ?>
                <li>
                  <a href="<?php echo site_url($controller.'/manage_gwala'); ?>">Manage Gawala</a>
                </li>
                <?php } ?>

              <?php } ?>
              
           </ul>
        </li>
    <?php } ?>
    

    <?php if(access('reports')){ ?>
    <li class="side-nav-item sub_menu">
       <a href="javascript: void(0);" class="side-nav-link" style="pointer-events: none;">
       <i class="mdi mdi-book"></i>
       <span><?php echo get_phrase('reports'); ?></span>
       </a>
       <ul class="side-nav-second-level collapse" aria-expanded="false">
          <?php /* collapse<li>
             <a href="<?php echo site_url($controller.'/manage_vyapari'); ?>">Vyapari registration</a>
          </li>*/ ?>
          
          <?php if(access('pass_block_report')){ ?>
          <li>
             <a href="<?php echo site_url($controller.'/reports/blocked'); ?>">Blocked Pass</a>
          </li>
          <?php } ?>
          
          <?php if(access('pass_inward_report')){ ?>
          <li>
             <a href="<?php echo site_url($controller.'/reports/inward'); ?>">Goat Inward</a>
          </li>
          <?php } ?>
          
          <?php if(access('pass_outward_report')){ ?>
          <li>
             <a href="<?php echo site_url($controller.'/reports/outward'); ?>">Goat Outward</a>
          </li> 
          <?php } ?>
          
          <?php if(access('pandol_info_report')){ ?>
          <li>
             <a href="<?php echo site_url($controller.'/reports/pandol-availability-map'); ?>">Pandol Info</a>
          </li> 
          <?php } ?>
          
          <?php if(access('menu_agent')){ ?>
          <li>
             <a href="<?php echo site_url($controller.'/reports/gwala'); ?>">Agent (Dawanwala)</a>
          </li> 
          <?php } ?>

          <?php if(access('statewise_vyapari_report')){ ?>
          <li>
             <a href="<?php echo site_url($controller.'/reports/vyapari-by-states'); ?>">State Vyapari</a>
          </li> 
          <?php } ?>          

          <?php if(access('statewise_goat_report')){ ?>
          <li>
             <a href="<?php echo site_url($controller.'/reports/goats-by-states'); ?>">State Goats</a>
          </li> 
          <?php } ?>          
          
       </ul>
    </li>    
    <?php } ?>
    
    <?php /*if(access('manage_vyapari')){ ?>
    <li class="side-nav-item">
      <a href="<?php echo site_url($controller.'/manage_vyapari_prebooking'); ?>" class="side-nav-link">
        <i class="mdi mdi-book-open-page-variant"></i>
        <span> <?php echo get_phrase('Vyapari Prebooking'); ?> </span>
      </a>
    </li>  
    <?php }*/ ?> 

  <?php //if(access('manage_settings')){ ?>
  <li class="side-nav-item mt-1">
    <a target="_blank" href="<?php echo base_url('home/pass_verification'); ?>" class="side-nav-link">
      <i class="mdi mdi-credit-card-scan"></i>
      <span> <?php echo get_phrase('Pass verification'); ?> </span>
    </a>
  </li> 
  <?php //} ?>  
  
  <?php //if(access('manage_settings')){ ?>
  <li class="side-nav-item mt-1">
    <a target="_blank" href="<?php echo base_url('home/vyapari_verification'); ?>" class="side-nav-link">
      <i class="mdi mdi-credit-card-scan"></i>
      <span> <?php echo get_phrase('Vyapari verification'); ?> </span>
    </a>
  </li> 
  <?php //} ?>  

  <?php if(access('manage_settings')){ ?>
  <li class="side-nav-item mt-1">
    <a href="<?php echo site_url($controller.'/website_settings/other_settings'); ?>" class="side-nav-link">
      <i class="mdi mdi-settings"></i>
      <span> <?php echo get_phrase('Settings'); ?> </span>
    </a>
  </li> 
  <?php } ?>     
  
  <?php if(access('manage_cache')){ ?>
  <li class="side-nav-item mt-1">
    <a href="<?php echo site_url($controller.'/clear_cache'); ?>" class="side-nav-link" style="background: #f8d7da; border-radius: 10px;font-weight: 700;color: #842029">
      <i class="mdi mdi-refresh"></i>
      <span> <?php echo get_phrase('Clear Cache'); ?> </span>
    </a>
  </li> 
  <?php } ?>    

    <?php
    /*$this->db->order_by('sort_order', 'asc');
    $main_menus = $this->db->get_where('menus', array('parent' => 0, 'status' => 1, $this->session->userdata('user_type').'_access' => 1))->result_array();
    foreach($main_menus as $main_menu){
      ?><li class="side-nav-item"><?php
      $this->db->order_by('sort_order', 'asc');
      $check_menus = $this->db->get_where('menus', array('parent' => $main_menu['id'], 'status' => 1, $this->session->userdata('user_type').'_access' => 1));
      if($check_menus->num_rows() > 0){ ?>
        <a href="javascript: void(0);" class="side-nav-link">
          <i class="<?php echo $main_menu['icon']; ?>"></i>
          <span><?php echo get_phrase($main_menu['displayed_name']); ?></span>
          <span class="menu-arrow"></span>
        </a>
        <ul class="side-nav-second-level" aria-expanded="false">
          <?php $this->db->order_by('sort_order', 'asc'); ?>
          <?php $menus = $this->db->get_where('menus', array('parent' => $main_menu['id'], 'status' => 1, $this->session->userdata('user_type').'_access' => 1))->result_array();
          foreach ($menus as $menu) {
            $this->db->order_by('sort_order', 'asc');
            $check_sub_menus = $this->db->get_where('menus', array('parent' => $menu['id'], 'status' => 1, $this->session->userdata('user_type').'_access' => 1));
            if($check_sub_menus->num_rows() > 0){ ?>
              <li class="side-nav-item">
                <a href="javascript: void(0);" aria-expanded="false"><?php echo get_phrase($menu['displayed_name']); ?>
                  <span class="menu-arrow"></span>
                </a>
                <ul class="side-nav-third-level" aria-expanded="false">
                  <?php
                  $this->db->order_by('sort_order', 'asc');
                  $sub_menus = $this->db->get_where('menus', array('parent' => $menu['id'], $this->session->userdata('user_type').'_access' => 1))->result_array();
                  foreach ($sub_menus as $sub_menu) {
                    ?>
                    <li>
                      <?php
                        if ($menu['is_addon']) {
                          $route = 'addons/'.$sub_menu['route_name'];
                        }else{
                          $route = $controller.'/'.$sub_menu['route_name'];
                        }
                       ?>
                      <a href="<?php echo site_url($route); ?>"><?php echo get_phrase($sub_menu['displayed_name']); ?></a>
                    </li>
                  <?php } ?>
                </ul>
              </li>
            <?php }else{ ?>
              <li>
                <?php
                  if ($menu['is_addon']) {
                    $route = 'addons/'.$menu['route_name'];
                  }else{
                    $route = $controller.'/'.$menu['route_name'];
                  }
                 ?>
                <a href="<?php echo site_url($route); ?>"><?php echo get_phrase($menu['displayed_name']); ?></a>
              </li>
            <?php } ?>
          <?php } ?></ul><?php
        }else{ ?>
          <?php
            if ($main_menu['is_addon']) {
              $route = 'addons/'.$main_menu['route_name'];
            }else{
              if($main_menu['unique_identifier'] == 'online_courses'){
                $route = 'addons/'.$main_menu['route_name'];
              }else{
                $route = $controller.'/'.$main_menu['route_name'];
              }
            }
           ?>
          <a href="<?php echo site_url($route); ?>" class="side-nav-link">
            <i class="<?php echo $main_menu['icon']; ?>"></i>
            <span><?php echo get_phrase($main_menu['displayed_name']); ?></span>
          </a>
        </li>
      <?php }
    }
    */?>
  </ul>
  <!-- End Sidebar -->

  <div class="clearfix"></div>
  <!-- Sidebar -left -->

</div>
<!-- Left Sidebar End -->

<script>
$(".sub_menu").hover(
  function () {
    $('.collapse').addClass("hover_menulist");
  },
  function () {
    $('.collapse').removeClass("hover_menulist");
  }
);
</script>




