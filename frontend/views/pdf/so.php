<!DOCTYPE HTML>
<html lang="en-US">
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <div class="konten">

            <h3 style="border-bottom: 1px solid grey;text-align: center">INVOICE</h3> 
            <table align="left" width="100%" style="border-collapse:collapse;border-spacing:0;margin:0;padding:0;">
                <tbody>
                    <tr>
                        <td style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#999;line-height:1.5;margin:0;padding:0">
                            <div style="margin:10px 2px">
                                <p style="font-family:Arial,sans-serif;color:#555;line-height:1.5;font-size:14px;margin:0;padding:0">
                                    Notification Delivery From System Information,
                                </p>
                            </div>
                            <div style="margin:10px 2px">
                                <p style="font-family:Arial,sans-serif;color:#555;line-height:1.5;font-size:14px;margin:0;padding:0">
                                    Berdasarkan system, Anda  telah membuat Order dengan list item berikut :
                                </p>
                                <br>
                                <table border="0" cellpadding="5" cellspacing="0" id="m_-3784408755349078820templateList" width="100%" style="border-collapse:collapse;border-spacing:0;font-size:12px;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;margin:0 0 25px;padding:0" bgcolor="#FFFFFF">
                                    <tbody>
                                        <tr>
                                            <th colspan="4" style="border-bottom-style:none;color:#ffffff;padding-left:10px;padding-right:10px" bgcolor="#900135">
                                    <h2 style="font-family:Arial,sans-serif;color:#ffffff;line-height:1.5;font-size:14px;margin:0;padding:5px 0">
                                        No Order : <?php echo $header['invoice']; ?>
                                    </h2>
                                    </th>
                                    </tr>
                                    <tr>
                                        <td align="left" colspan="2" valign="top" style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;margin:0;padding:5px 10px" bgcolor="#FFFFFF">
                                            <span style="font-family:Arial,sans-serif;color:#555;line-height:1.5;font-size:14px;margin:0;padding:0">Name</span>
                                        </td>
                                        <td align="right" valign="top" colspan="2" style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;margin:0;padding:5px 10px" bgcolor="#FFFFFF">
                                            <span style="text-align: right;font-family:Arial,sans-serif;color:#555;line-height:1.5;font-size:14px;margin:0;padding:0"><?php echo $header['user_name']; ?></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="left" colspan="2" valign="top" style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;margin:0;padding:5px 10px" bgcolor="#FFFFFF">
                                            <span style="font-family:Arial,sans-serif;color:#555;line-height:1.5;font-size:14px;margin:0;padding:0">Email</span>
                                        </td>
                                        <td align="right" valign="top" colspan="2" style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;margin:0;padding:5px 10px" bgcolor="#FFFFFF">
                                            <span style="text-align: right;font-family:Arial,sans-serif;color:#555;line-height:1.5;font-size:14px;margin:0;padding:0"><?php echo $header['user_email']; ?></span>
                                        </td>
                                    </tr>
                                    <?php if($header['shipping_address']):?>
                                    <tr>
                                        <td align="left" colspan="2" valign="top" style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;margin:0;padding:5px 10px" bgcolor="#FFFFFF">
                                            <span style="font-family:Arial,sans-serif;color:#555;line-height:1.5;font-size:14px;margin:0;padding:0">Alamat</span>
                                        </td>
                                        <td align="right" valign="top" colspan="2" style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;margin:0;padding:5px 10px" bgcolor="#FFFFFF">
                                            <span style="text-align: right;font-family:Arial,sans-serif;color:#555;line-height:1.5;font-size:14px;margin:0;padding:0"><?php echo $header['shipping_address']; ?></span>
                                        </td>
                                    </tr>
                                    <?php endif;?>
                                    <tr>
                                        <th colspan="4" style="border-bottom-style:none;color:#ffffff;padding-left:10px;padding-right:10px" bgcolor="#900135"></th>
                                    </tr>
                                    <tr>
                                        <td align="left" class="m_-3784408755349078820headingList" valign="top" width="65%" style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;font-size:11px;margin:0;padding:5px 10px" bgcolor="#F0F0F0">
                                            <strong style="color:#555;font-size:14px">Nama Barang</strong>
                                        </td>
                                        <td align="center" class="m_-3784408755349078820headingList" valign="top" width="10%" style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;font-size:11px;margin:0;padding:5px 10px" bgcolor="#F0F0F0">
                                            <strong style="color:#555;font-size:14px">Qty</strong>
                                        </td>
                                        <td align="center" class="m_-3784408755349078820headingList" valign="top" width="10%" style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;font-size:11px;margin:0;padding:5px 10px" bgcolor="#F0F0F0">
                                            <strong style="color:#555;font-size:14px">Price</strong>
                                        </td>
                                        <td align="right" class="m_-3784408755349078820headingList" valign="top" width="15%" style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;font-size:11px;margin:0;padding:5px 10px" bgcolor="#F0F0F0">
                                            <strong style="color:#555;font-size:14px">Total</strong>
                                        </td>
                                    </tr>
                                    </tbody>
                                    <?php
                                    $total = 0;
                                    ?>
                                    <?php for ($i = 0; $i < count($detail); $i++): ?>
                                        <?php $total = $total + ($detail[$i]['qty'] * $detail[$i]['product_sell_price']); ?>
                                        <tr>
                                            <td align="left" valign="middle" width="50%" style="font-size:14px;border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;margin:0;padding:5px 10px" bgcolor="#FFFFFF">
                                                <?php echo $detail[$i]['product_name']; ?>
                                            </td>
                                            <td align="center" valign="middle" width="10%" style="font-size:14px;border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;margin:0;padding:5px 10px" bgcolor="#FFFFFF">
                                                <?php echo $detail[$i]['qty']; ?>
                                            </td>
                                            <td align="center" valign="middle" width="15%" style="font-size:14px;border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;margin:0;padding:5px 10px" bgcolor="#FFFFFF">
                                                <?php echo number_format($detail[$i]['product_sell_price']); ?> 
                                            </td>
                                            <td align="right" valign="middle" width="25%" style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;margin:0;padding:5px 10px" bgcolor="#FFFFFF">
                                                <span style="font-family:Arial,sans-serif;color:#555;line-height:1.5;font-size:14px;margin:0;padding:0"></span><span style="font-family:Arial,sans-serif;color:#555;line-height:1.5;font-size:14px;margin:0;padding:0">
                                                    <?php echo number_format($detail[$i]['qty'] * $detail[$i]['product_sell_price']); ?> 
                                                </span>
                                            </td>
                                        </tr>
                                    <?php endfor; ?>
                                    <?php if(!empty($header['total_shipping_rupiah'])):?>
                                    <tr>
                                        <th colspan="4" style="border-bottom-style:none;color:#ffffff;padding-left:10px;padding-right:10px" bgcolor="#900135"></th>
                                    </tr>
                                    <tr>
                                        <td align="left" colspan="2" valign="top" style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;margin:0;padding:5px 10px" bgcolor="#FFFFFF">
                                            <span style="font-family:Arial,sans-serif;color:#555;line-height:1.5;font-size:14px;margin:0;padding:0"><?php echo $header['shipping_courier_service']; ?> </span>
                                        </td>
                                        <td align="right" valign="top" colspan="2"  style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;margin:0;padding:5px 10px" bgcolor="#FFFFFF">
                                            <span style="text-align: right;font-family:Arial,sans-serif;color:#555;line-height:1.5;font-size:14px;margin:0;padding:0"><?php echo number_format($header['total_shipping_rupiah']); ?></span>
                                        </td>
                                    </tr>
                                    <?php endif;?>
                                    <tr>
                                        <th colspan="1" style="text-align: left;border-bottom-style:none;color:#ffffff;padding-left:10px;padding-right:10px" bgcolor="#900135">
                                    <h2 style="font-family:Arial,sans-serif;color:#ffffff;line-height:1.5;font-size:14px;margin:0;padding:5px 0">
                                        Total
                                    </h2>
                                    </th>
                                    <th colspan="3" style="text-align: right;border-bottom-style:none;color:#ffffff;padding-left:10px;padding-right:10px" bgcolor="#900135">
                                    <h2 style="text-align: right;font-family:Arial,sans-serif;color:#ffffff;line-height:1.5;font-size:14px;margin:0;padding:5px 0">
                                        <?php echo number_format($total + $header['total_shipping_rupiah']); ?>
                                    </h2>
                                    </th>
                                    </tr>

                                </table>

                                <p style="font-family:Arial,sans-serif;color:#555;line-height:1.5;font-size:14px;margin:0;padding:0">
                                    Terimakasih sudah order di System kami jika ada masalah 
                                    <a href="" style="font-family:Arial,sans-serif;color:#900135!important;line-height:1.5;text-decoration:none;font-size:14px;margin:0;padding:0" target="_blank" >
                                        Hubungi Customer Service Kami
                                    </a>
                                </p>
                                <br>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>

        </div>
    </body>
</html>