<?php $d = isset($details) ? $details : array(); ?>
<div class="box box-warning" style="margin-top:15px;">
  <div class="box-header with-border">
    <h3 class="box-title"><i class="fa fa-search"></i> SEO Meta Details</h3>
    <div class="box-tools pull-right">
      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
    </div>
  </div>
  <div class="box-body">

    <!-- Basic SEO -->
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label>Meta Title</label>
          <input type="text" name="meta_title" class="form-control" value="<?php echo isset($d['meta_title']) ? htmlspecialchars($d['meta_title']) : ''; ?>">
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label>Meta Keywords</label>
          <input type="text" name="meta_keywords" class="form-control" value="<?php echo isset($d['meta_keywords']) ? htmlspecialchars($d['meta_keywords']) : ''; ?>" placeholder="keyword1, keyword2">
        </div>
      </div>
    </div>
    <div class="form-group">
      <label>Meta Description</label>
      <textarea name="meta_description" class="form-control" rows="2"><?php echo isset($d['meta_description']) ? htmlspecialchars($d['meta_description']) : ''; ?></textarea>
    </div>

    <!-- Heading Tags -->
    <div class="row">
      <div class="col-md-4">
        <div class="form-group">
          <label>H1 Tag</label>
          <input type="text" name="h1_tag" class="form-control" value="<?php echo isset($d['h1_tag']) ? htmlspecialchars($d['h1_tag']) : ''; ?>">
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label>H2 Tag</label>
          <input type="text" name="h2_tag" class="form-control" value="<?php echo isset($d['h2_tag']) ? htmlspecialchars($d['h2_tag']) : ''; ?>">
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label>H3 Tag</label>
          <input type="text" name="h3_tag" class="form-control" value="<?php echo isset($d['h3_tag']) ? htmlspecialchars($d['h3_tag']) : ''; ?>">
        </div>
      </div>
    </div>

    <!-- Image Alt Tags -->
    <div class="row">
      <?php for($i=1;$i<=5;$i++): ?>
      <div class="col-md-4">
        <div class="form-group">
          <label>Image Alt-<?php echo $i; ?> Tag</label>
          <input type="text" name="img_alt_<?php echo $i; ?>" class="form-control" value="<?php echo isset($d['img_alt_'.$i]) ? htmlspecialchars($d['img_alt_'.$i]) : ''; ?>">
        </div>
      </div>
      <?php endfor; ?>
    </div>

    <!-- Robots & Revisit -->
    <div class="row">
      <div class="col-md-4">
        <div class="form-group">
          <label>Robots</label>
          <select name="robots" class="form-control">
            <option value="">-- Select --</option>
            <?php foreach(['index, follow','noindex, follow','index, nofollow','noindex, nofollow'] as $r): ?>
            <option value="<?php echo $r; ?>" <?php echo (isset($d['robots']) && $d['robots']==$r)?'selected':''; ?>><?php echo $r; ?></option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label>Revisit After</label>
          <input type="text" name="revisit_after" class="form-control" value="<?php echo isset($d['revisit_after']) ? htmlspecialchars($d['revisit_after']) : ''; ?>" placeholder="7 days">
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label>Canonical</label>
          <input type="text" name="canonical" class="form-control" value="<?php echo isset($d['canonical']) ? htmlspecialchars($d['canonical']) : ''; ?>">
        </div>
      </div>
    </div>

    <!-- Open Graph -->
    <h5 style="border-bottom:1px solid #ddd;padding-bottom:5px;margin-bottom:10px;"><strong>Open Graph</strong></h5>
    <div class="row">
      <div class="col-md-4">
        <div class="form-group">
          <label>OG Locale</label>
          <input type="text" name="og_locale" class="form-control" value="<?php echo isset($d['og_locale']) ? htmlspecialchars($d['og_locale']) : ''; ?>" placeholder="en_US">
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label>OG Type</label>
          <input type="text" name="og_type" class="form-control" value="<?php echo isset($d['og_type']) ? htmlspecialchars($d['og_type']) : ''; ?>" placeholder="website">
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label>OG Image</label>
          <input type="text" name="og_image" class="form-control" value="<?php echo isset($d['og_image']) ? htmlspecialchars($d['og_image']) : ''; ?>">
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-4">
        <div class="form-group">
          <label>OG Title</label>
          <input type="text" name="og_title" class="form-control" value="<?php echo isset($d['og_title']) ? htmlspecialchars($d['og_title']) : ''; ?>">
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label>OG URL</label>
          <input type="text" name="og_url" class="form-control" value="<?php echo isset($d['og_url']) ? htmlspecialchars($d['og_url']) : ''; ?>">
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label>OG Site Name</label>
          <input type="text" name="og_site_name" class="form-control" value="<?php echo isset($d['og_site_name']) ? htmlspecialchars($d['og_site_name']) : ''; ?>">
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label>OG Tag</label>
          <input type="text" name="og_tag" class="form-control" value="<?php echo isset($d['og_tag']) ? htmlspecialchars($d['og_tag']) : ''; ?>">
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label>OG Description</label>
          <textarea name="og_description" class="form-control" rows="2"><?php echo isset($d['og_description']) ? htmlspecialchars($d['og_description']) : ''; ?></textarea>
        </div>
      </div>
    </div>

    <!-- Geo -->
    <h5 style="border-bottom:1px solid #ddd;padding-bottom:5px;margin-bottom:10px;"><strong>Geo</strong></h5>
    <div class="row">
      <div class="col-md-4">
        <div class="form-group">
          <label>Geo Region</label>
          <input type="text" name="geo_region" class="form-control" value="<?php echo isset($d['geo_region']) ? htmlspecialchars($d['geo_region']) : ''; ?>">
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label>Geo Place Name</label>
          <input type="text" name="geo_place_name" class="form-control" value="<?php echo isset($d['geo_place_name']) ? htmlspecialchars($d['geo_place_name']) : ''; ?>">
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label>Geo Position</label>
          <input type="text" name="geo_position" class="form-control" value="<?php echo isset($d['geo_position']) ? htmlspecialchars($d['geo_position']) : ''; ?>" placeholder="lat;long">
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label>ICBM</label>
          <input type="text" name="icbm" class="form-control" value="<?php echo isset($d['icbm']) ? htmlspecialchars($d['icbm']) : ''; ?>" placeholder="lat, long">
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label>Geography</label>
          <input type="text" name="geography" class="form-control" value="<?php echo isset($d['geography']) ? htmlspecialchars($d['geography']) : ''; ?>">
        </div>
      </div>
    </div>

    <!-- Site Info -->
    <h5 style="border-bottom:1px solid #ddd;padding-bottom:5px;margin-bottom:10px;"><strong>Site Info</strong></h5>
    <div class="row">
      <div class="col-md-4">
        <div class="form-group">
          <label>Author</label>
          <input type="text" name="author" class="form-control" value="<?php echo isset($d['author']) ? htmlspecialchars($d['author']) : ''; ?>">
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label>Subject</label>
          <input type="text" name="subject" class="form-control" value="<?php echo isset($d['subject']) ? htmlspecialchars($d['subject']) : ''; ?>">
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label>Owner</label>
          <input type="text" name="owner" class="form-control" value="<?php echo isset($d['owner']) ? htmlspecialchars($d['owner']) : ''; ?>">
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-3">
        <div class="form-group">
          <label>Coverage</label>
          <input type="text" name="coverage" class="form-control" value="<?php echo isset($d['coverage']) ? htmlspecialchars($d['coverage']) : ''; ?>">
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label>Language</label>
          <input type="text" name="language" class="form-control" value="<?php echo isset($d['language']) ? htmlspecialchars($d['language']) : ''; ?>" placeholder="en">
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label>Distribution</label>
          <input type="text" name="distribution" class="form-control" value="<?php echo isset($d['distribution']) ? htmlspecialchars($d['distribution']) : ''; ?>" placeholder="Global">
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label>Country</label>
          <input type="text" name="country" class="form-control" value="<?php echo isset($d['country']) ? htmlspecialchars($d['country']) : ''; ?>">
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label>Cache Control</label>
          <input type="text" name="cache_control" class="form-control" value="<?php echo isset($d['cache_control']) ? htmlspecialchars($d['cache_control']) : ''; ?>" placeholder="no-cache">
        </div>
      </div>
    </div>

    <!-- Social -->
    <h5 style="border-bottom:1px solid #ddd;padding-bottom:5px;margin-bottom:10px;"><strong>Social</strong></h5>
    <div class="row">
      <div class="col-md-4">
        <div class="form-group">
          <label>Instagram</label>
          <input type="text" name="instagram" class="form-control" value="<?php echo isset($d['instagram']) ? htmlspecialchars($d['instagram']) : ''; ?>">
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label>Facebook</label>
          <input type="text" name="facebook" class="form-control" value="<?php echo isset($d['facebook']) ? htmlspecialchars($d['facebook']) : ''; ?>">
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label>Youtube</label>
          <input type="text" name="youtube" class="form-control" value="<?php echo isset($d['youtube']) ? htmlspecialchars($d['youtube']) : ''; ?>">
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label>Twitter Site</label>
          <input type="text" name="twitter_site" class="form-control" value="<?php echo isset($d['twitter_site']) ? htmlspecialchars($d['twitter_site']) : ''; ?>" placeholder="@handle">
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label>Twitter Description</label>
          <textarea name="twitter_description" class="form-control" rows="2"><?php echo isset($d['twitter_description']) ? htmlspecialchars($d['twitter_description']) : ''; ?></textarea>
        </div>
      </div>
    </div>

  </div>
</div>
