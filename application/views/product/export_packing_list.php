<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Packing List <?php echo $date; ?></title>
<style>
  * { margin: 0; padding: 0; box-sizing: border-box; }
  body { font-family: Arial, sans-serif; font-size: 11px; background: #fff; color: #000; }
  .page { padding: 15px; }
  h1 { text-align: center; font-size: 16px; font-weight: bold; letter-spacing: 1px; margin-bottom: 12px; border-bottom: 2px solid #000; padding-bottom: 6px; }
  table { width: 100%; border-collapse: collapse; }
  th, td { border: 1px solid #000; padding: 4px 5px; text-align: center; vertical-align: middle; }
  th { background: #f0f0f0; font-weight: bold; font-size: 10px; text-transform: uppercase; }
  td.desc { text-align: left; }
  td.img-cell { width: 60px; }
  td.img-cell img { width: 55px; height: 55px; object-fit: cover; }
  td.img-cell .no-img { width: 55px; height: 55px; background: #eee; display: inline-flex; align-items: center; justify-content: center; font-size: 9px; color: #aaa; }
  tr:nth-child(even) { background: #fafafa; }
  tfoot td { font-weight: bold; background: #f0f0f0; }
  .no-print { margin-bottom: 10px; }
  @media print {
    .no-print { display: none; }
    body { font-size: 10px; }
    th, td { padding: 3px 4px; }
  }
</style>
</head>
<body>
<div class="page">
  <div class="no-print">
    <button onclick="window.print()" style="padding:6px 18px;background:#337ab7;color:#fff;border:none;border-radius:4px;cursor:pointer;font-size:13px;">
      &#128438; Print / Save as PDF
    </button>
    <button onclick="window.close()" style="padding:6px 14px;background:#aaa;color:#fff;border:none;border-radius:4px;cursor:pointer;font-size:13px;margin-left:8px;">
      Close
    </button>
  </div>

  <h1>PACKING LIST &nbsp;<?php echo date('Y-m-d'); ?></h1>

  <table>
    <thead>
      <tr>
        <th>#</th>
        <th>IMAGE</th>
        <th>DESCRIPTION</th>
        <th>CODE / BARCODE</th>
        <th>CATEGORY</th>
        <th>QTY/CTN</th>
        <th>TT QTY</th>
        <th>UNIT</th>
        <th>PRICE (£)</th>
        <th>TT AMT (£)</th>
        <th>WEIGHT</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $i = 1;
      $grandTotal = 0;
      $grandQty   = 0;
      foreach ($products as $p):
        $qty      = (int)$p['quantity'];
        $price    = (float)$p['price'];
        $ttAmt    = $qty * $price;
        $grandTotal += $ttAmt;
        $grandQty   += $qty;
      ?>
      <tr>
        <td><?php echo $i++; ?></td>
        <td class="img-cell">
          <?php if (!empty($p['image'])): ?>
            <img src="<?php echo base_url('uploads/products/' . $p['image']); ?>" alt="">
          <?php else: ?>
            <span class="no-img">No Img</span>
          <?php endif; ?>
        </td>
        <td class="desc"><?php echo htmlspecialchars($p['product_name']); ?></td>
        <td><?php echo htmlspecialchars($p['product_code']); ?></td>
        <td><?php echo htmlspecialchars($p['category_name'] . ($p['sub_category_name'] ? ' / ' . $p['sub_category_name'] : '')); ?></td>
        <td><?php echo $qty; ?></td>
        <td><?php echo $qty; ?></td>
        <td>PCS</td>
        <td><?php echo number_format($price, 2); ?></td>
        <td><?php echo number_format($ttAmt, 2); ?></td>
        <td>&nbsp;</td>
      </tr>
      <?php endforeach; ?>
    </tbody>
    <tfoot>
      <tr>
        <td colspan="5" style="text-align:right;">TOTALS</td>
        <td></td>
        <td><?php echo number_format($grandQty); ?></td>
        <td></td>
        <td></td>
        <td><?php echo number_format($grandTotal, 2); ?></td>
        <td></td>
      </tr>
    </tfoot>
  </table>
</div>
</body>
</html>
