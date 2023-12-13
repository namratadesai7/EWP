<?php
include('../conn.php');
include('../includes/header.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        .bill-table {
            color: #858796;
        }

        .html {
            scroll-behavior: smooth;
        }

        .bill-table input {
            border: 0;
        }

        .table th {
            padding: 10px;
        }

        .email {
            width: 350px;
        }

        .form-control[readonly] {
            background-color: #c6e3de;
            opacity: 1;
        }

        .form-control:focus {
            box-shadow: 0 0 0 0.2rem #deefec;
        }

        p {
            margin-bottom: 0;
        }

        .table-css {
            padding-bottom: 50px;
        }

        body {
            position: relative;
        }

        .scroll {
            position: absolute;
            right: 1rem;
            bottom: 0;
            width: 3rem;
            height: 3rem;
            line-height: 46px;

        }

        .scroll .scroll-to-top {
            text-align: center;
            color: #fff;
            background: rgba(90, 92, 105, .5);
            padding: 12px 16px;
        }

        .scroll-to-top:focus,
        .scroll-to-top:hover {
            color: #fff
        }

        .scroll-to-top:hover {
            background: #5a5c69
        }

        .scroll-to-top i {
            font-weight: 800
        }

        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type=number] {
            -moz-appearance: textfield;
        }

        @media only screen and (max-width:1650px) {
            .bill-table {
                display: block;
                overflow-x: auto;
            }
        }
    </style>
</head>

