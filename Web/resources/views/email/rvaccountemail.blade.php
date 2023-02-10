<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
   <head>
      <META http-equiv="Content-Type" content="text/html; charset=utf-8">
   </head>
   <body style="background:#f2f2f2;">
      <table width="650px" cellspacing="0" cellpadding="0" style=" border-collapse:collapse;margin:0 auto;background:#f2f2f2;font-family:Helvetica;">
        <thead>
        <tr style="border-bottom:2px solid #0093be;background:#fff;overflow:hidden">
                <th colspan="2">
                    <a href="{{ url('/') }}" style="margin:20px 10px;display:inline-block;float:left"><img src="{{ asset('assets/images/Atlaslogo.png') }}" title="" width="auto" height="auto" style="float:left"></a>
                </th> 
            </tr>
        </thead>
        <tbody style="background:#fff">
            <tr>
                <td colspan="2">
                <h3 style="text-align:center;font-weight:600;font-size:16px;color:#0d0808;margin:4% 0 0 0">Dear Accounts Team,</h3>
                                                      <h5 style="text-align:center;font-weight:400;font-size:18px;color:#393939;margin:3% 0 0 0"> Collector Agent has successfully submitted the RV form.</h5>
                                                      <h5 style="text-align:center;font-weight:400;font-size:18px;color:#393939;    width: 90%; margin: 1% auto 0;"> New RV has been submitted for your booking – RV {{$RV_FORM_NUMBER}} – CC {{$CUSTOMER_CODE}} – Amount # {{$AMOUNT}} {{$CURRENCY}}</h5>
                </td> 
            </tr>
            <tr>
                <td colspan="2">
                <h4 style="background:#0093be;color:#fff;border-bottom:1px solid #0093be;padding:10px 30px;margin:20px 0 0">Receipt Voucher Details</h4>
                </td> 
            </tr>
            <tr>
                <td style="padding:0 0 0 20px;">
                <h6 style="font-size:16px;color:#2c2c2c;margin:6% 0 2% 0;text-align:left;text-transform:capitalize">Receipt Voucher Number </h6>
                <p style="margin:0;font-size:14px;line-height:20px;text-align:left">{{$RV_FORM_NUMBER}}</p>
                </td>
                <td>
                <h6 style="font-size:16px;color:#2c2c2c;margin:6% 0 2% 0;text-align:left;text-transform:capitalize">Receipt Voucher Date</h6>
                <p style="margin:0;font-size:14px;line-height:20px;text-align:left">{{$RV_DATE}}</p>
                </td>
            </tr>
            <tr>
                <td style="padding:0 0 0 20px;">
                <h6 style="font-size:16px;color:#2c2c2c;margin:6% 0 2% 0;text-align:left;text-transform:capitalize">Customer Name</h6>
                                                         <p style="margin:0;font-size:14px;line-height:20px;text-align:left">{{$CUSTOMER_NAME}}</p>
                </td>
                <td>
                <h6 style="font-size:16px;color:#2c2c2c;margin:6% 0 2% 0;text-align:left;text-transform:capitalize">Customer Code</h6>
                                                         <p style="margin:0;font-size:14px;line-height:20px;text-align:left">{{$CUSTOMER_CODE}}</p>
                </td>
            </tr>
            <tr>
                <td style="padding:0 0 0 20px;">
                <h6 style="font-size:16px;color:#2c2c2c;margin:6% 0 2% 0;text-align:left;text-transform:capitalize">Customer Contact Number</h6>
                <p style="margin:0;font-size:14px;line-height:20px;text-align:left">{{$CUSTOMER_CONTACT_NUMBER}}</p>
                </td>
                <td>
                <h6 style="font-size:16px;color:#2c2c2c;margin:6% 0 2% 0;text-align:left;text-transform:capitalize">Branch</h6>
                <p style="margin:0;font-size:14px;line-height:20px;text-align:left;     word-wrap: break-word;" >{{$BRANCH}}</p>
                </td>
            </tr>
            <tr>
                <td style="padding:0 0 0 20px;">
                <h6 style="font-size:16px;color:#2c2c2c;margin:6% 0 2% 0;text-align:left;text-transform:capitalize">Currency</h6>
                <p style="margin:0;font-size:14px;line-height:20px;text-align:left">{{$CURRENCY}}</p>
                </td>
                <td>
                <h6 style="font-size:16px;color:#2c2c2c;margin:6% 0 2% 0;text-align:left;text-transform:capitalize">Amount
