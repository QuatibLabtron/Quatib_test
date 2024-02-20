
<table width="100%"  border="0" cellspacing="0" cellpadding="8">
  <tr>
    <td colspan="4" style="border-bottom:1px solid #ccc; border-top:1px solid #ccc;"><div align="center"><strong> Proforma Invoice </strong></div></td>
  </tr>
  <tr>
    <td colspan="2">To,<br>
      <strong><?php echo $tenders['contact_salutation'];?> <?php echo $tenders['contact_name'];?> </strong><br>
      <?php echo (!empty($organisations['org_billingadd']))?'Address: '.$organisations['org_billingadd']:''; ?>
      <br>
      <?php echo (!empty($organisations['org_billingpob']))?'P.O. Box : '.$organisations['org_billingpob']:'';?>, <?php echo (!empty($organisations['org_billingcity']))?$organisations['org_billingcity']:''; ?><br>
      <?php echo (!empty($organisations['org_billingstate']))?$organisations['org_billingstate']:'';?>,<?php echo (!empty($organisations['billingcountry']))?$organisations['billingcountry']:'';?> - <?php echo (!empty($organisations['org_billingpoc']))?$organisations['org_billingpoc']:''; ?><br></td>
    <td width="50%" colspan="2"> <div align="right"><strong>Invoice No: <?php echo $tenders['tdr_refid'] ?></strong> <br>
        <strong>Date:<?php echo date('d,M Y');  ?></strong> </div></td>
  </tr>
  <tr>
    <td colspan="4" align="right">Curreny (<?php echo get_gen_name($tenders['tdr_currency'],TENDER_PRICE_TYPE) ?>)</td>
  </tr>
</table>
<table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
  <thead>
  <tr>
    <td width="60%"> <div align="center"><strong>Description </strong></div></td>
     <td width="10%"> <div align="center"><strong>QTY </strong></div></td>
    <td width="15%"> <div align="center"><strong>Unit Price </strong></div></td>
    <td width="15%"> <div align="center"><strong>Total Price </strong></div></td>
  </tr>
  </thead>
  <tbody>
 <?php if(isset($tender_product) && $tender_product !='' && !empty($tender_product)) {
         $i = 0; 
        foreach ($tender_product as $key => $tenderproduct) {
       $product_desc = $tenderproduct['tdp_desc']; 
         ?>
  <tr>
    <td width="60%"> <div align="center"><strong><?php echo $tenderproduct['tdp_name'] ?></strong> </div>
      <div style="border-bottom: 1px solid white">
         <span>&nbsp;Shelves : 3(pcs) </span><br>
         <span>&nbsp;Display Resolution : 0.1 ℃ </span><br>
         <span>&nbsp;Temperature Range : (-20) ℃ ~ 65 ℃ </span><br>
         <span>&nbsp;Temperature Stability : High: ± 0.5 ℃ Low: ± 1 ℃ </span><br>
         <span>&nbsp;Ambient Temperature : 5 ℃ ~ 35 ℃ </span><br>
         <span>&nbsp;Timing Range : 1 ~ 9999 min </span><br>
         <span>&nbsp;Interior Dimension(W × D × H) : 500 × 400 × 600 mm </span><br>
         <span>&nbsp;Exterior Dimension(W × D × H) : 650 × 770 × 1320 mm </span><br>
         <span>&nbsp;Power Consumption : 1000 W </span><br>
         <span>&nbsp;Power : 220 V, 50 Hz </span><br>
      </div>
  </td>
    <td  width="10%"> <div align="center"><?php echo $tenderproduct['tdp_quantity'] ?> </div></td>
     <td width="15%"> <div align="right"><?php echo $tenderproduct['tdp_price'] ?>
         <?php if(isset($tenderproduct['tdp_discount_total_amt']) && $tenderproduct['tdp_discount_total_amt'] > 0 ){ ?> <br><br> <b>Disc. Price </b> : <?php echo $tenderproduct['tdp_discount_total_amt'] ?> <?php } ?>
     </div></td>
    <td width="15%"> <div align="right"><?php echo $tenderproduct['tdp_item_total'] ?> </div></td>
  </tr>
<?php }} ?>
</tbody>
<tfoot>
  <tr>
    <td colspan="3"> <div align="center"><strong>Price
    </strong></div></td>
    <td> <div align="right"><?php echo $tenders['tdr_item_total'] ?></div></td>
  </tr>
  <tr>
    <td colspan="3">      <div align="center"><strong>Packing, Forwarding & Shipping Charges </strong></div></td>
    <td> <div align="right"><?php echo $tenders['tdr_shipping_charges'] ?></div></td>
  </tr>
  <tr>
    <td colspan="3"> <div align="center"><strong>Bank Charges </strong></div></td>
    <td> <div align="right"> <?php echo $tenders['tdr_bank_charges'] ?> </div></td>
  </tr>
  <tr>
    <td colspan="3"> <div align="center"><strong>GRAND TOTAL(USD $) </strong></div></td>
    <td> <div align="right"><strong><?php echo $tenders['tdr_grandtotal'] ?></strong></div></td>
  </tr>
</tfoot>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><strong> Terms and Conditions </strong></td>
  </tr>
  <tr>
   <td>
     <?php echo $tenders['tdr_tnc']; ?>
   </td>
  </tr>
</table>

