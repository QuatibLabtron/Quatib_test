<style type="text/css">
.page-sidebar .page-sidebar-menu>li:second-child >a{
  border-top: none;
}
@media (min-width: 992px){
 .page-sidebar {
  position: fixed!important;
  margin-left: 0;
  // top: 50px;
  text-shadow: 0 0 black;
}
}
</style>
<div class="page-sidebar-wrapper">
  <div class="page-sidebar navbar-collapse collapse">
    <div class="scroller" style="height:98vh;padding-right:0;" data-always-visible="1" data-rail-visible1="0" data-handle-color="#D7DCE2">
     
      <ul class="page-sidebar-menu  page-header-fixed " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 44px">
       
        <li class="sidebar-toggler-wrapper hide">
          
          <div class="sidebar-toggler">
            <span></span>
          </div>
          
        </li>
        
        <?php
        $res=$this->home_model->getMenu();
        
        $i=1;
        foreach($res->result() as $row){
          $link = '';
          $res1=$this->home_model->getsubMenu($row->mnu_id);
          if($row->mnu_link == ''){
           
            $link = 'javascript:;';
            
            
            echo'<li class="nav-item">
            <a href="'.$link.'" class="nav-link nav-toggle">
            <i class="'.$row->mnu_icon.'""style="color: #f1f4f7;"></i>&nbsp;&nbsp;
            <span class="title" style="color:white;">'.$row->mnu_name.'</span>
            <span class="selected"></span>
            </a>';
            
            if(!empty($res1)){
              echo '<ul class="sub-menu">';
              foreach($res1->result() as $rw){
                $res2 = $this->home_model->getpages($rw->sbm_id,$rw->sbm_mnu_id);
                              // $res2 = $this->home_model->getpages($rw->page_id,$rw->module_id);
                if($rw->sbm_pagelink == ''){
                 $link1 = 'javascript:;';
                 
                 echo '<li class="nav-item">
                 <a href="'.$link.'" class="nav-link nav-toggle" style="color:white!important" >
                 <i class="icon-settings"></i> '.$rw->sbm_name.'
                 <span class="arrow"></span>
                 </a>';
                 if(!empty($res2)){
                  echo '<ul class="sub-menu">';
                  foreach($res2->result() as $rw1){
                   echo '<li class="nav-item"><a style="color:white!important" href="'.site_url("/".$rw1->form_name).'" class="nav-link">
                   <i class="fa fa-angle-double-right" aria-hidden="true"></i> '.$rw1->form_title.'</a></li>';
                   
                   
                 }
                 echo '</ul>';
               }
               
             }else{
              $link = $rw->sbm_pagelink;
              echo '<li class="nav-item">
              <a style="color:white!important" href="'.site_url($link).'" class="nav-link" >
              <i class="fa fa-angle-double-right" aria-hidden="true"></i>
              '.$rw->sbm_name.'
              </a>';
              
            }
            
            /*echo '<li><a href="'.site_url($rw->sbm_pagelink).'">'.$rw->sbm_name.'</a>';*/
            
            
            echo '</li>';
          }
          echo '</ul>';
        }
      }else{
        $link = $row->mnu_link;
        
        $check_active_tab = "" ;
        if($this->uri->segment(1) ==  $link || $this->uri->segment(1) == "" ){ 
          $check_active_tab ="active";
        }
        else
        {
          $check_active_tab ="";
        }
        echo '<li class="nav-item  '.$check_active_tab.'">
        <a href="'.site_url($link).'" class="nav-link nav-toggle">
        <i class="'.$row->mnu_icon.'"></i>&nbsp;&nbsp;
        <span class="title" style="color:white">'.$row->mnu_name.'</span>
        <span class="selected"></span>';
        if ($row->mnu_name=="Ticket") {echo '<span style="  height: 22px;    font-weight: 600;    padding: 4px 8px;    font-size: 14px!important; "  class="badge badge-danger">'.$this->ticket_model->getTicketsByUsercount().'</span>';}
          echo '  </a>';
          echo'</li>';
        }
        
        
        $i++;
      }
      ?>
      
        <?php echo'<li class="nav-item">            <a href="'.base_url('products-seo-import').'" class="nav-link nav-toggle">            <i class="fa fa-upload"></i>&nbsp;&nbsp;            <span class="title" style="color:white;">SEO Meta Data</span>            <span class="selected"></span>            </a>';			?>            
      
      
    </li>
    
  </ul>
  <!-- END SIDEBAR MENU -->
  <!-- END SIDEBAR MENU -->
</div>
<!-- END SIDEBAR -->
</div>
</div>