</h6>
<p style="margin:0;font-size:14px;line-height:20px;text-align:left">{{$AMOUNT}}</p>
                </td>
            </tr>
            <tr>
                <td style="padding:0 0 0 20px;">
                    <h6 style="font-size:16px;color:#2c2c2c;margin:6% 0 2% 0;text-align:left;text-transform:capitalize">Payment Category
                    </h6>
                    <p style="margin:0;font-size:14px;line-height:20px;text-align:left">{{$PAYMENT_CATEGORY}}</p>
                </td>
                <td>
                    <h6 style="font-size:16px;color:#2c2c2c;margin:6% 0 2% 0;text-align:left;text-transform:capitalize">Payment Type
                    </h6>
                    <p style="margin:0;font-size:14px;line-height:20px;text-align:left">{{$PAYMENT_TYPE}}</p>
                </td>
            </tr>
            <tr>
                <td style="padding:0 0 0 20px;">
                    <h6 style="font-size:16px;color:#2c2c2c;margin:6% 0 2% 0;text-align:left;text-transform:capitalize">Invoice Number
                    </h6>
                    <p style="margin:0;font-size:14px;line-height:20px;text-align:left;     word-wrap: break-word;">{{$INVOICE_NUMBERS}}</p>
                </td>
                <td>
                    <h6 style="font-size:16px;color:#2c2c2c;margin:6% 0 2% 0;text-align:left;text-transform:capitalize">Division
                    </h6>
                    <p style="margin:0;font-size:14px;line-height:20px;text-align:left">{{$DIVISION}}</p>
                </td>
            </tr>
            <tr>
                <td style="padding:0 0 0 20px;">
                    <h6 style="font-size:16px;color:#2c2c2c;margin:6% 0 2% 0;text-align:left;text-transform:capitalize">Cheque Numbers
                    </h6>
                    <p style="margin:0;font-size:14px;line-height:20px;text-align:left">{{$CHEQUE_NUMBER}}</p>
                </td>
                <td>
                    <h6 style="font-size:16px;color:#2c2c2c;margin:6% 0 2% 0;text-align:left;text-transform:capitalize">Bank Details
                    </h6>
                    <p style="margin:0;font-size:14px;line-height:20px;text-align:left">{{$BANK_DETAILS}}</p>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                <h4 style="background:#0093be;color:#fff;border-bottom:1px solid #0093be;padding:10px 30px;margin:20px 0 0">Collector Details</h4>
                </td> 
            </tr>
            <tr>
                <td style="padding:0 0 0 20px;">
                    <h6 style="font-size:16px;color:#2c2c2c;margin:6% 0 2% 0;text-align:left;text-transform:capitalize">Collector ID
                    </h6>
                    <p style="margin:0;font-size:14px;line-height:20px;text-align:left">{{$COLLECTOR_ID}}</p>
                </td>
                <td>
                    <h6 style="font-size:16px;color:#2c2c2c;margin:6% 0 2% 0;text-align:left;text-transform:capitalize">Collector Name
                    </h6>
                    <p style="margin:0;font-size:14px;line-height:20px;text-align:left">{{$COLLECTOR_NAME}}</p>
                </td>
            </tr>
            <tr>
                <td style="padding:0 0 0 20px;">
                    <h6 style="font-size:16px;color:#2c2c2c;margin:6% 0 2% 0;text-align:left;text-transform:capitalize">Collector Mobile Number
                    </h6>
                    <p style="margin:0;font-size:14px;line-height:20px;text-align:left">{{$COLLECTOR_MOBILE_NUMBER}}</p>
                </td>
                <td>
                    <h6 style="font-size:16px;color:#2c2c2c;margin:6% 0 2% 0;text-align:left;text-transform:capitalize">Collector Email
                    </h6>
                    <p style="margin:0;font-size:14px;line-height:20px;text-align:left">{{$COLLECTOR_EMAIL}}</p>
                </td>
            </tr>
            <tr>
            <td style="padding:0 0 0 20px;" colspan="2">
                <h6 style="font-size:16px;color:#2c2c2c;margin:4% 0 2% 0;text-align:left;text-transform:capitalize">Comments</h6>
                <p style="margin:0;font-size:14px;line-height:20px;text-align:left">{{$COMMENTS}}</p>
                </td> 
            </tr>
            <tr>
                <td colspan="2">
                <p style="text-align:center;width:100%;color:#fff;font-weight:bold;font-size:14px;background:#0093be;margin:0;padding:4% 0;border-top:1px solid #e4e7ea;margin-top:20px;">Thank you, Atlas Copco</p>
                </td>
             </tr>
        </tbody>
      </table>
   </body>
</html>