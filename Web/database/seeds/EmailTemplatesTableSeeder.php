<?php

use Illuminate\Database\Seeder;
use Admin\Models\EmailTemplate;

class EmailTemplatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
	public function run() {
		DB::table ( 'email_templates' )->delete ();
		DB::unprepared ( "ALTER TABLE email_templates AUTO_INCREMENT = 1;" );
	
		$emailTemplate = [
				'1' => [
						'name' => 'Password Reset',
						'slug' => 'password-reset',
						'subject' => 'Atlas Industrial Equipment Password Reset',
						'body' => '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
   <head>
      <META http-equiv="Content-Type" content="text/html; charset=utf-8">
   </head>
   <body>
      <table style="width:100%;background:#f2f2f2;overflow:hidden;border-collapse:collapse" border="0" cellspacing="0" cellpadding="0">
         <tbody>
            <tr>
               <td>
                  <table width="650px" style="margin:5% auto;max-width:650px;border-collapse:collapse;background:#f2f2f2;font-family:&#39;Helvetica&#39;,Arial" border="0" cellspacing="0" cellpadding="0">
                     <tbody>
                        <tr>
                           <td>
                              <table style="border-collapse:collapse;width:100%;background:#f2f2f2;border-radius:4px" border="0" cellspacing="0" cellpadding="0">
                                 <tbody>
                                    <tr>
                                       <td>
                                          <table style="width:100%;border-collapse:collapse" border="0" cellspacing="0" cellpadding="0">
                                             <tbody>
                                                <tr style="border-bottom:2px solid #0093be;background:#fff;overflow:hidden">
                                                   <td style="padding:3%;border-radius:4px 4px 0 0"><a style="display:inline-block;float:left" href="{{LOGOURL}}"><img src="{{LOGO}}" style="width:150px"></a>
                                                   </td>
                                                </tr>
                                             </tbody>
                                          </table>
                                          <table style="width:100%;border-collapse:collapse" border="0" cellspacing="0" cellpadding="0">
                                             <tbody>
                                                <tr style="background-color:#fff;padding-top:15%;background-repeat:no-repeat">
                                                   <td style="padding-top:1%">
                                                      <h3 style="font-weight:600;font-size:18px;color:#0d0808;margin:4% 0 4% 5%">Dear {{USER}},</h3>
                                                      <div style="font-weight:400;font-size:12px;color:#393939;margin:3% 10% 13% 7%;"><p style="font-size:14px">Welcome to Atlas Industrial Equipment. Click on the link below to reset you password.</p>
                                                       <p style="font-size:15px;margin-bottom:5%"><a href="{{URL}}">{{URL}}</a> </b></p>
                                                    </div> 

                                                          
                                                   </td>
                                                </tr>
                                             </tbody>
                                          </table>

                              <table style="border-collapse:collapse;width:100%" border="0" cellspacing="0" cellpadding="0">
                                 <tbody>
                                    <tr>
                                       <td>
                                          <div>
                                             <div style="width:100%;overflow:hidden">
                                                <p style="text-align:center;width:100%;color:#fff;font-weight:bold;font-size:14px;background:#0093be;margin:0;padding:4% 0;border-top:1p
                                                x solid #e4e7ea"><small style="font-size:14px;font-weight:100">Thank you, </small> <b>Atlas Copco</b></p>
                                             </div>
                                          </div>
                                       </td>
                                    </tr>
                                 </tbody>
                              </table>
                           </td>
                        </tr>
                     </tbody>
                  </table>
               </td>
            </tr>
         </tbody>
      </table>
   </body>
</html>',
						'is_active' => 1,
						'creator_id' => 1,
						'updator_id' => 1
				],
				'2' => [
						'name' => 'Password Change',
						'slug' => 'collector-forgot-password',
						'subject' => 'Atlas Industrial Equipment Password Changed',
						'body' => '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
   <head>
      <META http-equiv="Content-Type" content="text/html; charset=utf-8">
   </head>
   <body>
      <table style="width:100%;background:#f2f2f2;overflow:hidden;border-collapse:collapse" border="0" cellspacing="0" cellpadding="0">
         <tbody>
            <tr>
               <td>
                  <table width="650px" style="margin:5% auto;max-width:650px;border-collapse:collapse;background:#f2f2f2;font-family:&#39;Helvetica&#39;,Arial" border="0" cellspacing="0" cellpadding="0">
                     <tbody>
                        <tr>
                           <td>
                              <table style="border-collapse:collapse;width:100%;background:#f2f2f2;border-radius:4px" border="0" cellspacing="0" cellpadding="0">
                                 <tbody>
                                    <tr>
                                       <td>
                                          <table style="width:100%;border-collapse:collapse" border="0" cellspacing="0" cellpadding="0">
                                             <tbody>
                                                <tr style="border-bottom:2px solid #0093be;background:#fff;overflow:hidden">
                                                   <td style="padding:3%;border-radius:4px 4px 0 0"><a style="display:inline-block;float:left" href="{{LOGOURL}}"><img src="{{LOGO}}" style="width:150px"></a>
                                                   </td>
                                                </tr>
                                             </tbody>
                                          </table>
                                          <table style="width:100%;border-collapse:collapse" border="0" cellspacing="0" cellpadding="0">
                                             <tbody>
                                                <tr style="background-color:#fff;padding-top:15%;background-repeat:no-repeat">
                                                   <td style="padding-top:1%">
                                                      <h3 style="font-weight:600;font-size:18px;color:#0d0808;margin:4% 0 4% 5%">Dear {{USER}},</h3>
                                                      <div style="font-weight:400;font-size:12px;color:#393939;margin:3% 10% 13% 7%;"><p style="font-size:14px">Welcome to Atlas Industrial Equipment. Your Collector password has been changed. Your new login credential.</p>
                                                       <p style="font-size:15px; margin-bottom:5%;margin-top:5%"><b> Username: {{EMAIL}}</b> </p> 
                                                       <p style="font-size:15px;margin-bottom:5%"><b>Password: {{PASSWORD}} </b></p><p style="font-size:15px;margin-bottom:5%">Kindly change your password after login</p>

                                                    </div> 

                                                          
                                                   </td>
                                                </tr>
                                             </tbody>
                                          </table>

                              <table style="border-collapse:collapse;width:100%" border="0" cellspacing="0" cellpadding="0">
                                 <tbody>
                                    <tr>
                                       <td>
                                          <div>
                                             <div style="width:100%;overflow:hidden">
                                                <p style="text-align:center;width:100%;color:#fff;font-weight:bold;font-size:14px;background:#0093be;margin:0;padding:4% 0;border-top:1p
                                                x solid #e4e7ea"><small style="font-size:14px;font-weight:100">Thank you, </small> <b>Atlas Copco</b></p>
                                             </div>
                                          </div>
                                       </td>
                                    </tr>
                                 </tbody>
                              </table>
                           </td>
                        </tr>
                     </tbody>
                  </table>
               </td>
            </tr>
         </tbody>
      </table>
   </body>
</html>',
						'is_active' => 1,
						'creator_id' => 1,
						'updator_id' => 1
				],
				'3' => [
						'name' => 'Admin Registration',
						'slug' => 'admin_registration',
						'subject' => 'Atlas Industrial Equipment Admin Registration',
						'body' => '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
   <head>
      <META http-equiv="Content-Type" content="text/html; charset=utf-8">
   </head>
   <body>
      <table style="width:100%;background:#f2f2f2;overflow:hidden;border-collapse:collapse" border="0" cellspacing="0" cellpadding="0">
         <tbody>
            <tr>
               <td>
                  <table width="650px" style="margin:5% auto;max-width:650px;border-collapse:collapse;background:#f2f2f2;font-family:&#39;Helvetica&#39;,Arial" border="0" cellspacing="0" cellpadding="0">
                     <tbody>
                        <tr>
                           <td>
                              <table style="border-collapse:collapse;width:100%;background:#f2f2f2;border-radius:4px" border="0" cellspacing="0" cellpadding="0">
                                 <tbody>
                                    <tr>
                                       <td>
                                          <table style="width:100%;border-collapse:collapse" border="0" cellspacing="0" cellpadding="0">
                                             <tbody>
                                                <tr style="border-bottom:2px solid #0093be;background:#fff;overflow:hidden">
                                                   <td style="padding:3%;border-radius:4px 4px 0 0"><a style="display:inline-block;float:left" href="{{LOGOURL}}"><img src="{{LOGO}}" style="width:150px"></a>
                                                   </td>
                                                </tr>
                                             </tbody>
                                          </table>
                                          <table style="width:100%;border-collapse:collapse" border="0" cellspacing="0" cellpadding="0">
                                             <tbody>
                                                <tr style="background-color:#fff;padding-top:15%;background-repeat:no-repeat">
                                                   <td style="padding-top:1%">
                                                      <h3 style="font-weight:600;font-size:18px;color:#0d0808;margin:4% 0 4% 5%">Dear {{USER}},</h3>
                                                      <div style="font-weight:400;font-size:12px;color:#393939;margin:3% 10% 13% 7%;"><p style="font-size:14px">Welcome to Atlas Industrial Equipment. Your admin login credentials.</p>
                                                       <p style="font-size:15px; margin-bottom:5%;margin-top:5%"><b> Username: {{EMAIL}}</b> </p> 
                                                       <p style="font-size:15px;margin-bottom:5%"><b>Password: {{PASSWORD}} </b></p>
                                                    </div> 

                                                          
                                                   </td>
                                                </tr>
                                             </tbody>
                                          </table>

                              <table style="border-collapse:collapse;width:100%" border="0" cellspacing="0" cellpadding="0">
                                 <tbody>
                                    <tr>
                                       <td>
                                          <div>
                                             <div style="width:100%;overflow:hidden">
                                                <p style="text-align:center;width:100%;color:#fff;font-weight:bold;font-size:14px;background:#0093be;margin:0;padding:4% 0;border-top:1p
                                                x solid #e4e7ea"><small style="font-size:14px;font-weight:100">Thank you, </small> <b>Atlas Copco</b></p>
                                             </div>
                                          </div>
                                       </td>
                                    </tr>
                                 </tbody>
                              </table>
                           </td>
                        </tr>
                     </tbody>
                  </table>
               </td>
            </tr>
         </tbody>
      </table>
   </body>
</html>',
						'is_active' => 1,
						'creator_id' => 1,
						'updator_id' => 1
				],				
				'4' => [
                  'name' => 'Collectot Registration',
                  'slug' => 'collector_registration',
                  'subject' => 'Atlas Industrial Equipment Collector Registration',
                  'body' => '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
   <head>
      <META http-equiv="Content-Type" content="text/html; charset=utf-8">
   </head>
   <body>
      <table style="width:100%;background:#f2f2f2;overflow:hidden;border-collapse:collapse" border="0" cellspacing="0" cellpadding="0">
         <tbody>
            <tr>
               <td>
                  <table width="650px" style="margin:5% auto;max-width:650px;border-collapse:collapse;background:#f2f2f2;font-family:&#39;Helvetica&#39;,Arial" border="0" cellspacing="0" cellpadding="0">
                     <tbody>
                        <tr>
                           <td>
                              <table style="border-collapse:collapse;width:100%;background:#f2f2f2;border-radius:4px" border="0" cellspacing="0" cellpadding="0">
                                 <tbody>
                                    <tr>
                                       <td>
                                          <table style="width:100%;border-collapse:collapse" border="0" cellspacing="0" cellpadding="0">
                                             <tbody>
                                                <tr style="border-bottom:2px solid #0093be;background:#fff;overflow:hidden">
                                                   <td style="padding:3%;border-radius:4px 4px 0 0"><a style="display:inline-block;float:left" href="{{LOGOURL}}"><img src="{{LOGO}}" style="width:150px"></a>
                                                   </td>
                                                </tr>
                                             </tbody>
                                          </table>
                                          <table style="width:100%;border-collapse:collapse" border="0" cellspacing="0" cellpadding="0">
                                             <tbody>
                                                <tr style="background-color:#fff;padding-top:15%;background-repeat:no-repeat">
                                                   <td style="padding-top:1%">
                                                      <h3 style="font-weight:600;font-size:18px;color:#0d0808;margin:4% 0 4% 5%">Dear {{USER}},</h3>
                                                      <div style="font-weight:400;font-size:12px;color:#393939;margin:3% 10% 13% 7%;"><p style="font-size:14px">Welcome to Atlas Industrial Equipment. Your login credentials.</p>
                                                       <p style="font-size:15px; margin-bottom:5%;margin-top:5%"><b> Username: {{EMAIL}} or {{MOBILENUMBER}}</b> </p> 
                                                       <p style="font-size:15px;margin-bottom:5%"><b>Password: {{PASSWORD}} </b></p>
                                                    </div>
                                                   </td>
                                                </tr>
                                             </tbody>
                                          </table>

                              <table style="border-collapse:collapse;width:100%" border="0" cellspacing="0" cellpadding="0">
                                 <tbody>
                                    <tr>
                                       <td>
                                          <div>
                                             <div style="width:100%;overflow:hidden">
                                                <p style="text-align:center;width:100%;color:#fff;font-weight:bold;font-size:14px;background:#0093be;margin:0;padding:4% 0;border-top:1p
                                                x solid #e4e7ea"><small style="font-size:14px;font-weight:100">Thank you, </small> <b>Atlas Copco</b></p>
                                             </div>
                                          </div>
                                       </td>
                                    </tr>
                                 </tbody>
                              </table>
                           </td>
                        </tr>
                     </tbody>
                  </table>
               </td>
            </tr>
         </tbody>
      </table>
   </body>
</html>',
                  'is_active' => 1,
                  'creator_id' => 1,
                  'updator_id' => 1
            ],'5' => [
						'name' => 'Receipt Voucher Delete',
						'slug' => 'receipt_voucher_delete',
						'subject' => 'Receipt Voucher Deleted',
						'body' => '<p>&nbsp;</p>
<table style="width: 100%; background: #f2f2f2; overflow: hidden; border-collapse: collapse;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td>
<table style="margin: 5% auto; max-width: 650px; border-collapse: collapse; background: #f2f2f2; font-family: &#39;Helvetica&#39;,Arial;" border="0" width="650px" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td>
<table style="border-collapse: collapse; width: 100%; background: #f2f2f2; border-radius: 4px;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td>
<table style="width: 100%; border-collapse: collapse;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr style="border-bottom: 2px solid #0093be; background: #fff; overflow: hidden;">
<td style="padding: 3%; border-radius: 4px 4px 0 0;"><a style="display: inline-block; float: left;" href="{{LOGOURL}}"><img style="width: 150px;" src="{{LOGO}}" alt="" /></a></td>
</tr>
</tbody>
</table>
<table style="width: 100%; border-collapse: collapse;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr style="background-color: #fff; padding-top: 15%; background-repeat: no-repeat;">
<td style="padding-top: 1%;">
<h3 style="font-weight: 600; font-size: 18px; color: #0d0808; margin: 4% 0 4% 5%;">Dear Accounts Team,</h3>
<div style="font-weight: 400; font-size: 12px; color: #393939; margin: 3% 10% 13% 7%;">
<p style="font-size: 14px;">The Receipt Voucher <b>{{RV_NUMBER}}</b> has been deleted by <b>{{ADMIN_USER}}</b></p>
</div>
</td>
</tr>
</tbody>
</table>
<table style="border-collapse: collapse; width: 100%;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td>
<div>
<div style="width: 100%; overflow: hidden;">
<p style="text-align: center; width: 100%; color: #fff; font-weight: bold; font-size: 14px; background: #0093be; margin: 0; padding: 4% 0; border-top: 1p                                                x solid #e4e7ea;"><small style="font-size: 14px; font-weight: 100;">Thank you, </small> <strong>Atlas Copco</strong></p>
</div>
</div>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>',
						'is_active' => 1,
						'creator_id' => 1,
						'updator_id' => 1
				]
		];
		foreach ( $emailTemplate as $key => $value ) {
			EmailTemplate::create ( [
					'id' => $key,
					'name' => $value ['name'],
					'slug' => $value ['slug'],
					'subject' => $value ['subject'],
					'body' => $value ['body'],
					'is_active' => $value ['is_active'],
					'creator_id' => $value ['creator_id'],
					'updator_id' => $value ['updator_id'],
			] );
		}
	}
}
