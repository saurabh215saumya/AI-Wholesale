<style>
.kw-hero{background:linear-gradient(135deg,#1a1a2e 0%,#16213e 50%,#0f3460 100%);padding:60px 0 50px;position:relative;overflow:hidden;}
.kw-hero::before{content:'';position:absolute;inset:0;background:url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="20" cy="20" r="40" fill="rgba(255,96,0,0.06)"/><circle cx="80" cy="80" r="50" fill="rgba(255,96,0,0.04)"/></svg>') no-repeat center/cover;}
.kw-hero h1{color:#fff;font-size:36px;font-weight:800;margin:0 0 8px;position:relative;}
.kw-hero .breadcrumb{background:none;padding:8px 0 0;margin:0;position:relative;}
.kw-hero .breadcrumb li a{color:rgba(255,255,255,.65);}
.kw-hero .breadcrumb li.active{color:rgba(255,255,255,.9);}
.kw-hero .breadcrumb>li+li::before{color:rgba(255,255,255,.4);}
.kw-badge{display:inline-block;background:rgba(255,96,0,.15);border:1px solid rgba(255,96,0,.4);color:#ff8c42;border-radius:20px;padding:4px 14px;font-size:13px;font-weight:600;margin-bottom:14px;}
.kw-stats{display:flex;gap:30px;margin-top:24px;flex-wrap:wrap;}
.kw-stat{color:rgba(255,255,255,.8);font-size:13px;}
.kw-stat strong{color:#ff8c42;font-size:20px;display:block;font-weight:800;}
.kw-search-bar{background:#fff;border-radius:50px;box-shadow:0 4px 20px rgba(0,0,0,.1);display:flex;align-items:center;padding:6px 6px 6px 20px;max-width:480px;margin:20px 0 0;}
.kw-search-bar input{border:none;outline:none;flex:1;font-size:15px;background:transparent;color:#333;}
.kw-search-bar button{background:#ff6000;color:#fff;border:none;border-radius:50px;padding:9px 22px;font-size:14px;font-weight:600;cursor:pointer;white-space:nowrap;}
.kw-grid-section{padding:50px 0 60px;background:#f8f9fb;}
.kw-card{background:#fff;border-radius:12px;border:1px solid #eee;padding:22px 20px 18px;display:block;text-decoration:none;color:inherit;transition:all .25s;height:100%;position:relative;overflow:hidden;}
.kw-card::before{content:'';position:absolute;top:0;left:0;width:4px;height:100%;background:linear-gradient(180deg,#ff6000,#ff8c42);border-radius:4px 0 0 4px;opacity:0;transition:opacity .25s;}
.kw-card:hover{box-shadow:0 8px 30px rgba(255,96,0,.15);transform:translateY(-3px);border-color:#ffd0b0;text-decoration:none;color:inherit;}
.kw-card:hover::before{opacity:1;}
.kw-card-icon{width:38px;height:38px;background:linear-gradient(135deg,#fff3ec,#ffe0cc);border-radius:10px;display:flex;align-items:center;justify-content:center;margin-bottom:12px;}
.kw-card-icon i{color:#ff6000;font-size:16px;}
.kw-card h4{margin:0 0 6px;font-size:15px;font-weight:700;color:#222;line-height:1.3;}
.kw-card p{margin:0;font-size:12px;color:#888;line-height:1.5;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;}
.kw-card .kw-arrow{position:absolute;bottom:14px;right:16px;color:#ff6000;font-size:13px;opacity:0;transition:opacity .2s;}
.kw-card:hover .kw-arrow{opacity:1;}
.kw-col{margin-bottom:24px;display:flex;}
.kw-col>a{width:100%;}
.row.kw-row{display:flex;flex-wrap:wrap;}
.kw-empty{text-align:center;padding:80px 20px;}
.kw-empty i{font-size:56px;color:#ddd;display:block;margin-bottom:16px;}
.kw-hidden{display:none!important;}

/* Lock wall */
.kw-lock-wall{background:linear-gradient(180deg,transparent 0%,#f8f9fb 60%);padding:40px 0 60px;margin-top:-60px;position:relative;z-index:2;text-align:center;}
.kw-lock-box{background:#fff;border-radius:20px;box-shadow:0 8px 40px rgba(0,0,0,.1);padding:40px 36px;max-width:420px;margin:0 auto;border:1px solid #eee;}
.kw-lock-box .lock-icon{width:70px;height:70px;background:linear-gradient(135deg,#fff3ec,#ffe0cc);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 18px;}
.kw-lock-box .lock-icon i{color:#ff6000;font-size:28px;}
.kw-lock-box h3{font-size:20px;font-weight:800;color:#222;margin:0 0 8px;}
.kw-lock-box p{font-size:14px;color:#888;margin:0 0 22px;}
.kw-pw-input{width:100%;border:2px solid #eee;border-radius:10px;padding:12px 16px;font-size:15px;outline:none;transition:border .2s;box-sizing:border-box;}
.kw-pw-input:focus{border-color:#ff6000;}
.kw-pw-btn{width:100%;background:linear-gradient(135deg,#ff6000,#ff8c42);color:#fff;border:none;border-radius:10px;padding:13px;font-size:15px;font-weight:700;cursor:pointer;margin-top:12px;transition:opacity .2s;}
.kw-pw-btn:hover{opacity:.88;}
.kw-pw-error{color:#e00;font-size:13px;margin-top:8px;display:none;}
.kw-pw-count{font-size:13px;color:#aaa;margin-top:10px;}
</style>

<?php
$preview  = array_slice($keywords, 0, 9);
$remaining = array_slice($keywords, 9);
$hasMore   = count($remaining) > 0;
$totalCount = count($keywords);
?>

<!-- Hero -->
<div class="kw-hero">
  <div class="container">
    <span class="kw-badge"><i class="fa fa-map-marker"></i> <?php echo htmlspecialchars($location); ?></span>
    <h1><?php echo htmlspecialchars($location); ?> — Wholesale Keywords</h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url(); ?>">Home</a></li>
      <li class="active"><?php echo htmlspecialchars($location); ?></li>
    </ol>
    <?php if(!empty($keywords)): ?>
    <div class="kw-stats">
      <div class="kw-stat"><strong><?php echo $totalCount; ?></strong>Keywords</div>
      <div class="kw-stat"><strong>UK</strong>Coverage</div>
      <div class="kw-stat"><strong>Free</strong>Delivery</div>
    </div>
    <?php if(!$hasMore): ?>
    <div class="kw-search-bar">
      <input type="text" id="kwSearch" placeholder="Search keywords..." oninput="filterKw(this.value)">
      <button type="button"><i class="fa fa-search"></i> Search</button>
    </div>
    <?php endif; ?>
    <?php endif; ?>
  </div>
</div>

<!-- Grid -->
<div class="kw-grid-section">
  <div class="container">
    <?php if(empty($keywords)): ?>
    <div class="kw-empty">
      <i class="fa fa-search"></i>
      <h3 style="color:#aaa;font-weight:400;">No keywords found for <strong><?php echo htmlspecialchars($location); ?></strong></h3>
      <a href="<?php echo base_url(); ?>" class="btn btn-primary" style="border-radius:30px;margin-top:16px;">Back to Home</a>
    </div>
    <?php else: ?>

    <div id="kwNoResult" class="kw-empty" style="display:none;">
      <i class="fa fa-search"></i>
      <p style="color:#aaa;">No keywords match your search.</p>
    </div>

    <!-- First 9 always visible -->
    <div class="row kw-row" id="kwGrid">
      <?php foreach($preview as $kw): ?>
      <div class="col-md-4 col-sm-6 kw-col kw-item" data-name="<?php echo htmlspecialchars(strtolower($kw['keyword'])); ?>">
        <a href="<?php echo base_url($kw['page_slug'] ?: 'location/'.urlencode($location)); ?>" target="_blank" class="kw-card">
          <div class="kw-card-icon"><i class="fa fa-tag"></i></div>
          <h4><?php echo htmlspecialchars($kw['keyword']); ?></h4>
          <?php if(!empty($kw['page_title'])): ?>
          <p><?php echo htmlspecialchars($kw['page_title']); ?></p>
          <?php endif; ?>
          <span class="kw-arrow"><i class="fa fa-arrow-right"></i></span>
        </a>
      </div>
      <?php endforeach; ?>
    </div>

    <?php if($hasMore): ?>
    <!-- Remaining keywords hidden until unlocked -->
    <div id="kwLockedGrid" class="row kw-row" style="display:none;">
      <?php foreach($remaining as $kw): ?>
      <div class="col-md-4 col-sm-6 kw-col kw-item" data-name="<?php echo htmlspecialchars(strtolower($kw['keyword'])); ?>">
        <a href="<?php echo base_url($kw['page_slug'] ?: 'location/'.urlencode($location)); ?>" target="_blank" class="kw-card">
          <div class="kw-card-icon"><i class="fa fa-tag"></i></div>
          <h4><?php echo htmlspecialchars($kw['keyword']); ?></h4>
          <?php if(!empty($kw['page_title'])): ?>
          <p><?php echo htmlspecialchars($kw['page_title']); ?></p>
          <?php endif; ?>
          <span class="kw-arrow"><i class="fa fa-arrow-right"></i></span>
        </a>
      </div>
      <?php endforeach; ?>
    </div>

    <!-- Lock wall -->
    <div id="kwLockWall" class="kw-lock-wall">
      <div class="kw-lock-box">
        <div class="lock-icon"><i class="fa fa-lock"></i></div>
        <h3>View All <?php echo $totalCount; ?> Keywords</h3>
        <p>Enter the access password to unlock <strong><?php echo count($remaining); ?> more keywords</strong> for <?php echo htmlspecialchars($location); ?>.</p>
        <input type="password" id="kwPassword" class="kw-pw-input" placeholder="Enter password..." onkeydown="if(event.key==='Enter') unlockKw()">
        <button class="kw-pw-btn" onclick="unlockKw()"><i class="fa fa-unlock"></i> Unlock All Keywords</button>
        <p class="kw-pw-error" id="kwPwError"><i class="fa fa-times-circle"></i> Incorrect password. Please try again.</p>
        <p class="kw-pw-count">Showing 9 of <?php echo $totalCount; ?> keywords</p>
      </div>
    </div>
    <?php endif; ?>

    <?php endif; ?>
  </div>
</div>

<script>
function unlockKw() {
    var pw = document.getElementById('kwPassword').value;
    var err = document.getElementById('kwPwError');
    if (pw === 'Saurabh@3873') {
        document.getElementById('kwLockWall').style.display = 'none';
        document.getElementById('kwLockedGrid').style.display = 'flex';
        document.getElementById('kwLockedGrid').style.flexWrap = 'wrap';
        // show search bar after unlock
        var hero = document.querySelector('.kw-hero .container');
        var sb = document.createElement('div');
        sb.className = 'kw-search-bar';
        sb.style.marginTop = '20px';
        sb.innerHTML = '<input type="text" id="kwSearch" placeholder="Search keywords..." oninput="filterKw(this.value)"><button type="button"><i class="fa fa-search"></i> Search</button>';
        hero.appendChild(sb);
        err.style.display = 'none';
    } else {
        err.style.display = 'block';
        document.getElementById('kwPassword').focus();
    }
}

function filterKw(q) {
    q = q.toLowerCase().trim();
    var items = document.querySelectorAll('.kw-item');
    var visible = 0;
    items.forEach(function(el) {
        var match = !q || el.dataset.name.indexOf(q) !== -1;
        el.classList.toggle('kw-hidden', !match);
        if (match) visible++;
    });
    document.getElementById('kwNoResult').style.display = visible === 0 ? 'block' : 'none';
}
</script>
