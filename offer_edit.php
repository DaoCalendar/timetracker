<?php
// +----------------------------------------------------------------------+
// | Anuko Time Tracker
// +----------------------------------------------------------------------+
// | Copyright (c) Anuko International Ltd. (https://www.anuko.com)
// +----------------------------------------------------------------------+
// | LIBERAL FREEWARE LICENSE: This source code document may be used
// | by anyone for any purpose, and freely redistributed alone or in
// | combination with other software, provided that the license is obeyed.
// |
// | There are only two ways to violate the license:
// |
// | 1. To redistribute this code in source form, with the copyright
// |    notice or license removed or altered. (Distributing in compiled
// |    forms without embedded copyright notices is permitted).
// |
// | 2. To redistribute modified versions of this code in *any* form
// |    that bears insufficient indications that the modifications are
// |    not the work of the original author(s).
// |
// | This license applies to this document only, not any other software
// | that it may be combined with.
// |
// +----------------------------------------------------------------------+
// | Contributors:
// | https://www.anuko.com/time_tracker/credits.htm
// +----------------------------------------------------------------------+

require_once('initialize.php');
import('form.Form');
import('ttWorkHelper');

// Access checks.
if (!ttAccessAllowed('bid_on_work')) {
  header('Location: access_denied.php');
  exit();
}
if (!$user->isPluginEnabled('wk')) {
  header('Location: feature_disabled.php');
  exit();
}
$cl_offer_id = (int)$request->getParameter('id');
$workHelper = new ttWorkHelper($err);
$offer = $workHelper->getOwnOffer($cl_offer_id);
if (!$offer) {
  header('Location: access_denied.php');
  exit();
}
// End of access checks.

$currencies = ttWorkHelper::getCurrencies();

if ($request->isPost()) {
  $cl_name = trim($request->getParameter('offer_name'));
  $cl_description = trim($request->getParameter('description'));
  $cl_details = trim($request->getParameter('details'));
  $cl_currency = $request->getParameter('currency');
  $cl_budget = $request->getParameter('budget');
  $cl_payment_info = $request->getParameter('payment_info');
} else {
  $cl_name = $offer['subject'];
  $cl_description = $offer['descr_short'];
  $cl_details = $offer['descr_long'];
  $currency = $offer['currency'];
  $cl_currency = array_search($currency, $currencies);
  $cl_budget = $offer['amount'];
  $cl_payment_info = $offer['payment_info'];
  $cl_status = $offer['status_label'];
  $cl_moderator_comment = $offer['moderator_comment'];
}

$show_moderator_comment = $cl_moderator_comment != null;

$form = new Form('offerForm');
$form->addInput(array('type'=>'hidden','name'=>'id','value'=>$cl_offer_id));
$form->addInput(array('type'=>'text','maxlength'=>'100','name'=>'offer_name','style'=>'width: 250px;','value'=>$cl_name));
$form->addInput(array('type'=>'textarea','name'=>'description','style'=>'width: 250px; height: 40px;','value'=>$cl_description));
$form->addInput(array('type'=>'textarea','name'=>'details','style'=>'width: 250px; height: 80px;','value'=>$cl_details));
$form->addInput(array('type'=>'combobox','name'=>'currency','data'=>$currencies,'value'=>$cl_currency));
$form->addInput(array('type'=>'floatfield','maxlength'=>'10','name'=>'budget','format'=>'.2','value'=>$cl_budget));
$form->addInput(array('type'=>'textarea','name'=>'payment_info','style'=>'width: 250px; height: 40px;vertical-align: middle','value'=>$cl_payment_info));
$form->addInput(array('type'=>'text','name'=>'status','value'=>$cl_status));
$form->getElement('status')->setEnabled(false);
$form->addInput(array('type'=>'textarea','name'=>'moderator_comment','style'=>'width: 250px; height: 80px;','value'=>$cl_moderator_comment));
$form->getElement('moderator_comment')->setEnabled(false);
$form->addInput(array('type'=>'submit','name'=>'btn_save','value'=>$i18n->get('button.save')));

if ($request->isPost()) {
  // Validate user input.
  if (!ttValidString($cl_name)) $err->add($i18n->get('error.field'), $i18n->get('label.offer'));
  if (!ttValidString($cl_description, true)) $err->add($i18n->get('error.field'), $i18n->get('label.description'));
  if (!ttValidString($cl_details, true)) $err->add($i18n->get('error.field'), $i18n->get('label.details'));
  if (!ttValidString($cl_budget)) $err->add($i18n->get('error.field'), $i18n->get('label.budget'));
  if (!ttValidString($cl_payment_info)) $err->add($i18n->get('error.field'), $i18n->get('label.how_to_pay'));

  // Ensure user email exists (required for workflow).
  if (!$user->getEmail()) $err->add($i18n->get('error.no_email'));

  if ($err->no()) {
    if ($request->getParameter('btn_save')) {
      // Update offer information.
      $fields = array('offer_id'=>$cl_offer_id,
        'subject'=>$cl_name,
        'descr_short' => $cl_description,
        'descr_long' => $cl_details,
        'currency' => $currencies[$cl_currency],
        'amount' => $cl_budget,
        'payment_info' => $cl_payment_info);
      if ($workHelper->updateOwnOffer($fields)) {
        header('Location: work.php');
        exit();
      }
    }
  }
} // isPost

$smarty->assign('show_moderator_comment', $show_moderator_comment);
$smarty->assign('forms', array($form->getName()=>$form->toArray()));
$smarty->assign('title', $i18n->get('title.edit_offer'));
$smarty->assign('content_page_name', 'offer_edit.tpl');
$smarty->display('index.tpl');
