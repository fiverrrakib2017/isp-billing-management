<?php

include "../include/db_connect.php";

if (isset($_GET['clid'])) {

    $clid = $_GET['clid'];
    if ($cstmr = $con->query("SELECT * FROM sales WHERE id='$clid'")) {

        while ($rows = $cstmr->fetch_array()) {
            $lstid = $rows["id"];
            $client_id = $rows["client_id"];
            $sub_total = $rows["sub_total"];
            $date = $rows["date"];
            $discount = $rows["discount"];
            $grand_total = $rows["grand_total"];
            $total_paid = $rows["total_paid"];
            $total_due = $rows["total_due"];
        }
    }
}

?>




<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <!-- Meta Tags -->
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Laralink">
    <!-- Site Title -->
    <title>Sales Billing Invoice</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .tm_invoice.tm_style1 .tm_logo img {
            max-height: 100px;
        }
    </style>
</head>

<body style="margin-top: 1%">
    <div class="tm_container">
        <div class="tm_invoice_wrap">
            <div class="tm_invoice tm_style1" id="tm_download_section">
                <div class="tm_invoice_in">
                    <div class="tm_invoice_head tm_mb20">
                        <div class="tm_invoice_left">
                            <div class="tm_logo"><img src="../assets/images/it-fast.png" alt="Logo"><br> </div>
                        </div>
                        <div class="tm_invoice_right tm_text_right">
                            <div class="tm_primary_color tm_f50 tm_text_uppercase">Invoice</div>
                        </div>
                    </div>
                    <div class="tm_invoice_info tm_mb20">
                        <div class="tm_invoice_seperator tm_gray_bg"></div>
                        <div class="tm_invoice_info_list">
                            <p class="tm_invoice_number tm_m0">Invoice No: <b class="tm_primary_color"><?php echo $lstid; ?></b></p>
                            <p class="tm_invoice_date tm_m0">Date: 
                                <?php
                                    $date = $date;
                                    $formatted_date = date("d F Y", strtotime($date));
                                    echo $formatted_date;
                                ?>                            
                            </p>
                        </div>
                    </div>
                    <div class="tm_invoice_head tm_mb10">
                        <div class="tm_invoice_left">
                            <p class="tm_mb2 tm_f16"><b class="tm_primary_color tm_text_uppercase">STAR COMMUNICATION</b></p>
                            <p>
                                Sarkar super market 2nd floor <br>Gouripur Bazar, Daudkandi, Cumilla <br>
                                www.sr-communication.com <br>
                                hello@sr-cummunication.com<br>
                                01580-651309
                            </p>
                        </div>
                        <div class="tm_invoice_right" style="width:69% !important">
                            <div class="tm_grid_row tm_col_2  tm_col_2_sm tm_invoice_table tm_round_border">

                                <div>
                                    <p class="tm_m0">Client ID:</p>
                                    <b class="tm_primary_color"><?php echo $client_id; ?></b>
                                </div>
                                <div>
                                    <p class="tm_m0">Client Name:</p>
                                    <b class="tm_primary_color">

                                    <?php

                                        $client_id = $client_id;
                                        $allData = $con->query("SELECT * FROM clients WHERE id=$client_id ");
                                        while ($supplier = $allData->fetch_array()) {
                                            echo $supplier['fullname'];
                                        }

                                    ?>
                                    </b>
                                </div>


                                <div>
                                    <p class="tm_m0">Create Date</p>
                                    <b class="tm_primary_color">
                                        <?php
                                            $date = $date;
                                            $formatted_date = date("d F Y", strtotime($date));
                                            echo $formatted_date; 
                                        ?>

                                    </b>
                                </div>




                                <div>
                                    <p class="tm_m0">Address</p>
                                    <b class="tm_primary_color">
                                        <?php
                                            $client_id = $client_id;
                                            $allSupplierData = $con->query("SELECT * FROM clients WHERE id=$client_id ");
                                            while ($supplier = $allSupplierData->fetch_array()) {
                                                echo $supplier['address'];
                                            }

                                        ?>
                                    </b>
                                </div>



                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="tm_table tm_style1">
                        <div class="tm_round_border">
                            <div class="tm_table_responsive">
                                <table>
                                    <thead>
                                        <tr>
                                            <th class="tm_width_4 tm_semi_bold tm_primary_color">Item Name</th>

                                            <th class="tm_width_2 tm_semi_bold tm_primary_color">Quantity</th>

                                            <th class="tm_width_2 tm_semi_bold tm_primary_color">Amount</th>

                                            <th class="tm_width_2 tm_semi_bold tm_primary_color tm_text_right">Total Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                    <?php
        $id = $lstid;
        $allInvoiceData = $con->query("SELECT pd.product_id, pd.qty, pd.value, pd.total, p.name FROM sales_details pd JOIN products p ON pd.product_id = p.id WHERE pd.invoice_id =$id");
        while ($invoiceItem = $allInvoiceData->fetch_array()) {
            $name = $invoiceItem['name'];
            $qty = $invoiceItem['qty'];
            $amount = $invoiceItem['value'];
            $total_amount = $invoiceItem['total'];
            echo '
            <tr class="tm_gray_bg">
            <td class="tm_width_4">' . $name . '</td>

            <td class="tm_width_2 "><b>' . $qty . ' </b></td>

            <td class="tm_width_2 "><b>' . $amount . ' ৳</b></td>

            <td class="tm_width_2 tm_text_right"><b>' . $total_amount . ' ৳</b></td>
            </tr>
            
            
            ';
        }

                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tm_invoice_footer">
                            <div class="tm_left_footer">

                            </div>
                            <div class="tm_right_footer">
                                <table>
                                    <tbody>
                                        <tr class="tm_border_top">
                                            <td class="tm_width_3 tm_primary_color tm_border_none tm_bold">Sub Total</td>
                                            <td class="tm_width_3 tm_success_color tm_text_right tm_border_none tm_bold"><?php echo $sub_total; ?> ৳</td>
                                        </tr>

                                        <tr class="tm_border_top">
                                            <td class="tm_width_3 tm_primary_color tm_border_none tm_bold">Discount</td>
                                            <td class="tm_width_3 tm_success_color tm_text_right tm_border_none tm_bold"><?php echo $discount; ?> ৳</td>
                                        </tr>
                                        <tr class="tm_border_top">
                                            <td class="tm_width_3 tm_primary_color tm_border_none tm_bold">Paid Amount</td>
                                            <td class="tm_width_3 tm_success_color tm_text_right tm_border_none tm_bold"><?php echo $total_paid; ?> ৳</td>
                                        </tr>
                                        <tr class="tm_border_top">
                                            <td class="tm_width_3 tm_primary_color tm_border_none tm_bold">Due Amount</td>
                                            <td class="tm_width_3 tm_success_color tm_text_right tm_border_none tm_bold"><?php echo $total_due; ?> ৳</td>
                                        </tr>

                                        <tr class="tm_border_top">
                                            <td class="tm_width_3 tm_border_top_0 tm_bold tm_f18 tm_white_color tm_accent_bg tm_radius_6_0_0_6">Grand Total </td>
                                            <td class="tm_width_3 tm_border_top_0 tm_bold tm_f18 tm_primary_color tm_text_right tm_white_color tm_accent_bg tm_radius_0_6_6_0"><?php echo $grand_total; ?> ৳</td>
                                        </tr>
                                            
                                            






                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="tm_note tm_text_center tm_m0_md">
                        <p class="tm_m0" align=""><br> <br>Authorization signature and seal. &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;
                            Prepared By:
                            <?php 
                            session_start(); 
                            if (isset($_SESSION['fullname'])) {
                                echo $_SESSION['fullname'];
                            }else{
                                echo 'Rakib Mahmud'; 
                            }
                            ?>
                        </p>
                    </div><!-- .tm_note -->
                </div>
            </div>
            <div class="tm_invoice_btns tm_hide_print">
                <a href="javascript:window.print()" class="tm_invoice_btn tm_color1">
                    <span class="tm_btn_icon">
                        <svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512">
                            <path d="M384 368h24a40.12 40.12 0 0040-40V168a40.12 40.12 0 00-40-40H104a40.12 40.12 0 00-40 40v160a40.12 40.12 0 0040 40h24" fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="32" />
                            <rect x="128" y="240" width="256" height="208" rx="24.32" ry="24.32" fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="32" />
                            <path d="M384 128v-24a40.12 40.12 0 00-40-40H168a40.12 40.12 0 00-40 40v24" fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="32" />
                            <circle cx="392" cy="184" r="24" fill='currentColor' />
                        </svg>
                    </span>
                    <span class="tm_btn_text">Print</span>
                </a>
                <button id="tm_download_btn" class="tm_invoice_btn tm_color2">
                    <span class="tm_btn_icon">
                        <svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512">
                            <path d="M320 336h76c55 0 100-21.21 100-75.6s-53-73.47-96-75.6C391.11 99.74 329 48 256 48c-69 0-113.44 45.79-128 91.2-60 5.7-112 35.88-112 98.4S70 336 136 336h56M192 400.1l64 63.9 64-63.9M256 224v224.03" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" />
                        </svg>
                    </span>
                    <span class="tm_btn_text">Download</span>
                </button>
                <button id="tm_download_btn" class="tm_invoice_btn tm_color3" onclick="window.history.back()">
                    <span class="tm_btn_icon">
                        <svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512">
                            <path d="M328 112L184 256l144 144" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="48"/>
                        </svg>
                    </span>
                </button>
            </div>
        </div>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/jspdf.min.js"></script>
    <script src="assets/js/html2canvas.min.js"></script>
    <script src="assets/js/main.js"></script>
</body>

</html>