<body id="page-top">
    <div class="container-fluid">
        <form action="bill_db.php" method="post" class="mx-5">
            <div class="row mb-3">
                <div class="col">
                    <h4 class="pt-2 mb-0">Bill Generate</h4>
                </div>
                <div class="col-auto">
                    <button class="btn rounded-pill common-btn add-new" data-bs-toggle="modal"
                        data-bs-target="#addModal" href="bill_pdf.php">Print</button>
                </div>
            </div>
            <div class="divCss table-css">
                <table style="border:1px solid black; border-collapse:collapse;width:100%">
                    <thead>
                        <tr>
                            <th colspan="5" style="text-align:center;border:1px solid black;">
                                <p style="font-size:25px;background-color:#d3d3d3;margin-top:30px">SHUBHAM RECRUITMENT
                                    AGENCY BUSINESS
                                </p>
                                <p style="font-size:12px; margin-top:20px;">A/33, Vijaya Nagar Society, Nr- Meghdoot
                                    Society.
                                    Halol - 389350 . Panchmahal - Gujarat . <br> Godhra Road. Halol - 389350 .
                                    Panchmahal -
                                    Gujarat .</p>
                                <div style="display:flex;font-size:12px;justify-content:space-evenly;">
                                    <p style="font-size:12px;">E-mail: subhamrabusiness@gmail.com</p>
                                    <p>Mob.No. :8160900144</p>
                                </div>
                            </th>
                        </tr>
                        <tr>
                            <th colspan="2" style="font-size:14px;border:1px solid black;padding:5px;">
                                <sup>M / S .</sup>
                                Suyog Electricals Ltd
                            </th>
                            <th colspan="3" style="text-align:center;border:1px solid black;background-color:#d3d3d3;">
                                GST TAX INVOICE
                            </th>
                        </tr>
                        <tr style="font-size:14px;border:1px solid black;">
                            <th colspan="2" style="border:1px solid black;padding:5px;">
                                2204/2205,GIDC ESTATE - Halol,PMS-GJ-389350 </th>
                            <th colspan="3" style="display:flex;text-align:center;padding:5px;">
                                <p>
                                    Bill No :-- SRAB/33
                                </p>
                            </th>
                        </tr>
                        <tr style="font-size:14px;border:1px solid black;">
                            <th colspan="2" style="text-align:center;border:1px solid black;padding:5px;">
                                24AACCS9412R1ZV </th>
                            <th colspan="3" style="display:flex;padding:5px;">
                                <p>
                                    Date :--
                                </p>
                                <p>31-08-2023</p>

                            </th>
                        </tr>
                        <tr style="font-size:14px;text-align:center;">
                            <th style="border:1px solid black;">Sr.no</th>
                            <th style="border:1px solid black;">Particulars</th>
                            <th style="border:1px solid black;">Quantity</th>
                            <th style="border:1px solid black;">Rate</th>
                            <th style="border:1px solid black;">Amount</th>
                        </tr>

                    </thead>
                    <tbody style="font-size:14px;font-weight:700;">
                        <tr>
                            <td style="text-align:center;padding-top:15px;">1</td>
                            <td style="border-right:1px solid black;border-left: 1px solid black;padding-top:15px;padding-left:15px;">Labour supply work in
                                the <br> factory for the month of Aug-
                            </td>
                            <td style="text-align:center;border-right:1px solid black;border-left: 1px solid black;padding-top:15px;">
                                824.5</td>
                            <td style="border-right:1px solid black;border-left: 1px solid black;padding-top:15px;"></td>
                            <td style="text-align:center;padding-top:15px;">369779</td>

                        </tr>
                        <tr>
                            <td></td>
                            <td style="border-right:1px solid black;border-left: 1px solid black;padding-left:15px;padding-top:5px;">Att. Bonus</td>
                            <td style="border-right:1px solid black;border-left: 1px solid black;"></td>
                            <td style="border-right:1px solid black;border-left: 1px solid black;"></td>
                            <td style="text-align:center;">36030</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td style="border-right:1px solid black;border-left: 1px solid black;padding-left:15px;padding-top:5px;">HRA</td>
                            <td style="border-right:1px solid black;border-left: 1px solid black;"></td>
                            <td style="border-right:1px solid black;border-left: 1px solid black;"></td>
                            <td style="text-align:center;">62976</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td style="border-right:1px solid black;border-left: 1px solid black;padding-left:15px;padding-top:5px;">Washing Allowance
                            </td>
                            <td style="border-right:1px solid black;border-left: 1px solid black;"></td>
                            <td style="border-right:1px solid black;border-left: 1px solid black;"></td>
                            <td style="text-align:center;">28832</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td style="border-right:1px solid black;border-left: 1px solid black;padding-left:15px;padding-top:5px;">Over Time</td>
                            <td style="border-right:1px solid black;border-left: 1px solid black;"></td>
                            <td style="border-right:1px solid black;border-left: 1px solid black;"></td>
                            <td style="text-align:center;">44147</td>
                        </tr>
                        <tr rowspan="3">
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td style="text-align:center;"></td>
                        </tr>

                        <tr>
                            <td style="border-right: 1px solid black;"></td>
                            <td style="border-left: 1px solid black;"></td>
                            <td style="border:1px solid black;text-align:center;">Total</td>
                            <td></td>
                            <td style="text-align:center;border:1px solid black;">5,41,776</td>
                        </tr>
                        <tr>
                            <td style="border-right: 1px solid black;"></td>
                            <td style="text-align:right;border-right: 1px solid black;padding-right:5px;padding-top:5px;">ESIC Charges</td>
                            <td style="border-right: 1px solid black;"></td>
                            <td style="border-right: 1px solid black;text-align:center;">3.25%</td>
                            <td style="text-align:center;">16670</td>
                        </tr>
                        <tr>
                            <td style="border-right: 1px solid black;"></td>
                            <td style="text-align:right;border-right: 1px solid black;padding-right:5px;">PF Charges</td>
                            <td style="border-right: 1px solid black;"></td>
                            <td style="border-right: 1px solid black;text-align:center;">13%</td>
                            <td style="text-align:center;">48071</td>
                        </tr>
                        <tr>
                            <td style="border-right: 1px solid black;"></td>
                            <td style="text-align:right;border-right: 1px solid black;padding-right:5px;padding-bottom:5px;">Service Charges</td>
                            <td style="border-right: 1px solid black;"></td>
                            <td style="border-right: 1px solid black;text-align:center;">4%</td>
                            <td style="text-align:center;">14791</td>
                        </tr>
                        <tr>
                            <td style="border-right: 1px solid black;"></td>
                            <td style="border-right: 1px solid black;"></td>
                            <td style="border:1px solid black;text-align:center;">Sub Total</td>
                            <td style="border-right: 1px solid black;"></td>
                            <td style="text-align:center;border:1px solid black;">6,21,297</td>
                        </tr>
                        <tr>
                            <td style="border-right: 1px solid black;"></td>
                            <td style="text-align:right;border-right: 1px solid black;padding-right:5px;padding-top:10px;padding-bottom:10px;">SGST</td>
                            <td style="border-right: 1px solid black;"></td>
                            <td style="border-right: 1px solid black;text-align:center;">9%</td>
                            <td style="text-align:center;">55917</td>
                        </tr>
                        <tr>
                            <td style="border-right: 1px solid black;"></td>
                            <td style="text-align:right;border-right: 1px solid black;padding-right:5px;padding-top:10px;padding-bottom:10px;">CGST</td>
                            <td style="border-right: 1px solid black;"></td>
                            <td style="border-right: 1px solid black;text-align:center;">9%</td>
                            <td style="text-align:center;">55917</td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid black;"></td>
                            <td style="text-align:right;border: 1px solid black;padding:5px;">Invoice Total</td>
                            <td style="border-top: 1px solid black;border-bottom: 1px solid black;"></td>
                            <td
                                style="border-right: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;">
                            </td>
                            <td style="text-align:center;border: 1px solid black;">7,33,130</td>
                        </tr>
                        <tr style="border:1px solid black;">
                            <td colspan="5" style="padding:5px;">Amount In Word: Seven Lakh thirty-three thousand one hundred thirty only.
                            </td>
                        </tr>
                        <tr>
                            <td style="padding-top:5px;padding-left:5px;">GST No:</td>
                            <td style="border-right:1px solid black;">24ATAPG6048D1Z6</td>
                        </tr>
                        <tr>
                            <td style="padding-top:5px;padding-left:5px;">PAN NO :</td>
                            <td style="border-right:1px solid black;">ATAPG6048D</td>
                        </tr>
                        <tr>
                            <td style="padding-top:5px;padding-left:5px;">ESIC NO :</td>
                            <td style="border-right:1px solid black;">38000484020001019</td>
                            <td colspan="3" style="padding:5px;">
                            For , Shubham Recruitment Agency Business
                            </td>
                        </tr>
                        <tr>
                            <td style="padding-top:5px;padding-left:5px;">P F No :</td>
                            <td style="border-right:1px solid black;">VDBRD2076807000</td>
                        </tr>
                        <tr>
                            <td style="padding-top:5px;padding-left:5px;">Bank Detail :</td>
                            <td style="border-right:1px solid black;">HDFC BANK -Halol.</td>
                        </tr>
                        <tr>
                            <td style="padding-top:5px;padding-left:5px;">A/C NO :</td>
                            <td style="border-right:1px solid black;">50200049051242</td>
                        </tr>
                        <tr>
                            <td style="padding-top:5px;padding-left:5px;">E. & O. E.</td>
                            <td style="border-right:1px solid black;">Subject to Halol Jurisdiction</td>
                            <td colspan="3" style="text-align:center;">Authorised Signatory</td>
                        </tr>
                    </tbody>
                </table>
                <div>
                    <button type="submit" name="submit" class="btn common-btn float-end">Submit</button>
                </div>
            </div>
        </form>
    </div>
    <div class="scroll">
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>
    </div>
</body>

</html>

<?php
include('../includes/footer.php');
?>