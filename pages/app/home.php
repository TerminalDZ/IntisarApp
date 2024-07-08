<div class="container-fluid">
  <div class="page-header">
    <div class="row">
      <div class="col-lg-6 main-header">
        <h2>لوحة التحكم</h2>
      </div>
    </div>
  </div>
</div>

<!-- Container-fluid starts-->
<div class="container-fluid">
  <div class="col-md-12">
    <div class="card gradient-info o-hidden text-center">
      <div class="b-r-4 card-body">
        <div class="media static-top-widget">
          <div class="align-self-center text-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user-plus text-white i"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><line x1="20" y1="8" x2="20" y2="14"></line><line x1="23" y1="11" x2="17" y2="11"></line></svg>
          </div>
          <div class="media-body"><span class="m-0 text-white">المنخرطين</span>
            <h4 class="mb-0 counter text-white"><?= DB::Count('members', 'archiv = 0');?></h4><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user-plus icon-bg"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><line x1="20" y1="8" x2="20" y2="14"></line><line x1="23" y1="11" x2="17" y2="11"></line></svg>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row">

    <?=CSRF::create_token();?>

      <div class="col-md-6">
        <div class="card">
          <div class="card-body">
            <canvas id="UnitScoutChart"></canvas>
          </div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="card">
          <div class="card-body">
            <canvas id="genderChart"></canvas>
          </div>
        </div>
      </div>



  </div>


</div>
<!-- Container-fluid Ends-->

<script>
 
</script>



